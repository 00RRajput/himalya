<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Retailer;
use App\Models\RoutePlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportsController extends Controller
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


    public function reports(Request $request)
    {
    }
    public function routePlan(Request $request)
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
            'x_villages.fld_village as village_name'
        )
            ->with('attenUser', 'project')
            ->rightJoin('x_states', 'x_states.fld_sid', '=', 'route_plans.fld_state_id')
            ->rightJoin('x_districts', 'x_districts.fld_did', '=', 'route_plans.fld_district_id')
            ->rightJoin('x_villages', 'x_villages.fld_vid', '=', 'route_plans.fld_village_id');
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
        return view('report.routeplans', compact('records', 'projects', 'states', 'users', 'districts'));
    }



    public function getStateByProjectID($project_id)
    {
        return  DB::table('route_plans')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'route_plans.fld_state_id')
            ->groupBy('route_plans.fld_state_id')
            ->where('route_plans.fld_pid', $project_id)->get();
    }

    public function getDistrictByStateID($state_id)
    {
        return  DB::table('route_plans')
            ->select('x_districts.fld_did', 'x_districts.fld_district')
            ->join('x_districts', 'x_districts.fld_did', '=', 'route_plans.fld_district_id')
            ->groupBy('route_plans.fld_district_id')
            ->where('route_plans.fld_state_id', $state_id)->get();
    }
    public function getUsersProjectID($project_id)
    {
        return  DB::table('route_plans')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'route_plans.fld_uid')
            ->groupBy('route_plans.fld_uid')
            ->where('route_plans.fld_pid', $project_id)->get();
    }

    public function dayWiseSalesSummary(Request $request)
    {
        $records = RoutePlan::with('attenUser')->orderby('fld_rpid')->paginate();
        return view('report.day-wise-summary', compact('records'));
    }

    public function stockReport(Request $request)
    {
        $records = RoutePlan::with('attenUser')->orderby('fld_rpid')->paginate();
        return view('report.stock-report', compact('records'));
    }
}
