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
                EFISIENSI <span class="highlight">AKADEMIK</span><br>
                DI TANGAN ANDA.
            </h1>
            <p class="desc">Sistem pelacakan layanan administrasi terpadu Universitas Muhammadiyah Surakarta yang modern, transparan, dan akuntabel.</p>
            <div class="features">
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div>
                        <span class="feature-value">100%</span><br>Digital Workflow
                    </div>
                </div>
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div>
                        <span class="feature-value">REALTIME</span><br>Status Tracking
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-right">
        <h2 class="welcome">SELAMAT DATANG</h2>
        <p class="subtitle">Silakan masuk untuk mengakses layanan akademik Anda.</p>
        <div class="role-tabs">
                <button class="tab active" type="button">
                    <span class="tab-icon">🎓</span>
                    MAHASISWA
                </button>
                <button class="tab" type="button">
                    <span class="tab-icon">👨‍🏫</span>
                    DOSEN
                </button>
                <button class="tab" type="button">
                    <span class="tab-icon">🛡️</span>
                    ADMIN
                </button>
        </div>
        <form class="login-form" onsubmit="return false;">
            <label for="nim" class="form-label">NIM / EMAIL STUDENT</label>
            <div class="input-group">
                <span class="input-icon">👤</span>
                    <input type="text" id="nim" name="nim" placeholder="L200234258" required>
            </div>
            <label for="password" class="form-label">PASSWORD <a href="#" class="forgot">LUPA PASSWORD?</a></label>
            <div class="input-group" style="position:relative;">
                <span class="input-icon">🔒</span>
                <input type="password" id="password" name="password" placeholder="********" required>
                <span class="toggle-password" onclick="togglePassword()" style="cursor:pointer; position:absolute; right:12px; color:#888; font-size:1.1rem;">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path stroke="#888" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3" stroke="#888" stroke-width="2"/></svg>
                </span>
            </div>
            <button type="submit" class="btn-login">MASUK KE SISTEM →</button>
            </form>
            <script>
            function togglePassword() {
                const pwd = document.getElementById('password');
                const eye = document.getElementById('eyeIcon');
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    eye.innerHTML = '<path stroke="#888" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3" stroke="#888" stroke-width="2"/><line x1="4" y1="20" x2="20" y2="4" stroke="#888" stroke-width="2"/>';
                } else {
                    pwd.type = 'password';
                    eye.innerHTML = '<path stroke="#888" stroke-width="2" d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3" stroke="#888" stroke-width="2"/>';
                }
            }
            </script>
        </form>
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
                if (this.textContent.includes('DOSEN')) {
                    window.location.href = '/login-dosen';
                } else if (this.textContent.includes('ADMIN')) {
                    window.location.href = '/login-admin';
                }
            });
        });
        </script>
        <div class="divider"></div>
        <div class="no-account">
            Belum punya akun?
            <button class="btn-contact">HUBUNGI ADMIN IT</button>
        </div>
        <footer class="login-footer">
            © 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
        </footer>
    </div>
</div>
@endsection

@vite(['public/css/login-mahasiswa.css'])
