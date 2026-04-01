@extends('layouts.app')
@section('title', 'Login - Smart Academic UMS')
@section('head')
    @vite(['resources/css/login.css'])
@endsection
@section('content')
@include('components.icons')

<div class="login-main">
    <div class="login-container">
        <!-- LEFT SIDE: Branding & Info -->
        <div class="login-left">
            <div class="login-brand">
                <div class="brand-badge">UMS SMART TRACKING</div>
                <h1 class="brand-title">
                    EFISIENSI <span class="highlight">AKADEMIK</span><br>DI TANGAN ANDA.
                </h1>
                <div class="brand-desc">
                    Sistem pelacakan layanan administrasi terpadu Universitas Muhammadiyah Surakarta yang modern, transparan, dan akuntabel.
                </div>
                <div class="brand-feature-row">
                    <div class="brand-feature">
                        <span class="brand-feature-icon"><svg width="20" height="20"><use xlink:href="#icon-user"/></svg></span>
                        100% DIGITAL WORKFLOW
                    </div>
                    <div class="brand-feature">
                        <span class="brand-feature-icon"><svg width="20" height="20"><use xlink:href="#icon-eye"/></svg></span>
                        REALTIME STATUS TRACKING
                    </div>
                </div>
            </div>
        </div>
        <!-- RIGHT SIDE: Login Form -->
        <div class="login-right">
            <div class="login-form-card">
                <h2 class="login-title">SELAMAT DATANG</h2>
                <div class="login-subtitle">Silakan masuk untuk mengakses layanan akademik Anda.</div>
                <div class="login-role-switch">
                    <button class="role-btn active"><svg width="20" height="20"><use xlink:href="#icon-user"/></svg> MAHASISWA</button>
                    <button class="role-btn"><svg width="20" height="20"><use xlink:href="#icon-user"/></svg> DOSEN</button>
                    <button class="role-btn"><svg width="20" height="20"><use xlink:href="#icon-user"/></svg> ADMIN</button>
                </div>
                <form action="/login" method="POST" class="login-form-fields">
                    @csrf
                    <div class="form-group">
                        <label for="identifier">NIM / EMAIL STUDENT</label>
                        <div class="input-icon-group">
                            <span class="input-icon"><svg width="20" height="20"><use xlink:href="#icon-user"/></svg></span>
                            <input type="text" id="identifier" name="identifier" required placeholder="L200234258">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">PASSWORD</label>
                        <div class="input-icon-group">
                            <span class="input-icon"><svg width="20" height="20"><use xlink:href="#icon-lock"/></svg></span>
                            <input type="password" id="password" name="password" required placeholder="********">
                            <span class="input-icon input-icon-right"><svg width="20" height="20"><use xlink:href="#icon-eye"/></svg></span>
                        </div>
                    </div>
                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            INGAT SAYA
                        </label>
                        <a href="/forgot-password" class="forgot-link">LUPA PASSWORD?</a>
                    </div>
                    <button type="submit" class="login-btn">MASUK KE SISTEM <svg width="28" height="28" style="vertical-align:middle;"><use xlink:href="#icon-arrow-right"/></svg></button>
                </form>
                <div class="login-divider"><span>atau masuk melalui</span></div>
                <div class="login-alt-btns">
                    <button class="alt-btn">CAS UMS</button>
                    <button class="alt-btn">Google</button>
                </div>
                <div class="login-footer-alt">
                    <span>Belum punya akun?</span>
                    <a href="#" class="footer-link">HUBUNGI ADMIN IT</a>
                </div>
            </div>
        </div>
    </div>
    <footer class="login-footer-copyright">
        © 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
    </footer>
</div>
@endsection
