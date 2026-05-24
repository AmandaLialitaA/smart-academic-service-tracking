@extends('layouts.app')
@section('title', 'Dashboard Admin | STA-UMS')
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

    {{-- ===== HEADER ===== --}}
    <div class="da-header">
        <div>
            <h1 class="da-title">DASHBOARD ADMIN</h1>
            <p class="da-subtitle">Selamat datang kembali, Tim Administrasi Akademik UMS.</p>
        </div>
        <div class="da-header-actions">
            <button class="da-btn-outline">
                <i data-lucide="download" width="16" height="16"></i>
                Export Report
            </button>
            <button class="da-btn-primary">
                <i data-lucide="filter" width="16" height="16"></i>
                FILTER DATA
            </button>
        </div>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="da-stats-grid">
        {{-- Card 1: Total Pengajuan --}}
        <div class="da-stat-card da-stat-card--purple">
            <div class="da-stat-info">
                <div class="da-stat-label">TOTAL PENGAJUAN HARI INI</div>
                <div class="da-stat-number">124</div>
                <div class="da-stat-trend">
                    <i data-lucide="trending-up" width="14" height="14"></i>
                    +12% dari kemarin
                </div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="users" width="28" height="28"></i>
            </div>
        </div>
        {{-- Card 2: Menunggu Verifikasi --}}
        <div class="da-stat-card da-stat-card--cyan">
            <div class="da-stat-info">
                <div class="da-stat-label">MENUNGGU VERIFIKASI</div>
                <div class="da-stat-number">42</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="file-check" width="28" height="28"></i>
            </div>
        </div>
        {{-- Card 3: Menunggu TTD Dosen --}}
        <div class="da-stat-card da-stat-card--amber">
            <div class="da-stat-info">
                <div class="da-stat-label">MENUNGGU TTD DOSEN</div>
                <div class="da-stat-number">28</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="pen-line" width="28" height="28"></i>
            </div>
        </div>
        {{-- Card 4: Layanan Selesai --}}
        <div class="da-stat-card da-stat-card--white">
            <div class="da-stat-info">
                <div class="da-stat-label">LAYANAN SELESAI</div>
                <div class="da-stat-number">54</div>
            </div>
            <div class="da-stat-icon">
                <i data-lucide="check-circle" width="28" height="28"></i>
            </div>
        </div>
    </div>

    {{-- ===== ROW 2: Chart + Pengajuan Terbaru ===== --}}
    <div class="da-row-2">
        {{-- Chart Volume Layanan --}}
        <div class="da-chart-panel">
            <div class="da-panel-header">
                <div>
                    <div class="da-panel-title">VOLUME LAYANAN HARIAN</div>
                    <div class="da-panel-subtitle">Statistik pengajuan masuk dalam 7 hari terakhir</div>
                </div>
                <button class="da-btn-outline da-btn-sm">7 HARI TERAKHIR</button>
            </div>
            {{-- Chart pakai Canvas --}}
            <div class="da-chart-area">
                <canvas id="volumeChart" height="180"></canvas>
            </div>
        </div>

        {{-- Pengajuan Terbaru --}}
        <div class="da-recent-panel">
            <div class="da-panel-header">
                <div class="da-panel-title">PENGAJUAN TERBARU</div>
                <button class="da-icon-btn">
                    <i data-lucide="more-vertical" width="18" height="18"></i>
                </button>
            </div>
            <p class="da-panel-subtitle" style="margin-bottom:16px;">Log aktifitas sistem hari ini</p>

            <div class="da-recent-list">
                <div class="da-recent-item">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="da-recent-avatar" alt="">
                    <div class="da-recent-info">
                        <div class="da-recent-name">AHMAD FAUZAN</div>
                        <div class="da-recent-meta">L200210123 • Legalitas Ijazah</div>
                    </div>
                    <div class="da-recent-right">
                        <span class="da-mini-badge da-mini-badge--submitted">Submitted</span>
                        <div class="da-recent-time">10 MENIT LALU</div>
                    </div>
                </div>
                <div class="da-recent-item">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="da-recent-avatar" alt="">
                    <div class="da-recent-info">
                        <div class="da-recent-name">SITI AMINAH</div>
                        <div class="da-recent-meta">B100220045 • Surat Keterangan Aktif</div>
                    </div>
                    <div class="da-recent-right">
                        <span class="da-mini-badge da-mini-badge--waiting">Waiting</span>
                        <div class="da-recent-time">25 MENIT LALU</div>
                    </div>
                </div>
                <div class="da-recent-item">
                    <img src="https://randomuser.me/api/portraits/men/55.jpg" class="da-recent-avatar" alt="">
                    <div class="da-recent-info">
                        <div class="da-recent-name">BUDI SANTOSO</div>
                        <div class="da-recent-meta">D400190089 • Transkrip Nilai</div>
                    </div>
                    <div class="da-recent-right">
                        <span class="da-mini-badge da-mini-badge--completed">Completed</span>
                        <div class="da-recent-time">1 JAM LALU</div>
                    </div>
                </div>
                <div class="da-recent-item">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" class="da-recent-avatar" alt="">
                    <div class="da-recent-info">
                        <div class="da-recent-name">RINA WIJAYA</div>
                        <div class="da-recent-meta">A210210067 • Cuti Akademik</div>
                    </div>
                    <div class="da-recent-right">
                        <span class="da-mini-badge da-mini-badge--waiting">Waiting</span>
                        <div class="da-recent-time">2 JAM LALU</div>
                    </div>
                </div>
                <div class="da-recent-item">
                    <img src="https://randomuser.me/api/portraits/men/77.jpg" class="da-recent-avatar" alt="">
                    <div class="da-recent-info">
                        <div class="da-recent-name">ANDI PRATAMA</div>
                        <div class="da-recent-meta">L200210555 • Legalitas Ijazah</div>
                    </div>
                    <div class="da-recent-right">
                        <span class="da-mini-badge da-mini-badge--rejected">Rejected</span>
                        <div class="da-recent-time">3 JAM LALU</div>
                    </div>
                </div>
                <div class="da-recent-item">
                    <img src="https://randomuser.me/api/portraits/women/90.jpg" class="da-recent-avatar" alt="">
                    <div class="da-recent-info">
                        <div class="da-recent-name">LARASATI PUTRI</div>
                        <div class="da-recent-meta">K100220332 • Surat Keterangan Aktif</div>
                    </div>
                    <div class="da-recent-right">
                        <span class="da-mini-badge da-mini-badge--completed">Completed</span>
                        <div class="da-recent-time">4 JAM LALU</div>
                    </div>
                </div>
            </div>

            <a href="/admin/semua-pengajuan" class="da-btn-full">Lihat Semua Pengajuan</a>
        </div>
    </div>

    {{-- ===== ROW 3: Workload + Mendesak ===== --}}
    <div class="da-row-3">
        {{-- Workload Distribution --}}
        <div class="da-workload-panel">
            <div class="da-panel-title" style="margin-bottom:20px;">WORKLOAD DISTRIBUTION</div>
            <div class="da-donut-wrap">
                <canvas id="donutChart" width="180" height="180"></canvas>
                <div class="da-donut-legend">
                    <div class="da-legend-item">
                        <span class="da-legend-dot" style="background:#a259e6;"></span>
                        Mahasiswa
                    </div>
                    <div class="da-legend-item">
                        <span class="da-legend-dot" style="background:#00c9a7;"></span>
                        Dosen
                    </div>
                    <div class="da-legend-item">
                        <span class="da-legend-dot" style="background:#f59e0b;"></span>
                        Admin BAA
                    </div>
                </div>
            </div>
        </div>

        {{-- Mendesak --}}
        <div class="da-urgent-panel">
            <div class="da-panel-title" style="margin-bottom:20px;">MENDESAK</div>
            <div class="da-urgent-item da-urgent-item--red">
                <i data-lucide="alert-circle" width="20" height="20"></i>
                <div>
                    <div class="da-urgent-title">15 DOKUMEN OVERDUE</div>
                    <div class="da-urgent-desc">Pengajuan dari Mahasiswa Fakultas Teknik melewati batas verifikasi 24 jam.</div>
                </div>
            </div>
            <div class="da-urgent-item da-urgent-item--gray">
                <i data-lucide="clock" width="20" height="20"></i>
                <div>
                    <div class="da-urgent-title">SISTEM SINKRONISASI</div>
                    <div class="da-urgent-desc">Data SIAKAD akan disinkronisasi dalam 2 jam ke depan.</div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Init Lucide
lucide.createIcons();

// Volume Chart
const volumeCtx = document.getElementById('volumeChart').getContext('2d');
new Chart(volumeCtx, {
    type: 'bar',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [
            {
                label: 'Pengajuan',
                data: [45, 48, 52, 75, 68, 30, 20],
                backgroundColor: 'rgba(162, 89, 230, 0.5)',
                borderColor: '#a259e6',
                borderWidth: 2,
            },
            {
                label: 'Selesai',
                data: [40, 44, 50, 62, 55, 25, 18],
                backgroundColor: 'rgba(0, 201, 167, 0.4)',
                borderColor: '#00c9a7',
                borderWidth: 2,
                type: 'line',
                tension: 0.3,
                fill: false,
                pointBackgroundColor: '#00c9a7',
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
            x: { grid: { display: false } }
        }
    }
});

// Donut Chart
const donutCtx = document.getElementById('donutChart').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Mahasiswa', 'Dosen', 'Admin BAA'],
        datasets: [{
            data: [60, 25, 15],
            backgroundColor: ['#a259e6', '#00c9a7', '#f59e0b'],
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        cutout: '70%',
        plugins: { legend: { display: false } },
        responsive: false,
    }
});
</script>
@endsection