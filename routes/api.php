<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//register
Route::post('/register', [AuthController::class, 'register']);
//login
Route::post('/login', [AuthController::class, 'login']);

//get all post
Route::get('/all/posts', [PostController::class, 'getAllPost']);
//get a post
Route::get('/single/posts/{post_id}', [PostController::class, 'getPost']);

//middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    

    //addpost
    Route::post('/add/post', [PostController::class, 'addNewPost']);
    //editpost
    Route::post('/edit/post', [PostController::class, 'editPost']);
    //delete post
    Route::post('/delete/post{post_id}', [PostController::class, 'deletPost']);
    //comment
    Route::post('/comment', [CommentController::class, 'postComment']);
    //likes
    Route::post('/like', [LikesController::class, 'likePost']);


   

});