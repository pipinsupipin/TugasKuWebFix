<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\Api\UserController::class, 'getUserData']);
    Route::put('user/profile', [\App\Http\Controllers\Api\UserController::class, 'updateProfile']);
    Route::put('user/password', [\App\Http\Controllers\Api\UserController::class, 'updatePassword']);
    Route::delete('user/{userId}', [\App\Http\Controllers\Api\UserController::class, 'deleteAccount']);

    // Kategori Tugas
    Route::apiResource('kategori', \App\Http\Controllers\Api\KategoriTugasController::class);
    Route::get('/kategori/{id}/tugas', [\App\Http\Controllers\Api\KategoriTugasController::class, 'getTasksByCategory']);
    
    // Tugas
    Route::apiResource('tugas', \App\Http\Controllers\Api\TugasController::class);
    Route::post('tugas/{id}/toggle-complete', [\App\Http\Controllers\Api\TugasController::class, 'toggleComplete']);
    
    // Streaks
    Route::get('streaks', [\App\Http\Controllers\Api\StreakController::class, 'index']);
    Route::get('streaks/summary', [\App\Http\Controllers\Api\StreakController::class, 'summary']);
    // Route::get('streaks/today', [\App\Http\Controllers\Api\StreakController::class, 'checkTodayTasks']);
});
