<?php

namespace App\Http\Controllers\Mandi;
use App\Http\Traits\BaseTrait;

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
    use BaseTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createRoutePlan(Request $request)
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $states = DB::table('x_states')->orderBy('fld_state')->get();
        $destrict = DB::table('x_districts')->orderBy('fld_district')->get();
        $towns = DB::table('x_towns')->orderBy('fld_town')->get();
        $mandis = DB::table('x_mandis')->orderBy('fld_mandi')->get();
        $wholesalers = DB::table('mandi_wholesalers')->orderBy('fld_wholesaler')->get();
        $users = DB::table('users')->orderBy('fld_name')->get();
        return view('mandi.createRoutePlan', compact('projects', 'states', 'destrict', 'towns', 'mandis', 'wholesalers', 'users'));
    }

    public function storeRoutePlan(Request $request)
    {
        $request->validate([
            'fld_project_id' => 'required',
            'wholesaler_id' => 'required',
            'user_id' => 'required',
            'state_id' => 'required',
            'mandi_id' => 'required',
            'district_id' => 'required',
            'fld_tid' => 'required',
            'fld_date' => 'required'
        ]);

        $data = [
            'fld_rphid' => 0,
            "fld_pid" => $request->fld_project_id,
            'fld_uid' => $request->user_id,
            "fld_state_id" => $request->state_id,
            "fld_district_id" => $request->district_id,
            "fld_town_id" => $request->fld_tid,
            'fld_mandi_id' => $request->mandi_id,
            'fld_wsid' => $request->wholesaler_id,
            // 'fld_village_id' => $request->village_id,
            "fld_user" => DB::table('users')->where('fld_uid', $request->user_id)->value('fld_name'),
            "fld_date" => $request->fld_date
        ];

        DB::table('mandi_routes')->insert($data);
        return redirect()->back()
            ->with('success', 'Route Plan successfully added');
    }


    public function updateRoutePlan(Request $request, $id)
    {
        $request->validate([
            'fld_project_id' => 'required',
            'wholesaler_id' => 'required',
            'user_id' => 'required',
            'state_id' => 'required',
            'mandi_id' => 'required',
            'district_id' => 'required',
            'fld_tid' => 'required',
            'fld_date' => 'required'
        ]);

        $data = [
            'fld_rphid' => 0,
            "fld_pid" => $request->fld_project_id,
            'fld_uid' => $request->user_id,
            "fld_state_id" => $request->state_id,
            "fld_district_id" => $request->district_id,
            "fld_town_id" => $request->fld_tid,
            'fld_mandi_id' => $request->mandi_id,
            'fld_wsid' => $request->wholesaler_id,
            // 'fld_village_id' => $request->village_id,
            "fld_user" => DB::table('users')->where('fld_uid', $request->user_id)->value('fld_name'),
            "fld_date" => $request->fld_date
        ];

        DB::table('mandi_routes')->where('fld_rpid', $id)->update($data);
        return redirect()->back()
            ->with('success', 'Route Plan successfully updated');
    }

    public function editRoutePlan($id)
    {

        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $states = DB::table('x_states')->orderBy('fld_state')->get();
        $destrict = DB::table('x_districts')->orderBy('fld_district')->get();
        $towns = DB::table('x_towns')->orderBy('fld_town')->get();
        $mandis = DB::table('x_mandis')->orderBy('fld_mandi')->get();
        $wholesalers = DB::table('mandi_wholesalers')->orderBy('fld_wholesaler')->get();
        $users = DB::table('users')->orderBy('fld_name')->get();
        
        $routePlan = DB::table('mandi_routes')->where('fld_rpid', $id)->first();
       
        return view('mandi.editRoutePlan', compact('projects', 'states', 'destrict', 'towns', 'mandis', 'wholesalers', 'users', 'routePlan'));
    }


    public function mandiRoutePlan(Request $request)
    {
        $users = $districts = $states = [];
        $projects = DB::table('projects')->where('fld_status', 1)->get();

        if ($request->project_id) {
            $project_id = $request->project_id;
        } else {
            $project_id = 2;
        }

        $query = DB::table('mandi_routes')->select(
            'mandi_routes.*',
            'x_states.fld_state as state_name',
            // 'x_districts.fld_district as district_name',
            // 'x_villages.fld_village as village_name',
            'x_towns.fld_town',
            'x_mandis.fld_mandi',
            'mandi_wholesalers.fld_wholesaler',
            'projects.fld_name as project_name'
        )
            // ->with('attenUser', 'project')
            ->leftJoin('x_states', 'x_states.fld_sid', '=', 'mandi_routes.fld_state_id')
            // ->leftJoin('x_districts', 'x_districts.fld_did', '=', 'mandi_routes.fld_district_id')
            ->leftJoin('x_towns', 'x_towns.fld_tid', '=', 'mandi_routes.fld_town_id')
            ->leftJoin('x_mandis', 'x_mandis.fld_mid', '=', 'mandi_routes.fld_mandi_id')
            ->leftJoin('mandi_wholesalers', 'mandi_wholesalers.fld_wsid', '=', 'mandi_routes.fld_wsid')
            ->leftJoin('projects', 'projects.fld_pid', '=', 'mandi_routes.fld_pid');
           
        if ($project_id) {
            $query->where('mandi_routes.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        }
        
        if ($request->state_id) {
            $query->where('mandi_routes.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }
        if ($request->district_id) {
            $query->where('mandi_routes.fld_district_id', $request->district_id);
        }

        if ($request->user_id) {
            $query->where('mandi_routes.fld_uid', $request->user_id);
        }
        if ($request->start_date) {
            $query->where('mandi_routes.fld_date', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->where('mandi_routes.fld_date', '<=', $request->end_date);
        }
        
        $records = $query->orderby('mandi_routes.fld_date', 'desc')
            ->paginate(20);
           
        return view('mandi.routeplans', compact('records', 'projects', 'states', 'users', 'districts'));
    }

    public function deleteRoutePlan($id)
    {

        DB::table('mandi_routes')->where('fld_rpid', $id)->delete();
        return redirect()->back()
            ->with('success', 'Route Plan successfully deleted');
    }

    public function getRoutePlan(Request $request)
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $records = DB::table('mandi_routes_historys')
            ->select('mandi_routes_historys.*', 'users.fld_name as user_name', 'projects.fld_name as project_name')
            ->join('users', 'users.fld_uid', '=', 'mandi_routes_historys.fld_uid')
            ->join('projects', 'projects.fld_pid', '=', 'mandi_routes_historys.fld_pid')
            ->orderBy('mandi_routes_historys.fld_mhrid', 'desc')->paginate();
        return view('mandi.uploadroute', compact('records', 'projects'));
    }

    public function uploadRoutePlan(Request $request)
    {
        try {
           
        $request->validate([
            'project_id' => 'required',
        ]);


        $res =   $this->showUploadFile($request, 'excel', 'uploads/routeplans');
        $project_id = $request->project_id;
        // dd($project_id, $res);
        $is_route_plan = DB::table('mandi_routes')->where('fld_pid', $project_id)->count();
        if ($is_route_plan) {
            DB::table('mandi_routes')->where('fld_date', date('Y-m-d'))->delete();
        }

        $insertedId = DB::table('mandi_routes_historys')->insertGetId([
            'fld_pid' => $project_id,
            'fld_uid' => Auth::user()->fld_uid,
            'fld_path' => $res['file_path'],
            'fld_file' => $res['name'],
            "fld_remark" => 'NA'
        ]);
       
        // Fetch the inserted record based on the ID
        $routePlanHistrory = DB::table('mandi_routes_historys')->where('fld_mhrid', $insertedId)->first();
        $rows = Excel::toArray(new RoutePlanImport($project_id), $res['file_path'])[0];
        $bluckData = [];
        unset($rows[0]);
        
        foreach ($rows as $key => $row) {
            /**
             * 0 Date
             * 1 State
             * 2 District
             * 3 Tehsil
             * 4 User
             * 5 Village
             */
            if ($row[0] === null && $row[1] === null && $row[2] === null && $row[3] === null && $row[4] === null && $row[5] === null) {
                break;
            }
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]);
            /**
             * Save the excel file in the Route plans history table
             * Once record save then extacrt the excel and perform the below steps:
             */
            $pid = $project_id;
            /**
             * Check current state present in the table if yes
             */
            $sid = $this->getState('x_states', 'fld_sid', ['fld_state' => $row[1]]);
            /**
             * Check current district present in the table if yes
             */
            $did =  $this->getDistrict($row[2], $sid);
           
            $tid =  $this->getTownId($row[2], $sid);
            /**
             * Check current user present in the table if yes then add that user with increament id 
             * exaple fld_username value BBMP05 already in table then next value will be BBMP05-1 and so on
             */
          
            /**
             * Check current district present in the table if yes
             */
            /**
             * Check current district present in the table if yes
             */
            // TehsSil ID
            // $fld_tid = $this->getTehsilId($row[3], ['fld_state_id' => $sid, 'fld_district_id' => $did, 'fld_tehsil' => $row[3]]);

            // Village ID
            // $fld_vid = $this->getVillageId($row[5], ['fld_state_id' => $sid, 'fld_district_id' => $did, 'fld_tehsil_id' => $fld_tid, 'fld_village' => $row[5]]);

            // Project ID
            $fld_pid = $this->getDBData('projects', 'fld_pid', ['fld_pid' => $pid]);

            $mId = $this->getMandiId($row[3], $sid, $tid);

            $user =  $this->getUserDetails($row[6], $pid, $sid, $key);

            $oId = $this->getOutletId($row[4], $sid, $tid, $pid, $user['fld_uid'], $did);

            $whId = $this->getWsId($row[5], $pid, $sid, $tid, $mId, $oId);


            
            $data = [
                'fld_rphid' => $routePlanHistrory->fld_mhrid,
                "fld_pid" => $fld_pid,
                'fld_uid' => $user['fld_uid'],
                "fld_state_id" => $sid,
                "fld_district_id" => $did,
                'fld_town_id' => $tid,
                'fld_mandi_id' => $mId,
                'fld_wsid' => $whId,
                "fld_user" => $user['username'],
                "fld_date" => $date
            ];

            $bluckData[] = $data;
            
        }
        
        DB::table('mandi_routes')->insert($bluckData);
        return redirect()->back();
         //code...
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function retailSales(Request $request)
    {
        // dd($request->all());
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
// dd($project_id);
        $query =  DB::table('mandi_retail_sales')
            ->select(
                'mandi_retail_sales.*',
                'mandi_retailers.fld_store_name as shop_name',
                'mandi_retailers.fld_owner_name as owner_name',
                'mandi_retailers.fld_number as mobile_no',
                "mandi_retailers.fld_village",
                // "x_tehsils.fld_tehsil as tehsil",
                "x_districts_mandi.fld_district",
                "x_states.fld_state",
                'x_towns.fld_town',
                "mandi_retailers.fld_photo_file",
                "mandi_retailers.fld_photo_path",
                "users.fld_name",
                'mandi_retailers.fld_rid'
            )
            ->selectRaw('CASE
                WHEN fld_type = 1 THEN "Retailer"
                WHEN fld_type = 2 THEN "Wholesaler"
                ELSE "Unknown"
                END AS shop_type
            ')
            ->join('mandi_retailers', 'mandi_retailers.fld_rid', '=', 'mandi_retail_sales.fld_mrid', 'left')
            ->join('users', 'users.fld_uid', '=', 'mandi_retail_sales.fld_uid', 'left')
            // ->join('x_villages', 'x_villages.fld_vid', '=', 'mandi_retailers.fld_village_id', 'left')
            ->join('x_towns', 'x_towns.fld_tid', '=', 'mandi_retailers.fld_town_id', 'left')
            // ->join('x_tehsils', 'x_tehsils.fld_tid', '=', 'mandi_retailers.fld_tehsil_id', 'left')
            ->join('x_districts_mandi', 'x_districts_mandi.fld_did', '=', 'mandi_retailers.fld_district_id', 'left')
            ->join('x_states', 'x_states.fld_sid', '=', 'mandi_retailers.fld_state_id', 'left');
            
        if ($project_id) {
            $query->where('mandi_retail_sales.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        }
        if ($request->user_id) {
            $query->where('users.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('mandi_retailers.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }

        if ($request->start_date) {
            $query->where('mandi_retail_sales.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('mandi_retail_sales.fld_date', '<=', $request->end_date);
        }

        if ($request->district_id) {
            $query->where('mandi_retailers.fld_did', $request->district_id);
        }
        $retailerName = null;
        if ($retailer_id) {
            $query->where('fld_rid', $retailer_id);
            $retailerName=DB::table('mandi_retailers')->where('fld_rid', $retailer_id)->value('fld_store_name');
           
        }


        // if ($request->submit === "export") {
        //     $query = $query->where('users.fld_demo', 0);
        //     $fld_rsids = $query->orderby('fld_date', 'desc')->pluck('fld_rsid')->toArray();
        //     $export = new RetailSaleExport($fld_rsids, $project_id);
        //     $file_name = 'mandiRetailSales' . '_' . date('d.m.Y');
        //     return Excel::download($export, $file_name . '_.xlsx');
        // }
        $total_order_value = $query->sum('mandi_retail_sales.fld_total');
        $records = $query->orderby('fld_date', 'desc')->paginate();
        // dd($records);
        return view('mandi.retailsales', compact('records', 'projects','retailerName', 'states', 'districts', 'users', 'total_order_value'));
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
        $retailSale = DB::table('mandi_retail_sales')->where('fld_rsid', $id)->first();
        $records = DB::table('mandi_retail_sales_items')
            ->select('mandi_retail_sales_items.*', 'products.fld_name as product_name', 'products.fld_selling_price', 'products.fld_mrp')
            ->join('products', 'products.fld_pid', '=', 'mandi_retail_sales_items.fld_pid', 'left')
            ->where('fld_mrsid', $id)->get();
         
        return view('mandi.retailsaledetails', compact('records', 'products', 'retailSale'));
    }

    public function retailSaleDetailsDelete($id)
    {
        DB::table('mandi_retail_sales')->where('fld_rsid', $id)->delete();
        DB::table('mandi_retail_sales_items')->where('fld_mrsid', $id)->delete();

        return redirect()->back()->withSuccess('You have successfully deleted!');;
    }
    public function consumerSaleDetailsDelete($id)
    {
        DB::table('mandi_consumer_sales')->where('fld_mcsid', $id)->delete();
        DB::table('mandi_consumer_sales_items')->where('fld_mcsid', $id)->delete();

        return redirect()->back()->withSuccess('You have successfully deleted!');;
    }

    public function retailSaleDetailsUpdate(Request $request)
    {
        try {
            DB::table('mandi_retail_sales')->where('fld_rsid', $request->fld_rsid)->update(['fld_date' => $request->fld_date, 'fld_total' => $request->fld_total]);
            DB::table('mandi_retail_sales_items')->where('fld_mrsid', $request->fld_rsid)->delete();
            // dd('hdhd');
            DB::table('mandi_retail_sales_items')->insert($request->items);

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
        $consumerSale = DB::table('mandi_consumer_sales')->where('fld_mcsid', $id)->first();
       
        $records = DB::table('mandi_consumer_sales_items')
            ->select('mandi_consumer_sales_items.*', 'products.fld_name as product_name', 'products.fld_selling_price', 'products.fld_mrp')
            ->join('products', 'products.fld_pid', '=', 'mandi_consumer_sales_items.fld_pid', 'left')

            ->where('fld_mcsid', $id)->get();
           
        return view('mandi.consumersaledetails', compact('records', 'products', 'consumerSale'));
    }

    public function consumerSaleDetailsUpdate(Request $request)
    {
        try { 
            DB::table('mandi_consumer_sales')->where('fld_mcsid', $request->fld_mcsid)->update(['fld_date' => $request->fld_date, 'fld_total' => $request->fld_total]);
            DB::table('mandi_consumer_sales_items')->where('fld_mcsid', $request->fld_mcsid)->delete();
            DB::table('mandi_consumer_sales_items')->insert($request->items);

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

        $query =  DB::table('mandi_consumer_sales')
            ->select(
                'mandi_consumer_sales.*',
                'mandi_consumers.fld_name as consumer_name',
                'mandi_consumers.fld_number as mobile_no',
                'mandi_consumers.fld_village',
                // "x_villages.fld_village",
                "x_towns.fld_town",
                // "x_tehsils.fld_tehsil as tehsil",
                "x_districts_mandi.fld_district",
                "x_states.fld_state",
                "users.fld_name"
            )
            ->join('mandi_consumers', 'mandi_consumers.fld_cid', '=', 'mandi_consumer_sales.fld_mcid')
            ->join('users', 'users.fld_uid', '=', 'mandi_consumer_sales.fld_uid')
            ->join('x_towns', 'x_towns.fld_tid', '=', 'mandi_consumers.fld_town_id')
            // ->join('x_tehsils', 'x_tehsils.fld_tid', '=', 'mandi_consumers.fld_tehsil_id')
            ->join('x_districts_mandi', 'x_districts_mandi.fld_did', '=', 'mandi_consumers.fld_district_id', 'left')
            ->join('x_states', 'x_states.fld_sid', '=', 'mandi_consumers.fld_state_id', 'left');


        if ($project_id) {
            $query->where('mandi_consumer_sales.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
        }
        if ($request->user_id) {
            $query->where('users.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('mandi_consumers.fld_state_id', $request->state_id);
        }

        if ($request->start_date) {
            $query->where('mandi_consumer_sales.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('mandi_consumer_sales.fld_date', '<=', $request->end_date);
        }

        if ($request->district_id) {
            $query->where('mandi_consumers.fld_did', $request->district_id);
        }
        if ($cid) {
            $query->where('mandi_consumers.fld_cid', $cid);
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
        return view('mandi.consumersales', compact('records', 'projects', 'districts', 'users', 'total_order_value'));
    }



    public function addNewOrder(Request $request)
    {
        $products = DB::table('products')->get();
        $retailer = DB::table('mandi_retailers')->where('fld_rid', $request->rid)->first();
        $retailSale = DB::table('mandi_retail_sales')->where('fld_mrid', $request->rid)->first();
      
        return view('mandi.addNewOrder', compact('products', 'retailSale', 'retailer'));
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



             $retailer = DB::table('mandi_retailers')->where('fld_rid', $request->fld_rid)->first();
            
            $order = [
                'fld_mobile_id' => 'web',
                'fld_mrid' => $retailer->fld_rid,
                'fld_uid' => $retailer->fld_uid,
                'fld_pid' => $retailer->fld_pid,
                'fld_total' => $request->fld_total,
                'fld_date' => now()
            ];

            $fld_rsid = DB::table('mandi_retail_sales')->insertGetId($order);
            $items = $request->items;
            $orderItem = [];
            foreach ($items  as $item) {
                $item['fld_mrsid'] = $fld_rsid;
                $item['fld_date'] = now();
                $orderItem[] = $item;
            }

            DB::table('mandi_retail_sales_items')->insert($orderItem);

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
