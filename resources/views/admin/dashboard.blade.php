@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection
@section('sidebar')
<div class="sidebar-header">Smart Academic UMS</div>
<nav class="sidebar-menu">
    <ul>
        <li class="active"><a href="/admin/dashboard">Dashboard</a></li>
        <li><a href="/admin/pengguna">Manajemen Pengguna</a></li>
        <li><a href="/admin/laporan">Laporan Sistem</a></li>
        <li><a href="/admin/pengaturan">Pengaturan Sistem</a></li>
    </ul>
</nav>
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>DASHBOARD ADMINISTRATOR</h1>
    <div class="user-info">
        <span>Administrator Sistem</span>
        <span>Biro Administrasi Akademik</span>
    </div>
</div>
@endsection
@section('content')
<div class="dashboard-main">
    <p>Monitor dan kelola sistem layanan akademik Universitas Muhammadiyah Surakarta.</p>

    <!-- System Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <div class="stat-number">2,847</div>
                <div class="stat-label">TOTAL MAHASISWA</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👨‍🏫</div>
            <div class="stat-content">
                <div class="stat-number">156</div>
                <div class="stat-label">DOSEN AKTIF</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📄</div>
            <div class="stat-content">
                <div class="stat-number">1,234</div>
                <div class="stat-label">PENGAJUAN BULAN INI</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚡</div>
            <div class="stat-content">
                <div class="stat-number">98.5%</div>
                <div class="stat-label">UPTIME SISTEM</div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="system-status">
        <h2>STATUS SISTEM</h2>
        <div class="status-indicators">
            <div class="status-item">
                <div class="status-light online"></div>
                <div class="status-text">
                    <div class="status-title">DATABASE</div>
                    <div class="status-desc">Online - Response: 45ms</div>
                </div>
            </div>
            <div class="status-item">
                <div class="status-light online"></div>
                <div class="status-text">
                    <div class="status-title">API SERVICES</div>
                    <div class="status-desc">Online - All endpoints healthy</div>
                </div>
            </div>
            <div class="status-item">
                <div class="status-light warning"></div>
                <div class="status-text">
                    <div class="status-title">STORAGE</div>
                    <div class="status-desc">Warning - 78% capacity used</div>
                </div>
            </div>
            <div class="status-item">
                <div class="status-light online"></div>
                <div class="status-text">
                    <div class="status-title">EMAIL SERVICE</div>
                    <div class="status-desc">Online - Queue: 12 messages</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="recent-activities">
        <h2>AKTIVITAS SISTEM TERBARU</h2>
        <div class="activity-feed">
            <div class="activity-item">
                <div class="activity-time">14:30</div>
                <div class="activity-content">
                    <div class="activity-title">Pengajuan Baru Diterima</div>
                    <div class="activity-desc">Ahmad Fauzi (TI-2020-001) mengajukan Surat Keterangan</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-time">14:15</div>
                <div class="activity-content">
                    <div class="activity-title">Verifikasi Dosen Selesai</div>
                    <div class="activity-desc">Dr. Ahmad Yani menyetujui 3 pengajuan mahasiswa</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-time">13:45</div>
                <div class="activity-content">
                    <div class="activity-title">Backup Sistem</div>
                    <div class="activity-desc">Backup otomatis database berhasil - Size: 2.3GB</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-time">13:20</div>
                <div class="activity-content">
                    <div class="activity-title">User Login</div>
                    <div class="activity-desc">Administrator logged in from IP 192.168.1.100</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-actions">
        <h2>AKSI ADMINISTRATOR</h2>
        <div class="action-grid">
            <button class="admin-btn">
                <div class="btn-icon">🔧</div>
                <div class="btn-text">MAINTENANCE</div>
            </button>
            <button class="admin-btn">
                <div class="btn-icon">📊</div>
                <div class="btn-text">ANALYTICS</div>
            </button>
            <button class="admin-btn">
                <div class="btn-icon">👥</div>
                <div class="btn-text">USER MGMT</div>
            </button>
            <button class="admin-btn">
                <div class="btn-icon">⚙️</div>
                <div class="btn-text">SETTINGS</div>
            </button>
            <button class="admin-btn">
                <div class="btn-icon">🔒</div>
                <div class="btn-text">SECURITY</div>
            </button>
            <button class="admin-btn">
                <div class="btn-icon">📋</div>
                <div class="btn-text">AUDIT LOG</div>
            </button>
        </div>
    </div>

    <!-- System Metrics -->
    <div class="metrics-panels">
        <div class="metric-panel">
            <h3>PENGAJUAN HARIAN</h3>
            <div class="metric-chart">
                <div class="chart-placeholder">
                    <div style="font-size:2rem;margin-bottom:10px;">📈</div>
                    <div>Grafik pengajuan harian akan ditampilkan di sini</div>
                </div>
            </div>
        </div>
        <div class="metric-panel">
            <h3>PERFORMA SISTEM</h3>
            <div class="metric-stats">
                <div>Average Response Time: <strong>245ms</strong></div>
                <div>Error Rate: <strong>0.02%</strong></div>
                <div>Active Sessions: <strong>89</strong></div>
                <div>Memory Usage: <strong>67%</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection
