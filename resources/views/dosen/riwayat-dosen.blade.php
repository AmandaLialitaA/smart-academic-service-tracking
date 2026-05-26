@extends('layouts.app')
@section('title', 'Riwayat | Dosen UMS')
@section('topbar_name', 'lecturer')
@section('topbar_role', 'UMS Academic')
@section('head')
    @vite(['resources/css/riwayat-dosen.css'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
@endsection

@section('sidebar')
    @include('components.sidebar-dosen')
@endsection

@section('content')
<div class="riwayat-dosen-wrap">

    {{-- ===== HEADER ===== --}}
    <div class="rd-header">
        <div>
            <h1 class="rd-title">RIWAYAT TTD</h1>
            <p class="rd-subtitle">Daftar pengajuan yang telah kamu tanda tangani atau tolak.</p>
        </div>
        <div class="rd-header-actions">
            <button class="rd-btn-outline">
                <i data-lucide="download" width="16" height="16"></i>
                Rekap Bulanan
            </button>
        </div>
    </div>

    {{-- ===== STATS SINGKAT ===== --}}
    <div class="rd-stats-row">
        <div class="rd-stat-card">
            <div class="rd-stat-icon rd-stat-icon--green">
                <i data-lucide="check-circle" width="22" height="22"></i>
            </div>
            <div>
                <div class="rd-stat-number">24</div>
                <div class="rd-stat-label">Disetujui Bulan Ini</div>
            </div>
        </div>
        <div class="rd-stat-card">
            <div class="rd-stat-icon rd-stat-icon--red">
                <i data-lucide="x-circle" width="22" height="22"></i>
            </div>
            <div>
                <div class="rd-stat-number">3</div>
                <div class="rd-stat-label">Ditolak Bulan Ini</div>
            </div>
        </div>
        <div class="rd-stat-card">
            <div class="rd-stat-icon rd-stat-icon--purple">
                <i data-lucide="users" width="22" height="22"></i>
            </div>
            <div>
                <div class="rd-stat-number">148</div>
                <div class="rd-stat-label">Total Mahasiswa Terlayani</div>
            </div>
        </div>
    </div>

    {{-- ===== FILTER ===== --}}
    <div class="rd-filter-bar">
        <div class="rd-search">
            <i data-lucide="search" width="18" height="18"></i>
            <input type="text" placeholder="Cari nama mahasiswa atau jenis layanan...">
        </div>
        <div class="rd-filter-group">
            <select class="rd-select">
                <option value="">Semua Status</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
            <select class="rd-select">
                <option value="">Semua Layanan</option>
                <option>Surat Keterangan Aktif</option>
                <option>Transkrip Nilai</option>
                <option>Legalisir Ijazah</option>
                <option>Cuti Akademik</option>
                <option>Surat Rekomendasi</option>
            </select>
            <select class="rd-select">
                <option value="">Semua Bulan</option>
                <option>Oktober 2026</option>
                <option>November 2026</option>
                <option>Desember 2026</option>
            </select>
        </div>
    </div>

    {{-- ===== TABEL ===== --}}
    <div class="rd-table-wrap">
        <table class="rd-table">
            <thead>
                <tr>
                    <th>MAHASISWA</th>
                    <th>JENIS LAYANAN</th>
                    <th>TANGGAL MASUK</th>
                    <th>TANGGAL SELESAI</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                {{-- Row 1 --}}
                <tr>
                    <td>
                        <div class="rd-student-cell">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                 alt="avatar" class="rd-student-avatar">
                            <div>
                                <div class="rd-student-name">Ahmad Dahlan</div>
                                <div class="rd-student-nim">L200210045</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="rd-service-cell">
                            <i data-lucide="file-text" width="16" height="16"></i>
                            Surat Keterangan Aktif Kuliah
                        </div>
                    </td>
                    <td class="rd-date">24 Okt 2026</td>
                    <td class="rd-date">24 Okt 2026, 16:30</td>
                    <td>
                        <span class="rd-badge rd-badge--approved">
                            <i data-lucide="check" width="13" height="13"></i>
                            Disetujui
                        </span>
                    </td>
                    <td>
                        <a href="/dosen/detail-pengajuan" class="rd-btn-review">
                            <i data-lucide="eye" width="14" height="14"></i>
                            Lihat
                        </a>
                    </td>
                </tr>
                {{-- Row 2 --}}
                <tr>
                    <td>
                        <div class="rd-student-cell">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                 alt="avatar" class="rd-student-avatar">
                            <div>
                                <div class="rd-student-name">Siti Walidah</div>
                                <div class="rd-student-nim">B100220112</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="rd-service-cell">
                            <i data-lucide="file-text" width="16" height="16"></i>
                            Transkrip Nilai Sementara
                        </div>
                    </td>
                    <td class="rd-date">24 Okt 2026</td>
                    <td class="rd-date">24 Okt 2026, 15:10</td>
                    <td>
                        <span class="rd-badge rd-badge--approved">
                            <i data-lucide="check" width="13" height="13"></i>
                            Disetujui
                        </span>
                    </td>
                    <td>
                        <a href="/dosen/detail-pengajuan" class="rd-btn-review">
                            <i data-lucide="eye" width="14" height="14"></i>
                            Lihat
                        </a>
                    </td>
                </tr>
                {{-- Row 3 --}}
                <tr>
                    <td>
                        <div class="rd-student-cell">
                            <img src="https://randomuser.me/api/portraits/men/55.jpg"
                                 alt="avatar" class="rd-student-avatar">
                            <div>
                                <div class="rd-student-name">Haidar Nashir</div>
                                <div class="rd-student-nim">J500210089</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="rd-service-cell">
                            <i data-lucide="file-text" width="16" height="16"></i>
                            Pengajuan Cuti Akademik
                        </div>
                    </td>
                    <td class="rd-date">23 Okt 2026</td>
                    <td class="rd-date">23 Okt 2026, 11:45</td>
                    <td>
                        <span class="rd-badge rd-badge--rejected">
                            <i data-lucide="x" width="13" height="13"></i>
                            Ditolak
                        </span>
                    </td>
                    <td>
                        <a href="/dosen/detail-pengajuan" class="rd-btn-review">
                            <i data-lucide="eye" width="14" height="14"></i>
                            Lihat
                        </a>
                    </td>
                </tr>
                {{-- Row 4 --}}
                <tr>
                    <td>
                        <div class="rd-student-cell">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg"
                                 alt="avatar" class="rd-student-avatar">
                            <div>
                                <div class="rd-student-name">Salma Salsabil</div>
                                <div class="rd-student-nim">A510210023</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="rd-service-cell">
                            <i data-lucide="file-text" width="16" height="16"></i>
                            Legalisir Ijazah
                        </div>
                    </td>
                    <td class="rd-date">23 Okt 2026</td>
                    <td class="rd-date">23 Okt 2026, 09:20</td>
                    <td>
                        <span class="rd-badge rd-badge--approved">
                            <i data-lucide="check" width="13" height="13"></i>
                            Disetujui
                        </span>
                    </td>
                    <td>
                        <a href="/dosen/detail-pengajuan" class="rd-btn-review">
                            <i data-lucide="eye" width="14" height="14"></i>
                            Lihat
                        </a>
                    </td>
                </tr>
                {{-- Row 5 --}}
                <tr>
                    <td>
                        <div class="rd-student-cell">
                            <img src="https://randomuser.me/api/portraits/men/77.jpg"
                                 alt="avatar" class="rd-student-avatar">
                            <div>
                                <div class="rd-student-name">Budi Utomo</div>
                                <div class="rd-student-nim">D400210056</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="rd-service-cell">
                            <i data-lucide="file-text" width="16" height="16"></i>
                            Surat Rekomendasi Beasiswa
                        </div>
                    </td>
                    <td class="rd-date">22 Okt 2026</td>
                    <td class="rd-date">22 Okt 2026, 14:05</td>
                    <td>
                        <span class="rd-badge rd-badge--approved">
                            <i data-lucide="check" width="13" height="13"></i>
                            Disetujui
                        </span>
                    </td>
                    <td>
                        <a href="/dosen/detail-pengajuan" class="rd-btn-review">
                            <i data-lucide="eye" width="14" height="14"></i>
                            Lihat
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===== PAGINATION ===== --}}
    <div class="rd-pagination">
        <button class="rd-page-btn">
            <i data-lucide="chevron-left" width="16" height="16"></i>
        </button>
        <button class="rd-page-btn rd-page-btn--active">1</button>
        <button class="rd-page-btn">2</button>
        <button class="rd-page-btn">3</button>
        <span class="rd-page-dots">...</span>
        <button class="rd-page-btn">12</button>
        <button class="rd-page-btn">
            <i data-lucide="chevron-right" width="16" height="16"></i>
        </button>
    </div>

</div>

<script>
    // Init Lucide icons
    lucide.createIcons();
</script>
@endsection