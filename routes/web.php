<?php

use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome');
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index']);


Route::group(['prefix' => config('admin.admin_prefix')], function () {

    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
