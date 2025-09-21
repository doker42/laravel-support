<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::all();

        return view('admin.settings.list', ['settings' => $settings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'key'    => 'required|string|max:255',
            'value'  => 'required|string|max:2000',
        ]);

        $target = Setting::create($input);

        if ($target) {
            return redirect(route('setting_list'))->with(['status' => __("All ok!")]);
        }

        return redirect(route('setting_create'))->withErrors(__('Failed to create setting'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        $setting = Setting::find($setting->id);

        return view('admin.settings.show', ['setting' => $setting]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        if ($setting) {
            return view('admin.settings.edit', ['setting' => $setting]);
        }
        return redirect(route('setting_list'))->withErrors('Failed get setting!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $input = $request->validate([
            'value'  => 'required|string|max:2000',
        ]);

        if ($setting->update($input)) {
            return redirect(route('setting_list'))->with(['status' => __("All ok!")]);
        }

        return redirect(route('setting_edit', ['id' => $setting->id]))->withErrors(__('Failed to update setting'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        if ($setting->delete()) {
            return redirect(route('setting_list'))->with('status', __('setting was deleted'));
        }
        return redirect(route('setting_list'))->withErrors(__('Failed to delete setting'));
    }
}
