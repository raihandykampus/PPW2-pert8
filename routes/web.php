<?php

use App\Http\Controllers\ApplicationController;
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



// LATIHAN 8: Route untuk download template
Route::get('/jobs/import-template', [JobController::class, 'downloadTemplate'])
     ->name('jobs.importTemplate')
     ->middleware('isAdmin');

Route::post('/jobs/import', [JobController::class, 'import'])
     ->name('jobs.import')
     ->middleware('isAdmin');


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


// Route::resource('jobs', JobController::class)->middleware(['auth', 'isAdmin']);

// 1. ROUTE UNTUK JOB SEEKER (USER BIASA)
// Hanya boleh akses 'index' (melihat daftar) & 'show' (melihat detail)
Route::resource('jobs', JobController::class)
     ->middleware(['auth'])
     ->only(['index', 'show']);

// 2. ROUTE UNTUK ADMIN
// Boleh akses sisanya: 'create', 'store', 'edit', 'update', 'destroy'
Route::resource('jobs', JobController::class)
     ->middleware(['auth', 'isAdmin'])
     ->except(['index', 'show']);

// Route untuk memproses lamaran (POST)
Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
     ->name('apply.store')
     ->middleware('auth');

// Route untuk Admin melihat daftar pelamar per lowongan
Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'index'])
     ->name('applications.index')
     ->middleware('isAdmin'); // Hanya Admin



Route::put('/applications/{application}', [ApplicationController::class, 'update'])
     ->name('applications.update')
     ->middleware('isAdmin');

// LATIHAN 6: Route untuk download CV
Route::get('/applications/{application}/download-cv', [ApplicationController::class, 'downloadCv'])
     ->name('applications.downloadCv')
     ->middleware('isAdmin');

Route::get('/jobs/{job}/applicants/export', [ApplicationController::class, 'export'])
     ->name('applications.export')
     ->middleware('isAdmin');




