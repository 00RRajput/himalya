<?php

namespace App\Http\Controllers;

use App\Models\Project;
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

class ProjectController extends Controller
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

    public function records()
    {
        return  Project::with('routePlans')->select('fld_pid', 'fld_name', 'fld_sale_type', 'fld_start_date', 'fld_status', 'fld_consumer_sales', 'fld_activity_photos')->selectRaw(
            'CASE
            WHEN fld_sale_type = 1 THEN "Retail"
            WHEN fld_sale_type = 2 THEN "Order Booking"
            ELSE "Unknown"
         END AS sale_type'
        )->orderBy('projects.fld_pid', 'desc')->paginate(15);
    }

    public function index(): View
    {
        $records = $this->records();
        return view('project.index', compact('records'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fld_name' => 'required|unique:projects',
            'fld_sale_type' => 'required',
            'fld_start_date' => 'required',
        ]);
        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        Project::create($data);
        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        $records = $this->records();
        return view('project.index', compact('project', 'records'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $request->validate([
            'fld_name' => 'required|unique:Projects,fld_name,' . $project->fld_cid . ',fld_cid',
            'fld_sale_type' => 'required',
            'fld_start_date' => 'required'
        ]);

        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        $project->update($data);
        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }
}
