<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\TargetClient;
use Illuminate\Http\Request;

class TargetClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targetClients = TargetClient::all();

        return view('admin.target-client.list', ['targetClients' => $targetClients]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TargetClient $targetClient)
    {
        if ($targetClient) {
            $periods = config('target.periods');
            $targetStatuses = $targetClient->target->targetStatus;
            $statuses = [];

            foreach ($targetStatuses as $targetStatus) {
                if ($targetStatus->start_date && $targetStatus->stop_date) {

                    $diff = $targetStatus->start_date->diff($targetStatus->stop_date);
                    $statuses[] = [
                        'stop'  => $targetStatus->stop_date,
                        'start' => $targetStatus->start_date,
                        'downtime' => $diff->format('%h:%I'),
                    ];
                } elseif (!$targetStatus->start_date && $targetStatus->stop_date) {
                    $statuses[] = [
                        'stop'  => $targetStatus->stop_date,
                        'start' => $targetStatus->start_date,
                        'downtime' => 'doesnt work',
                    ];
                }
            }

            return view('admin.target-client.show', ['targetClient' => $targetClient, 'statuses' => $statuses]);
        }
        return redirect(route('target_client_list'))->withErrors('Failed get targetClient!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TargetClient $targetClient)
    {
        if ($targetClient) {

            $intervals = config('target.intervals');

            return view('admin.target-client.edit', ['targetClient' => $targetClient, 'intervals' => $intervals]);
        }
        return redirect(route('target_client_list'))->withErrors('Failed get targetClient!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TargetClient $targetClient)
    {
        $input = $request->validate([
            'url' => 'required|url|max:255',
            'interval'  => 'required|integer|max:3600',
            'active' => ''
        ]);

        if (isset($input['active']) && $input['active'] == 'on') {
            $input['active'] = 1;
        } else {
            $input['active'] = 0;
        }

        if ($targetClient->update($input)) {
            return redirect(route('target_client_list'))->with(['status' => __("All ok!")]);
        }

        return redirect(route('target_client_edit', ['id' => $targetClient->id]))->withErrors(__('Failed to update targetClient'));
    }

    public function toggleActive(TargetClient $targetClient)
    {
        $targetClient->active = ! $targetClient->active;
        $targetClient->save();

        return response()->json([
            'success' => true,
            'active' => $targetClient->active,
        ]);
    }

}
