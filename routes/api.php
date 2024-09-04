<?php

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\AccountTYpe;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\UserAuthcontroller;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentReactionController;

Route::post('v1/user/sign_up',[UserAuthcontroller::class, 'store']);
Route::post('v1/user/login', [UserAuthcontroller::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('v1/user/edit-picture', [UserProfileController::class, 'editImage']);
    Route::post('v1/user/logout', [UserAuthcontroller::class, 'destroy']);
    Route::get('blog/home', [BlogController::class, 'index']);
    Route::get('blog/single_page/{id}', [BlogController::class, 'singleCategory']);
    Route::get('blog/single_post/{id}', [BlogController::class, 'show']);
    Route::post('blog/create_comment/{id}', [CommentReactionController::class, 'createComment']);
    Route::get('blog/post_comment/{id}', [CommentReactionController::class, 'getPostComment']);
    Route::post('blog/create_reaction/{id}', [CommentReactionController::class, 'createReaction']);
});
Route::middleware(['auth:sanctum', AdminCheck::class])->group( function(){
    Route::post('/category/create', [CategoryController::class, 'store']);
});
Route::middleware(['auth:sanctum', AccountTYpe::class])->group( function(){
    Route::get('/post/index', [PostController::class, 'index']);
    Route::get('/draft/index', [DraftController::class, 'index']);
    Route::post('/post/create', [PostController::class, 'store']);
});
