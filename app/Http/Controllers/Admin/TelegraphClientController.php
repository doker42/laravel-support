<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\TelegraphClient;
use Illuminate\Http\Request;

class TelegraphClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = TelegraphClient::all();
        return view('admin.clients.list', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TelegraphClient $client)
    {
        $plans = Plan::all();
        return view('admin.clients.edit', compact('client','plans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TelegraphClient $client)
    {
        $input = $request->validate([
           'plan_id' => 'required|int'
        ]);

        $client->update([
            'plan_id' => $input['plan_id']
        ]);

        return redirect(route('client_list'))->with('status', __('Client was updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TelegraphClient $client)
    {
        if ($client->delete()) {
            return redirect(route('client_list'))->with('status', __('Client was deleted'));
        }
        return redirect(route('client_list'))->withErrors(__('Failed to delete client'));
    }
}
