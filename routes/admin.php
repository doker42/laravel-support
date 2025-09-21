<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TargetController;
use App\Http\Controllers\Admin\TelegraphClientController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => config('admin.admin_prefix'), 'middleware' => ['auth'] ], function () {

    Route::post('/bot/toggle', [AdminController::class, 'toggle'])->name('bot.toggle');

    Route::get('/', [AdminController::class, 'dashboard'])->name('admin');

    Route::group(['prefix' => 'users'], function () {
        Route::controller( AdminController::class)->group(function () {
            Route::get('/', 'usersList')->name('user_list');
        });
    });

    Route::group(['prefix' => 'targets'], function () {
        Route::controller( TargetController::class)->group(function () {
            Route::get('/', 'index')->name('target_list');
            Route::get('/create', 'create')->name('target_create');
            Route::post('/store', 'store')->name('target_store');
            Route::get('/show/{target}', 'show')->name('target_show');
            Route::get('/edit/{target}', 'edit')->name('target_edit');
            Route::post('/update/{target}', 'update')->name('target_update');
            Route::delete('/destroy/{target}', 'destroy')->name('target_destroy');
        });
    });
    Route::group(['prefix' => 'plans'], function () {
        Route::controller( PlanController::class)->group(function () {
            Route::get('/', 'index')->name('plan_list');
            Route::get('/create', 'create')->name('plan_create');
            Route::post('/store', 'store')->name('plan_store');
            Route::get('/show/{plan}', 'show')->name('plan_show');
            Route::get('/edit/{plan}', 'edit')->name('plan_edit');
            Route::post('/update/{plan}', 'update')->name('plan_update');
            Route::delete('/destroy/{plan}', 'destroy')->name('plan_destroy');
        });
    });
    Route::group(['prefix' => 'clients'], function () {
        Route::controller( TelegraphClientController::class)->group(function () {
            Route::get('/', 'index')->name('client_list');
//            Route::get('/create', 'create')->name('client_create');
//            Route::post('/store', 'store')->name('client_store');
//            Route::get('/show/{plan}', 'show')->name('client_show');
            Route::get('/edit/{client}', 'edit')->name('client_edit');
            Route::post('/update/{client}', 'update')->name('client_update');
            Route::delete('/destroy/{client}', 'destroy')->name('client_destroy');
        });
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::controller( SettingController::class)->group(function () {
            Route::get('/', 'index')->name('setting_list');
            Route::get('/create', 'create')->name('setting_create');
            Route::post('/store', 'store')->name('setting_store');
            Route::get('/show/{setting}', 'show')->name('setting_show');
            Route::get('/edit/{setting}', 'edit')->name('setting_edit');
            Route::post('/update/{setting}', 'update')->name('setting_update');
            Route::delete('/destroy/{setting}', 'destroy')->name('setting_destroy');
        });
    });

//    Route::group(['prefix' => 'settings'], function () {
//        Route::controller( AdminSettingController::class)->group(function () {
//            Route::get('/list', 'index')->name('admin_setting_list');
//            Route::get('/create', 'create')->name('admin_setting_create');
//            Route::get('/edit/{id}', 'edit')->name('admin_setting_edit');
//            Route::post('/store', 'store')->name('admin_setting_store');
//            Route::post('/update/{id}', 'update')->name('admin_setting_update');
//            Route::delete('/destroy/{id}', 'destroy')->name('admin_setting_destroy');
//        });
//    });
//    Route::group(['prefix' => 'visitors'], function () {
//        Route::controller( AdminVisitorController::class)->group(function () {
//            Route::get('/', 'index')->name('admin.visitor.list');
//            Route::post('/ban-update', 'banUpdate')->name('admin.visitor.ban_update');
////            Route::get('/ip-search', 'autocompleteByIp')->name('admin.ip.search');
//        });
//    });
//    Route::group(['prefix' => 'ignored-ips'], function () {
//        Route::controller( AdminIgnoredIpController::class)->group(function () {
//            Route::get('/list', 'index')->name('admin.ignored_ip.list');
//            Route::get('/create', 'create')->name('admin.ignored_ip.create');
//            Route::post('/store', 'store')->name('admin.ignored_ip.store');
//            Route::delete('/delete/{ip}', 'destroy')->name('admin.ignored_ip.destroy');
//        });
//    });
//    Route::group(['prefix' => 'fail2ban'], function () {
//        Route::controller( AdminFail2BanController::class)->group(function () {
//            Route::get('/banned-ips', 'index')->name('admin.fail2ban.index');
//        });
//    });
});
