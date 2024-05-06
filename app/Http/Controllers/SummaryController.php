<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
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
    function records()
    {
        return Summary::with('project')
            ->select('fld_scfid', 'fld_pid', 'fld_question', 'fld_placeholder', 'fld_ans', 'fld_created_at')
            ->selectRaw('
            CASE
                WHEN fld_type = "T" THEN "Text"
                WHEN fld_type = "R" THEN "Radio"
                WHEN fld_type = "S" THEN "Select"
                WHEN fld_type = "TA" THEN "Text Area"
                ELSE "Unknown"
            END AS type')
            ->selectRaw('
            CASE
                WHEN fld_required = 0 THEN "No"
                WHEN fld_required = 1 THEN "Yes"
                ELSE "Unknown"
            END AS required')
            ->selectRaw('
            CASE
                WHEN fld_display_order = 0 THEN "No"
                WHEN fld_display_order = 1 THEN "Yes"
                ELSE "Unknown"
            END AS fld_display_order')
            ->selectRaw('
            CASE
                WHEN fld_status = 1 THEN "Active"
                WHEN fld_status = 0 THEN "Deactive"
                ELSE "Unknown"
            END AS status')
            ->orderBy('fld_display_order', 'asc')
            ->paginate(15);
    }

    public function index(Request $request)
    {
        $records =  $this->records();
        $project_id = $request->pid ?? 0;
        if ($project_id) {
            $project = DB::table('projects')->where('fld_pid', $project_id)->first();
            return view('summaries.index', compact('records', 'project'));
        } else {
            return redirect(route('dashboard'))->withSuccess('message', "Please select project id");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fld_question' => 'required|unique:x_summaries',
            'fld_pid' => 'required',
            'fld_type' => 'required',
        ]);

        $data = $request->all();
        $data['fld_isnumeric'] = (isset($data['fld_isnumeric'])) ? 1 : 0;
        $data['fld_status'] = (isset($data['fld_status'])) ? 1 : 0;
        $data['fld_required'] = (isset($data['fld_required'])) ? 1 : 0;
        Summary::create($data);
        return redirect()->back()
            ->with('success', 'Summary created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Summary $summary)
    {
        $records =  $this->records();
        $project_id = $request->pid ?? 0;
        if ($project_id) {
            $project = DB::table('projects')->where('fld_pid', $project_id)->first();
            return view('summaries.index', compact('records', 'project', 'summary'));
        }
        return redirect(route('dashboard'))->withSuccess('message', "Please select project id");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Summary $summary): RedirectResponse
    {
        $request->validate([
            'fld_question' => 'required|unique:x_summaries,fld_question,' . $summary->fld_scfid . ',fld_scfid',
            'fld_pid' => 'required',
            'fld_type' => 'required',
            'fld_status'
        ]);

        $data = $request->all();
        $data['fld_isnumeric'] = (isset($data['fld_isnumeric'])) ? 1 : 0;
        $data['fld_status'] = (isset($data['fld_status'])) ? 1 : 0;
        $data['fld_required'] = (isset($data['fld_required'])) ? 1 : 0;
        $summary->update($data);
        return redirect()->route('summaries.index', ['pid' => $request->fld_pid])
            ->with('success', 'Summary updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Summary $summary): RedirectResponse
    {
        DB::table('summaries')->where('summaries', $summary->fld_scfid)->delete();

        $summary->delete();

        return redirect()->back()
            ->with('success', 'Summary deleted successfully');
    }

    public function reorder(Request $request)
    {
        $order = $request->all();

        foreach ($order as $key => $value) {
            Summary::where('fld_scfid', $value)->update(['fld_display_order' => $key]);
        }
        return response()->json(['success' => true]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function updateStatus(Request $request)
    {
        $fld_scfid = $request->fld_scfid;
        $status = $request->status;
        $product = Summary::find($fld_scfid);
        $product->fld_status = $status;
        $product->save();
        return 1;
    }
}
