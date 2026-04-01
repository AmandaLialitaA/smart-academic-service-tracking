<?php

use Illuminate\Support\Facades\Route;


// Landing page
Route::get('/', function () {
    return view('landing');
});

// Login selection page (choose role)
Route::get('/login', function () {
    return view('auth.login-select');
});

// Login Routes for different roles
Route::get('/login/mahasiswa', function () {
    return view('auth.login-mahasiswa');
});

Route::get('/login/dosen', function () {
    return view('auth.login-dosen');
});

Route::get('/login/admin', function () {
    return view('auth.login-admin');
});

// Mahasiswa Routes
Route::get('/dashboard', function () {
    return view('mahasiswa.dashboard');
});

Route::get('/pengajuan', function () {
    return view('mahasiswa.pengajuan');
});

Route::get('/upload', function () {
    return view('mahasiswa.upload');
});

Route::get('/tracking', function () {
    return view('mahasiswa.tracking');
});

// Dosen Routes
Route::get('/dosen/dashboard', function () {
    return view('dosen.dashboard');
});

// Admin Routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
