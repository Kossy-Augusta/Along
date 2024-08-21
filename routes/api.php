<?php

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\UserAuthcontroller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\AccountTYpe;

Route::post('v1/user/sign_up',[UserAuthcontroller::class, 'store']);
Route::post('v1/user/login', [UserAuthcontroller::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('v1/user/edit-picture', [UserProfileController::class, 'editImage']);
    Route::post('v1/user/logout', [UserAuthcontroller::class, 'destroy']);
    
});
Route::middleware(['auth:sanctum', AdminCheck::class])->group( function(){
    Route::post('/category/create', [CategoryController::class, 'store']);
});
Route::middleware(['auth:sanctum', AccountTYpe::class])->group( function(){
    Route::get('/post/index', [PostController::class, 'index']);
    Route::post('/post/create', [PostController::class, 'store']);
});
