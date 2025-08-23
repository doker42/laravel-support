<?php


use App\Http\Controllers\Api\TelegramController;
use Illuminate\Support\Facades\Route;


Route::controller(TelegramController::class)->group(function () {
    Route::group(['prefix' => 'telegram'], function (){
        $telegramBotToken = env('LASER_TOKEN');
        Route::any('/' . $telegramBotToken . '/webhook', 'laserHook');
    });
});