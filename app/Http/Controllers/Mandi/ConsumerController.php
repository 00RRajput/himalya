<?php

namespace App\Http\Controllers\Mandi;

use App\Exports\ConsumerSaleExport;
use App\Models\Consumer;
use App\Models\ConsumerSale;
use Dotenv\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use App\Http\Controllers\Controller;

class ConsumerController extends Controller
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


    public function index(Request $request)
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

        $query =  DB::table('mandi_consumers')
            ->select(
                'mandi_consumers.fld_cid',
                'mandi_consumers.fld_pid',
                'mandi_consumers.fld_district_id',
                'mandi_consumers.fld_state_id',
                'mandi_consumers.fld_uid',
                'mandi_consumers.fld_name as consumer_name',
                'mandi_consumers.fld_number',
                'mandi_consumers.fld_remark',
                'mandi_consumers.fld_remark2',
                'mandi_consumers.fld_remark3',
                // 'mandi_consumers.fld_village_id',
                // 'mandi_consumers.fld_tehsil_id',
                'mandi_consumers.fld_lat',
                'mandi_consumers.fld_long',
                'mandi_consumers.fld_created_at',
                'mandi_consumers.fld_village',
                'projects.fld_name as project_name',
                // "x_villages.fld_village as village_name",
                // "x_tehsils.fld_tehsil as tehsil_name",
                "x_districts_mandi.fld_district as district_name",
                "x_states.fld_state as state_name",
                "users.fld_name",
                "mandi_consumer_sales.fld_total"
            )

            ->join('x_states', 'x_states.fld_sid', '=', 'mandi_consumers.fld_state_id')
            ->join('users', 'users.fld_uid', '=', 'mandi_consumers.fld_uid', 'left')
            // ->join('x_villages', 'x_villages.fld_vid', '=', 'mandi_consumers.fld_village_id', 'left')
            ->join('x_towns', 'x_towns.fld_tid', '=', 'mandi_consumers.fld_town_id', 'left')
            // ->join('x_tehsils', 'x_tehsils.fld_tid', '=', 'mandi_consumers.fld_tehsil_id', 'left')
            ->join('x_districts_mandi', 'x_districts_mandi.fld_did', '=', 'mandi_consumers.fld_district_id', 'left')
            ->join('mandi_consumer_sales', 'mandi_consumer_sales.fld_mcid', '=', 'mandi_consumers.fld_cid', 'left')
            ->join('projects', 'projects.fld_pid', '=', 'mandi_consumers.fld_pid');

        if ($project_id) {
            $query->where('mandi_consumers.fld_pid', $project_id);
            $request->session()->put('project_id', $project_id);
            $states = $this->getStateByProjectID($project_id);
            $users = $this->getUsersProjectID($project_id);
        }
        if ($request->user_id) {
            $query->where('mandi_consumers.fld_uid', $request->user_id);
        }

        if ($request->state_id) {
            $query->where('mandi_consumers.fld_state_id', $request->state_id);
            $districts =  $this->getDistrictByStateID($request->state_id);
        }

        if ($request->start_date) {
            $query->where('mandi_consumers.fld_created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('mandi_consumers.fld_created_at', '<=', $request->end_date);
        }

        if ($request->district_id) {
            $query->where('mandi_consumers.fld_district_id', $request->district_id);
        }
        if ($retailer_id) {
            $query->where('mandi_consumers.fld_rid', $retailer_id);
        }


        if ($request->submit === "export") {
            $query = $query->where('users.fld_demo', 0);
            $fld_rsids = $query->orderby('fld_created_at', 'desc')->get();
            $export = new ConsumerSaleExport($fld_rsids);
            $file_name = 'consumers' . '_' . date('d.m.Y');
            return Excel::download($export, $file_name . '_.xlsx');
        }

        $records = $query->orderby('fld_created_at', 'desc')->paginate();
        // dd($records);
        return view('mandi.consumer.index', compact('records', 'projects', 'states', 'districts', 'users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $states = DB::table('x_states')->get();
        $projects = DB::table('projects')->get();
        return view('user.create', compact('states', 'projects'));
    }




    public function addNewOrder(Request $request)
    {
        //$records = ActivityReport::with('attenUser')->orderby('fld_prid')->paginate();
        $products = DB::table('products')->get();
        $consumer = DB::table('mandi_consumers')->where('fld_cid', $request->cid)->first();

        return view('mandi.consumer.addNewOrder', compact('products', 'consumer'));
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



          
           $consumer = DB::table('mandi_consumers')->where('fld_cid', $request->fld_cid)->first();
          
            $order = [
                'fld_mobile_id' => 'web',
                'fld_mcid' => $consumer->fld_cid,
                'fld_uid' => $consumer->fld_uid,
                'fld_pid' => $consumer->fld_pid,
                'fld_total' => $request->fld_total,
                'fld_date' => now()
            ];

            $fld_csid = DB::table('mandi_consumer_sales')->insertGetId($order);
           
            $items = $request->items;
            $orderItem = [];
            foreach ($items  as $item) {
                unset($item['fld_csid']);
                $item['fld_mcsid'] = $fld_csid;
                $item['fld_date'] = now();
                $orderItem[] = $item;
            }
           
            DB::table('mandi_consumer_sales_items')->insert($orderItem);

            return response()->json([
                'isSuccess' => true,
                'Message' => "Order has been created"
            ], 200); // Status code here

        } catch (\Throwable $th) {
            // dd($th);
            return response()->json([
                'isSuccess' => false,
                'Message' => $th->getMessage()
            ], 500); // Status code here
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consumer $user): View
    {
        return view('products.show', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($consumer)
    {
        DB::table('mandi_consumers')->where('fld_cid', $consumer)->first();
        // Delete user along with related orders and order items
        $sales = DB::table('mandi_consumer_sales')->where('fld_mcid', $consumer)->get();
        foreach ($sales as $order) {
            DB::table('mandi_consumer_sales_items')->where('fld_mcsid', $order->fld_mcsid)->delete();
            
        }
        DB::table('mandi_consumer_sales')->where('fld_mcid', $consumer)->delete();
        DB::table('mandi_consumers')->where('fld_cid', $consumer)->delete();
        // $consumer->delete(); // Delete user
        return redirect()->route('mandi.consumer')
            ->with('success', 'Consumer deleted successfully');
    }





    public function getStateByProjectID($project_id)
    {
        return  DB::table('consumers')
            ->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'consumers.fld_state_id')
            ->groupBy('consumers.fld_state_id')
            ->where('consumers.fld_pid', $project_id)->get();
    }
    public function getUsersProjectID($project_id)
    {
        return  DB::table('consumers')
            ->select('users.fld_uid', 'users.fld_name')
            ->join('users', 'users.fld_uid', '=', 'consumers.fld_uid')
            ->groupBy('consumers.fld_uid')
            ->where('consumers.fld_pid', $project_id)->get();
    }
    public function getDistrictByStateID($state_id)
    {
        return  DB::table('consumers')
            ->select('consumers.fld_did', 'x_districts.fld_did', 'x_districts.fld_district')
            ->join('x_districts', 'x_districts.fld_did', '=', 'consumers.fld_did')
            ->groupBy('consumers.fld_did')
            ->where('consumers.fld_state_id', $state_id)->get();
    }
}
