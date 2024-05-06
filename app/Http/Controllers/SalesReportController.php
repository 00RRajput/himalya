<?php

namespace App\Http\Controllers;

use App\Exports\ConsumerSaleExport;
use App\Exports\RetailSaleExport;
use App\Models\Attendance;
use App\Models\Retailer;
use App\Models\RetailSale;
use App\Models\RoutePlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

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

    public function vanRoutePlan(Request $request)
    {
        $users = $districts = $states = [];
        $projects = DB::table('projects')->where('fld_status', 1)->get();

        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }

        $query = RoutePlan::select(
            '*',
            'x_states.fld_state as state_name',
            'x_districts.fld_district as district_name',
            'x_villages.fld_village as village_name',
            'x_tehsils.fld_tehsil'
        )
            // ->with('attenUser', 'project')
            ->rightJoin('x_states', 'x_states.fld_sid', '=', 'route_plans.fld_state_id')
            ->rightJoin('x_districts', 'x_districts.fld_did', '=', 'route_plans.fld_district_id')
            ->rightJoin('x_villages', 'x_villages.fld_vid', '=', 'route_plans.fld_village_id')
            ->rightJoin('x_tehsils', 'x_tehsils.fld_tid', '=', 'route_plans.fld_tehsil_id');
        if ($project_id) {
            $query->whereHas('project', function ($q) use ($project_id) {
                $q->where('fld_pid', $project_id);
            });
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        }

        if ($request->state_id) {
            $query->where('route_plans.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }
        if ($request->district_id) {
            $query->where('route_plans.fld_district_id', $request->district_id);
        }

        if ($request->user_id) {
            $query->where('route_plans.fld_uid', $request->user_id);
        }
        if ($request->start_date) {
            $query->where('route_plans.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('route_plans.fld_date', '<=', $request->end_date);
        }

        $records = $query->orderby('route_plans.fld_date', 'desc')
            ->paginate(20);
        return view('routeplans', compact('records', 'projects', 'states', 'users', 'districts'));
    }

    public function getRoutePlan(Request $request)
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $records = DB::table('route_plans_historys')
            ->select('route_plans_historys.*', 'users.fld_name as user_name', 'projects.fld_name as project_name')
            ->join('users', 'users.fld_uid', '=', 'route_plans_historys.fld_uid')
            ->join('projects', 'projects.fld_pid', '=', 'route_plans_historys.fld_pid')
            ->orderBy('route_plans_historys.fld_rphid', 'desc')->paginate();
        return view('uploadroute', compact('records', 'projects'));
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
        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }

        $query =  DB::table('retail_sales')
            ->select(
                'retail_sales.*',
                'retailers.fld_store_name as shop_name',
                'retailers.fld_owner_name as owner_name',
                'retailers.fld_number as mobile_no',
                "x_villages.fld_village",
                "x_tehsils.fld_tehsil as tehsil",
                "x_districts.fld_district",
                "x_states.fld_state",
                "retailers.fld_photo_file",
                "retailers.fld_photo_path",
                "users.fld_name"
            )
            ->selectRaw('CASE
                WHEN fld_type = 1 THEN "Retailer"
                WHEN fld_type = 2 THEN "Wholesaler"
                ELSE "Unknown"
                END AS shop_type
            ')
            ->join('retailers', 'retailers.fld_rid', '=', 'retail_sales.fld_rid', 'left')
            ->join('users', 'users.fld_uid', '=', 'retail_sales.fld_uid', 'left')
            ->join('x_villages', 'x_villages.fld_vid', '=', 'retailers.fld_village_id', 'left')
            ->join('x_tehsils', 'x_tehsils.fld_tid', '=', 'retailers.fld_tehsil_id', 'left')
            ->join('x_districts', 'x_districts.fld_did', '=', 'retailers.fld_did', 'left')
            ->join('x_states', 'x_states.fld_sid', '=', 'retailers.fld_state_id', 'left');

        if ($project_id) {
            $query->where('retail_sales.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        }
        if ($request->user_id) {
            $query->where('users.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('retailers.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }

        if ($request->start_date) {
            $query->where('retail_sales.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('retail_sales.fld_date', '<=', $request->end_date);
        }

        if ($request->district_id) {
            $query->where('retailers.fld_did', $request->district_id);
        }
        $retailerName=null;
        session(['retsil-route' => route('van.retailsales')]);
        if ($retailer_id) {
            $query->where('retail_sales.fld_rid', $retailer_id);
            $retailerName = ($query->first('shop_name'))->shop_name;
            session(['retsil-route' => route('van.retailsales', ['rid'=>$retailer_id])]);
        }


        if ($request->submit === "export") {
            $query = $query->where('users.fld_demo', 0);
            $fld_rsids = $query->orderby('fld_date', 'desc')->pluck('fld_rsid')->toArray();
            $export = new RetailSaleExport($fld_rsids, $project_id);
            $file_name = 'retailSales' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }
        $total_order_value = $query->sum('fld_total');
        $records = $query->orderby('fld_date', 'desc')->paginate();
      
        return view('retailsales', compact('records', 'projects', 'states', 'districts', 'users', 'total_order_value', 'retailerName'));
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
        $retailSale = DB::table('retail_sales')->where('fld_rsid', $id)->first();
        $records = DB::table('retail_sales_items')
            ->select('retail_sales_items.*', 'products.fld_name as product_name', 'products.fld_selling_price', 'products.fld_mrp')
            ->join('products', 'products.fld_pid', '=', 'retail_sales_items.fld_pid', 'left')
            ->where('fld_rsid', $id)->get();
        //   dd($products, $retailSale, $records);
        return view('retailsaledetails', compact('records', 'products', 'retailSale'));
    }

    public function retailSaleDetailsDelete($id)
    {
        DB::table('retail_sales')->where('fld_rsid', $id)->delete();
        DB::table('retail_sales_items')->where('fld_rsid', $id)->delete();

        return redirect()->back()->withSuccess('You have successfully deleted!');;
    }
    public function consumerSaleDetailsDelete($id)
    {
        DB::table('consumer_sales')->where('fld_csid', $id)->delete();
        DB::table('consumer_sales_items')->where('fld_csid', $id)->delete();

        return redirect()->back()->withSuccess('You have successfully deleted!');;
    }

    public function retailSaleDetailsUpdate(Request $request)
    {
        try {
            DB::table('retail_sales')->where('fld_rsid', $request->fld_rsid)->update(['fld_date' => $request->fld_date, 'fld_total' => $request->fld_total]);
            DB::table('retail_sales_items')->where('fld_rsid', $request->fld_rsid)->delete();
            DB::table('retail_sales_items')->insert($request->items);

            return response()->json([
                'isSuccess' => true,
                'Message' => "Item updated successfuly"
            ], 200); // Status code here

        } catch (\Throwable $th) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Somethin went wrong"
            ], 500); // Status code here
        }
    }


    public function consumerSaleDetails($id)
    {
        $products = DB::table('products')->get();
        $consumerSale = DB::table('consumer_sales')->where('fld_csid', $id)->first();
        $records = DB::table('consumer_sales_items')
            ->select('consumer_sales_items.*', 'products.fld_name as product_name', 'products.fld_selling_price', 'products.fld_mrp')
            ->join('products', 'products.fld_pid', '=', 'consumer_sales_items.fld_pid', 'left')

            ->where('fld_csid', $id)->get();
        return view('consumersaledetails', compact('records', 'products', 'consumerSale'));
    }

    public function consumerSaleDetailsUpdate(Request $request)
    {
        try {
            DB::table('consumer_sales')->where('fld_csid', $request->fld_csid)->update(['fld_date' => $request->fld_date, 'fld_total' => $request->fld_total]);
            DB::table('consumer_sales_items')->where('fld_csid', $request->fld_csid)->delete();
            DB::table('consumer_sales_items')->insert($request->items);

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

        $query =  DB::table('consumer_sales')
            ->select(
                'consumer_sales.*',
                'consumers.fld_name as consumer_name',
                'consumers.fld_number as mobile_no',
                "x_villages.fld_village",
                "x_tehsils.fld_tehsil as tehsil",
                "x_districts.fld_district",
                "x_states.fld_state",
                "users.fld_name"
            )
            ->join('consumers', 'consumers.fld_cid', '=', 'consumer_sales.fld_cid')
            ->join('users', 'users.fld_uid', '=', 'consumer_sales.fld_uid')
            ->join('x_villages', 'x_villages.fld_vid', '=', 'consumers.fld_village_id')
            ->join('x_tehsils', 'x_tehsils.fld_tid', '=', 'consumers.fld_tehsil_id')
            ->join('x_districts', 'x_districts.fld_did', '=', 'consumers.fld_did', 'left')
            ->join('x_states', 'x_states.fld_sid', '=', 'consumers.fld_state_id', 'left');


        if ($project_id) {
            $query->where('consumer_sales.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
        }
        if ($request->user_id) {
            $query->where('users.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('consumers.fld_state_id', $request->state_id);
        }

        if ($request->start_date) {
            $query->where('consumer_sales.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('consumer_sales.fld_date', '<=', $request->end_date);
        }

        if ($request->district_id) {
            $query->where('consumers.fld_did', $request->district_id);
        }
        if ($cid) {
            $query->where('consumers.fld_cid', $cid);
        }

        if ($request->submit === "export") {
            $query = $query->where('users.fld_demo', 0);
            $fld_csids = $query->orderby('fld_date')->pluck('fld_csid')->toArray();
            $export = new ConsumerSaleExport($fld_csids);
            $file_name = 'consumer_sale_items' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }
        $total_order_value = $query->sum('fld_total');
        $records = $query->orderby('fld_date', 'desc')->paginate();
        return view('consumersales', compact('records', 'projects', 'districts', 'users', 'total_order_value'));
    }



    public function addNewOrder(Request $request)
    {
        //$records = ActivityReport::with('attenUser')->orderby('fld_prid')->paginate();
        $products = DB::table('products')->get();
        $retailer = Retailer::find($request->rid);
        $retailSale = RetailSale::find($request->retailer_sale_id);

        return view('addNewOrder', compact('products', 'retailSale', 'retailer'));
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



            $retailer = Retailer::find($request->fld_rid);
            $order = [
                'fld_mobile_id' => 'web',
                'fld_rid' => $retailer->fld_rid,
                'fld_uid' => $retailer->fld_uid,
                'fld_pid' => $retailer->fld_pid,
                'fld_total' => $request->fld_total,
                'fld_date' => now()
            ];

            $fld_rsid = DB::table('retail_sales')->insertGetId($order);
            $items = $request->items;
            $orderItem = [];
            foreach ($items  as $item) {
                $item['fld_rsid'] = $fld_rsid;
                $item['fld_date'] = now();
                $orderItem[] = $item;
            }

            DB::table('retail_sales_items')->insert($orderItem);

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
