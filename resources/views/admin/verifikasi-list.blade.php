@extends('layouts.app')
@section('title', 'Antrian Verifikasi | STA-UMS')
@section('topbar_name', 'admin')
@section('topbar_role', 'UMS Academic')

@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="da-wrap">

    {{-- HEADER --}}
    <div class="da-header">
        <div>
            <h1 class="da-title">ANTRIAN VERIFIKASI</h1>
            <p class="da-subtitle">Dokumen yang menunggu verifikasi dari Admin BAA.</p>
        </div>
        <div class="da-header-actions">
            <button class="da-btn-outline">
                <i data-lucide="refresh-cw" width="16" height="16"></i>
                Refresh
            </button>
            <button class="da-btn-primary">
                <i data-lucide="filter" width="16" height="16"></i>
                Filter
            </button>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="da-stats-grid">
        <div class="da-stat-card da-stat-card--purple">
            <div class="da-stat-info">
                <div class="da-stat-label">TOTAL ANTRIAN</div>
                <div class="da-stat-number">42</div>
                <div class="da-stat-trend">
                    <i data-lucide="trending-up" width="14" height="14"></i>
                    +5 dari kemarin
                </div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="clipboard-list" width="28" height="28"></i>
            </div>
        </div>
        <div class="da-stat-card da-stat-card--amber">
            <div class="da-stat-info">
                <div class="da-stat-label">URGENT</div>
                <div class="da-stat-number">8</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="alert-circle" width="28" height="28"></i>
            </div>
        </div>
        <div class="da-stat-card da-stat-card--cyan">
            <div class="da-stat-info">
                <div class="da-stat-label">DIPROSES HARI INI</div>
                <div class="da-stat-number">15</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="check-circle" width="28" height="28"></i>
            </div>
        </div>
        <div class="da-stat-card da-stat-card--white">
            <div class="da-stat-info">
                <div class="da-stat-label">RATA-RATA WAKTU</div>
                <div class="da-stat-number">2.3<span style="font-size:1rem;font-weight:600;">jam</span></div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="clock" width="28" height="28"></i>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="sp-filter-bar">
        <div class="sp-search-wrap">
            <i data-lucide="search" width="16" height="16" class="sp-search-icon"></i>
            <input type="text" class="sp-search" placeholder="Cari nama, NIM, atau ID pengajuan...">
        </div>
        <div class="sp-filters">
            <select class="sp-select">
                <option value="">Semua Layanan</option>
                <option>Surat Keterangan Aktif Kuliah</option>
                <option>Transkrip Nilai Sementara</option>
                <option>Pengajuan Cuti Akademik</option>
                <option>Legalisir Ijazah Elektronik</option>
                <option>Surat Pengantar Magang</option>
            </select>
            <select class="sp-select">
                <option value="">Semua Prioritas</option>
                <option>Urgent</option>
                <option>Normal</option>
            </select>
            <input type="date" class="sp-select sp-date">
        </div>
    </div>

    {{-- TABLE --}}
    <div class="sp-table-wrap">
        <table class="sp-table">
            <thead>
                <tr>
                    <th>ID PENGAJUAN</th>
                    <th>MAHASISWA</th>
                    <th>JENIS LAYANAN</th>
                    <th>TANGGAL MASUK</th>
                    <th>PRIORITAS</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="sp-id">REQ-UMS-2023-9941</td>
                    <td>
                        <div class="sp-mhs">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="sp-avatar" alt="">
                            <div>
                                <div class="sp-mhs-name">Ahmad Fauzi</div>
                                <div class="sp-mhs-nim">L200210156</div>
                            </div>
                        </div>
                    </td>
                    <td>Surat Keterangan Aktif Kuliah</td>
                    <td>
                        <div>24 Okt 2023</div>
                        <div class="sp-time">09:12 WIB</div>
                    </td>
                    <td><span class="vl-badge vl-badge--urgent">URGENT</span></td>
                    <td><span class="sp-badge sp-badge--submitted">Submitted</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi/detail" class="sp-btn-detail">
                                <i data-lucide="shield-check" width="14" height="14"></i>
                                Verifikasi
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sp-id">REQ-UMS-2023-9942</td>
                    <td>
                        <div class="sp-mhs">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="sp-avatar" alt="">
                            <div>
                                <div class="sp-mhs-name">Siti Aminah</div>
                                <div class="sp-mhs-nim">B100220045</div>
                            </div>
                        </div>
                    </td>
                    <td>Transkrip Nilai Sementara</td>
                    <td>
                        <div>24 Okt 2023</div>
                        <div class="sp-time">10:30 WIB</div>
                    </td>
                    <td><span class="vl-badge vl-badge--normal">NORMAL</span></td>
                    <td><span class="sp-badge sp-badge--submitted">Submitted</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi/detail" class="sp-btn-detail">
                                <i data-lucide="shield-check" width="14" height="14"></i>
                                Verifikasi
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sp-id">REQ-UMS-2023-9943</td>
                    <td>
                        <div class="sp-mhs">
                            <img src="https://randomuser.me/api/portraits/men/55.jpg" class="sp-avatar" alt="">
                            <div>
                                <div class="sp-mhs-name">Budi Santoso</div>
                                <div class="sp-mhs-nim">D400190089</div>
                            </div>
                        </div>
                    </td>
                    <td>Pengajuan Cuti Akademik</td>
                    <td>
                        <div>23 Okt 2023</div>
                        <div class="sp-time">14:20 WIB</div>
                    </td>
                    <td><span class="vl-badge vl-badge--urgent">URGENT</span></td>
                    <td><span class="sp-badge sp-badge--submitted">Submitted</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi/detail" class="sp-btn-detail">
                                <i data-lucide="shield-check" width="14" height="14"></i>
                                Verifikasi
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sp-id">REQ-UMS-2023-9944</td>
                    <td>
                        <div class="sp-mhs">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="sp-avatar" alt="">
                            <div>
                                <div class="sp-mhs-name">Rina Wijaya</div>
                                <div class="sp-mhs-nim">A210210067</div>
                            </div>
                        </div>
                    </td>
                    <td>Legalisir Ijazah Elektronik</td>
                    <td>
                        <div>23 Okt 2023</div>
                        <div class="sp-time">08:45 WIB</div>
                    </td>
                    <td><span class="vl-badge vl-badge--normal">NORMAL</span></td>
                    <td><span class="sp-badge sp-badge--submitted">Submitted</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi/detail" class="sp-btn-detail">
                                <i data-lucide="shield-check" width="14" height="14"></i>
                                Verifikasi
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sp-id">REQ-UMS-2023-9945</td>
                    <td>
                        <div class="sp-mhs">
                            <img src="https://randomuser.me/api/portraits/men/77.jpg" class="sp-avatar" alt="">
                            <div>
                                <div class="sp-mhs-name">Andi Pratama</div>
                                <div class="sp-mhs-nim">L200210555</div>
                            </div>
                        </div>
                    </td>
                    <td>Surat Pengantar Magang</td>
                    <td>
                        <div>22 Okt 2023</div>
                        <div class="sp-time">11:00 WIB</div>
                    </td>
                    <td><span class="vl-badge vl-badge--normal">NORMAL</span></td>
                    <td><span class="sp-badge sp-badge--submitted">Submitted</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi/detail" class="sp-btn-detail">
                                <i data-lucide="shield-check" width="14" height="14"></i>
                                Verifikasi
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="sp-pagination">
            <div class="sp-pagination-info">Menampilkan 1-5 dari 42 antrian</div>
            <div class="sp-pagination-btns">
                <button class="sp-page-btn" disabled>
                    <i data-lucide="chevron-left" width="14" height="14"></i>
                </button>
                <button class="sp-page-btn sp-page-btn--active">1</button>
                <button class="sp-page-btn">2</button>
                <button class="sp-page-btn">3</button>
                <span class="sp-page-ellipsis">...</span>
                <button class="sp-page-btn">9</button>
                <button class="sp-page-btn">
                    <i data-lucide="chevron-right" width="14" height="14"></i>
                </button>
            </div>
        </div>
    </div>

</div>

<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>

<script>lucide.createIcons();</script>
@endsection