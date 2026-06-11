<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

// ── Landing ───────────────────────────────────────────────────
Route::get('/', fn() => view('landing'));

// ── Auth (Guest only) ─────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',            [AuthController::class, 'showSelectRole'])->name('login');
    Route::get('/login/mahasiswa',  [AuthController::class, 'showLoginMahasiswa'])->name('login.mahasiswa');
    Route::get('/login/dosen',      [AuthController::class, 'showLoginDosen'])->name('login.dosen');
    Route::get('/login/admin',      [AuthController::class, 'showLoginAdmin'])->name('login.admin');

    Route::post('/login/mahasiswa', [AuthController::class, 'loginMahasiswa'])->name('login.mahasiswa.post');
    Route::post('/login/dosen',     [AuthController::class, 'loginDosen'])->name('login.dosen.post');
    Route::post('/login/admin',     [AuthController::class, 'loginAdmin'])->name('login.admin.post');
});

// ── Logout ────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── MAHASISWA ─────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))->name('mahasiswa.dashboard');
    Route::get('/pengajuan', fn() => view('mahasiswa.pengajuan'))->name('mahasiswa.pengajuan');
    Route::get('/tracking',  fn() => view('mahasiswa.tracking'))->name('mahasiswa.tracking');
    Route::get('/riwayat',   fn() => view('mahasiswa.riwayat'))->name('mahasiswa.riwayat');
});

// ── DOSEN ─────────────────────────────────────────────────────
Route::middleware('auth')->prefix('dosen')->group(function () {
    Route::get('/dashboard',         fn() => view('dosen.dashboard'))->name('dosen.dashboard');
    Route::get('/detail-pengajuan',  fn() => view('dosen.detail-pengajuan'))->name('dosen.detail');
    Route::get('/riwayat',           fn() => view('dosen.riwayat-dosen'))->name('dosen.riwayat');
    Route::get('/menunggu',          fn() => view('dosen.dashboard'))->name('dosen.menunggu');
});

// ── ADMIN ─────────────────────────────────────────────────────
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard',         fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/verifikasi',        fn() => view('admin.verifikasi-list'))->name('admin.verifikasi');
    Route::get('/verifikasi/detail', fn() => view('admin.verifikasi'))->name('admin.verifikasi.detail');
    Route::get('/semua-pengajuan',   fn() => view('admin.semua-pengajuan'))->name('admin.semua-pengajuan');
    Route::get('/analytics',         fn() => view('admin.analytics'))->name('admin.analytics');
});

// ── Misc ──────────────────────────────────────────────────────
Route::get('/lupa-password',  fn() => view('auth.lupa-password'))->name('password.request');
Route::get('/kontak-admin',   fn() => view('auth.kontak-admin'))->name('kontak.admin');