<?php

namespace App\Http\Controllers;

use App\Http\Traits\BaseTrait;
use App\Models\ActivityPhoto;
use App\Models\PurchaseDetail;
use App\Models\RoutePlan;
use Illuminate\Http\Request;
use App\Imports\RoutePlanEx;
use App\Imports\RoutePlanImport;
use App\Models\District;
use App\Models\PhotoType;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\RoutePlansHistory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getClients(Request $request)
    {
        $records = DB::table('clients')->orderby('fld_cid', 'desc')->paginate();
        return view('purchasedetail', compact('records'));
    }

    public function getProjects(Request $request)
    {
        $records = ActivityPhoto::with('attenUser')->orderby('fld_prid')->paginate();
        return view('activityPhoto', compact('records'));
    }

    public function getPhotoTypes(Request $request)
    {
        $records = PhotoType::orderby('fld_ptid')->paginate();
        return view('phototype.index', compact('records'));
    }

    public function getRoutePlan(Request $request)
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $records = DB::table('route_plans_historys')
            ->select('route_plans_historys.*', 'users.fld_name as user_name', 'projects.fld_name as project_name')
            ->join('users', 'users.fld_uid', '=', 'route_plans_historys.fld_uid')
            ->join('projects', 'projects.fld_pid', '=', 'route_plans_historys.fld_pid')
            ->orderBy('route_plans_historys.fld_rphid', 'desc')->paginate();
        return view('masters.route-plans.index', compact('records', 'projects'));
    }

    public function deleteRoutePlan($id)
    {

        DB::table('route_plans')->where('fld_rpid', $id)->delete();
        return redirect()->back()
            ->with('success', 'Route Plan successfully deleted');
    }

    public function updateRoutePlan(Request $request, $id)
    {
        $request->validate([
            'fld_username' => 'required',
            'fld_uid' => 'required',
            'state_id' => 'required',
            'district_id' => 'required',
            'fld_tid' => 'required',
            'village_id' => 'required',
            'fld_date' => 'required'
        ]);

        $data = [
            'fld_rphid' => 0,
            'fld_uid' => $request->fld_uid,
            "fld_state_id" => $request->state_id,
            "fld_district_id" => $request->district_id,
            'fld_tehsil_id' => $request->fld_tid,
            'fld_village_id' => $request->village_id,
            "fld_user" => $request->fld_username,
            "fld_date" => $request->fld_date
        ];

        DB::table('route_plans')->where('fld_rpid', $id)->update($data);
        return redirect()->back()
            ->with('success', 'Route Plan successfully updated');
    }

    public function editRoutePlan($id)
    {
        $routePlan = DB::table('route_plans')->where('fld_rpid', $id)->first();
        $states = DB::table('x_states')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('route_plans', 'route_plans.fld_state_id', '=', 'x_states.fld_sid')
            ->distinct('fld_pid')
            ->where('fld_pid', $routePlan->fld_pid)->orderBy('fld_state')->get();
        $districts = DB::table('x_districts')->where('fld_state_id', $routePlan->fld_state_id)->orderBy('fld_district')->get();
        $villages = DB::table('x_villages')->where('fld_district_id', $routePlan->fld_district_id)->orderBy('fld_village')->get();
        $users = DB::table('users')->select('users.fld_uid', 'users.fld_username')->where('fld_project_id', $routePlan->fld_pid)->where('fld_role', 2)->get();
        return view('editRoutePlan', compact('districts', 'states', 'villages', 'routePlan', 'users'));
    }

    public function createRoutePlan(Request $request)
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $states = DB::table('x_states')->orderBy('fld_state')->get();
        return view('createRoutePlan', compact('projects', 'states'));
    }
    public function storeRoutePlan(Request $request)
    {
        $request->validate([
            'fld_project_id' => 'required',
            'fld_username' => 'required',
            'fld_uid' => 'required',
            'state_id' => 'required',
            'district_id' => 'required',
            'fld_tid' => 'required',
            'village_id' => 'required',
            'fld_date' => 'required'
        ]);

        $data = [
            'fld_rphid' => 0,
            "fld_pid" => $request->fld_project_id,
            'fld_uid' => $request->fld_uid,
            "fld_state_id" => $request->state_id,
            "fld_district_id" => $request->district_id,
            'fld_tehsil_id' => $request->fld_tid,
            'fld_village_id' => $request->village_id,
            "fld_user" => $request->fld_username,
            "fld_date" => $request->fld_date
        ];

        DB::table('route_plans')->insert($data);
        return redirect()->back()
            ->with('success', 'Route Plan successfully added');
    }
    public function uploadRoutePlan(Request $request)
    {

        $request->validate([
            'project_id' => 'required',
        ]);


        $res =   $this->showUploadFile($request, 'excel', 'uploads/routeplans');
        $project_id = $request->project_id;

        $is_route_plan = RoutePlan::where('fld_pid', $project_id)->count();
        if ($is_route_plan) {
            RoutePlan::where('fld_date', date('Y-m-d'))->delete();
        }

        $routePlanHistrory =  RoutePlansHistory::create([
            'fld_pid' => $project_id,
            'fld_uid' => Auth::user()->fld_uid,
            'fld_file_path' => $res['file_path'],
            'fld_file_name' => $res['name'],
            "fld_remark" => 'NA'
        ]);
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
            /**
             * Check current user present in the table if yes then add that user with increament id 
             * exaple fld_username value BBMP05 already in table then next value will be BBMP05-1 and so on
             */
            $user =  $this->getUserDetails($row[4], $pid, $sid, $key);
            /**
             * Check current district present in the table if yes
             */
            /**
             * Check current district present in the table if yes
             */
            // TehsSil ID
            $fld_tid = $this->getTehsilId($row[3], ['fld_state_id' => $sid, 'fld_district_id' => $did, 'fld_tehsil' => $row[3]]);

            // Village ID
            $fld_vid = $this->getVillageId($row[5], ['fld_state_id' => $sid, 'fld_district_id' => $did, 'fld_tehsil_id' => $fld_tid, 'fld_village' => $row[5]]);

            // Project ID
            $fld_pid = $this->getDBData('projects', 'fld_pid', ['fld_pid' => $pid]);
            $data = [
                'fld_rpid' => $routePlanHistrory->fld_rphid,
                "fld_pid" => $fld_pid,
                'fld_uid' => $user['fld_uid'],
                "fld_state_id" => $sid,
                "fld_district_id" => $did,
                'fld_tehsil_id' => $fld_tid,
                'fld_village_id' => $fld_vid,
                "fld_user" => $user['username'],
                "fld_date" => $date
            ];

            $bluckData[] = $data;
        }
        DB::table('route_plans')->insert($bluckData);
        return redirect()->back();
    }
    public function uploadProducts(Request $request)
    {
        $request->validate([
            'fld_project_id' => 'required',
        ]);

        $res =   $this->showUploadFile($request, 'excel', 'uploads/products');
        $project_id = $request->project_id;

        $is_route_plan = RoutePlan::where('fld_pid', $project_id)->count();
        if ($is_route_plan) {
            RoutePlan::where('fld_date', date('Y-m-d'))->delete();
        }

        $rphid =  ProductHistory::create([
            'fld_pid' => $project_id,
            'fld_uid' => Auth::user()->fld_uid,
            'fld_path' => $res['file_path'],
            'fld_file' => $res['name'],
            "fld_remark" => 'NA'
        ]);

        $rows = Excel::toArray(new RoutePlanImport($project_id), $res['file_path'])[0];
        $isAOrR = (isset($request->aorr)) ? true : false;
        if ($isAOrR) {
            DB::table('products')->where('fld_p_id', $request->project_id)->delete();
        }


        $bluckData = [];
        unset($rows[0]);
        foreach ($rows as $key => $row) {
            $pid = $project_id;
            $data = [
                // 'fld_rphid' => $rphid,
                "fld_p_id" => $pid,
                "fld_sku" => $row['0'],
                "fld_name" => $row['1'],
                "fld_type" => 1,
                'fld_status' => 1,
                'fld_display_order' => 0,
            ];
            $bluckData[] = $data;
        }
        DB::table('products')->insert($bluckData);
        return redirect()->back();
    }

    public function getProducts(Request $request)
    {
        $records = RoutePlan::with('attenUser')->orderby('fld_prid')->paginate();
        return view('activityreport', compact('records'));
    }
    public function getUsers(Request $request)
    {
        $records = RoutePlan::with('attenUser')->orderby('fld_prid')->paginate();
        return view('activityreport', compact('records'));
    }
}
