<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TargetController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => config('admin.admin_prefix'), 'middleware' => ['auth'] ], function () {

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
//    Route::group(['prefix' => 'works'], function () {
//        Route::controller( AdminWorkController::class)->group(function () {
//            Route::get('/list', 'index')->name('admin_work_list');
//            Route::get('/create', 'create')->name('admin_work_create');
//            Route::get('/edit/{id}', 'edit')->name('admin_work_edit');
//            Route::post('/store', 'store')->name('admin_work_store');
//            Route::post('/update/{id}', 'update')->name('admin_work_update');
//            Route::delete('/destroy/{id}', 'destroy')->name('admin_work_destroy');
//        });
//    });
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
