<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VacancyController;

// ============= ПОСТЫ =============
Route::get('/posts', [PostController::class, 'index']);              // GET - все посты
Route::post('/posts', [PostController::class, 'store']);             // POST - создать пост
Route::get('/posts/{id}', [PostController::class, 'show']);          // GET - один пост
Route::put('/posts/{id}', [PostController::class, 'update']);        // PUT - полное обновление
Route::patch('/posts/{id}', [PostController::class, 'update']);      // PATCH - частичное обновление
Route::delete('/posts/{id}', [PostController::class, 'destroy']);    // DELETE - удалить пост

// ============= КОММЕНТАРИИ =============
Route::get('/comments', [CommentController::class, 'index']);                 // GET - все комментарии
Route::post('/comments', [CommentController::class, 'store']);                // POST - создать комментарий
Route::get('/comments/{id}', [CommentController::class, 'show']);             // GET - один комментарий
Route::put('/comments/{id}', [CommentController::class, 'update']);           // PUT - полное обновление
Route::patch('/comments/{id}', [CommentController::class, 'update']);         // PATCH - частичное обновление
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);       // DELETE - удалить комментарий

// ============= ВАКАНСИИ =============
Route::get('/vacancies', [VacancyController::class, 'index']);         // GET - все вакансии
Route::get('/vacancies/create', [VacancyController::class, 'create']); // GET - форма создания
Route::post('/vacancies', [VacancyController::class, 'store']);        // POST - создать вакансию
Route::get('/vacancies/{vacancy}', [VacancyController::class, 'show']);// GET - одна вакансия
Route::get('/vacancies/{vacancy}/edit', [VacancyController::class, 'edit']); // GET - форма редактирования
Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update']);     // PUT - полное обновление
Route::patch('/vacancies/{vacancy}', [VacancyController::class, 'update']);   // PATCH - частичное обновление
Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy']); // DELETE - удалить вакансию
