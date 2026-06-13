@extends('layouts.auth')

@section('content')
<div class="login-container">
    <div class="login-left">
        <div class="branding">
            <div class="logo-title">
                <span class="logo-icon">🎓</span>
                <span class="logo-text">UMS SMART TRACKING</span>
            </div>
            <h1 class="headline">
                <span class="highlight">SISTEM AKADEMIK TERPADU</span><br>
                PORTAL DOSEN UMS
            </h1>
            <p class="desc">Efisiensi birokrasi dalam genggaman. Pantau pengajuan, berikan tanda tangan digital, dan kelola dokumen mahasiswa lebih cepat dari sebelumnya.</p>
            <div class="features">
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div><span class="feature-value">SECURE AUTHENTICATION</span><br>NIDN INTEGRATED</div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-right">
        <h2 class="welcome">LOGIN DOSEN</h2>
        <p class="subtitle">UNIVERSITAS MUHAMMADIYAH SURAKARTA</p>
        <div class="role-tabs">
            <button class="tab" type="button"><span class="tab-icon">🎓</span>MAHASISWA</button>
            <button class="tab active" type="button"><span class="tab-icon">👨‍🏫</span>DOSEN</button>
            <button class="tab" type="button"><span class="tab-icon">🛡️</span>ADMIN</button>
        </div>

        @if ($errors->any())
            <div style="background:#fee2e2;color:#b91c1c;border-radius:8px;padding:10px 14px;margin-bottom:12px;font-size:0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="login-form" method="POST" action="{{ url('login/dosen') }}">
            @csrf
            <label for="email" class="form-label">EMAIL INSTITUSI</label>
            <div class="input-group">
                <span class="input-icon">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z" fill="#222"/></svg>
                </span>
                <input type="email" id="email" name="email" placeholder="dosen@ac.id" value="{{ old('email') }}" required>
            </div>
            <label for="password" class="form-label">KATA SANDI</label>
            <div class="input-group" style="position:relative;">
                <span class="input-icon">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24"><path d="M12 17a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm6-7V8a6 6 0 1 0-12 0v2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2Zm-8-2a4 4 0 1 1 8 0v2H6V8Zm10 10H6v-6h12v6Z" fill="#222"/></svg>
                </span>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                <span class="toggle-password" onclick="togglePassword()" style="cursor:pointer;position:absolute;right:12px;color:#222;font-size:1.1rem;">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path stroke="#222" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3" stroke="#222" stroke-width="2"/></svg>
                </span>
            </div>
            <button type="submit" class="btn-login">Masuk Sekarang →</button>
        </form>

        <div class="divider"></div>
        <footer class="login-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>

        <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.innerHTML = '<path stroke="#222" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3" stroke="#222" stroke-width="2"/><line x1="4" y1="20" x2="20" y2="4" stroke="#222" stroke-width="2"/>';
            } else {
                pwd.type = 'password';
                eye.innerHTML = '<path stroke="#222" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3" stroke="#222" stroke-width="2"/>';
            }
        }
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                if (this.textContent.includes('MAHASISWA')) window.location.href = '/login/mahasiswa';
                else if (this.textContent.includes('ADMIN')) window.location.href = '/login/admin';
            });
        });
        </script>
    </div>
</div>
@endsection

@vite(['public/css/login-dosen.css'])