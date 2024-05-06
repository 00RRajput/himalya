<?php

namespace App\Http\Controllers;

use App\Models\Client;
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

class ClientController extends Controller
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


    public function index(): View
    {
        $records = Client::paginate(15);
        $client = [];
        return view('client.index', compact('records', 'client'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fld_name' => 'required|unique:clients',
        ]);
        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        Client::create($data);
        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): View
    {
        $records = Client::paginate(15);
        return view('client.index', compact('client', 'records'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $request->validate([
            'fld_name' => 'required|unique:clients,fld_name,' . $client->fld_cid . ',fld_cid'
        ]);

        $data = $request->all();
        $data['fld_status'] = (isset($data['status'])) ? 1 : 0;
        $client->update($data);
        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully');
    }
}
