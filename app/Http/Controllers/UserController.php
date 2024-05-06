<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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

    public function records($request)
    {
        $query =    User::select('users.*', 'x_states.fld_state as state_name', 'projects.fld_name as project_name')
            ->selectRaw(
                'CASE
            WHEN fld_role = 1 THEN "Admin"
            WHEN fld_role = 2 THEN "Field User"
            WHEN fld_role = 3 THEN "Nebula"
            WHEN fld_role = 4 THEN "Client"
            WHEN fld_role = 5 THEN "Vendor"
            ELSE "Unknown"
         END AS role_name'
            )
            ->join('x_states', 'x_states.fld_sid', '=', 'users.fld_state_id')
            ->join('projects', 'projects.fld_pid', '=', 'users.fld_project_id');

        if ($request->project_id) {
            $query->where('fld_project_id', $request->project_id);
        }
        if ($request->state_id) {
            $query->where('fld_state_id', $request->state_id);
        }
        if ($request->fld_role) {
            $query->where('fld_role', $request->fld_role);
        }


        return $query->latest()->paginate(15);
    }

    public function userRoles()
    {
        return  User::select('fld_role')
            ->selectRaw(
                'CASE
        WHEN fld_role = 1 THEN "Admin"
        WHEN fld_role = 2 THEN "Field User"
        WHEN fld_role = 3 THEN "Nebula"
        WHEN fld_role = 4 THEN "Client"
        WHEN fld_role = 5 THEN "Vendor"
        ELSE "Unknown"
     END AS role_name'
            )->groupBy('fld_role')->get();
    }

    public function index(Request $request): View
    {
        $records =  $this->records($request);
        $roles =  $this->userRoles();

        $states = DB::table('x_states')->get();
        $projects = DB::table('projects')->get();
        return view('user.index', compact('records', 'states', 'projects', 'roles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $states = DB::table('x_states')->get();
        $projects = DB::table('projects')->get();
        return view('user.index', compact('states', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fld_username' => 'required',
            'fld_password' => 'required',
            'fld_state_id' => 'required',
            'fld_project_id' => 'required',
        ]);
        $data = $request->all();

        $data['fld_name'] = $request->fld_username;
        $data['fld_password'] = Hash::make($request->fld_password);
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;
        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): View
    {
        $records =  $this->records($request);
        $states = DB::table('x_states')->get();
        $projects = DB::table('projects')->get();
        $roles =  $this->userRoles();
        return view('user.index', compact('user', 'states', 'projects', 'records', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'fld_username' => 'required',
            'fld_state_id' => 'required',
            'fld_project_id' => 'required',
        ]);

        $data = $request->all();
        $data['fld_name'] = $request->fld_username;
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;
        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
