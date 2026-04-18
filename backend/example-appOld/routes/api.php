<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationActionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes (только для авторизованных)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // ===== ВАКАНСИИ =====
    Route::apiResource('vacancies', VacancyController::class);

    // ===== КОЛЛЕДЖИ =====
    Route::get('/colleges/universities', [CollegeController::class, 'getUniversities']);
    Route::get('/colleges/colleges-only', [CollegeController::class, 'getCollegesOnly']);
    Route::get('/colleges/search', [CollegeController::class, 'search']);
    Route::apiResource('colleges', CollegeController::class);

    // ===== APPLICATIONS =====
    Route::apiResource('applications', ApplicationController::class);

    // ===== REQUESTS =====
    Route::apiResource('requests', RequestController::class);

    // ===== ACTIONS =====
    Route::post('/applications/{id}/reject', [ApplicationActionController::class, 'reject']);
    Route::post('/applications/{id}/invite', [ApplicationActionController::class, 'invite']);

    // ===== CHATS =====
    Route::apiResource('chats', ChatController::class);
    Route::get('/chats/{chatId}/messages', [MessageController::class, 'index']);

    // ===== MESSAGES =====
    Route::apiResource('messages', MessageController::class)->only(['store', 'show', 'destroy']);
});