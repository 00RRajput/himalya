<?php

namespace App\Http\Controllers\Branding;

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

class BrandingController extends Controller
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
        $districts = $users = $states = [];

        $records = DB::table('recce')
        ->where('recce.fld_approved', 0)
        ->leftjoin('recce_outlets', 'recce_outlets.fld_oid', 'recce.fld_outlet_id')
        ->leftjoin('x_districts_recce', 'x_districts_recce.fld_did', 'recce_outlets.fld_district_id')
        ->leftjoin('x_recce_types', 'x_recce_types.fld_rtid', 'recce.fld_rtype')
        ->leftjoin('x_towns_recce', 'x_towns_recce.fld_tid', 'recce_outlets.fld_town_id')
        ->leftjoin('users', 'users.fld_uid', 'recce.fld_uid')
        // ->groupBy('recce.fld_raid')
        ->select(
            'recce.fld_raid',
            'recce_outlets.fld_outlet',
            'x_districts_recce.fld_district',
            'x_towns_recce.fld_town',
            'users.fld_name',
            'x_recce_types.fld_type',
            'recce.fld_width',
            'recce.fld_height',
            'recce.fld_photo_path_recce',
            'recce.fld_photo_file_recce',
            'recce.fld_photo_path_install',
            'recce.fld_photo_file_install',
            'recce.fld_lat',
            'recce.fld_long',
            'recce.fld_recce_date',
            'recce.fld_approved',
        )->paginate();
          
        $records->getCollection()->transform(function ($row) {
            $row->images = DB::table('recce_images')->where('fld_raid', $row->fld_raid)->get();
            return $row;
        });
        
        return view('branding.reccepending', compact('records', 'projects', 'states', 'districts', 'users'));
    }

    public function brandingImages(Request $request)
    {
        // if ($request->type == 'recce') {
            $images = DB::table('recce_images')
            ->join('x_ptypes', 'x_ptypes.fld_ptid', 'recce_images.fld_ptype')
            ->join('recce', 'recce.fld_raid', 'recce_images.fld_raid')
            ->join('users', 'users.fld_uid', 'recce.fld_uid')
            ->join('projects', 'projects.fld_pid', 'recce.fld_pid')
            ->where('recce_images.fld_raid', $request->id)
            ->select(
                'recce_images.*',
                'recce.*',
                'x_ptypes.fld_type as photo_type',
                'users.fld_name as user_name',
                'projects.fld_name as project_name'
            )
            ->paginate();
            
            return view('branding.activityPhoto', compact('images', 'request'));
        // }
        dd($images);
        dd($request->all());
    }

    public function approvedRecce(Request $request)
    {

        $projects = DB::table('projects')->get();
        $districts = $users = $states = [];

        $records = DB::table('recce')
        ->where('recce.fld_approved', 1)
        ->leftjoin('recce_outlets', 'recce_outlets.fld_oid', 'recce.fld_outlet_id')
        ->leftjoin('x_districts_recce', 'x_districts_recce.fld_did', 'recce_outlets.fld_district_id')
        ->leftjoin('x_recce_types', 'x_recce_types.fld_rtid', 'recce.fld_rtype')
        ->leftjoin('x_towns_recce', 'x_towns_recce.fld_tid', 'recce_outlets.fld_town_id')
        ->leftjoin('users', 'users.fld_uid', 'recce.fld_uid')
        ->select(
            'recce.fld_raid',
            'recce_outlets.fld_outlet',
            'x_districts_recce.fld_district',
            'x_towns_recce.fld_town',
            'users.fld_name',
            'x_recce_types.fld_type',
            'recce.fld_width',
            'recce.fld_height',
            'recce.fld_photo_path_recce',
            'recce.fld_photo_file_recce',
            'recce.fld_photo_path_install',
            'recce.fld_photo_file_install',
            'recce.fld_lat',
            'recce.fld_long',
            'recce.fld_recce_date',
            'recce.fld_approved',
        )->paginate();
          
        $records->getCollection()->transform(function ($row) {
            $row->images = DB::table('recce_images')->where('fld_raid', $row->fld_raid)->get();
            return $row;
        });

        return view('branding.recceapprove', compact('records', 'projects', 'states', 'districts', 'users'));
    }

    public function rejectedRecce(Request $request)
    {

        $projects = DB::table('projects')->get();
        $districts = $users = $states = [];

        $records = DB::table('recce')
        ->where('recce.fld_approved', 2)
        ->leftjoin('recce_outlets', 'recce_outlets.fld_oid', 'recce.fld_outlet_id')
        ->leftjoin('x_districts_recce', 'x_districts_recce.fld_did', 'recce_outlets.fld_district_id')
        ->leftjoin('x_recce_types', 'x_recce_types.fld_rtid', 'recce.fld_rtype')
        ->leftjoin('x_towns_recce', 'x_towns_recce.fld_tid', 'recce_outlets.fld_town_id')
        ->leftjoin('users', 'users.fld_uid', 'recce.fld_uid')
        ->select(
            'recce.fld_raid',
            'recce_outlets.fld_outlet',
            'x_districts_recce.fld_district',
            'x_towns_recce.fld_town',
            'users.fld_name',
            'x_recce_types.fld_type',
            'recce.fld_width',
            'recce.fld_height',
            'recce.fld_photo_path_recce',
            'recce.fld_photo_file_recce',
            'recce.fld_photo_path_install',
            'recce.fld_photo_file_install',
            'recce.fld_lat',
            'recce.fld_long',
            'recce.fld_recce_date',
            'recce.fld_approved',
        )->paginate();
          
        $records->getCollection()->transform(function ($row) {
            $row->images = DB::table('recce_images')->where('fld_raid', $row->fld_raid)->get();
            return $row;
        });

        return view('branding.recceapprove', compact('records', 'projects', 'states', 'districts', 'users'));
    }

    public function approveRecce ($id) {
        DB::table('recce')->where('fld_raid', $id)->update(['fld_approved'=> 1]);
        return redirect()->back()->with(['success'=> 'Recce Approved Successfully!']);
    }

    public function rejectRecce ($id) {
        DB::table('recce')->where('fld_raid', $id)->update(['fld_approved'=> 2]);
        return redirect()->back()->with(['success'=> 'Recce Rejected Successfully!']);
    }

    public function installationComplete(Request $request)
    {

        $projects = DB::table('projects')->get();
        $districts = $users = $states = [];

        $records = DB::table('recce')
        ->where('recce.fld_approved_install', 0)
        // ->leftjoin('recce_images', 'recce_images.fld_raid', 'recce.fld_raid')
        ->leftjoin('recce_outlets', 'recce_outlets.fld_oid', 'recce.fld_outlet_id')
        ->leftjoin('x_districts_recce', 'x_districts_recce.fld_did', 'recce_outlets.fld_district_id')
        ->leftjoin('x_recce_types', 'x_recce_types.fld_rtid', 'recce.fld_rtype')
        ->leftjoin('x_towns_recce', 'x_towns_recce.fld_tid', 'recce_outlets.fld_town_id')
        ->leftjoin('users', 'users.fld_uid', 'recce.fld_uid')
        ->select(
            'recce.fld_raid',
            'recce_outlets.fld_oid',
            'recce_outlets.fld_outlet',
            'x_districts_recce.fld_district',
            'x_towns_recce.fld_town',
            'users.fld_name',
            'x_recce_types.fld_type',
            'recce.fld_width',
            'recce.fld_height',
            'recce.fld_photo_path_recce',
            'recce.fld_photo_file_recce',
            'recce.fld_photo_path_install',
            'recce.fld_photo_file_install',
            'recce.fld_lat',
            'recce.fld_long',
            'recce.fld_install_date',
            // 'recce_images.fld_path',
            // 'recce_images.fld_image',
        )->paginate();

        $records->getCollection()->transform(function ($row) {
            $row->images = DB::table('recce_images')->where('fld_raid', $row->fld_raid)->get();
            return $row;
        });
        // dd($records);
        return view('branding.installationcomplete', compact('records', 'projects', 'states', 'districts', 'users'));
    }

    public function installationApproved(Request $request)
    {

        $projects = DB::table('projects')->get();
        $districts = $users = $states = [];

        $records = DB::table('recce')->where(['recce.fld_approved_install'=> 1])
        ->leftjoin('recce_images', 'recce_images.fld_raid', 'recce.fld_raid')
        ->leftjoin('recce_outlets', 'recce_outlets.fld_oid', 'recce.fld_outlet_id')
        ->leftjoin('x_districts_recce', 'x_districts_recce.fld_did', 'recce_outlets.fld_district_id')
        ->leftjoin('x_recce_types', 'x_recce_types.fld_rtid', 'recce.fld_rtype')
        ->leftjoin('x_towns_recce', 'x_towns_recce.fld_tid', 'recce_outlets.fld_town_id')
        ->leftjoin('users', 'users.fld_uid', 'recce.fld_uid')
        ->select(
            'recce.fld_raid',
            'recce_outlets.fld_oid',
            'recce_outlets.fld_outlet',
            'x_districts_recce.fld_district',
            'x_towns_recce.fld_town',
            'users.fld_name',
            'x_recce_types.fld_type',
            'recce.fld_width',
            'recce.fld_height',
            'recce.fld_photo_path_recce',
            'recce.fld_photo_file_recce',
            'recce.fld_photo_path_install',
            'recce.fld_photo_file_install',
            'recce.fld_lat',
            'recce.fld_long',
            'recce.fld_install_date',
            'recce_images.fld_path',
            'recce_images.fld_image',
            'recce_outlets.fld_direct_install'
        )->paginate();

        return view('branding.installationapprove', compact('records', 'projects', 'states', 'districts', 'users'));
    }

    public function installationRejected(Request $request)
    {

        $projects = DB::table('projects')->get();
        $districts = $users = $states = [];

        $records = DB::table('recce')->where([ 'recce.fld_approved_install'=> 2])
        ->leftjoin('recce_images', 'recce_images.fld_raid', 'recce.fld_raid')
        ->leftjoin('recce_outlets', 'recce_outlets.fld_oid', 'recce.fld_outlet_id')
        ->leftjoin('x_districts_recce', 'x_districts_recce.fld_did', 'recce_outlets.fld_district_id')
        ->leftjoin('x_recce_types', 'x_recce_types.fld_rtid', 'recce.fld_rtype')
        ->leftjoin('x_towns_recce', 'x_towns_recce.fld_tid', 'recce_outlets.fld_town_id')
        ->leftjoin('users', 'users.fld_uid', 'recce.fld_uid')
        ->select(
            'recce.fld_raid',
            'recce_outlets.fld_oid',
            'recce_outlets.fld_outlet',
            'x_districts_recce.fld_district',
            'x_towns_recce.fld_town',
            'users.fld_name',
            'x_recce_types.fld_type',
            'recce.fld_width',
            'recce.fld_height',
            'recce.fld_photo_path_recce',
            'recce.fld_photo_file_recce',
            'recce.fld_photo_path_install',
            'recce.fld_photo_file_install',
            'recce.fld_lat',
            'recce.fld_long',
            'recce.fld_install_date',
            'recce_images.fld_path',
            'recce_images.fld_image',
        )->paginate();

        return view('branding.installationreject', compact('records', 'projects', 'states', 'districts', 'users'));
    }


    public function approveInstallation ($id) {
        DB::table('recce')->where('fld_raid', $id)->update(['fld_approved_install'=> 1]);
        return redirect()->back()->with(['success'=> 'Installation Approved Successfully!']);
    }

    public function rejectInstallation ($id) {
        DB::table('recce')->where('fld_raid', $id)->update(['fld_approved_install'=> 2]);
        return redirect()->back()->with(['success'=> 'Installation Rejected Successfully!']);
    }

    public function outlets () {
        $projects = DB::table('projects')->get();
        $districts = $users = $states = [];

        $outlets = DB::table('recce_outlets')
        ->join('x_districts', 'x_districts.fld_did', 'recce_outlets.fld_district_id')
        ->join('x_towns', 'x_towns.fld_tid', 'recce_outlets.fld_town_id')
        ->join('x_states', 'x_states.fld_sid', 'recce_outlets.fld_state_id')
        ->join('users', 'users.fld_uid', 'recce_outlets.fld_uid')
        ->select(
            'recce_outlets.*',
            'x_districts.fld_district',
            'x_towns.fld_town',
            'x_states.fld_state',
            'users.fld_name as user',
            DB::raw('(SELECT COUNT(*) FROM tbl_recce WHERE tbl_recce.fld_outlet_id = tbl_recce_outlets.fld_oid) AS recce_count')
        )->paginate();
     
        return view('branding.outlets', compact('outlets', 'projects', 'states', 'districts', 'users'));
    }

}