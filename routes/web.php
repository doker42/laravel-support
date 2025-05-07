<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LandingController::class, 'index']);
Route::post('/contact', [LandingController::class, 'contact']);