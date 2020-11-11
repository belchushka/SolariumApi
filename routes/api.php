<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('/user', \App\Http\Controllers\UserController::class);
Route::post("/user/login",[\App\Http\Controllers\UserController::class,"login"]);
Route::post("/user/logout",[\App\Http\Controllers\UserController::class,"user_logout"]);
