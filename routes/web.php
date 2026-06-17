<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TandaTanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('landing'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showSelectRole'])->name('login');
    Route::get('/login/mahasiswa', [AuthController::class, 'showLoginMahasiswa'])->name('login.mahasiswa');
    Route::get('/login/dosen', [AuthController::class, 'showLoginDosen'])->name('login.dosen');
    Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');

    Route::post('/login/mahasiswa', [AuthController::class, 'loginMahasiswa'])->name('login.mahasiswa.post');
    Route::post('/login/dosen', [AuthController::class, 'loginDosen'])->name('login.dosen.post');
    Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/lupa-password', fn () => view('auth.lupa-password'))->name('password.request');
    Route::post('/lupa-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::post('/settings/avatar', [SettingsController::class, 'updateAvatar'])->name('settings.avatar.update');
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', [PengajuanController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('mahasiswa.pengajuan');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('mahasiswa.pengajuan.store');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('mahasiswa.pengajuan.detail');
    Route::get('/tracking/{pengajuan}', [PengajuanController::class, 'tracking'])->name('mahasiswa.tracking');
    Route::get('/riwayat', [PengajuanController::class, 'riwayat'])->name('mahasiswa.riwayat');
    Route::get('/ttd/{tandaTangan}/unduh', [TandaTanganController::class, 'unduh'])->name('mahasiswa.ttd.unduh'); // tambah ini
});

Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/menunggu', [DosenController::class, 'menunggu'])->name('menunggu');
    Route::get('/riwayat', [DosenController::class, 'riwayat'])->name('riwayat');
    Route::get('/pengajuan/{pengajuan}', [DosenController::class, 'show'])->name('pengajuan.show');
    Route::post('/pengajuan/{pengajuan}/approve', [DosenController::class, 'approve'])->name('pengajuan.approve');
    Route::post('/pengajuan/{pengajuan}/reject', [DosenController::class, 'reject'])->name('pengajuan.reject');

    // TTD routes
    Route::get('/pengajuan/{pengajuan}/ttd', [TandaTanganController::class, 'show'])->name('ttd.show');
    Route::post('/pengajuan/{pengajuan}/ttd', [TandaTanganController::class, 'store'])->name('ttd.store');

    // POINT 1: gambar (preview) dan unduh file TTD
    Route::get('/ttd/{tandaTangan}/gambar', [TandaTanganController::class, 'gambar'])->name('ttd.gambar');
    Route::get('/ttd/{tandaTangan}/unduh', [TandaTanganController::class, 'unduh'])->name('ttd.unduh');
    Route::delete('/ttd/{tandaTangan}', [TandaTanganController::class, 'destroy'])->name('ttd.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/verifikasi', [AdminController::class, 'verifikasiList'])->name('verifikasi');
    Route::get('/verifikasi/{pengajuan}', [AdminController::class, 'show'])->name('verifikasi.detail');
    Route::post('/verifikasi/{pengajuan}/setuju', [AdminController::class, 'approveSubmitted'])->name('verifikasi.setuju');

    // POINT 4 FIX: route tolak — satu route, ditangani AdminController::rejectPengajuan
    Route::post('/verifikasi/{pengajuan}/tolak', [AdminController::class, 'rejectPengajuan'])->name('verifikasi.tolak');

    Route::post('/pengajuan/{pengajuan}/teruskan', [AdminController::class, 'teruskeDosen'])->name('pengajuan.teruskan');
    Route::post('/pengajuan/{pengajuan}/selesai', [AdminController::class, 'checklist'])->name('pengajuan.selesai');
    Route::get('/semua-pengajuan', [AdminController::class, 'semuaPengajuan'])->name('semua-pengajuan');

    // POINT 2 & 3: admin kelola user (buat, update, hapus dari DB)
    Route::get('/settings', [AdminController::class, 'usersIndex'])->name('settings');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // POINT 1: admin juga bisa lihat/unduh TTD dosen
    Route::get('/ttd/{tandaTangan}/gambar', [TandaTanganController::class, 'gambar'])->name('ttd.gambar');
    Route::get('/ttd/{tandaTangan}/unduh', [TandaTanganController::class, 'unduh'])->name('ttd.unduh');
});

Route::middleware('auth')->group(function () {
    Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show');
    Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])->name('dokumen.download');
});

Route::get('/kontak-admin', fn () => view('auth.kontak-admin'))->name('kontak.admin');

// group dosen
Route::get('/ttd/{tandaTangan}/pdf', [TandaTanganController::class, 'unduhPdfTtd'])->name('ttd.pdf');

// group mahasiswa
Route::get('/ttd/{tandaTangan}/pdf', [TandaTanganController::class, 'unduhPdfTtd'])->name('mahasiswa.ttd.pdf');

// group admin
Route::get('/ttd/{tandaTangan}/pdf', [TandaTanganController::class, 'unduhPdfTtd'])->name('ttd.pdf');