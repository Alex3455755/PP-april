<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;

// ============= ВАКАНСИИ =============
Route::get('/vacancies', [VacancyController::class, 'index']);
Route::get('/vacancies/create', [VacancyController::class, 'create']);
Route::post('/vacancies', [VacancyController::class, 'store']);
Route::get('/vacancies/{vacancy}', [VacancyController::class, 'show']);
Route::get('/vacancies/{vacancy}/edit', [VacancyController::class, 'edit']);
Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update']);
Route::patch('/vacancies/{vacancy}', [VacancyController::class, 'update']);
Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy']);

// Маршруты для колледжей
Route::get('/colleges', [CollegeController::class, 'index']);
Route::get('/colleges/universities', [CollegeController::class, 'getUniversities']);
Route::get('/colleges/colleges-only', [CollegeController::class, 'getCollegesOnly']);
Route::get('/colleges/search', [CollegeController::class, 'search']);
Route::get('/colleges/{college}', [CollegeController::class, 'show']);
Route::post('/colleges', [CollegeController::class, 'store']);
Route::put('/colleges/{college}', [CollegeController::class, 'update']);
Route::patch('/colleges/{college}', [CollegeController::class, 'update']);
Route::delete('/colleges/{college}', [CollegeController::class, 'destroy']);

// Авторизация
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ============= APPLICATIONS =============
Route::get('/applications', [ApplicationController::class, 'index']);
Route::get('/applications/create', [ApplicationController::class, 'create']);
Route::post('/applications', [ApplicationController::class, 'store']);
Route::get('/applications/{application}', [ApplicationController::class, 'show']);
Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit']);
Route::put('/applications/{application}', [ApplicationController::class, 'update']);
Route::patch('/applications/{application}', [ApplicationController::class, 'update']);
Route::delete('/applications/{application}', [ApplicationController::class, 'destroy']);




// ============= REQUESTS / APPLICATIONS =============
Route::get('/requests', [RequestController::class, 'index']);
Route::post('/requests', [RequestController::class, 'store']);
Route::get('/requests/{id}', [RequestController::class, 'show']);
Route::put('/requests/{id}', [RequestController::class, 'update']);
Route::patch('/requests/{id}', [RequestController::class, 'update']);
Route::delete('/requests/{id}', [RequestController::class, 'destroy']);