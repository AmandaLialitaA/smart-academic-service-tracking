@extends('layouts.app')
@section('title', 'Semua Pengajuan | STA-UMS')
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
            <h1 class="da-title">SEMUA PENGAJUAN</h1>
            <p class="da-subtitle">Kelola seluruh pengajuan layanan akademik mahasiswa UMS.</p>
        </div>
        <div class="da-header-actions">
            <button class="da-btn-outline">
                <i data-lucide="download" width="16" height="16"></i>
                Export CSV
            </button>
            <button class="da-btn-primary">
                <i data-lucide="plus" width="16" height="16"></i>
                Tambah Manual
            </button>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="da-stats-grid">
        <div class="da-stat-card da-stat-card--purple">
            <div class="da-stat-info">
                <div class="da-stat-label">TOTAL PENGAJUAN</div>
                <div class="da-stat-number">348</div>
                <div class="da-stat-trend">
                    <i data-lucide="trending-up" width="14" height="14"></i>
                    +8% bulan ini
                </div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="clipboard-list" width="28" height="28"></i>
            </div>
        </div>
        <div class="da-stat-card da-stat-card--cyan">
            <div class="da-stat-info">
                <div class="da-stat-label">SUBMITTED</div>
                <div class="da-stat-number">42</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="send" width="28" height="28"></i>
            </div>
        </div>
        <div class="da-stat-card da-stat-card--amber">
            <div class="da-stat-info">
                <div class="da-stat-label">WAITING / ON PROCESS</div>
                <div class="da-stat-number">28</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="clock" width="28" height="28"></i>
            </div>
        </div>
        <div class="da-stat-card da-stat-card--white">
            <div class="da-stat-info">
                <div class="da-stat-label">COMPLETED</div>
                <div class="da-stat-number">278</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="check-circle" width="28" height="28"></i>
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
                <option value="">Semua Status</option>
                <option>Submitted</option>
                <option>Waiting</option>
                <option>Completed</option>
                <option>Rejected</option>
            </select>
            <select class="sp-select">
                <option value="">Semua Layanan</option>
                <option>Surat Keterangan Aktif Kuliah</option>
                <option>Transkrip Nilai Sementara</option>
                <option>Pengajuan Cuti Akademik</option>
                <option>Legalisir Ijazah Elektronik</option>
                <option>Surat Pengantar Magang</option>
            </select>
            <select class="sp-select">
                <option value="">Semua Fakultas</option>
                <option>Komunikasi & Informatika</option>
                <option>Teknik</option>
                <option>Ekonomi & Bisnis</option>
                <option>Hukum</option>
                <option>Kedokteran</option>
            </select>
            <input type="date" class="sp-select sp-date">
        </div>
    </div>

    {{-- TABLE --}}
    <div class="sp-table-wrap">
        <table class="sp-table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" class="sp-checkbox">
                    </th>
                    <th>ID PENGAJUAN</th>
                    <th>MAHASISWA</th>
                    <th>JENIS LAYANAN</th>
                    <th>TANGGAL</th>
                    <th>PENANGGUNG JAWAB</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" class="sp-checkbox"></td>
                    <td class="sp-id">REQ-2024-001</td>
                    <td>
                        <div class="sp-mhs">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="sp-avatar" alt="">
                            <div>
                                <div class="sp-mhs-name">Ahmad Fauzan</div>
                                <div class="sp-mhs-nim">L200210123</div>
                            </div>
                        </div>
                    </td>
                    <td>Surat Keterangan Aktif Kuliah</td>
                    <td>
                        <div>24 Mei 2024</div>
                        <div class="sp-time">10:30 WIB</div>
                    </td>
                    <td>Dr. Ir. Wahyudin, M.T.</td>
                    <td><span class="sp-badge sp-badge--completed">Completed</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi" class="sp-btn-detail">
                                <i data-lucide="eye" width="14" height="14"></i>
                                Detail
                            </a>
                            <button class="sp-btn-more">
                                <i data-lucide="more-vertical" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="sp-checkbox"></td>
                    <td class="sp-id">REQ-2024-005</td>
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
                        <div>26 Mei 2024</div>
                        <div class="sp-time">09:15 WIB</div>
                    </td>
                    <td>Prof. Dr. Anom Sutopo, M.Hum.</td>
                    <td><span class="sp-badge sp-badge--waiting">Waiting</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi" class="sp-btn-detail">
                                <i data-lucide="eye" width="14" height="14"></i>
                                Detail
                            </a>
                            <button class="sp-btn-more">
                                <i data-lucide="more-vertical" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="sp-checkbox"></td>
                    <td class="sp-id">REQ-2024-009</td>
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
                        <div>28 Mei 2024</div>
                        <div class="sp-time">08:45 WIB</div>
                    </td>
                    <td>Drs. Sujiwo, M.Kom.</td>
                    <td><span class="sp-badge sp-badge--submitted">Submitted</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi" class="sp-btn-detail">
                                <i data-lucide="eye" width="14" height="14"></i>
                                Detail
                            </a>
                            <button class="sp-btn-more">
                                <i data-lucide="more-vertical" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="sp-checkbox"></td>
                    <td class="sp-id">REQ-2024-012</td>
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
                        <div>29 Mei 2024</div>
                        <div class="sp-time">14:20 WIB</div>
                    </td>
                    <td>Staff BAA UMS</td>
                    <td><span class="sp-badge sp-badge--rejected">Rejected</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi" class="sp-btn-detail">
                                <i data-lucide="eye" width="14" height="14"></i>
                                Detail
                            </a>
                            <button class="sp-btn-more">
                                <i data-lucide="more-vertical" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="sp-checkbox"></td>
                    <td class="sp-id">REQ-2024-015</td>
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
                        <div>30 Mei 2024</div>
                        <div class="sp-time">11:00 WIB</div>
                    </td>
                    <td>Maryono, Ph.D.</td>
                    <td><span class="sp-badge sp-badge--waiting">Waiting</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi" class="sp-btn-detail">
                                <i data-lucide="eye" width="14" height="14"></i>
                                Detail
                            </a>
                            <button class="sp-btn-more">
                                <i data-lucide="more-vertical" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="sp-checkbox"></td>
                    <td class="sp-id">REQ-2024-018</td>
                    <td>
                        <div class="sp-mhs">
                            <img src="https://randomuser.me/api/portraits/women/90.jpg" class="sp-avatar" alt="">
                            <div>
                                <div class="sp-mhs-name">Larasati Putri</div>
                                <div class="sp-mhs-nim">K100220332</div>
                            </div>
                        </div>
                    </td>
                    <td>Surat Keterangan Aktif Kuliah</td>
                    <td>
                        <div>31 Mei 2024</div>
                        <div class="sp-time">13:45 WIB</div>
                    </td>
                    <td>Dr. Ir. Wahyudin, M.T.</td>
                    <td><span class="sp-badge sp-badge--completed">Completed</span></td>
                    <td>
                        <div class="sp-aksi">
                            <a href="/admin/verifikasi" class="sp-btn-detail">
                                <i data-lucide="eye" width="14" height="14"></i>
                                Detail
                            </a>
                            <button class="sp-btn-more">
                                <i data-lucide="more-vertical" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="sp-pagination">
            <div class="sp-pagination-info">Menampilkan 1-6 dari 348 pengajuan</div>
            <div class="sp-pagination-btns">
                <button class="sp-page-btn" disabled>
                    <i data-lucide="chevron-left" width="14" height="14"></i>
                </button>
                <button class="sp-page-btn sp-page-btn--active">1</button>
                <button class="sp-page-btn">2</button>
                <button class="sp-page-btn">3</button>
                <span class="sp-page-ellipsis">...</span>
                <button class="sp-page-btn">58</button>
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