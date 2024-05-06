<?php

namespace App\Http\Controllers\Mela;

use App\Exports\PurchaseSaleExport;
use App\Exports\StockistsExport;
use App\Models\ActivityPhoto;
use App\Models\PurchaseDetail;
use App\Models\PurchaseDetailItem;
use App\Models\RoutePlan;
use App\Models\Stockiest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PurchaseDetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Purchase the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $projects = DB::table('projects')->get();
        $stockist_id = $request->sid ?? 0;
        $users = $states   = [];
        $query = DB::table('purchases')->select(
            'purchases.fld_prid',
            'purchases.fld_uid',
            'purchases.fld_project_id',
            'purchases.fld_sid',
            'purchases.fld_total',
            'purchases.fld_date',
            'purchases.fld_bill_photo_path',
            'purchases.fld_bill_photo_file',
            'projects.fld_name as project_name',
            'users.fld_username',
            'stockists.fld_stockist_name as stockist_name',
            'stockists.fld_firm_name as stockist_firm_name',
            'stockists.fld_number as stockist_number',
            'stockists.fld_photo_path',
            'stockists.fld_photo_file',
            'stockists.fld_lat',
            'stockists.fld_long',
            'x_districts.fld_district',
            'x_states.fld_state'
        )
            ->join('projects', 'projects.fld_pid', '=', 'purchases.fld_project_id', 'left')
            ->join('users', 'users.fld_uid', '=', 'purchases.fld_uid', 'left')
            ->join('stockists', 'stockists.fld_sid', '=', 'purchases.fld_sid', 'left')
            ->join('x_states', 'x_states.fld_sid', '=', 'stockists.fld_state_id', 'left')
            ->join('x_districts', 'x_districts.fld_did', '=', 'stockists.fld_did')
            ->where('purchases.fld_project_id', '=', 3);
        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }


        if ($project_id) {
            $query->where('purchases.fld_project_id', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        } else {
            $request->session()->forget('project_id');
        }

        if ($request->user_id) {
            $query->where('purchases.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('stockists.fld_state_id', $request->state_id);
        }

        if ($request->start_date) {
            $query->where('purchases.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('purchases.fld_date', '<=', $request->end_date);
        }
        if ($stockist_id) {
            $query->where('purchases.fld_sid', $stockist_id);
        }

        if ($request->submit === "export") {
            $fld_csids = $query->orderby('fld_prid')->pluck('fld_prid')->toArray();
            $export = new PurchaseSaleExport($fld_csids);
            $file_name = 'purchase_sale_items' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }

        $cq = $query;
        // $cq->where('users.fld_demo', 0);
        $total_order_value = $cq->sum('fld_total');

        $records =  $query->orderby('purchases.fld_date', 'desc')->paginate();
        return view('mela.purchasedetail', compact('records', 'projects', 'users', 'states', 'total_order_value'));
    }


    /**
     * Show stockists.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getStockists(Request $request)
    {
        $projects = DB::table('projects')->get();
        $users = $states = $districts = [];
        $query = Stockiest::select(
            'x_states.fld_state',
            'x_districts.fld_district',
            'projects.fld_name as project_name',
            'stockists.fld_sid',
            'stockists.fld_stockist_name',
            'stockists.fld_firm_name',
            'stockists.fld_number as stockist_number',
            'stockists.fld_photo_path',
            'stockists.fld_photo_file',
            'stockists.fld_lat',
            'stockists.fld_long',
            'stockists.fld_created_at',
            'users.fld_username',
        )

            ->join('projects', 'projects.fld_pid', '=', 'stockists.fld_pid')
            ->join('x_states', 'x_states.fld_sid', '=', 'stockists.fld_state_id')
            ->join('x_districts', 'stockists.fld_did', '=', 'x_districts.fld_did')
            ->join('users', 'users.fld_uid', '=', 'stockists.fld_uid')
            ->with(['purchase' => function ($query) {
                $query->select('fld_bill_photo_path', 'fld_bill_photo_file');
            }])
            ->withSum('purchase', 'fld_total')
            ->where('stockists.fld_pid', 3);
        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }


        if ($project_id) {
            $query->where('stockists.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
        } else {
            $request->session()->forget('project_id');
        }

        if ($request->user_id) {
            $query->where('stockists.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('stockists.fld_state_id', $request->state_id);
        }

        if ($request->district_id) {
            $query->where('stockists.fld_did', $request->district_id);
        }

        if ($request->submit === "export") {
            $query = $query->where('users.fld_demo', 0);
            $fld_csids = $query->orderby('stockists.fld_sid')->get();
            $export = new StockistsExport($fld_csids);
            $file_name = 'stockists' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }
        $records =  $query->orderby('stockists.fld_sid', 'desc')->paginate();
        return view('mela.stockists', compact('records', 'projects', 'users', 'states', 'districts'));
    }



    public function addNewStockistOrder(Request $request)
    {
        //$records = ActivityReport::with('attenUser')->orderby('fld_prid')->paginate();
        $products = DB::table('products')->get();
        $stockist = Stockiest::find($request->sid);

        return view('mela.stockiestAddNewOrder', compact('products', 'stockist'));
    }

    public function saveStockistOrder(Request $request)
    {

        try {

            if (!count($request->items)) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Please add atleast one item"
                ], 403); // Status code here
            }



            $consumer = Stockiest::find($request->fld_sid);
            $order = [
                'fld_mobile_id' => 'web',
                'fld_sid' => $consumer->fld_sid,
                'fld_uid' => $consumer->fld_uid,
                'fld_project_id' => $consumer->fld_pid,
                'fld_total' => $request->fld_total,
                'fld_date' => now()
            ];

            $fld_prid = DB::table('purchases')->insertGetId($order);
            $items = $request->items;
            $orderItem = [];
            foreach ($items  as $item) {
                $item['fld_prid'] = $fld_prid;
                $item['fld_project_id'] = $consumer->fld_pid;
                $item['fld_date'] = now();
                $orderItem[] = $item;
            }

            DB::table('purchases_items')->insert($orderItem);

            return response()->json([
                'isSuccess' => true,
                'Message' => "Order has been created"
            ], 200); // Status code here

        } catch (\Throwable $th) {
            return response()->json([
                'isSuccess' => false,
                'Message' => $th->getMessage()
            ], 500); // Status code here
        }
    }





    public function updatePurchaseDetails(Request $request)
    {
        try {
            DB::table('purchases')->where('fld_prid', $request->fld_prid)->update(['fld_date' => $request->fld_date, 'fld_total' => $request->fld_total]);
            DB::table('purchases_items')->where('fld_prid', $request->fld_prid)->delete();
            DB::table('purchases_items')->insert($request->items);

            return response()->json([
                'isSuccess' => true,
                'Message' => "Item updated successfuly"
            ], 200); // Status code here

        } catch (\Throwable $th) {
            return response()->json([
                'isSuccess' => false,
                'Message' => $th->getMessage()
            ], 500); // Status code here
        }
    }




    public function deletePurchaseDetails($id)
    {
        PurchaseDetail::where('fld_prid', $id)->delete();
        PurchaseDetailItem::where('fld_prid', $id)->delete();
        return redirect()->back()->withSuccess('You have successfully deleted!');;
    }
    public function getPurchaseDetails($id)
    {
        $products = DB::table('products')->get();
        $purchases = DB::table('purchases')->where('fld_prid', $id)->first();
        $records = DB::table('purchases_items')
            ->select('purchases_items.*', 'products.fld_name as product_name', 'products.fld_selling_price', 'products.fld_mrp')
            ->join('products', 'products.fld_pid', '=', 'purchases_items.fld_product_id', 'left')
            ->where('fld_prid', $id)->get();
        return view('mela.purchasedetailItems', compact('records', 'products', 'purchases'));
    }


    //  Stockist   


    public function getStateByProjectIDForStockist($project_id)
    {
        return  DB::table('stockists')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'stockists.fld_state_id')
            ->groupBy('stockists.fld_state_id')
            ->where('stockists.fld_pid', $project_id)->get();
    }
    public function getUsersProjectIDForStockist($project_id)
    {
        return  DB::table('stockists')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'stockists.fld_uid')
            ->groupBy('stockists.fld_uid')
            ->where('stockists.fld_pid', $project_id)->get();
    }
    public function getDistrictByStateIDForStockist($state_id)
    {
        return  DB::table('stockists')
            ->select('x_districts.fld_did', 'x_districts.fld_district')
            ->join('x_districts', 'x_districts.fld_did', '=', 'stockists.fld_did')
            ->groupBy('stockists.fld_did')
            ->where('stockists.fld_state_id', $state_id)->get();
    }


    //  Stockist   


    public function getStateByProjectID($project_id)
    {
        return  DB::table('users')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'users.fld_state_id')
            ->groupBy('users.fld_state_id')
            ->where('users.fld_project_id', $project_id)->get();
    }
    public function getUsersProjectID($project_id)
    {
        return  DB::table('retail_sales')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'retail_sales.fld_uid')
            ->groupBy('retail_sales.fld_uid')
            ->where('retail_sales.fld_pid', $project_id)->get();
    }
    public function getDistrictByStateID($state_id)
    {
        return  DB::table('retailers')
            ->select('x_districts.fld_did', 'x_districts.fld_district')
            ->join('x_districts', 'x_districts.fld_did', '=', 'retailers.fld_did')
            ->groupBy('retailers.fld_did')
            ->where('retailers.fld_state_id', $state_id)->get();
    }

    public function activityPhoto(Request $request)
    {
        $projects = DB::table('projects')->get();
        $users = $states = $districts =  [];
        $query = DB::table('mela_images')
            ->select(
                'mela_images.*',
                'x_ptypes.fld_type as photo_type',
                'users.fld_name as user_name',
            )
            ->join('users', 'users.fld_uid', '=', 'mela_images.fld_uid')
             ->join('x_ptypes', 'x_ptypes.fld_ptid', '=', 'mela_images.fld_image_type', 'left');
            
        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }


        // if ($project_id) {
        //     $query->where('mela_images.fld_pid', $project_id);
        //     $request->session()->put('project_id', $project_id);
        //     $states = $this->getStateByProjectID($project_id);
        //     $users = $this->getUsersProjectIDAP($project_id);
        // } else {
        //     $request->session()->forget('project_id');
        // }

        if ($request->user_id) {
            $query->where('mela_images.fld_uid', $request->user_id);
        }

        $records =  $query->orderby('mela_images.fld_miid', 'desc')->paginate(20);
        
        return view('mela.activityPhoto', compact('records', 'projects', 'users', 'states', 'districts'));
    }




    public function getUsersProjectIDAP($project_id)
    {
        return  DB::table('activity_photos')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'activity_photos.fld_uid')
            ->groupBy('activity_photos.fld_uid')
            ->where('activity_photos.fld_pid', $project_id)->get();
    }
    public function getDistrictByStateIDAP($state_id)
    {
        return  DB::table('activity_photos')
            ->select('x_districts.fld_did', 'x_districts.fld_district')
            ->join('x_districts', 'x_districts.fld_did', '=', 'activity_photos.fld_did')
            ->groupBy('activity_photos.fld_did')
            ->where('activity_photos.fld_state_id', $state_id)->get();
    }
    public function getUsersStateID($state_id, $project_id)
    {
        return  DB::table('purchases')
            ->select('users.fld_uid', 'users.fld_name', 'purchases.fld_prid')
            ->join('users', 'users.fld_uid', '=', 'purchases.fld_uid')
            ->join('stockists', 'stockists.fld_sid', '=', 'purchases.fld_sid')
            ->groupBy('purchases.fld_uid')
            ->where('purchases.fld_project_id', $project_id)
            ->where('stockists.fld_state_id', $state_id)->get();
    }



    public function activityReports(Request $request)
    {
        $records = ActivityPhoto::with('user')->orderby('fld_aid')->paginate();
        return view('activityreport', compact('records'));
    }

    public function reports(Request $request)
    {
        //$records = ActivityReport::with('attenUser')->orderby('fld_prid')->paginate();
        $records = RoutePlan::with('attenUser')->orderby('fld_prid')->paginate();
        return view('reports', compact('records'));
    }
}
