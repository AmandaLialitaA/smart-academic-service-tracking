@extends('layouts.auth')
@section('title', 'Login - Smart Academic UMS')
@section('head')
    @vite(['resources/css/login.css'])
@endsection

@section('content')
@include('components.icons')

<div class="login-main" id="login-main" data-role="{{ $role ?? 'mahasiswa' }}">
    <div class="login-container">

        {{-- ===== KIRI: Branding ===== --}}
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
                    EFISIENSI<br>
                    <span class="highlight">AKADEMIK</span><br>
                    DI TANGAN<br>
                    ANDA.
                </h1>

                <p class="brand-desc" id="brand-desc">
                    Sistem pelacakan layanan administrasi terpadu
                    Universitas Muhammadiyah Surakarta yang
                    modern, transparan, dan akuntabel.
                </p>
            </div>

            <div class="brand-features-bottom">
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div class="feature-text">
                        <span class="feature-value" id="feature-value-1">100%</span>
                        <span class="feature-label" id="feature-label-1">Digital Workflow</span>
                    </div>
                </div>
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div class="feature-text">
                        <span class="feature-value" id="feature-value-2">REALTIME</span>
                        <span class="feature-label" id="feature-label-2">Status Tracking</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== KANAN: Form ===== --}}
        <div class="login-right">
            <div class="role-pill" id="role-pill">Portal Mahasiswa</div>
            <h2 class="login-title">SELAMAT DATANG</h2>
            <p class="login-subtitle" id="login-subtitle">Silakan masuk untuk mengakses layanan akademik Anda.</p>
            <p class="login-role-note" id="login-role-note">Akses portal mahasiswa untuk mengajukan, melacak, dan menyelesaikan layanan akademik Anda.</p>

            {{-- Role tabs --}}
            <div class="login-role-switch">
                <button class="role-btn" id="tab-mahasiswa" type="button">
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

            {{-- Form --}}
            <form action="/login/mahasiswa" method="POST" class="login-form-fields" id="login-form">
                @csrf

                @if ($errors->any())
                    <div class="login-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="identifier" id="label-identifier">NIM / EMAIL STUDENT</label>
                    <div class="input-icon-group">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 20c0-4 4-7 8-7s8 3 8 7"/>
                            </svg>
                        </span>
                        <input type="text" id="identifier" name="email"
                               required placeholder="budi@student.ums.ac.id"
                               value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon-group">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input type="password" id="password" name="password"
                               required placeholder="••••••••">
                        <span class="input-icon input-icon-right" onclick="togglePassword()">
                            <svg id="eyeIcon" width="20" height="20" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    MASUK KE SISTEM
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </form>

            <hr class="login-divider">

            <div class="login-footer-alt" id="footer-alt">
                <span id="footer-alt-text">Belum punya akun?</span>
                <button class="alt-btn-contact" id="btn-kontak"
                        onclick="window.location='/kontak-admin'">
                    HUBUNGI ADMIN IT
                </button>
            </div>
        </div>
    </div>

    <footer class="login-footer-copyright">
        © 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
    </footer>
</div>

<style>
.login-error {
    background: #fee2e2;
    border: 2px solid #ef4444;
    color: #991b1b;
    padding: 10px 14px;
    font-weight: 700;
    font-size: 0.9rem;
    margin-bottom: 16px;
}
</style>

<script>
// ─── Toggle show/hide password ────────────────────────────────
function togglePassword() {
    const pwd = document.getElementById('password');
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
}

// ─── Konfigurasi per role ─────────────────────────────────────
const formActions = {
    mahasiswa: '/login/mahasiswa',
    dosen:     '/login/dosen',
    admin:     '/login/admin',
};

const tabConfig = {
    mahasiswa: {
        label:       'NIM / EMAIL STUDENT',
        placeholder: 'budi@student.ums.ac.id',
    },
    dosen: {
        label:       'NIDN / EMAIL INSTITUSI',
        placeholder: 'ahmad.yani@ums.ac.id',
    },
    admin: {
        label:       'NIP / EMAIL ADMIN',
        placeholder: 'admin@ums.ac.id',
    },
};

