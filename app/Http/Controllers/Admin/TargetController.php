<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targets = Target::all();

        return view('admin.targets.list', ['targets' => $targets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periods = config('target.periods');

        return view('admin.targets.create', ['periods' => $periods]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'url'     => 'required|string|max:255|unique:targets,url',
            'period'  => 'required|integer|max:3600',
        ]);

        $target = Target::create($input);

        if ($target) {
            return redirect(route('admin_work_list'))->with(['status' => __("All ok!")]);
        }

        return redirect(route('admin_work_create'))->withErrors(__('Failed to create target'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        if ($target) {

            $periods = config('target.periods');
            return view('admin.targets.edit', ['target' => $target, 'periods' => $periods]);
        }
        return redirect(route('target_list'))->withErrors('Failed get target!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Target $target)
    {
        $input = $request->validate([
            'url' => 'required|url|max:255|unique:targets,url,' . $target->id,
            'period' => 'required|string|max:255',
            'active' => ''
        ]);

        if (isset($input['active']) && $input['active'] == 'on') {
            $input['active'] = 1;
        } else {
            $input['active'] = 0;
        }

        if ($target->update($input)) {
            return redirect(route('target_list'))->with(['status' => __("All ok!")]);
        }

        return redirect(route('target_edit', ['id' => $target->id]))->withErrors(__('Failed to update target'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        if ($target->delete()) {
            return redirect(route('target_list'))->with('status', __('Target was deleted'));
        }
        return redirect(route('target_list'))->withErrors(__('Failed to delete target'));
    }
}
