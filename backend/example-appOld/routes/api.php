<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationActionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes (только для авторизованных)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // ===== USER =====
    Route::middleware(['web', 'auth'])->get('/user', [AuthController::class, 'user']);

    // ===== VACANCIES =====
    Route::middleware(['web', 'auth'])->apiResource('vacancies', VacancyController::class);

    // ===== COLLEGES =====
    Route::middleware(['web', 'auth'])->get('/colleges/universities', [CollegeController::class, 'getUniversities']);
    Route::middleware(['web', 'auth'])->get('/colleges/colleges-only', [CollegeController::class, 'getCollegesOnly']);
    Route::middleware(['web', 'auth'])->get('/colleges/search', [CollegeController::class, 'search']);
    Route::middleware(['web', 'auth'])->apiResource('colleges', CollegeController::class);

    // ===== APPLICATIONS =====
    Route::middleware(['web', 'auth'])->apiResource('applications', ApplicationController::class);

    // ===== REQUESTS =====
    Route::middleware(['web', 'auth'])->apiResource('requests', RequestController::class);

    // ===== ACTIONS =====
    Route::middleware(['web', 'auth'])->post('/applications/{id}/reject', [ApplicationActionController::class, 'reject']);
    Route::middleware(['web', 'auth'])->post('/applications/{id}/invite', [ApplicationActionController::class, 'invite']);

    // ===== CHATS =====
    Route::middleware(['web', 'auth'])->get('/chats', [ChatController::class, 'index']);
    Route::middleware(['web', 'auth'])->post('/chats', [ChatController::class, 'store']);
    Route::middleware(['web', 'auth'])->get('/chats/{chat}', [ChatController::class, 'show']);
    Route::middleware(['web', 'auth'])->delete('/chats/{chat}', [ChatController::class, 'destroy']);

    // ===== MESSAGES =====
    Route::middleware(['web', 'auth'])->get('/chats/{chat}/messages', [MessageController::class, 'index']);
    Route::middleware(['web', 'auth'])->post('/messages', [MessageController::class, 'store']);
    Route::middleware(['web', 'auth'])->get('/messages/{message}', [MessageController::class, 'show']);
    Route::middleware(['web', 'auth'])->delete('/messages/{message}', [MessageController::class, 'destroy']);
});