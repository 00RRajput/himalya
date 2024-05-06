<?php

namespace App\Http\Controllers\Mandi;

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
use App\Http\Controllers\Controller;

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
        $query = DB::table('mandi_retailers')->select(
            'mandi_retailers.fld_rid',
            'mandi_retailers.fld_owner_name',
            'mandi_retailers.fld_store_name',
            'mandi_retailers.fld_number',
            'mandi_retailers.fld_pid',
            'mandi_retailers.fld_district_id',
            'mandi_retailers.fld_state_id',
            'mandi_retailers.fld_uid',
            'mandi_retailers.fld_type',
            'mandi_retailers.fld_comments_1',
            'mandi_retailers.fld_comments_2',
            'mandi_retailers.fld_comments_3',
            'mandi_retailers.fld_village',
            // 'mandi_retailers.fld_tehsil_id',
            'x_towns.fld_town',
            'mandi_retailers.fld_lat',
            'mandi_retailers.fld_long',
            'mandi_retailers.fld_photo_path',
            'mandi_retailers.fld_photo_file',
            'mandi_retailers.fld_created_at',
            'users.fld_name as username',
            'x_states.fld_state',
            'x_districts_mandi.fld_district',
            'mandi_retailers.fld_village',
            'projects.fld_name as project_name',
            DB::raw('(SELECT SUM(fld_total) FROM tbl_mandi_retail_sales WHERE tbl_mandi_retail_sales.fld_mrid = fld_rid) AS retail_sale_count_sum_fld_total'),
            DB::raw('(SELECT COUNT(*) FROM tbl_mandi_retail_sales WHERE tbl_mandi_retail_sales.fld_mrid = fld_rid) AS order_count')
         )
            ->rightJoin('x_states', 'x_states.fld_sid', '=', 'mandi_retailers.fld_state_id')
            ->rightJoin('x_districts_mandi', 'x_districts_mandi.fld_did', '=', 'mandi_retailers.fld_district_id')
            ->rightJoin('x_towns', 'x_towns.fld_tid', '=', 'mandi_retailers.fld_town_id')
            ->rightJoin('projects', 'projects.fld_pid', '=', 'mandi_retailers.fld_pid')
            ->rightJoin('users', 'users.fld_uid', '=', 'mandi_retailers.fld_uid');
           
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
            $query->where('mandi_retailers.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        } else {
            $request->session()->forget('project_id');
        }

        if ($request->user_id) {
            $query->where('mandi_retailers.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('mandi_retailers.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }

        if ($request->district_id) {
            $query->where('mandi_retailers.fld_district_id', $request->district_id);
        }
        if ($request->submit === "export") {
            $records = $query->orderby('mandi_retailers.fld_rid', 'desc')->get();
            $export = new RetailerExport($records, $project_id);
            $file_name = 'mandi_retailers' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }
        // $retailSaleCount = $query->sum('fld_total');
        $records = $query->orderby('mandi_retailers.fld_rid', 'desc')->paginate();
    //   dd($records, $projects, $states, $districts, $users);
        return view('mandi.retailers', compact('records', 'projects', 'states', 'districts', 'users'));
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

        $retailer = DB::table('mandi_retailers')->where('fld_rid', $id)->first();
if ($retailer) {
    $orders = DB::table('mandi_retail_sales')->where('fld_mrid', $id)->get();
    $orders->each(function ($order) {
        DB::table('mandi_retail_sales_items')->where('fld_mrsid', $order->fld_rsid)->delete();
        DB::table('mandi_retail_sales')->where('fld_rsid', $order->fld_rsid)->delete();
    });

    DB::table('mandi_retailers')->where('fld_rid', $id)->delete();
}
        return redirect()->route('mandi.retailers')
            ->with('success', 'Retailer deleted successfully');
    }
}