const roleConfig = {
    mahasiswa: {
        eyebrow:  'Portal Mahasiswa',
        title:    'EFISIENSI<br><span class="highlight">AKADEMIK</span><br>DI TANGAN<br>ANDA.',
        desc:     'Sistem pelacakan layanan administrasi terpadu Universitas Muhammadiyah Surakarta yang modern, transparan, dan akuntabel.',
        value1:   '100%',    label1: 'Digital Workflow',
        value2:   'REALTIME', label2: 'Status Tracking',
        rolePill: 'Portal Mahasiswa',
        subtitle: 'Silakan masuk untuk mengakses layanan akademik Anda.',
        roleNote: 'Akses portal mahasiswa untuk mengajukan, melacak, dan menyelesaikan layanan akademik Anda.',
        footerText: 'Belum punya akun?',
        kontakLabel: 'HUBUNGI ADMIN IT',
    },
    dosen: {
        eyebrow:  'Portal Dosen',
        title:    'VERIFIKASI<br><span class="highlight">AKADEMIK</span><br>LEBIH CEPAT<br>DAN TEPAT.',
        desc:     'Pantau pengajuan mahasiswa, tinjau dokumen, dan proses keputusan akademik dengan antarmuka yang lebih terarah untuk dosen.',
        value1:   '24/7',  label1: 'Review Terkelola',
        value2:   '90%',   label2: 'Pengajuan Terverifikasi',
        rolePill: 'Portal Dosen',
        subtitle: 'Silakan masuk untuk memverifikasi dan menindaklanjuti layanan akademik mahasiswa.',
        roleNote: 'Tampilan dosen dirancang untuk mempercepat peninjauan proses layanan dan komunikasi akademik.',
        footerText: 'Kendala akses?',
        kontakLabel: 'HUBUNGI ADMIN IT',
    },
    admin: {
        eyebrow:  'Portal Admin',
        title:    'KONTROL<br><span class="highlight">LAYANAN</span><br>AKADEMIK<br>TERPUSAT.',
        desc:     'Kelola keseluruhan alur layanan akademik, menjaga akurasi data, dan mengawasi proses administrasi secara terpusat.',
        value1:   '100%',    label1: 'Kontrol Operasional',
        value2:   'REALTIME', label2: 'Monitoring Sistem',
        rolePill: 'Portal Admin',
        subtitle: 'Silakan masuk untuk mengelola proses layanan akademik dan operasional kampus.',
        roleNote: 'Tampilan admin dibuat dengan fokus pada kontrol, auditing, dan kinerja operasional.',
        footerText: 'Kendala akses sistem?',
        kontakLabel: 'BANTUAN IT',
    },
};

// ─── Terapkan perubahan visual & fungsional saat ganti role ───
function applyRole(role) {
    const cfg = roleConfig[role];
    const tab = tabConfig[role];

    // 1. Ganti action form
    document.getElementById('login-form').action = formActions[role];

    // 2. data-role → CSS login.css otomatis ganti warna left panel & aksen
    document.getElementById('login-main').dataset.role = role;

    // 3. Konten panel kiri
    document.getElementById('brand-eyebrow').textContent   = cfg.eyebrow;
    document.getElementById('brand-title').innerHTML        = cfg.title;
    document.getElementById('brand-desc').textContent       = cfg.desc;
    document.getElementById('feature-value-1').textContent  = cfg.value1;
    document.getElementById('feature-label-1').textContent  = cfg.label1;
    document.getElementById('feature-value-2').textContent  = cfg.value2;
    document.getElementById('feature-label-2').textContent  = cfg.label2;

    // 4. Konten panel kanan
    document.getElementById('role-pill').textContent        = cfg.rolePill;
    document.getElementById('login-subtitle').textContent   = cfg.subtitle;
    document.getElementById('login-role-note').textContent  = cfg.roleNote;
    document.getElementById('label-identifier').textContent = tab.label;
    document.getElementById('identifier').placeholder       = tab.placeholder;

    // 5. Footer alt
    const footerAlt = document.getElementById('footer-alt');
    const footerTxt = document.getElementById('footer-alt-text');
    const btnKontak = document.getElementById('btn-kontak');
    if (footerTxt) footerTxt.textContent = cfg.footerText;
    if (btnKontak) btnKontak.textContent = cfg.kontakLabel;
    if (footerAlt) footerAlt.style.display = 'flex'; // selalu tampil

    // 6. Active tab styling
    document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
    const activeTab = document.getElementById('tab-' + role);
    if (activeTab) activeTab.classList.add('active');
}

// ─── Klik tab → ganti role (TIDAK redirect ke URL lain) ───────
document.querySelectorAll('.role-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const role = this.id.replace('tab-', ''); // 'mahasiswa' / 'dosen' / 'admin'
        applyRole(role);
    });
});

// ─── Inisialisasi: baca role dari server (dikirim via $role) ──
// Jika dibuka via /login/dosen, controller set $role = 'dosen', dst.
(function init() {
    const serverRole = document.getElementById('login-main').dataset.role || 'mahasiswa';
    applyRole(serverRole);
})();
</script>
@endsection