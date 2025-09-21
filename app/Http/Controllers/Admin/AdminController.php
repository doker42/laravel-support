<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    public function dashboard()
    {
        $current = (bool) Setting::get('bot_enabled', config('admin.bot_enabled'));
        session()->flash('bot_enabled', $current);
        return view('admin.dashboard');
    }


    public function toggle()
    {
        $current = (bool) Setting::get('bot_enabled', config('admin.bot_enabled'));
        $new = ! $current;

        Setting::set('bot_enabled', $new ? '1' : '0');

        return redirect()
            ->back()
            ->with('bot_enabled', $new)
            ->with('status', $new ? '🤖 Бот включен' : '🤖 Бот выключен');
    }
}
