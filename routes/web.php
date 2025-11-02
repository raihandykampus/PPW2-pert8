<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class,'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class,'register']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware(['auth']);
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

// LATIHAN 1: route profile
Route::get('/profile', function() {
    return view('profile');
})->middleware(['auth'])->name('profile');

Route::get('/hello', function() {
    return "Halo, ini halaman percobaan route!";
});

Route::get('/jobs', [JobController::class, 'index']);

Route::get('/admin', function() {
    return "Halo Admin! Ini Halaman Khusus Admin.";
})->middleware(['auth', 'isAdmin']);

// LATIHAN 2: Route Untuk kelola jobs (admin only)
Route::get('/admin/jobs', function() {
    return "Halaman Kelola Lowongan Kerja (Khusus Admin)";
})->middleware(['auth', 'isAdmin']);