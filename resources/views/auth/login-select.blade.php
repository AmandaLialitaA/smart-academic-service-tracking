@extends('layouts.app')
@section('title', 'Pilih Login | STA-UMS')
@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700;900&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Instrument Sans', Arial, sans-serif; background: #fafafd; }
        .login-select-container { max-width: 420px; margin: 64px auto; background: #fff; border-radius: 18px; box-shadow: 0 4px 24px 0 rgba(162,89,230,0.08); padding: 40px 32px; text-align: center; }
        .login-select-title { font-family: 'Montserrat', Arial, sans-serif; font-weight: 900; font-size: 1.5rem; color: #a259e6; margin-bottom: 18px; }
        .login-select-desc { color: #888; font-size: 1.05rem; margin-bottom: 32px; }
        .login-select-btns { display: flex; flex-direction: column; gap: 18px; }
        .login-btn { display: flex; align-items: center; justify-content: center; gap: 12px; font-family: 'Montserrat', Arial, sans-serif; font-weight: 700; font-size: 1.1rem; border-radius: 12px; padding: 1em 0; border: none; background: #a259e6; color: #fff; box-shadow: 0 2px 12px 0 rgba(162,89,230,0.10); text-decoration: none; transition: background .2s; }
        .login-btn:hover { background: #7c3aed; }
        .login-btn svg { width: 22px; height: 22px; }
    </style>
@endsection
@section('content')
<script>document.body.classList.add('login-page');</script>
<div class="login-select-container">
    <div class="login-select-title">Pilih Portal Login</div>
    <div class="login-select-desc">Masuk sebagai Mahasiswa, Dosen, atau Admin sesuai peran Anda.</div>
    <div class="login-select-btns">
        <a href="/login/mahasiswa" class="login-btn"><svg fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#fff"/><path d="M12 13c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" fill="#a259e6"/></svg> Mahasiswa</a>
        <a href="/login/dosen" class="login-btn"><svg fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#fff"/><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" fill="#a259e6"/></svg> Dosen</a>
        <a href="/login/admin" class="login-btn"><svg fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#fff"/><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" fill="#a259e6"/></svg> Admin</a>
    </div>
</div>
@endsection
