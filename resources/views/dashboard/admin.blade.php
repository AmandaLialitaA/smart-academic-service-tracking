@extends('layouts.auth')

@section('content')
@vite(['public/css/dashboard-admin.css'])
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Smart Academic Service Tracking System UMS</h2>
        </div>
        <nav class="sidebar-menu">
            <ul>
                <li class="active"><a href="#">Dashboard</a></li>
                <li><a href="#">Verifikasi</a></li>
                <li><a href="#">Semua Pengajuan</a></li>
                <li><a href="#">Analytics</a></li>
            </ul>
        </nav>
    </aside>
    <main class="dashboard-main">
        <header class="dashboard-header">
            <h1>DASHBOARD <span class="highlight">ADMIN</span></h1>
            <p>Selamat datang kembali, Tim Administrasi Akademik UMS.</p>
            <div class="dashboard-stats">
                <div class="stat">
                    <h2>124</h2>
                    <p>Total Pengajuan Hari Ini</p>
                </div>
                <div class="stat">
                    <h2>42</h2>
                    <p>Menunggu Verifikasi</p>
                </div>
                <div class="stat">
                    <h2>28</h2>
                    <p>Menunggu TTD Dosen</p>
                </div>
                <div class="stat">
                    <h2>54</h2>
                    <p>Layanan Selesai</p>
                </div>
            </div>
        </header>
        <section class="daily-volume">
            <h2>Volume Layanan Harian</h2>
            <div class="chart-container">
                <canvas id="dailyVolumeChart"></canvas>
            </div>
        </section>
        <section class="urgent-info">
            <div class="info-box">
                <h3>Mendesak</h3>
                <ul>
                    <li>15 Dokumen Overdue</li>
                    <li>Sistem SIAKAD akan disinkronisasi dalam 2 jam ke depan.</li>
                </ul>
            </div>
        </section>
        <section class="latest-requests">
            <h2>Pengajuan Terbaru</h2>
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Layanan</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ahmad Fauzan</td>
                        <td>Legalisir Ijazah</td>
                        <td>24 Okt 2023</td>
                        <td><span class="status submitted">Submitted</span></td>
                    </tr>
                    <tr>
                        <td>Siti Aminah</td>
                        <td>Surat Keterangan Aktif</td>
                        <td>24 Okt 2023</td>
                        <td><span class="status waiting">Waiting</span></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</div>
@endsection