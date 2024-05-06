<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Tehsil;
use App\Models\Village;
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

class VillageController extends Controller
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
        $tehsil_id = $request->tehsil_id ?? 0;
        $query = Village::with('state', 'district', 'tehsil');
        if ($state_id) {
            $query->where('fld_state_id', $state_id);
        }
        if ($district_id) {
            $query->where('fld_district_id', $district_id);
        }
        if ($tehsil_id) {
            $query->where('fld_tehsil_id', $tehsil_id);
        }
        return $query->orderBy('fld_village', 'asc')->paginate();
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
            'fld_tehsil_id' => 'required',
            'fld_village' => 'required',
        ]);
        $data = $request->all();

        $data['fld_state_id'] = $request->fld_state_id;
        $data['fld_district_id'] = $request->fld_district_id;
        $data['fld_tehsil_id'] = $request->fld_tehsil_id;
        $data['fld_village'] = $request->fld_village;
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;
        Village::create($data);

        return redirect()->route('village.index')
            ->with('success', 'Village created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Village $village): View
    {
        $records = $this->getData($request);
        $states = DB::table('x_states')->orderBy('fld_state', 'asc')->get();
        $districts = DB::table('x_districts')->where('fld_state_id', $village->fld_state_id)->orderBy('fld_district', 'asc')->get();
        $tehsils = DB::table('x_tehsils')->where('fld_district_id', $village->fld_district_id)->orderBy('fld_tehsil', 'asc')->get();
        return view('location.location', compact('states', 'records', 'districts', 'tehsils', 'village'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Village $village): RedirectResponse
    {
        $request->validate([
            'fld_state_id' => 'required',
            'fld_district_id' => 'required',
            'fld_tehsil_id' => 'required',
            'fld_village' => 'required',
        ]);
        $data = $request->all();

        $data['fld_state_id'] = $request->fld_state_id;
        $data['fld_district_id'] = $request->fld_district_id;
        $data['fld_tehsil_id'] = $request->fld_tehsil_id;
        $data['fld_village'] = $request->fld_village;
        $data['fld_status'] = (isset($request->fld_status)) ? 1 : 0;

        $village->update($data);

        return redirect()->route('village.index')
            ->with('success', 'Village updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Village $village): RedirectResponse
    {
        $village->delete();
        return redirect()->route('village.index')
            ->with('success', 'Village   deleted successfully');
    }
}
