@extends('layouts.app')
@section('title', 'Dashboard Dosen')
@section('head')
    @vite(['resources/css/dashboard-dosen.css'])
@endsection
@section('sidebar')
<div class="sidebar-header">Smart Academic UMS</div>
<nav class="sidebar-menu">
    <ul>
        <li class="active"><a href="/dosen/dashboard">Dashboard</a></li>
        <li><a href="/dosen/verifikasi">Verifikasi Pengajuan</a></li>
        <li><a href="/dosen/riwayat">Riwayat Tanda Tangan</a></li>
        <li><a href="/dosen/laporan">Laporan Akademik</a></li>
    </ul>
</nav>
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>DASHBOARD DOSEN</h1>
    <div class="user-info">
        <span>Dr. Ahmad Yani, S.T., M.T.</span>
        <span>Dosen Tetap - Teknik Informatika</span>
    </div>
</div>
@endsection
@section('content')
<div class="dashboard-main">
    <p>Kelola dan pantau pengajuan akademik mahasiswa yang memerlukan verifikasi Anda.</p>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-content">
                <div class="stat-number">12</div>
                <div class="stat-label">MENUNGGU VERIFIKASI</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <div class="stat-number">28</div>
                <div class="stat-label">DISETUJUI HARI INI</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏰</div>
            <div class="stat-content">
                <div class="stat-number">5</div>
                <div class="stat-label">DALAM ANTRIAN</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-number">94%</div>
                <div class="stat-label">TINGKAT KELENGKAPAN</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>AKSI CEPAT</h2>
        <div class="action-buttons">
            <button class="action-btn primary">VERIFIKASI BARU</button>
            <button class="action-btn secondary">TANDA TANGAN DIGITAL</button>
            <button class="action-btn secondary">EXPORT LAPORAN</button>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="recent-activities">
        <h2>AKTIVITAS TERBARU</h2>
        <div class="activity-table">
            <div class="table-header">
                <div>WAKTU</div>
                <div>MAHASISWA</div>
                <div>JENIS LAYANAN</div>
                <div>STATUS</div>
                <div>AKSI</div>
            </div>
            <div class="table-row">
                <div>10:30</div>
                <div>Ahmad Fauzi<br><span style="color:#666;font-size:0.9em;">TI-2020-001</span></div>
                <div>Surat Keterangan</div>
                <div><span class="status-badge pending">MENUNGGU</span></div>
                <div><button class="btn-small">VERIFIKASI</button></div>
            </div>
            <div class="table-row">
                <div>09:15</div>
                <div>Siti Aminah<br><span style="color:#666;font-size:0.9em;">TI-2020-015</span></div>
                <div>Surat Rekomendasi</div>
                <div><span class="status-badge approved">DISETUJUI</span></div>
                <div><button class="btn-small disabled">SELESAI</button></div>
            </div>
            <div class="table-row">
                <div>08:45</div>
                <div>Budi Santoso<br><span style="color:#666;font-size:0.9em;">TI-2020-023</span></div>
                <div>Surat Aktif Kuliah</div>
                <div><span class="status-badge rejected">DITOLAK</span></div>
                <div><button class="btn-small disabled">SELESAI</button></div>
            </div>
        </div>
    </div>

    <!-- Info Panels -->
    <div class="info-panels">
        <div class="info-panel">
            <h3>PANDUAN VERIFIKASI</h3>
            <ul>
                <li>Periksa kelengkapan data mahasiswa di SIAKAD</li>
                <li>Validasi persyaratan akademik sesuai ketentuan</li>
                <li>Berikan alasan jika menolak pengajuan</li>
                <li>Gunakan tanda tangan digital untuk otentikasi</li>
            </ul>
        </div>
        <div class="info-panel">
            <h3>STATISTIK BULANAN</h3>
            <div class="monthly-stats">
                <div>Total Verifikasi: <strong>156</strong></div>
                <div>Rata-rata Waktu: <strong>2.3 jam</strong></div>
                <div>Tingkat Kepuasan: <strong>4.8/5</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection
