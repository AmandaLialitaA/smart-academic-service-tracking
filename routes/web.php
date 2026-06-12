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
    Route::get('/login',                [AuthController::class, 'showSelectRole'])->name('login.select');
    Route::get('/login/mahasiswa',      [AuthController::class, 'showLoginMahasiswa'])->name('login.mahasiswa');
    Route::get('/login/dosen',          [AuthController::class, 'showLoginDosen'])->name('login.dosen');
    Route::get('/login/admin',          [AuthController::class, 'showLoginAdmin'])->name('login.admin');

    Route::post('/login/mahasiswa',     [AuthController::class, 'loginMahasiswa']);
    Route::post('/login/dosen',         [AuthController::class, 'loginDosen']);
    Route::post('/login/admin',         [AuthController::class, 'loginAdmin']);
});

// ── Logout ────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── DOKUMEN (semua role berwenang) ─────────────────────────────
Route::get('/dokumen/{dokumen}', [PengajuanController::class, 'dokumen'])
    ->name('dokumen.show')
    ->middleware('auth');

// ── MAHASISWA ─────────────────────────────────────────────────
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard',            [PengajuanController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('/pengajuan',            [PengajuanController::class, 'index'])->name('mahasiswa.pengajuan');
    Route::post('/pengajuan',           [PengajuanController::class, 'store'])->name('mahasiswa.pengajuan.store');
    Route::get('/upload',               [PengajuanController::class, 'showUpload'])->name('mahasiswa.upload');
    Route::get('/tracking',             [PengajuanController::class, 'tracking'])->name('mahasiswa.tracking');
    Route::get('/pengajuan/{pengajuan}',[PengajuanController::class, 'show'])->name('mahasiswa.pengajuan.show');
    Route::get('/settings',             [PengajuanController::class, 'settings'])->name('mahasiswa.settings');
    Route::put('/settings/password',    [PengajuanController::class, 'updatePassword'])->name('mahasiswa.settings.password');
});

// ── DOSEN ─────────────────────────────────────────────────────
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard',            [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/verifikasi',           [DosenController::class, 'listPengajuan'])->name('verifikasi');
    Route::get('/pengajuan/{pengajuan}',[DosenController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{pengajuan}/approve', [DosenController::class, 'approve'])->name('pengajuan.approve');
    Route::post('/pengajuan/{pengajuan}/reject',  [DosenController::class, 'reject'])->name('pengajuan.reject');
});

// ── ADMIN ─────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',            [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengajuan',            [AdminController::class, 'listPengajuan'])->name('pengajuan');
    Route::get('/pengajuan/{pengajuan}',[AdminController::class, 'show'])->name('pengajuan.show');

    // Alur workflow
    Route::post('/pengajuan/{pengajuan}/verifikasi',  [AdminController::class, 'verifikasi'])->name('pengajuan.verifikasi');
    Route::post('/pengajuan/{pengajuan}/teruskan',    [AdminController::class, 'teruskeDosen'])->name('pengajuan.teruskan');
    Route::post('/pengajuan/{pengajuan}/selesai',     [AdminController::class, 'checklist'])->name('pengajuan.selesai');
});