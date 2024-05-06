<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Tehsil;
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

class TehsilController extends Controller
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

    function getData($request)
    {
        $state_id = $request->state_id ?? 0;
        $district_id = $request->district_id ?? 0;
        $query = Tehsil::with('state', 'district');
        if ($state_id) {
            $query->where('fld_state_id', $state_id);
        }
        if ($district_id) {
            $query->where('fld_district_id', $district_id);
        }
        return $query->orderBy('fld_tehsil', 'asc')->paginate();
    }

    public function index(Request $request): View
    {

        $records = $this->getData($request);
        $states = DB::table('x_states')->orderBy('fld_state', 'asc')->get();

        return view('location.location', compact('records', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'fld_state_id' => 'required',
            'fld_district_id' => 'required',
            'fld_tehsil' => 'required',
        ]);
        $data = $request->all();

        $data['fld_state_id'] = $request->fld_state_id;
        $data['fld_district_id'] = $request->fld_district_id;
        $data['fld_tehsil'] = $request->fld_district;
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;
        District::create($data);

        return redirect()->route('district.index')
            ->with('success', 'District created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Tehsil $tehsil): View
    {
        $records = $this->getData($request);
        $states = DB::table('x_states')->orderBy('fld_state', 'asc')->get();
        $districts = DB::table('x_districts')->where('fld_state_id', $tehsil->fld_state_id)->orderBy('fld_district', 'asc')->get();
        return view('location.location', compact('tehsil', 'states', 'records', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tehsil $tehsil): RedirectResponse
    {
        $request->validate([
            'fld_state_id' => 'required',
            'fld_district_id' => 'required',
            'fld_tehsil' => 'required',
        ]);
        $data = $request->all();

        $data['fld_state_id'] = $request->fld_state_id;
        $data['fld_district_id'] = $request->fld_district_id;
        $data['fld_tehsil'] = $request->fld_tehsil;
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;

        $tehsil->update($data);

        return redirect()->route('tehsil.index')
            ->with('success', 'Tehsil updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tehsil $tehsil): RedirectResponse
    {
        $tehsil->delete();
        return redirect()->route('tehsil.index')
            ->with('success', 'Tehsil deleted successfully');
    }
}
