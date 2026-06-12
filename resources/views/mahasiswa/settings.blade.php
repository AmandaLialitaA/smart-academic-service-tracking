@extends('layouts.app')
@section('title', 'Settings')
@section('head')
    @vite(['resources/css/settings-mahasiswa.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>SETTINGS</h1>
    <div class="user-info">
        <span>Universitas Muhammadiyah Surakarta</span>
        <span>2023/2024</span>
    </div>
</div>
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>
<div class="settings-main">
    <p>Kelola informasi akun dan keamanan Anda.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-card">
        <h2>Informasi Akun</h2>
        <div class="desc">Username (email) hanya dapat diubah oleh admin.</div>
        <div class="settings-info-row">
            <label>Nama</label>
            <div class="value">{{ auth()->user()->name }}</div>
        </div>
        <div class="settings-info-row">
            <label>Username / Email</label>
            <div class="value">{{ auth()->user()->email }}</div>
        </div>
        <div class="settings-info-row">
            <label>NIM</label>
            <div class="value">{{ auth()->user()->nim }}</div>
        </div>
    </div>

    <div class="settings-card">
        <h2>Ubah Password</h2>
        <div class="desc">Pastikan password baru Anda kuat dan tidak digunakan di tempat lain.</div>
        <form action="{{ route('mahasiswa.settings.password') }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" minlength="8" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required>
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection