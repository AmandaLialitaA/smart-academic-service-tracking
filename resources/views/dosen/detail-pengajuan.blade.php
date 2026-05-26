@extends('layouts.app')
@section('title', 'Detail Pengajuan Dosen')
@section('head')
    @vite(['resources/css/detail-pengajuan-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('topbar_name', 'lecturer')
@section('topbar_role', 'UMS Academic')
@section('content')
<div class="detail-wrap">

    <div class="detail-body">

        {{-- Kolom Kiri --}}
        <div class="detail-left">

            {{-- Profil Mahasiswa --}}
            <div class="detail-card">
                <div class="detail-card-title">PROFIL MAHASISWA</div>
                <div class="mhs-profile">
                    <img src="https://i.pravatar.cc/80?img=3" class="mhs-profile-avatar" alt="">
                    <div class="mhs-profile-name">FELIX ARLO</div>
                    <div class="mhs-profile-nim">L200210123</div>
                </div>
                <div class="mhs-detail-item">
                    <div class="mhs-detail-label">
                        <i data-lucide="book-open" style="width:14px;height:14px;"></i>
                        PROGRAM STUDI
                    </div>
                    <div class="mhs-detail-val">Informatika (S1)</div>
                </div>
                <div class="mhs-detail-item">
                    <div class="mhs-detail-label">
                        <i data-lucide="calendar" style="width:14px;height:14px;"></i>
                        SEMESTER
                    </div>
                    <div class="mhs-detail-val">5 (Ganjil)</div>
                </div>
            </div>

            {{-- Detail Layanan --}}
            <div class="detail-card">
                <div class="detail-card-title">DETAIL LAYANAN</div>
                <div class="layanan-detail-item">
                    <div class="layanan-detail-label">JENIS LAYANAN</div>
                    <div class="layanan-detail-val">Surat Keterangan Aktif Kuliah</div>
                </div>
                <div class="layanan-detail-item">
                    <div class="layanan-detail-label">TANGGAL PENGAJUAN</div>
                    <div class="layanan-detail-val">20 Okt 2023, 14:30 WIB</div>
                </div>
                <div class="layanan-note">
                    "Saya memerlukan surat ini sebagai syarat administrasi pengajuan beasiswa Bank Indonesia tahun 2023."
                </div>
                <div class="layanan-status-badge">MENUNGGU TTD DOSEN</div>
                <div class="layanan-verified">
                    <i data-lucide="info" style="width:15px;height:15px;color:#555;flex-shrink:0;"></i>
                    <span>Sistem telah memverifikasi data akademik mahasiswa ini secara otomatis. Dokumen siap untuk ditandatangani.</span>
                </div>
            </div>

        </div>

        {{-- Kolom Kanan --}}
        <div class="detail-right">

            {{-- Toolbar PDF --}}
            <div class="pdf-toolbar">
                <div class="pdf-zoom">
                    <button class="pdf-btn"><i data-lucide="zoom-out" style="width:15px;height:15px;"></i></button>
                    <span class="pdf-zoom-val">100%</span>
                    <button class="pdf-btn"><i data-lucide="zoom-in" style="width:15px;height:15px;"></i></button>
                </div>
                <button class="pdf-btn-download">
                    <i data-lucide="download" style="width:14px;height:14px;"></i>
                    UNDUH PDF
                </button>
                <span class="pdf-filename">SURAT_AKTIF_FELIX.PDF</span>
                <button class="pdf-btn"><i data-lucide="maximize-2" style="width:15px;height:15px;"></i></button>
            </div>

            {{-- Preview Surat --}}
            <div class="pdf-preview">
                <div class="surat-wrap">
                    <div class="surat-header">
                        <div class="surat-logo">
                            <div class="surat-logo-box">UMS</div>
                            <div class="surat-univ">
                                <div class="surat-univ-name">UNIVERSITAS MUHAMMADIYAH SURAKARTA</div>
                                <div class="surat-univ-sub">BIRO ADMINISTRASI AKADEMIK (BAA)</div>
                            </div>
                        </div>
                        <div class="surat-nomor">No: 452/A.3-III/B AA/IX/2023</div>
                    </div>
                    <hr class="surat-divider">
                    <div class="surat-judul">SURAT KETERANGAN AKTIF KULIAH</div>
                    <p class="surat-pembuka">Yang bertanda tangan di bawah ini, Wakil Dekan Bidang Akademik Universitas Muhammadiyah Surakarta, menerangkan bahwa:</p>
                    <table class="surat-table">
                        <tr><td>NAMA</td><td>: FELIX ARLO</td></tr>
                        <tr><td>NIM</td><td>: L200210123</td></tr>
                        <tr><td>FAKULTAS</td><td>: Komunikasi dan Informatika</td></tr>
                        <tr><td>SEMESTER</td><td>: 5 (Ganjil) 2023/2024</td></tr>
                    </table>
                    <p class="surat-isi">Adalah benar-benar mahasiswa aktif pada program studi Informatika Universitas Muhammadiyah Surakarta untuk tahun akademik yang sedang berjalan.</p>
                    <p class="surat-isi">Demikian surat keterangan ini diberikan kepada yang bersangkutan untuk dapat dipergunakan sebagaimana mestinya, khususnya untuk keperluan <strong>Pengajuan Beasiswa Eksternal</strong>.</p>
                    <div class="surat-kota">Surakarta, 24 Oktober 2023</div>
                    <div class="surat-ttd-area">
                        <div class="surat-ttd-placeholder">Tanda Tangan Digital Disini</div>
                        <div class="surat-ttd-line">--------------------------------</div>
                        <div class="surat-ttd-nama">DR. ENG. MUHAMMAD KUSBAN</div>
                        <div class="surat-ttd-nidn">NIDN. 0623057102</div>
                    </div>
                </div>
            </div>

            {{-- Komentar & Aksi --}}
            <div class="detail-action-box">
                <div class="komentar-label">KOMENTAR / CATATAN PENINJAU</div>
                <div class="komentar-row">
                    <textarea class="komentar-input" placeholder="Berikan catatan jika diperlukan (misal: alasan penolakan...)"></textarea>
                    <div class="aksi-buttons">
                        <button class="btn-tolak">
                            <i data-lucide="x-circle" style="width:15px;height:15px;color:#e11d48;"></i>
                            Tolak
                        </button>
                        <button class="btn-approve">
                            <i data-lucide="file-check" style="width:15px;height:15px;"></i>
                            APPROVE & TTD
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>
@endsection