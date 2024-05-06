<?php

namespace App\Http\Controllers\mela;

use App\Exports\ConsumerSaleExport;
use App\Exports\RetailSaleExport;
use App\Models\Attendance;
use App\Models\Retailer;
use App\Models\RetailSale;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\RoutePlan;
use App\Imports\RoutePlanImport;

class SalesReportController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function retailSales(Request $request)
    {
        $projects = DB::table('projects')->get();
        $retailer_id = $request->rid ?? 0;
        $districts = $users = $states = [];
        if ($request->submit != 'reset' && $request->project_id) {
            $project_id = $request->project_id;
        } elseif ($request->submit != 'reset' && session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }

        $query =  DB::table('mela_retail_sales')
            ->select(
                'mela_retail_sales.*',
                'mela_retailers.fld_store_name as shop_name',
                'mela_retailers.fld_owner_name as owner_name',
                'mela_retailers.fld_number as mobile_no',
                "mela_retailers.fld_village",
                // "x_tehsils.fld_tehsil as tehsil",
                "x_districts_mela.fld_district",
                "x_states.fld_state",
                'x_towns.fld_town',
                "mela_retailers.fld_photo_file",
                "mela_retailers.fld_photo_path",
                "users.fld_name",
                'mela_retailers.fld_rid'
            )
            ->selectRaw('CASE
                WHEN fld_type = 1 THEN "Retailer"
                WHEN fld_type = 2 THEN "Wholesaler"
                ELSE "Unknown"
                END AS shop_type
            ')
            ->join('mela_retailers', 'mela_retailers.fld_rid', '=', 'mela_retail_sales.fld_mrid', 'left')
            ->join('users', 'users.fld_uid', '=', 'mela_retail_sales.fld_uid', 'left')
            // ->join('x_villages', 'x_villages.fld_vid', '=', 'mela_retailers.fld_village_id', 'left')
            ->join('x_towns', 'x_towns.fld_tid', '=', 'mela_retailers.fld_town_id', 'left')
            // ->join('x_tehsils', 'x_tehsils.fld_tid', '=', 'mela_retailers.fld_tehsil_id', 'left')
            ->join('x_districts_mela', 'x_districts_mela.fld_did', '=', 'mela_retailers.fld_district_id', 'left')
            ->join('x_states', 'x_states.fld_sid', '=', 'mela_retailers.fld_state_id', 'left');
            
        if ($project_id) {
            $query->where('mela_retail_sales.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        }
        if ($request->user_id) {
            $query->where('users.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('mela_retailers.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }

        if ($request->start_date) {
            $query->where('mela_retail_sales.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('mela_retail_sales.fld_date', '<=', $request->end_date);
        }

        if ($request->district_id) {
            $query->where('mela_retailers.fld_did', $request->district_id);
        }
        if ($retailer_id) {
            $query->where('fld_rid', $retailer_id);
        }


        // if ($request->submit === "export") {
        //     $query = $query->where('users.fld_demo', 0);
        //     $fld_rsids = $query->orderby('fld_date', 'desc')->pluck('fld_rsid')->toArray();
        //     $export = new RetailSaleExport($fld_rsids, $project_id);
        //     $file_name = 'melaRetailSales' . '_' . date('d.m.Y');
        //     return Excel::download($export, $file_name . '_.xlsx');
        // }
        $total_order_value = $query->sum('mela_retail_sales.fld_total');
        $records = $query->orderby('fld_date', 'desc')->paginate();
        // dd($records);
        return view('mela.retailsales', compact('records', 'projects', 'states', 'districts', 'users', 'total_order_value'));
    }


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
    public function getUsersStateID($state_id)
    {
        return  DB::table('retailers')
            ->select('users.fld_uid', 'users.fld_name', 'retail_sales.fld_rsid')
            ->join('users', 'users.fld_uid', '=', 'retailers.fld_uid')
            ->join('retail_sales', 'retail_sales.fld_rid', '=', 'retailers.fld_rid')
            ->groupBy('retailers.fld_uid')
            ->where('retailers.fld_state_id', $state_id)->get();
    }
    public function getUsersStateIDForConsumer($state_id)
    {
        return  DB::table('consumers')
            ->select('users.fld_uid', 'users.fld_name', 'consumer_sales.fld_csid')
            ->join('users', 'users.fld_uid', '=', 'consumers.fld_uid')
            ->join('consumer_sales', 'consumer_sales.fld_cid', '=', 'consumers.fld_cid')
            ->groupBy('consumers.fld_uid')
            ->where('consumers.fld_state_id', $state_id)->get();
    }
    public function getDistrictByStateID($state_id)
    {
        return  DB::table('retailers')
            ->select('x_districts.fld_did', 'x_districts.fld_district')
            ->join('x_districts', 'x_districts.fld_did', '=', 'retailers.fld_did')
            ->groupBy('retailers.fld_did')
            ->where('retailers.fld_state_id', $state_id)->get();
    }

    public function retailSaleDetails($id)
    {
        $products = DB::table('products')->get();
        $retailSale = DB::table('mela_retail_sales')->where('fld_rsid', $id)->first();
        $records = DB::table('mela_retail_sales_items')
            ->select('mela_retail_sales_items.*', 'products.fld_name as product_name', 'products.fld_selling_price', 'products.fld_mrp')
            ->join('products', 'products.fld_pid', '=', 'mela_retail_sales_items.fld_pid', 'left')
            ->where('fld_mrsid', $id)->get();
         
        return view('mela.retailsaledetails', compact('records', 'products', 'retailSale'));
    }

    public function retailSaleDetailsDelete($id)
    {
        DB::table('mela_retail_sales')->where('fld_rsid', $id)->delete();
        DB::table('mela_retail_sales_items')->where('fld_mrsid', $id)->delete();

        return redirect()->back()->withSuccess('You have successfully deleted!');;
    }
    public function consumerSaleDetailsDelete($id)
    {
        DB::table('mela_consumer_sales')->where('fld_mcsid', $id)->delete();
        DB::table('mela_consumer_sales_items')->where('fld_mcsid', $id)->delete();

        return redirect()->back()->withSuccess('You have successfully deleted!');;
    }

    public function retailSaleDetailsUpdate(Request $request)
    {
        try {
            DB::table('mela_retail_sales')->where('fld_rsid', $request->fld_rsid)->update(['fld_date' => $request->fld_date, 'fld_total' => $request->fld_total]);
            DB::table('mela_retail_sales_items')->where('fld_mrsid', $request->fld_rsid)->delete();
            // dd('hdhd');
            DB::table('mela_retail_sales_items')->insert($request->items);

            return response()->json([
                'isSuccess' => true,
                'Message' => "Item updated successfuly"
            ], 200); // Status code here

        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'isSuccess' => false,
                'Message' => "Somethin went wrong"
            ], 500); // Status code here
        }
    }


    public function consumerSaleDetails($id)
    {
        $products = DB::table('products')->get();
        $consumerSale = DB::table('mela_consumer_sales')->where('fld_mcsid', $id)->first();
       
        $records = DB::table('mela_consumer_sales_items')
            ->select('mela_consumer_sales_items.*', 'products.fld_name as product_name', 'products.fld_selling_price', 'products.fld_mrp')
            ->join('products', 'products.fld_pid', '=', 'mela_consumer_sales_items.fld_pid', 'left')

            ->where('fld_mcsid', $id)->get();
           
        return view('mela.consumersaledetails', compact('records', 'products', 'consumerSale'));
    }

    public function consumerSaleDetailsUpdate(Request $request)
    {
        try { 
            DB::table('mela_consumer_sales')->where('fld_mcsid', $request->fld_mcsid)->update(['fld_date' => $request->fld_date, 'fld_total' => $request->fld_total]);
            DB::table('mela_consumer_sales_items')->where('fld_mcsiid', $request->fld_mcsid)->delete();
            DB::table('mela_consumer_sales_items')->insert($request->items);

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


/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function consumer(Request $request)
    {
        $projects = DB::table('projects')->get();
        $districts = $users = [];
        $records = DB::table('mela_consumers')
        ->select(
            'mela_consumers.*',
            DB::raw('(SELECT COUNT(*) FROM tbl_mela_consumer_sales WHERE tbl_mela_consumer_sales.fld_mcid = tbl_mela_consumers.fld_mcid) AS s_count')
        )
        ->paginate();

        return view('mela.attendees', compact('records', 'projects', 'districts', 'users'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function consumerSales(Request $request)
    {
        $projects = DB::table('projects')->get();
        $cid = $request->cid ?? 0;
        $districts = $users = [];
        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }

        $query =  DB::table('mela_consumer_sales')
            ->select(
                'mela_consumer_sales.*',
                'mela_consumers.fld_name as consumer_name',
                'mela_consumers.fld_phone as mobile_no',
                'mela_consumers.fld_village',
                "users.fld_name"
            )
            ->join('mela_consumers', 'mela_consumers.fld_mcid', '=', 'mela_consumer_sales.fld_mcid')
            ->join('users', 'users.fld_uid', '=', 'mela_consumer_sales.fld_uid');
            

        if ($project_id) {
            $query->where('mela_consumer_sales.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
        }
        if ($request->user_id) {
            $query->where('users.fld_uid', $request->user_id);
        }

        // if ($request->state_id) {
        //     $query->where('mela_consumers.fld_state_id', $request->state_id);
        // }

        if ($request->start_date) {
            $query->where('mela_consumer_sales.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('mela_consumer_sales.fld_date', '<=', $request->end_date);
        }

        // if ($request->district_id) {
        //     $query->where('mela_consumers.fld_did', $request->district_id);
        // }
        if ($cid) {
            $query->where('mela_consumers.fld_mcid', $cid);
        }

        // if ($request->submit === "export") {
        //     $query = $query->where('users.fld_demo', 0);
        //     $fld_csids = $query->orderby('fld_date')->pluck('fld_csid')->toArray();
        //     $export = new ConsumerSaleExport($fld_csids);
        //     $file_name = 'consumer_sale_items' . '_' . date('d.m.Y');
        //     return Excel::download($export, $file_name . '_.xlsx');
        // }
        $total_order_value = $query->sum('fld_total');
        $records = $query->orderby('fld_date', 'desc')->paginate();
        // dd($records);
        return view('mela.consumersales', compact('records', 'projects', 'districts', 'users', 'total_order_value'));
    }



    public function addNewOrder(Request $request)
    {
        $products = DB::table('products')->get();
        $retailer = DB::table('mela_retailers')->where('fld_rid', $request->rid)->first();
        $retailSale = DB::table('mela_retail_sales')->where('fld_mrid', $request->rid)->first();
      
        return view('mela.addNewOrder', compact('products', 'retailSale', 'retailer'));
    }

    public function storeNewOrder(Request $request)
    {

        try {

            if (!count($request->items)) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Please add atleast one item"
                ], 403); // Status code here
            }



             $retailer = DB::table('mela_retailers')->where('fld_rid', $request->fld_rid)->first();
            
            $order = [
                'fld_mobile_id' => 'web',
                'fld_mrid' => $retailer->fld_rid,
                'fld_uid' => $retailer->fld_uid,
                'fld_pid' => $retailer->fld_pid,
                'fld_total' => $request->fld_total,
                'fld_date' => now()
            ];

            $fld_rsid = DB::table('mela_retail_sales')->insertGetId($order);
            $items = $request->items;
            $orderItem = [];
            foreach ($items  as $item) {
                $item['fld_mrsid'] = $fld_rsid;
                $item['fld_date'] = now();
                $orderItem[] = $item;
            }

            DB::table('mela_retail_sales_items')->insert($orderItem);

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
}
