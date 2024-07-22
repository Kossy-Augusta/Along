<?php

use App\Http\Controllers\Auth\UserAuthcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('v1/user/sign_up',[UserAuthcontroller::class, 'store']);
Route::post('v1/user/login', [UserAuthcontroller::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('v1/user/logout', [UserAuthcontroller::class, 'destroy']);
});