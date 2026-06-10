@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('head')
    @vite(['resources/css/dashboard-mahasiswa.css'])
@endsection

@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection

@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>

<div class="dashboard-main">
    <div class="dashboard-header">
        <h2 class="dashboard-title">HALO, FELIX 👋</h2>
        <p class="dashboard-desc">
            Selamat datang kembali di portal layanan akademik UMS. Berikut adalah ringkasan pengajuan Anda hari ini.
        </p>
    </div>

    <div class="dashboard-badges">
        <div class="badge badge-submitted">
            <div class="badge-label">SUBMITTED</div>
            <div class="badge-count">2</div>
        </div>
        <div class="badge badge-waiting">
            <div class="badge-label">WAITING</div>
            <div class="badge-count">1</div>
        </div>
        <div class="badge badge-completed">
            <div class="badge-label">COMPLETED</div>
            <div class="badge-count">1</div>
        </div>
        <div class="badge badge-rejected">
            <div class="badge-label">REJECTED</div>
            <div class="badge-count">1</div>
        </div>
    </div>

    <section class="latest-requests">
        <div class="section-header">
            <h2>STATUS PENGAJUAN TERBARU</h2>
            <a href="#" class="lihat-semua">Lihat Semua Riwayat</a>
        </div>

        <table class="requests-table">
            <thead>
                <tr>
                    <th>ID PENGAJUAN</th>
                    <th>JENIS LAYANAN</th>
                    <th>TANGGAL DIAJUKAN</th>
                    <th>DOSEN/STAFF PENANGGUNG JAWAB</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>REG-2024-001</td>
                    <td>Surat Keterangan Aktif Kuliah</td>
                    <td>24 Mei 2024</td>
                    <td><em>Dr. Ir. Wahyudin, M.T.</em></td>
                    <td><span class="status-badge completed">Completed</span></td>
                    <td><button class="btn-track">🔎 Track</button></td>
                </tr>
                <tr>
                    <td>REG-2024-005</td>
                    <td>Transkrip Nilai Sementara</td>
                    <td>26 Mei 2024</td>
                    <td><em>Prof. Dr. Anom Sutopo, M.Hum.</em></td>
                    <td><span class="status-badge waiting">Waiting</span></td>
                    <td><button class="btn-track">🔎 Track</button></td>
                </tr>
                <tr>
                    <td>REG-2024-009</td>
                    <td>Pengajuan Cuti Akademik</td>
                    <td>28 Mei 2024</td>
                    <td><em>Drs. Sujiwo, M.Kom.</em></td>
                    <td><span class="status-badge submitted">Submitted</span></td>
                    <td><button class="btn-track">🔎 Track</button></td>
                </tr>
                <tr>
                    <td>REQ-2024-012</td>
                    <td>Legalisir Ijazah Elektronik</td>
                    <td>29 Mei 2024</td>
                    <td><em>Staff BAA UMS</em></td>
                    <td><span class="status-badge rejected">Rejected</span></td>
                    <td><button class="btn-track">🔎 Track</button></td>
                </tr>
                <tr>
                    <td>REQ-2024-015</td>
                    <td>Surat Pengantar Magang</td>
                    <td>30 Mei 2024</td>
                    <td><em>Maryono, Ph.D.</em></td>
                    <td><span class="status-badge submitted">Submitted</span></td>
                    <td><button class="btn-track">🔎 Track</button></td>
                </tr>
            </tbody>
        </table>
    </section>

    <div class="dashboard-bottom-boxes">
        <div class="tips-box tips-box--purple">
            <b>💡 TIPS KECEPATAN LAYANAN</b>
            <ol>
                <li>Pastikan dokumen yang diunggah dalam format PDF dengan ukuran maksimal 2MB untuk mempercepat verifikasi.</li>
                <li>Gunakan email akademik (@student.ums.ac.id) untuk korespondensi resmi dengan dosen penanggung jawab.</li>
            </ol>
        </div>

        <div class="tips-box tips-box--dark">
            <b>Butuh Bantuan?</b>
            <p>Jika pengajuan Anda tertunda lebih dari 3 hari kerja tanpa status yang jelas, silakan hubungi biro Administrasi Akademik (BAA).</p>
            <div class="tips-location"><b>Lokasi BAA:</b> Gedung Siti Walidah Lt. 2</div>
            <a href="#" class="btn-contact btn-contact-dark">Kontak Admin</a>
        </div>
    </div>
</div>

<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>
@endsection
