<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
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
    public function index(Request $request)
    {
        $projects = DB::table('projects')->get();
        $users = $states = [];

        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }

        $query = Attendance::with('attenUser', 'project', 'state');
        if ($project_id) {
            $query->whereHas('project', function ($q) use ($project_id) {
                $q->where('fld_pid', $project_id);
            });
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        }

        if ($request->state_id) {
            $query->where('attendances.fld_state_id', $request->state_id);
        }

        if ($request->user_id) {
            $query->where('attendances.fld_uid', $request->user_id);
        }
        if ($request->start_date) {
            $query->whereDate('attendances.fld_datetime', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('attendances.fld_datetime', '<=', $request->end_date);
        }

        if ($request->submit === "export") {
            $records = $query->orderby('fld_datetime', 'desc')->get();
            $export = new AttendanceExport($records, $project_id);
            $file_name = 'attendance' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }


        $records = $query->orderby('fld_datetime', 'desc')->paginate();
        return view('attendance', compact('records', 'projects', 'states', 'users'));
    }


    public function getSummaryData()
    {
    }



    public function getStateByProjectID($project_id)
    {
        return  DB::table('attendances')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'attendances.fld_state_id')
            ->groupBy('attendances.fld_state_id')
            ->where('attendances.fld_pid', $project_id)->get();
    }

    public function getUsersProjectID($project_id)
    {
        return  DB::table('attendances')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'attendances.fld_uid')
            ->groupBy('attendances.fld_uid')
            ->where('attendances.fld_pid', $project_id)->get();
    }

    public function getUsersStatusID($state_id)
    {
        return  DB::table('attendances')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'attendances.fld_uid')
            ->groupBy('attendances.fld_uid')
            ->where('attendances.fld_state_id', $state_id)->get();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('attendances')
            ->where('attendances.fld_aid', $id)->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance deleted successfully');
    }
}
