@extends('layouts.auth')
@section('title', 'Lupa Password - Smart Academic UMS')
@section('head')
    @vite(['resources/css/login.css'])
@endsection
@section('content')

<div class="login-main" id="login-main" data-role="mahasiswa">
    <div class="login-container">

        {{-- KIRI: Branding --}}
        <div class="login-left">
            <div class="login-brand">
                <div class="brand-logo-row">
                    <div class="brand-logo-icon">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                            <path d="M12 3L2 9l10 6 10-6-10-6z" fill="#fff"/>
                            <path d="M2 15l10 6 10-6" stroke="#fff" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="brand-logo-text">UMS SMART TRACKING</span>
                </div>
                <p class="brand-eyebrow" id="brand-eyebrow">Portal Mahasiswa</p>
                <h1 class="brand-title" id="brand-title">
                    LUPA<br>
                    <span class="highlight">PASSWORD</span><br>
                    ANDA?
                </h1>
                <p class="brand-desc" id="brand-desc">
                    Tenang, kami akan membantu Anda mengatur ulang password akun akademik Anda dengan aman.
                </p>
            </div>
            <div class="brand-features-bottom">
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div class="feature-text">
                        <span class="feature-value">100%</span>
                        <span class="feature-label">AMAN & TERENKRIPSI</span>
                    </div>
                </div>
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div class="feature-text">
                        <span class="feature-value">24/7</span>
                        <span class="feature-label">LAYANAN AKTIF</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: Form --}}
        <div class="login-right">
            <div class="role-pill" id="role-pill">Portal Mahasiswa</div>
            <h2 class="login-title">LUPA PASSWORD</h2>
            <p class="login-subtitle">Masukkan email atau ID akun Anda. Kami akan mengirimkan instruksi reset password.</p>

            {{-- Role tabs --}}
            <div class="login-role-switch">
                <button class="role-btn active" id="tab-mahasiswa" type="button">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422A12.083 12.083 0 0 1 21 13c0 3.866-4.03 7-9 7S3 16.866 3 13a12.08 12.08 0 0 1 2.84-2.422L12 14z"/>
                    </svg>
                    MAHASISWA
                </button>
                <button class="role-btn" id="tab-dosen" type="button">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 4-7 8-7s8 3 8 7"/>
                    </svg>
                    DOSEN
                </button>
                <button class="role-btn" id="tab-admin" type="button">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    ADMIN
                </button>
            </div>

            @if(session('status'))
                <div style="background:#f0fff0;border:1px solid #c7ecc7;padding:12px;margin-bottom:12px;color:#0a7a0a;">
                    Instruksi reset password telah dikirim ke email Anda. Cek inbox atau folder spam.
                </div>
            @endif
            @if($errors->any())
                <div style="background:#fee2e2;color:#b91c1c;padding:10px;margin-bottom:12px;">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Step 1: Input --}}
            <div id="step1">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label id="label-identifier">EMAIL AKUN</label>
                        <div class="input-icon-group">
                            <span class="input-icon">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 4-7 8-7s8 3 8 7"/>
                                </svg>
                            </span>
                            <input type="email" name="email" id="emailInput" class="login-input" placeholder="email@ums.ac.id" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="lp-info-box">
                        <span id="infoText">Masukkan email yang terdaftar di sistem. Link reset akan dikirim ke email tersebut.</span>
                    </div>

                    <button type="submit" class="login-btn">
                        KIRIM INSTRUKSI RESET
                    </button>
                </form>
            </div>

            {{-- Step 2: Sukses --}}
            <div id="step2" style="display:none;">
                <div class="lp-success-box">
                    <div class="lp-success-icon">
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#15803d" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <div class="lp-success-title">EMAIL TERKIRIM!</div>
                    <p class="lp-success-desc">Instruksi reset password telah dikirim. Silakan cek inbox atau folder spam.</p>
                    <div class="lp-success-email" id="successEmail">l200***@student.ums.ac.id</div>
                </div>

                <button type="button" class="login-btn" onclick="showStep1()">
                    KIRIM ULANG
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </div>

            <hr class="login-divider">

            <div class="login-footer-alt">
                <span>Sudah ingat password?</span>
                <a href="/login" class="alt-btn-contact">KEMBALI KE LOGIN</a>
            </div>
        </div>
    </div>

    <footer class="login-footer-copyright">
        © 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
    </footer>
</div>

<script>
const roleConfig = {
    mahasiswa: {
        eyebrow: 'Portal Mahasiswa',
        title: 'LUPA<br><span class="highlight">PASSWORD</span><br>ANDA?',
        desc: 'Tenang, kami akan membantu Anda mengatur ulang password akun akademik Anda dengan aman.',
        rolePill: 'Portal Mahasiswa',
        fieldLabel: 'NIM / EMAIL STUDENT',
        placeholder: 'L200234258',
        infoText: 'Masukkan NIM atau email student (@student.ums.ac.id) yang terdaftar di sistem.',
    },
    dosen: {
        eyebrow: 'Portal Dosen',
        title: 'LUPA<br><span class="highlight">PASSWORD</span><br>ANDA?',
        desc: 'Kami akan membantu memulihkan akses akun dosen Anda ke sistem akademik.',
        rolePill: 'Portal Dosen',
        fieldLabel: 'NIDN / EMAIL INSTITUSI',
        placeholder: '0627018801',
        infoText: 'Masukkan NIDN atau email institusi (@ums.ac.id) yang terdaftar di sistem.',
    },
    admin: {
        eyebrow: 'Portal Admin',
        title: 'LUPA<br><span class="highlight">PASSWORD</span><br>ANDA?',
        desc: 'Hubungi tim IT jika Anda memerlukan bantuan pemulihan akun admin.',
        rolePill: 'Portal Admin',
        fieldLabel: 'NIP / USERNAME',
        placeholder: 'Masukkan ID Pegawai',
        infoText: 'Masukkan NIP atau username admin. Jika masalah berlanjut, hubungi Tim IT.',
    }
};

function applyRole(role) {
    const c = roleConfig[role];
    document.getElementById('login-main').dataset.role = role;
    document.getElementById('brand-eyebrow').textContent = c.eyebrow;
    document.getElementById('brand-title').innerHTML = c.title;
    document.getElementById('brand-desc').textContent = c.desc;
    document.getElementById('role-pill').textContent = c.rolePill;
    document.getElementById('label-identifier').textContent = c.fieldLabel;
    document.getElementById('emailInput').placeholder = c.placeholder;
    document.getElementById('infoText').textContent = c.infoText;
}

document.querySelectorAll('.role-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        applyRole(this.id.replace('tab-', ''));
    });
});

function showStep2() {
    const val = document.getElementById('emailInput').value.trim();
    if (!val) { alert('Silakan isi field terlebih dahulu.'); return; }
    document.getElementById('step1').style.display = 'none';
    document.getElementById('step2').style.display = 'block';
}

function showStep1() {
    document.getElementById('step1').style.display = 'block';
    document.getElementById('step2').style.display = 'none';
    document.getElementById('emailInput').value = '';
}

// Ambil role dari URL parameter
const urlParams = new URLSearchParams(window.location.search);
const initRole = urlParams.get('role') || 'mahasiswa';

// Aktifkan tab sesuai role
document.getElementById('tab-' + initRole).classList.add('active');
document.querySelectorAll('.role-btn:not(#tab-' + initRole + ')').forEach(b => b.classList.remove('active'));

applyRole(initRole);
</script>

@endsection