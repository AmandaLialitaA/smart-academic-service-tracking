@extends('layouts.auth')

@section('content')
@vite(['public/css/dashboard-dosen.css'])
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Smart Academic UMS</h2>
        </div>
        <nav class="sidebar-menu">
            <ul>
                <li class="active"><a href="#">Dashboard</a></li>
                <li><a href="#">Menunggu TTD</a></li>
                <li><a href="#">Riwayat</a></li>
            </ul>
        </nav>
    </aside>
    <main class="dashboard-main">
        <header class="dashboard-header">
            <h1>DASHBOARD <span class="highlight">DOSEN</span></h1>
            <p>Selamat datang kembali, Prof. Dr. Sutrisno. Anda memiliki <strong>12 pengajuan</strong> yang menunggu verifikasi hari ini.</p>
            <div class="dashboard-stats">
                <div class="stat">
                    <h2>12</h2>
                    <p>Perlu tindakan segera</p>
                </div>
                <div class="stat">
                    <h2>148</h2>
                    <p>Mahasiswa terlayani</p>
                </div>
                <div class="stat">
                    <h2>24</h2>
                    <p>Dokumen telah diproses</p>
                </div>
            </div>
        </header>
        <section class="pending-requests">
            <h2>Pengajuan Menunggu TTD</h2>
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Layanan</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ahmad Dahlan</td>
                        <td>Surat Keterangan Aktif Kuliah</td>
                        <td>24 Okt 2023</td>
                        <td>Menunggu TTD</td>
                        <td><button class="btn-review">Review</button></td>
                    </tr>
                    <tr>
                        <td>Siti Walidah</td>
                        <td>Transkrip Nilai Sementara</td>
                        <td>24 Okt 2023</td>
                        <td>Menunggu TTD</td>
                        <td><button class="btn-review">Review</button></td>
                    </tr>
                    <tr>
                        <td>Haidar Nashir</td>
                        <td>Pengajuan Cuti Akademik</td>
                        <td>23 Okt 2023</td>
                        <td>Menunggu TTD</td>
                        <td><button class="btn-review">Review</button></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section class="info-boxes">
            <div class="info-box">
                <h3>Jadwal Tanda Tangan Offline</h3>
                <p>Bagi mahasiswa yang memerlukan tanda tangan basah untuk berkas khusus, jam pelayanan tersedia setiap Selasa & Kamis pukul 13:00 - 15:00 di Ruang Dosen Lt. 3.</p>
                <a href="#">Lihat Jadwal Lengkap</a>
            </div>
            <div class="info-box">
                <h3>Tips Verifikasi Cepat</h3>
                <p>Gunakan fitur "Batch Signature" untuk menandatangani lebih dari 5 dokumen sekaligus dengan satu kali verifikasi OTP/Biometrik.</p>
                <a href="#">Pelajari Fitur</a>
            </div>
        </section>
    </main>
</div>
@endsection