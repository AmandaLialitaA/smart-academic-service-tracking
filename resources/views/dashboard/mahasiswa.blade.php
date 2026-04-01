@extends('layouts.auth')

@section('content')
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Smart Academic Service Tracking System UMS</h2>
        </div>
        <nav class="sidebar-menu">
            <ul>
                <li class="active"><a href="#">Dashboard</a></li>
                <li><a href="#">Ajukan Layanan</a></li>
                <li><a href="#">Riwayat Pengajuan</a></li>
            </ul>
        </nav>
    </aside>
    <main class="dashboard-main">
        <header class="dashboard-header">
            <h1>HALO, FELIX 👋</h1>
            <p>Selamat datang kembali di portal layanan akademik UMS. Berikut adalah ringkasan pengajuan Anda hari ini.</p>
            <div class="dashboard-stats">
                <div class="stat">
                    <h2>2</h2>
                    <p>Submitted</p>
                </div>
                <div class="stat">
                    <h2>1</h2>
                    <p>Waiting</p>
                </div>
                <div class="stat">
                    <h2>1</h2>
                    <p>Completed</p>
                </div>
                <div class="stat">
                    <h2>1</h2>
                    <p>Rejected</p>
                </div>
            </div>
        </header>
        <section class="latest-requests">
            <h2>Status Pengajuan Terbaru</h2>
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>ID Pengajuan</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal Diajukan</th>
                        <th>Dosen/Staff Penanggung Jawab</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>REG-2024-001</td>
                        <td>Surat Keterangan Aktif Kuliah</td>
                        <td>24 Mei 2024</td>
                        <td>Dr. Ir. Wahyudin, M.T.</td>
                        <td><span class="status completed">Completed</span></td>
                        <td><button class="btn-track">Track</button></td>
                    </tr>
                    <tr>
                        <td>REG-2024-005</td>
                        <td>Transkrip Nilai Sementara</td>
                        <td>26 Mei 2024</td>
                        <td>Prof. Dr. Anon Sutopo, M.Hum.</td>
                        <td><span class="status waiting">Waiting</span></td>
                        <td><button class="btn-track">Track</button></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section class="info-boxes">
            <div class="info-box">
                <h3>Tips Kecepatan Layanan</h3>
                <ul>
                    <li>Pastikan dokumen yang diunggah dalam format PDF dengan ukuran maksimal 2MB untuk mempercepat verifikasi.</li>
                    <li>Gunakan email akademik (@student.ums.ac.id) untuk korespondensi resmi dengan dosen penanggung jawab.</li>
                </ul>
            </div>
            <div class="info-box">
                <h3>Butuh Bantuan?</h3>
                <p>Jika pengajuan Anda tertunda lebih dari 3 hari kerja tanpa status yang jelas, silakan hubungi biro Administrasi Akademik (BAA).</p>
                <a href="#" class="btn-contact">Kontak Admin</a>
            </div>
        </section>
    </main>
</div>
@endsection

@vite(['public/css/dashboard-mahasiswa.css'])