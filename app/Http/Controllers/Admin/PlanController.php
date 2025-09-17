<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::all();

        return view('admin.plans.list', ['plans' => $plans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string|max:2000',
            'price'        => 'required|integer|max:100',
            'limit'        => 'required|integer|max:100',
            'interval'     => 'required|integer|max:3600',
            'duration'     => 'required|integer|max:100',
            'active'       => '',
        ]);


        if (isset($input['active']) && $input['active'] == 'on') {
            $input['active'] = 1;
        } else {
            $input['active'] = 0;
        }

        $target = Plan::create($input);

        if ($target) {
            return redirect(route('plan_list'))->with(['status' => __("All ok!")]);
        }

        return redirect(route('plan_create'))->withErrors(__('Failed to create plan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        $plan = Plan::find($plan->id);

        return view('admin.plans.show', ['plan' => $plan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        if ($plan) {
            return view('admin.plans.edit', ['plan' => $plan]);
        }
        return redirect(route('plan_list'))->withErrors('Failed get plan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $input = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string|max:2000',
            'price'        => 'required|integer|max:100',
            'limit'        => 'required|integer|max:100',
            'interval'     => 'required|integer|max:3600',
            'duration'     => 'required|integer|max:1000',
            'active'       => '',
        ]);

        if (isset($input['active']) && $input['active'] == 'on') {
            $input['active'] = 1;
        } else {
            $input['active'] = 0;
        }

        if ($plan->update($input)) {
            return redirect(route('plan_list'))->with(['status' => __("All ok!")]);
        }

        return redirect(route('plan_edit', ['id' => $plan->id]))->withErrors(__('Failed to update plan'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        if ($plan->delete()) {
            return redirect(route('plan_list'))->with('status', __('Plan was deleted'));
        }
        return redirect(route('plan_list'))->withErrors(__('Failed to delete plan'));
    }
}
