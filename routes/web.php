<?php

/**
 * Path   : routes/web.php
 * Status : GANTI — tulis ulang full file ini
 * Ubahan : Menambahkan route company profile (publik)
 */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// ============================================================
// ROOT — arahkan ke beranda company profile
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ============================================================
// COMPANY PROFILE — semua halaman publik (tanpa login)
// ============================================================
Route::get('/tentang',  [HomeController::class, 'tentang'])->name('compro.tentang');
Route::get('/layanan',  [HomeController::class, 'layanan'])->name('compro.layanan');
Route::get('/jadwal',   [HomeController::class, 'jadwal'])->name('compro.jadwal');
Route::get('/kontak',   [HomeController::class, 'kontak'])->name('compro.kontak');

// ============================================================
// PUBLIK — display antrian & API
// ============================================================
Route::get('/antrian/display', [QueueController::class, 'display'])
    ->name('queues.display');

Route::get('/api/antrian/current', [QueueController::class, 'current'])
    ->name('api.antrian.current');

// ============================================================
// AUTH
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ============================================================
// ADMIN DASHBOARD
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
});

// ============================================================
// STAFF DASHBOARD
// ============================================================
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', fn () => view('staff.dashboard'))->name('dashboard');
});

// ============================================================
// FITUR UTAMA — semua user login
// ============================================================
Route::middleware('auth')->group(function () {

    Route::resource('patients', PatientController::class);

    Route::resource('doctors', DoctorController::class);

    Route::resource('schedules', ScheduleController::class);

    Route::resource('queues', QueueController::class)->only([
        'index', 'create', 'store', 'destroy',
    ]);

    Route::patch('/queues/{queue}/status', [QueueController::class, 'updateStatus'])
        ->name('queues.updateStatus');
});
