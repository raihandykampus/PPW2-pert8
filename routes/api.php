<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobApiController;

// Test Route
Route::get('/status', fn() => ['status' => 'API is running']);

// Public Routes (Bisa diakses tanpa login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Latihan 4: Jobs Read-Only bisa diakses publik
Route::get('/jobs', [JobApiController::class, 'index']);
Route::get('/jobs/{job}', [JobApiController::class, 'show']);


// Protected Routes (Harus punya Token)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', fn (Request $r) => $r->user()); // Cek user saat ini
    Route::post('/logout', [AuthController::class, 'logout']);

    // Jobs API
    Route::post('/jobs', [JobApiController::class, 'store']);

    // latihan 2
    Route::patch('/applications/{id}/status', [ApplicationApiController::class, 'updateStatus']);
});