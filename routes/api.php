<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    

    //blog api endpoints

    //addpost
    Route::post('/add/post', [PostController::class, 'addNewPost']);
    //editpost
    Route::post('/edit/post', [PostController::class, 'editPost']);
    
});