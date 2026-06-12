@extends('layouts.auth')
@section('title', 'Daftar Akun - UMS Smart Tracking')
@section('content')
<div class="login-container">
    <div class="login-right" style="max-width:480px;margin:40px auto;">
        <h2 class="welcome">DAFTAR AKUN</h2>
        <p class="subtitle">Buat akun {{ $role === 'dosen' ? 'Dosen' : 'Mahasiswa' }} UMS.</p>

        @if($errors->any())
            <div style="background:#fee2e2;color:#b91c1c;padding:10px;margin-bottom:12px;border-radius:6px;">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="login-form">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <label class="form-label">NAMA LENGKAP</label>
            <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:10px;margin-bottom:12px;">

            <label class="form-label">EMAIL</label>
            <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:10px;margin-bottom:12px;">

            @if($role === 'mahasiswa')
            <label class="form-label">NIM</label>
            <input type="text" name="nim" value="{{ old('nim') }}" required style="width:100%;padding:10px;margin-bottom:12px;">
            <label class="form-label">PROGRAM STUDI</label>
            <input type="text" name="prodi" value="{{ old('prodi') }}" required style="width:100%;padding:10px;margin-bottom:12px;">
            <label class="form-label">SEMESTER</label>
            <input type="number" name="semester" min="1" max="14" value="{{ old('semester') }}" required style="width:100%;padding:10px;margin-bottom:12px;">
            @endif

            <label class="form-label">PASSWORD</label>
            <input type="password" name="password" required style="width:100%;padding:10px;margin-bottom:12px;">
            <label class="form-label">KONFIRMASI PASSWORD</label>
            <input type="password" name="password_confirmation" required style="width:100%;padding:10px;margin-bottom:16px;">

            <button type="submit" class="btn-login">DAFTAR SEKARANG →</button>
        </form>

        <p style="margin-top:16px;font-size:14px;">
            Sudah punya akun?
            @if($role === 'dosen')
                <a href="{{ route('login.dosen') }}">Login Dosen</a>
            @else
                <a href="{{ route('login.mahasiswa') }}">Login Mahasiswa</a>
            @endif
        </p>
    </div>
</div>
@endsection
