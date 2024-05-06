<?php

namespace App\Http\Controllers\Mela;
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

class MelaRoutePlanController extends Controller
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


      public function melaRoutePlan(Request $request)
    {
        $users = $districts = $states = [];
        $projects = DB::table('projects')->where('fld_status', 1)->get();

        if ($request->project_id) {
            $project_id = $request->project_id;
        } else {
            $project_id = 3;
        }

        $query = DB::table('mela_routes')->select(
            'mela_routes.*',
            'x_states.fld_state as state_name',
            'x_districts.fld_district as district_name',
            'x_villages_mela.fld_village as village_name',
            'projects.fld_name as project_name'
        )
            // ->with('attenUser', 'project')
            ->rightJoin('x_states', 'x_states.fld_sid', '=', 'mela_routes.fld_state_id')
            ->rightJoin('x_districts', 'x_districts.fld_did', '=', 'mela_routes.fld_district_id')
            ->rightJoin('x_villages_mela', 'x_villages_mela.fld_vid', '=', 'mela_routes.fld_village_id')
            ->rightJoin('projects', 'projects.fld_pid', '=', 'mela_routes.fld_pid');
        if ($project_id) {
            $query->where('mela_routes.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            
            $states = $this->getStateByProjectID($project_id);
          
        }
       
        if ($request->state_id) {
            $query->where('mela_routes.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }
        
        if ($request->district_id) {
            $query->where('mela_routes.fld_district_id', $request->district_id);
        }

        if ($request->user_id) {
            $query->where('mela_routes.fld_uid', $request->user_id);
        }
        if ($request->start_date) {
            $query->where('mela_routes.fld_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('mela_routes.fld_date', '<=', $request->end_date);
        }

        $records = $query->orderby('mela_routes.fld_date', 'desc')
            ->paginate(20);
       
        return view('mela.routeplans', compact('records', 'projects', 'states', 'users', 'districts'));
    }

    public function deleteRoutePlan($id)
    {

        DB::table('mela_routes')->where('fld_rpid', $id)->delete();
        return redirect()->back()
            ->with('success', 'Route Plan successfully deleted');
    }

    public function getRoutePlan(Request $request)
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $records = DB::table('mela_routes_historys')
            ->select('mela_routes_historys.*', 'users.fld_name as user_name', 'projects.fld_name as project_name')
            ->join('users', 'users.fld_uid', '=', 'mela_routes_historys.fld_uid')
            ->join('projects', 'projects.fld_pid', '=', 'mela_routes_historys.fld_pid')
            ->orderBy('mela_routes_historys.fld_mhid', 'desc')->paginate();
        return view('mela.uploadroute', compact('records', 'projects'));
    }


    public function updateRoutePlan(Request $request, $id)
    {
        $request->validate([
            'fld_username' => 'required',
            'fld_uid' => 'required',
            'state_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'fld_date' => 'required'
        ]);

        $data = [
            'fld_rphid' => 0,
            'fld_uid' => $request->fld_uid,
            "fld_state_id" => $request->state_id,
            "fld_district_id" => $request->district_id,
            'fld_village_id' => $request->village_id,
            "fld_user" => $request->fld_username,
            "fld_date" => $request->fld_date
        ];

        DB::table('mela_routes')->where('fld_rpid', $id)->update($data);
        return redirect()->back()
            ->with('success', 'Route Plan successfully updated');
    }

    public function editRoutePlan($id)
    {
        $routePlan = DB::table('mela_routes')->where('fld_rpid', $id)->first();
        $states = DB::table('x_states')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('mela_routes', 'mela_routes.fld_state_id', '=', 'x_states.fld_sid')
            ->distinct('fld_pid')
            ->where('fld_pid', $routePlan->fld_pid)->orderBy('fld_state')->get();
        $districts = DB::table('x_districts')->where('fld_state_id', $routePlan->fld_state_id)->orderBy('fld_district')->get();
        $villages = DB::table('x_villages')->where('fld_district_id', $routePlan->fld_district_id)->orderBy('fld_village')->get();
        $users = DB::table('users')->select('users.fld_uid', 'users.fld_username')->where('fld_project_id', $routePlan->fld_pid)->where('fld_role', 2)->get();
        return view('mela.editRoutePlan', compact('districts', 'states', 'villages', 'routePlan', 'users'));
    }

    public function createRoutePlan(Request $request)
    {
        $projects = DB::table('projects')->where('fld_status', 1)->get();
        $states = DB::table('x_states')->orderBy('fld_state')->get();
        // $districts = DB::table('x_districts')
        return view('mela.createRoutePlan', compact('projects', 'states'));
    }
    public function storeRoutePlan(Request $request)
    {
        $request->validate([
            'fld_project_id' => 'required',
            'fld_username' => 'required',
            'fld_uid' => 'required',
            'state_id' => 'required',
            'district_id' => 'required',
            // 'fld_tid' => 'required',
            'village_id' => 'required',
            'fld_date' => 'required'
        ]);

        $data = [
            'fld_rphid' => 0,
            "fld_pid" => $request->fld_project_id,
            'fld_uid' => $request->fld_uid,
            "fld_state_id" => $request->state_id,
            "fld_district_id" => $request->district_id,
            // 'fld_tehsil_id' => $request->fld_tid,
            'fld_village_id' => $request->village_id,
            "fld_user" => $request->fld_username,
            "fld_date" => $request->fld_date
        ];

        DB::table('mela_routes')->insert($data);
        return redirect()->back()
            ->with('success', 'Route Plan successfully added');
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
        $is_route_plan = DB::table('mela_routes')->where('fld_rpid', $project_id)->count();
        if ($is_route_plan) {
            DB::table('mela_routes')->where('fld_date', date('Y-m-d'))->delete();
        }

        $insertedId = DB::table('mela_routes_historys')->insertGetId([
            'fld_pid' => $project_id,
            'fld_uid' => Auth::user()->fld_uid,
            'fld_path' => $res['file_path'],
            'fld_file' => $res['name'],
            "fld_remark" => 'NA'
        ]);
        // dd($res);
        // Fetch the inserted record based on the ID
        $routePlanHistrory = DB::table('mela_routes_historys')->where('fld_mhid', $insertedId)->first();
        $rows = Excel::toArray(new RoutePlanImport($project_id), $res['file_path'])[0];
        $bluckData = [];
        unset($rows[0]);
        
        foreach ($rows as $key => $row) {
            /**
             * 0 Date
             * 1 State
             * 2 District
             * 3 User
             * 4 Village
             */
            if ($row[0] === null && $row[1] === null && $row[2] === null && $row[3] === null && $row[4] === null) {
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
           
            // $tid =  $this->getTownId($row[2], $sid);
            /**
             * Check current user present in the table if yes then add that user with increament id 
             * exaple fld_username value BBMP05 already in table then next value will be BBMP05-1 and so on
             */
          
            // Village ID
            $fld_vid = $this->getVillageId($row[3], ['fld_state_id' => $sid, 'fld_district_id' => $did, 'fld_village' => $row[3]]);

            // Project ID
            $fld_pid = $this->getDBData('projects', 'fld_pid', ['fld_pid' => $pid]);

            $user =  $this->getUserDetails($row[4], $pid, $sid, $key);
           
            $data = [
                'fld_rphid' => $routePlanHistrory->fld_mhid,
                "fld_pid" => $fld_pid,
                'fld_uid' => $user['fld_uid'],
                "fld_state_id" => $sid,
                "fld_district_id" => $did,
                'fld_village_id' => $fld_vid,
                "fld_user" => $user['username'],
                "fld_date" => $date
            ];

            $bluckData[] = $data;
            
        }
        
        DB::table('mela_routes')->insert($bluckData);
        return redirect()->back();
         //code...
        } catch (\Throwable $th) {
            dd($th);
        }
    }


    public function getStateByProjectID($project_id)
    {
        return  DB::table('users')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'users.fld_state_id')
            ->groupBy('users.fld_state_id')
            ->where('users.fld_project_id', $project_id)->get();
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
}