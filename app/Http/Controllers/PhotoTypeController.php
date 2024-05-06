<?php

namespace App\Http\Controllers;

use App\Models\PhotoType;
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

class PhotoTypeController extends Controller
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

    public function getPurpose()
    {
        return DB::table('x_ptypes')->select('fld_purpose')->groupBy('fld_purpose')->orderBy('fld_purpose', 'asc')->get();
    }

    public function index(): View
    {
        $purposes = $this->getPurpose();
        $records = PhotoType::orderBy('fld_ptid', 'desc')->paginate(15);
        return view('phototype.index', compact('records', 'purposes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fld_purpose' => 'required',
            'fld_type' => 'required',
        ]);
        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        PhotoType::create($data);
        return redirect()->route('phototypes.index')
            ->with('success', 'Photo Type created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhotoType $phototype): View
    {
        $purposes = $this->getPurpose();
        $records = PhotoType::orderby('fld_ptid')->paginate(15);
        return view('phototype.index', compact('phototype', 'records', 'purposes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhotoType $phototype): RedirectResponse
    {
        $request->validate([
            'fld_purpose' => 'required',
            'fld_type' => 'required',
        ]);

        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        $phototype->update($data);
        return redirect()->route('phototypes.index')
            ->with('success', 'Photo type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhotoType $phototype): RedirectResponse
    {
        $phototype->delete();

        return redirect()->route('phototypes.index')
            ->with('success', 'Photo type deleted successfully');
    }
}
