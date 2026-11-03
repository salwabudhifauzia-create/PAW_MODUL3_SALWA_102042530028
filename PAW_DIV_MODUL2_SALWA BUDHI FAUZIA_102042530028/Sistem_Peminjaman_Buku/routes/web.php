<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

// Guest Routes (Khusus yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes (Khusus Admin yang sudah login)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // TODO: - Daftarkan route resource untuk BukuController ('buku')
    // Resource CRUD Data Buku
    Route::resource('buku', BukuController::class);

    // Resource CRUD Data Anggota
    Route::resource('anggota', AnggotaController::class)->parameters(['anggota' => 'anggota']);

    // Resource Peminjaman & Transaksi Pengembalian
    Route::resource('peminjaman', PeminjamanController::class);
    Route::put('/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
});

