<?php

namespace App\Http\Controllers;

use App\Models\District;
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

class DistrictController extends Controller
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


    public function index(Request $request): View
    {
        $state_id = $request->state_id ?? 0;
        $states = DB::table('x_states')->orderBy('fld_state', 'asc')->get();
        $query = District::with('state');
        if ($state_id) {
            $query->where('fld_state_id', $state_id);
        }
        $records = $query->orderBy('fld_district', 'asc')->paginate();
        return view('location.location', compact('records', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'fld_state_id' => 'required',
            'fld_district' => 'required',
        ]);
        $data = $request->all();

        $data['fld_state_id'] = $request->fld_state_id;
        $data['fld_district'] = $request->fld_district;
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;
        District::create($data);

        return redirect()->route('district.index')
            ->with('success', 'District created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district): View
    {
        $states = DB::table('x_states')->orderBy('fld_state', 'asc')->get();
        $records = District::with('state')->orderBy('fld_district', 'asc')->paginate();

        return view('location.location', compact('district', 'states', 'records'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district): RedirectResponse
    {
        $request->validate([
            'fld_state_id' => 'required',
            'fld_district' => 'required',
        ]);
        $data = $request->all();

        $data['fld_state_id'] = $request->fld_state_id;
        $data['fld_district'] = $request->fld_district;
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;

        $district->update($data);

        return redirect()->route('district.index')
            ->with('success', 'District updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district): RedirectResponse
    {
        $district->delete();
        return redirect()->route('district.index')
            ->with('success', 'District deleted successfully');
    }
}
