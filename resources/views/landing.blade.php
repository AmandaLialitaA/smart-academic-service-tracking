@extends('layouts.app')
@section('title', 'STA-UMS | Layanan Akademik Digital')
@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700;900&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/landing.css'])
@endsection
@section('content')
<script>document.body.classList.add('landing-page');</script>
<div class="landing-hero">
    <header class="landing-header">
        <div class="logo-area">
            <span class="logo-icon"><svg width="32" height="32" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#a259e6"/><path d="M7 12l5 5 5-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
            <span class="logo-text">STA-UMS</span>
        </div>
        <a href="/login" class="btn btn-primary">Login Portal</a>
    </header>
    <div class="hero-content">
        <div class="hero-left">
            <div class="badge-version">E-Office Tracking</div>
            <h1 class="hero-title">Layanan Akademik <span class="highlight">Lebih Cepat & Transparan.</span></h1>
            <p class="hero-desc">Sistem Pelacakan Akademik Terpadu Universitas Muhammadiyah Surakarta. Pantau setiap tahap pengajuan dokumen Anda secara real-time melalui platform digital kami yang aman.</p>
            <div class="hero-actions">
                <a href="/login" class="btn btn-primary">Mulai Pengajuan <svg width="20" height="20" style="vertical-align:middle;"><use xlink:href="#icon-arrow-right"/></svg></a>
            </div>
        </div>
        <div class="hero-right">
            <div class="feature-list">
                <div class="feature-item"><span class="feature-icon">⚡</span> Proses Kilat</div>
                <div class="feature-item"><span class="feature-icon">🌐</span> Akses Universal</div>
                <div class="feature-item"><span class="feature-icon">🔒</span> Keamanan Terjamin</div>
                <div class="feature-item"><span class="feature-icon">📜</span> Sertifikasi Mutu</div>
            </div>
        </div>
    </div>
</div>
<div class="landing-section popular-services">
    <h2 class="section-title">Layanan Akademik Terpopuler.</h2>
    <p class="section-desc">Kami menyediakan berbagai layanan administrasi untuk menunjang kebutuhan studi Anda tanpa birokrasi yang rumit.</p>
    <div class="service-cards">
        <div class="service-card">
            <div class="service-icon">🔗</div>
            <div class="service-title">Legalisir Dokumen Digital</div>
            <div class="service-desc">Proses legalisir ijazah dan transkrip dengan teknologi QR Code untuk validasi.</div>
            <a href="/login" class="service-link">Mulai Layanan</a>
        </div>
        <div class="service-card">
            <div class="service-icon">🗂️</div>
            <div class="service-title">Pengajuan Cuti Akademik</div>
            <div class="service-desc">Prosedur administrasi untuk pengajuan cuti studi sementara dengan mudah.</div>
            <a href="/login" class="service-link">Mulai Layanan</a>
        </div>
        <div class="service-card">
            <div class="service-icon">📑</div>
            <div class="service-title">Layanan Lainnya</div>
            <div class="service-desc">Akses berbagai layanan akademik dengan dukungan tanda tangan digital yang aman dan efisien.</div>
            <a href="/login" class="service-link">Mulai Layanan</a>
        </div>
    </div>
</div>
<div class="landing-section cta-section">
    <div class="cta-box">
        <h2 class="cta-title">Siap Mempercepat Urusan Akademik Anda?</h2>
        <p class="cta-desc">Gunakan akun CAS (Central Authentication Service) UMS Anda untuk masuk dan mulai ajukan layanan sekarang juga.</p>
        <a href="/login" class="btn btn-primary cta-btn">Masuk Portal Login</a>
    </div>
</div>
<footer class="landing-footer">
    <div class="footer-left">
        <span class="footer-logo">STA-UMS</span>
        <span class="footer-desc">Pusat layanan administrasi akademik digital terbaik untuk menunjang kebutuhan studi mahasiswa Universitas Muhammadiyah Surakarta.</span>
    </div>
    <div class="footer-center">
        <div class="footer-col">
            <div class="footer-title">Layanan</div>
            <a href="/login">Legalisir Digital</a>
            <a href="/login">Cuti Akademik</a>
            <a href="/login">Dan Layanan Lainnya</a>
        </div>
        <div class="footer-col">
            <div class="footer-title">Bantuan</div>
            <a href="#">Panduan</a>
            <a href="#">FAQ</a>
            <a href="#">Kontak Admin</a>
            <a href="#">Syarat & Ketentuan</a>
        </div>
        <div class="footer-col">
            <div class="footer-title">Hubungi Kami</div>
            <span>📍Gedung J, Kampus 2, Universitas Muhammadiyah Surakarta</span>
        </div>
    </div>
    <div class="footer-right">
        <span>© 2026 Universitas Muhammadiyah Surakarta. Semua hak cipta dilindungi.</span>
    </div>
</footer>
@endsection
