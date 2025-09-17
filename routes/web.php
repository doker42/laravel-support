<?php

use App\Models\Target;
use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome');
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index']);


//Route::get('/foo', function (){
//    echo('FOO');
//});

Route::view('/privacy-policy', 'privacy')->name('privacy');

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
