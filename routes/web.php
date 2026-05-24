<?php

use Illuminate\Support\Facades\Route;


// Landing page
Route::get('/', function () {
    return view('landing');
});

// Login page
Route::get('/login', function () {
    return view('auth.login');
});

// Mahasiswa Routes
Route::get('/dashboard', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/pengajuan', function () {
    return view('mahasiswa.pengajuan');
});

Route::get('/tracking', function () {
    return view('mahasiswa.tracking');
});

Route::get('/riwayat', function () {
    return view('mahasiswa.riwayat');
});

// Dosen Routes
Route::get('/dosen/dashboard', function () {
    return view('dosen.dashboard');
});

Route::get('/dosen/detail-pengajuan', function () {
    return view('dosen.detail-pengajuan');
});

Route::get('/dosen/riwayat', function () {
    return view('dosen.riwayat-dosen');
});

// Admin Routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/verifikasi', function () {
    return view('admin.verifikasi-list');
});

Route::get('/admin/verifikasi/detail', function () {
    return view('admin.verifikasi');
});

Route::get('/admin/analytics',  fn() => view('admin.analytics'))->name('admin.analytics');

Route::get('/admin/semua-pengajuan', function () {
    return view('admin.semua-pengajuan');
});

// lupa password
Route::get('/lupa-password', function () {
    return view('auth.lupa-password');
});

// kontak admin
Route::get('/kontak-admin', function () {
    return view('auth.kontak-admin');
});