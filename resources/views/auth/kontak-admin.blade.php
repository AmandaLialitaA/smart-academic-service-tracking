@extends('layouts.auth')
@section('title', 'Hubungi Admin IT - Smart Academic UMS')
@section('head')
    @vite(['resources/css/login.css'])
@endsection
@section('content')

<div class="login-main" id="login-main" data-role="mahasiswa">
    <div class="login-container">

        {{-- KIRI --}}
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
                <p class="brand-eyebrow">Portal Akademik</p>
                <h1 class="brand-title">
                    BUTUH<br>
                    <span class="highlight">BANTUAN</span><br>
                    DARI KAMI?
                </h1>
                <p class="brand-desc">
                    Tim Admin IT UMS siap membantu Anda mendaftarkan akun dan mengakses layanan akademik.
                </p>
            </div>
            <div class="brand-features-bottom">
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div class="feature-text">
                        <span class="feature-value">08.00</span>
                        <span class="feature-label">BUKA LAYANAN</span>
                    </div>
                </div>
                <div class="feature-with-bar">
                    <div class="vertical-bar"></div>
                    <div class="feature-text">
                        <span class="feature-value">15.00</span>
                        <span class="feature-label">TUTUP LAYANAN</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN --}}
        <div class="login-right">
            <div class="role-pill">Hubungi Admin IT</div>
            <h2 class="login-title">HUBUNGI ADMIN IT</h2>
            <p class="login-subtitle">Belum punya akun? Silakan mengunjungi ruang TU FKI UMS untuk mendaftarkan akun Anda ke sistem.</p>

            {{-- Kontak Cards --}}
            <div class="kontak-grid">

                <div class="kontak-card">
                    <div class="kontak-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.37 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.37a16 16 0 0 0 6.72 6.72l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <div class="kontak-info">
                        <div class="kontak-label">TELEPON</div>
                        <div class="kontak-val">(0271) 717417</div>
                        <div class="kontak-sub">Senin - Jumat, 08.00 - 15.00 WIB</div>
                    </div>
                </div>

                <div class="kontak-card">
                    <div class="kontak-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <div class="kontak-info">
                        <div class="kontak-label">EMAIL</div>
                        <div class="kontak-val">it@ums.ac.id</div>
                        <div class="kontak-sub">Respon dalam 1x24 jam kerja</div>
                    </div>
                </div>

                <div class="kontak-card">
                    <div class="kontak-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div class="kontak-info">
                        <div class="kontak-label">LOKASI</div>
                        <div class="kontak-val">Gedung J, Kampus 2</div>
                        <div class="kontak-sub">Universitas Muhammadiyah Surakarta</div>
                    </div>
                </div>

                <div class="kontak-card">
                    <div class="kontak-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="kontak-info">
                        <div class="kontak-label">WHATSAPP</div>
                        <div class="kontak-val">+62 812-3456-7890</div>
                        <div class="kontak-sub">Chat langsung dengan tim IT</div>
                    </div>
                </div>

            </div>

            {{-- Info Box --}}
            <div class="lp-info-box" style="margin-top:16px;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>Siapkan KTM/KTP dan surat keterangan dari fakultas saat mengunjungi Admin IT untuk proses pendaftaran akun.</span>
            </div>

            <hr class="login-divider">

            <div class="login-footer-alt">
                <span>Sudah punya akun?</span>
                <a href="/login" class="alt-btn-contact">KEMBALI</a>
            </div>
        </div>
    </div>

    <footer class="login-footer-copyright">
        © 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
    </footer>
</div>

<script>
const urlParams = new URLSearchParams(window.location.search);
const role = urlParams.get('role') || 'mahasiswa';

const roleInfo = {
    mahasiswa: {
        pill: 'Portal Mahasiswa',
        subtitle: 'Belum punya akun mahasiswa? Hubungi tim Admin IT UMS untuk mendaftarkan akun Anda.',
        info: 'Siapkan KTM dan surat keterangan dari fakultas saat mengunjungi Admin IT.'
    }
};

const r = roleInfo[role] || roleInfo.mahasiswa;
document.querySelector('.role-pill').textContent = r.pill;
document.querySelector('.login-subtitle').textContent = r.subtitle;
document.querySelector('.lp-info-box span').textContent = r.info;
</script>

@endsection