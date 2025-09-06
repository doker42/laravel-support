<?php

use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'welcome');
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index']);


Route::get('/foo', function (){
    echo('FOO');
    $client = \App\Models\TelegraphClient::find(3);
    dump($client->end_subscription);

    $today = Carbon::today();
    $endSubscription = $client->end_subscription;
    dump($today > $endSubscription);

//    dump($client->targets->count());
//    $target = \App\Models\Target::find(6);
//    $client = $target->client;
//    $chat = TelegraphChat::find(2);
//    dump($target->client->chat_id);
//    dump($chat);


    die;
});


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
