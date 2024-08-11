<?php

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\UserAuthcontroller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::post('v1/user/sign_up',[UserAuthcontroller::class, 'store']);
Route::post('v1/user/login', [UserAuthcontroller::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('v1/user/edit-picture', [UserProfileController::class, 'editImage']);
    Route::post('v1/user/logout', [UserAuthcontroller::class, 'destroy']);
    Route::post('/post/create', [PostController::class, 'create']);
});
Route::group(['middleware' => 'auth:sanctum', AdminCheck::class], function(){
    Route::post('/category/create', [CategoryController::class, 'store']);
});