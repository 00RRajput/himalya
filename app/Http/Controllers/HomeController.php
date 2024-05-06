<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
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
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function root(Request $request)
    {
        $projects = DB::table('projects')->get();
        $project_id  = $request->project_id ?? 1;
        $fld_start_date = $projects->where('fld_pid', $project_id)->first()?->fld_start_date;
        $users = $this->getDashData($project_id);
        $startDate = Carbon::parse($fld_start_date);
        $endDate = Carbon::today();
        $totalDaysDifference = $startDate->diffInDays($endDate);
        return view('index', compact('projects', 'users', 'project_id', 'totalDaysDifference'));
    }

    public function getUsers($project_id)
    {
        return  DB::table('users')->select('users.fld_uid', 'users.fld_username')->where('fld_project_id', $project_id)->where('fld_role', 2)->get();
    }

    public function getState($project_id)
    {
        return  DB::table('users')->select('x_states.fld_sid', 'x_states.fld_state')
            ->join('x_states', 'x_states.fld_sid', '=', 'users.fld_state_id')
            ->where('fld_project_id', $project_id)
            ->orderBy('x_states.fld_state')
            ->distinct('users.fld_state_id')
            ->get();
    }

    function getDistrict($sid)
    {
        return DB::table('x_districts')->select('fld_did', 'fld_district')->where('fld_state_id', $sid)->orderBy('fld_district')->get();
    }
    function getTehsil($sid)
    {
        return DB::table('x_tehsils')->select('fld_tid', 'fld_tehsil')->where('fld_district_id', $sid)->orderBy('fld_tehsil')->get();
    }

    public function getVillage($did)
    {
        return  DB::table('x_villages')
            ->select('fld_vid', 'fld_tehsil_id', 'fld_village', 'fld_tehsil')
            ->join('x_tehsils', 'x_tehsils.fld_tid', '=', 'x_villages.fld_tehsil_id')
            ->where('x_villages.fld_district_id', $did)
            ->where('x_tehsils.fld_status', 1)
            ->get();
    }







    public function getDashData($project_id)
    {
        /**
         *  FIXME: Remove != 15 from query
         * 1. District - From the route plan of that user, show the distinct disrict name. if more then one, then show comma separated and one below other with br
         * 2. Total retail coverage - Show the total number of retailers added by the user
         * 3. Total Outlet converted - it will show the count of outlets from #2 point who have placed order. Even the outlet have given more than 1 order, it will be count as one.
         * 4. Total sales in rs - Total of all the orders places by that user
         * 5. total purchase - total of all the purchase made by that user
         * 6. Calculate VAN attendances from env variable to current date
         */
        //return User::with('routePlan', 'routePlan.district', 'totalRetailers', 'totalRetailers.retailSaleCount')->withCount('totalRetailers')->withSum('total_purchase', 'fld_total')->withSum('total_retailsales', 'fld_total')->where('fld_project_id', $project_id)->where('fld_uid', '!=', 15)->where('fld_role', 2)->get();
        $fromDate = env('START_WORKING_DAY');
        return User::with('routePlan', 'routePlan.district', 'totalRetailers', 'totalRetailers.retailSaleCount')
            ->withCount('totalRetailers')
            ->withSum('total_purchase', 'fld_total')
            ->withSum('total_retailsales', 'fld_total')
            ->withCount(['attendances' => function ($query) use ($fromDate) {
                $query->where('fld_datetime', '>=', $fromDate);
            }])
            ->where('fld_project_id', $project_id)
            ->where('fld_demo', 0)
            ->where('fld_role', 2)
            ->get();
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}
