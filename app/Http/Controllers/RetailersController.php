<?php

namespace App\Http\Controllers;

use App\Exports\RetailerExport;
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

class RetailersController extends Controller
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
        $users = $states = $districts = [];
        $projects = DB::table('projects')->get();
        $query = Retailer::select(
            'retailers.fld_rid',
            'retailers.fld_owner_name',
            'retailers.fld_store_name',
            'retailers.fld_number',
            'retailers.fld_pid',
            'retailers.fld_did',
            'retailers.fld_state_id',
            'retailers.fld_uid',
            'retailers.fld_type',
            'retailers.fld_comments_1',
            'retailers.fld_comments_2',
            'retailers.fld_comments_3',
            'retailers.fld_village_id',
            'retailers.fld_tehsil_id',
            'retailers.fld_lat',
            'retailers.fld_long',
            'retailers.fld_photo_path',
            'retailers.fld_photo_file',
            'retailers.fld_created_at',
            'users.fld_name as username',
            'x_states.fld_state',
            'x_districts.fld_district',
            'x_villages.fld_village',
            'x_tehsils.fld_tehsil',
            'projects.fld_name as project_name',
            DB::raw('(SELECT SUM(fld_total) FROM tbl_retail_sales WHERE tbl_retail_sales.fld_rid = fld_rid) AS retail_sale_count_sum_fld_total'),
            DB::raw('(SELECT COUNT(*) FROM tbl_retail_sales WHERE tbl_retail_sales.fld_rid = fld_rid) AS order_count')
         )
            ->leftJoin('x_states', 'x_states.fld_sid', '=', 'retailers.fld_state_id')
            ->leftJoin('x_districts', 'x_districts.fld_did', '=', 'retailers.fld_did')
            ->leftJoin('x_villages', 'x_villages.fld_vid', '=', 'retailers.fld_village_id')
            ->leftJoin('x_tehsils', 'x_tehsils.fld_tid', '=', 'retailers.fld_tehsil_id')
            ->leftJoin('projects', 'projects.fld_pid', '=', 'retailers.fld_pid')
            ->leftJoin('users', 'users.fld_uid', '=', 'retailers.fld_uid')
            ->withSum('retailSaleCount', 'fld_total');
        if ($request->submit === 'reset') {
            $request->session()->forget('project_id');
            return redirect()->back();
        }

        if ($request->project_id) {
            $project_id = $request->project_id;
        } elseif (session('project_id')) {
            $project_id = session('project_id');
        } else {
            $project_id = 0;
        }
        
        if ($project_id) {
            $query->where('retailers.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        } else {
            $request->session()->forget('project_id');
        }

        if ($request->user_id) {
            $query->where('retailers.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('retailers.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }

        if ($request->district_id) {
            $query->where('retailers.fld_did', $request->district_id);
        }
        if ($request->submit === "export") {
            $records = $query->orderby('retailers.fld_rid', 'desc')->get();
            $export = new RetailerExport($records, $project_id);
            $file_name = 'retailers' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }

        $records = $query->orderby('retailers.fld_rid', 'desc')->paginate();
      
        return view('retailers', compact('records', 'projects', 'states', 'districts', 'users'));
    }



    public function getStateByProjectID($project_id)
    {
        return  DB::table('retailers')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'retailers.fld_state_id')
            ->groupBy('retailers.fld_state_id')
            ->where('retailers.fld_pid', $project_id)->get();
    }
    public function getUsersProjectID($project_id)
    {
        return  DB::table('retailers')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'retailers.fld_uid')
            ->groupBy('retailers.fld_uid')
            ->where('retailers.fld_pid', $project_id)->get();
    }
    public function getDistrictByStateID($state_id)
    {
        return  DB::table('retailers')
            ->select('x_districts.fld_did', 'x_districts.fld_district')
            ->join('x_districts', 'x_districts.fld_did', '=', 'retailers.fld_did')
            ->groupBy('retailers.fld_did')
            ->where('retailers.fld_state_id', $state_id)->get();
    }


    function getRetailerOrders($fld_rid)
    {
        return RetailSale::with('items')->where('fld_rid', $fld_rid)->get();
    }

    function deleteRetaile($fld_rid)
    {
        return RetailSale::with('items')->where('fld_rid', $fld_rid)->get();
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $retailer = Retailer::find($id);
        // Delete user along with related orders and order items
        $retailer->orders()->each(function ($order) {
            $order->items()->delete(); // Delete order items
            $order->delete(); // Delete order
        });

        $retailer->delete(); // Delete user
        return redirect()->route('retailers')
            ->with('success', 'Retailer deleted successfully');
    }
}
