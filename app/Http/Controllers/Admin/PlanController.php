<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interval;
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
        $intervals = Interval::ARR;

        return view('admin.plans.create', ['intervals' => $intervals]);
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
//            'interval'     => 'required|integer|max:3600',
            'intervals'    => 'required',
            'duration'     => 'required|integer|max:100',
            'active'       => '',
            'default'      => '',
            'regular'      => '',
        ]);


        if (isset($input['active']) && $input['active'] == 'on') {
            $input['active'] = 1;
        } else {
            $input['active'] = 0;
        }

        if (isset($input['default']) && $input['default'] == 'on') {
            $input['default'] = 1;
        } else {
            $input['default'] = 0;
        }

        if (isset($input['regular']) && $input['regular'] == 'on') {
            $input['regular'] = 1;
        } else {
            $input['regular'] = 0;
        }

        if (!empty(Interval::ARR[$input['intervals']])) {
            $input['intervals'] = json_encode(Interval::ARR[$input['intervals']]);
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

            $intervals = Interval::ARR;

            return view('admin.plans.edit', ['plan' => $plan, 'intervals' => $intervals]);
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
            'intervals'     => 'required',
            'duration'     => 'required|integer|max:1000',
            'active'       => '',
            'default'      => '',
            'regular'      => '',
        ]);

        if (isset($input['active']) && $input['active'] == 'on') {
            $input['active'] = 1;
        } else {
            $input['active'] = 0;
        }

        if (isset($input['default']) && $input['default'] == 'on') {
            $input['default'] = 1;
        } else {
            $input['default'] = 0;
        }

        if (isset($input['regular']) && $input['regular'] == 'on') {
            $input['regular'] = 1;
        } else {
            $input['regular'] = 0;
        }

        if (!empty(Interval::ARR[$input['intervals']])) {
            $input['intervals'] = Interval::ARR[$input['intervals']];
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
