<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/',[PostController::class,'index']);
Route::post('/store',[PostController::class,'store']);
Route::get('/show/{id}',[PostController::class,'show']);
Route::patch('/update/{id}',[PostController::class,'update']);
Route::delete('/destroy/{id}',[PostController::class,'destroy']);



Route::get('/Comment',[CommentController::class,'index']);
Route::post('/Comment/store',[CommentController::class,'store']);
Route::get('/Comment/show/{id}',[CommentController::class,'show']);
Route::patch('/Comment/update/{id}',[CommentController::class,'update']);
Route::delete('/Comment/destroy/{id}',[CommentController::class,'destroy']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
