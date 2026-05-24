@extends('layouts.app')
@section('title', 'Riwayat Pengajuan')
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
        <h2 class="dashboard-title">RIWAYAT PENGAJUAN</h2>
        <p class="dashboard-desc">Semua pengajuan layanan akademik yang pernah Anda buat.</p>
    </div>

    {{-- Filter & Search --}}
    <div class="riwayat-filter-bar">
        <input type="text" class="riwayat-search" placeholder="🔍 Cari ID atau jenis layanan...">
        <div class="riwayat-filter-group">
            <select class="riwayat-select">
                <option value="">Semua Status</option>
                <option value="submitted">Submitted</option>
                <option value="waiting">Waiting</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
            </select>
            <select class="riwayat-select">
                <option value="">Semua Layanan</option>
                <option>Surat Keterangan Aktif Kuliah</option>
                <option>Transkrip Nilai Sementara</option>
                <option>Pengajuan Cuti Akademik</option>
                <option>Legalisir Ijazah Elektronik</option>
                <option>Surat Pengantar Magang</option>
            </select>
        </div>
    </div>

    {{-- Summary badges --}}
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

    {{-- Tabel --}}
    <section class="latest-requests">
        <div class="section-header">
            <h2>SEMUA PENGAJUAN</h2>
            <span class="riwayat-count">Menampilkan 5 pengajuan</span>
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
                    <td>REQ-2024-001</td>
                    <td>Surat Keterangan Aktif Kuliah</td>
                    <td>24 Mei 2024</td>
                    <td><em>Dr. Ir. Wahyudin, M.T.</em></td>
                    <td><span class="status-badge completed">Completed</span></td>
                    <td><a href="/tracking" class="btn-track">🔎 Track</a></td>
                </tr>
                <tr>
                    <td>REQ-2024-005</td>
                    <td>Transkrip Nilai Sementara</td>
                    <td>26 Mei 2024</td>
                    <td><em>Prof. Dr. Anom Sutopo, M.Hum.</em></td>
                    <td><span class="status-badge waiting">Waiting</span></td>
                    <td><a href="/tracking" class="btn-track">🔎 Track</a></td>
                </tr>
                <tr>
                    <td>REQ-2024-009</td>
                    <td>Pengajuan Cuti Akademik</td>
                    <td>28 Mei 2024</td>
                    <td><em>Drs. Sujiwo, M.Kom.</em></td>
                    <td><span class="status-badge submitted">Submitted</span></td>
                    <td><a href="/tracking" class="btn-track">🔎 Track</a></td>
                </tr>
                <tr>
                    <td>REQ-2024-012</td>
                    <td>Legalisir Ijazah Elektronik</td>
                    <td>29 Mei 2024</td>
                    <td><em>Staff BAA UMS</em></td>
                    <td><span class="status-badge rejected">Rejected</span></td>
                    <td><a href="/tracking" class="btn-track">🔎 Track</a></td>
                </tr>
                <tr>
                    <td>REQ-2024-015</td>
                    <td>Surat Pengantar Magang</td>
                    <td>30 Mei 2024</td>
                    <td><em>Maryono, Ph.D.</em></td>
                    <td><span class="status-badge submitted">Submitted</span></td>
                    <td><a href="/tracking" class="btn-track">🔎 Track</a></td>
                </tr>
            </tbody>
        </table>
    </section>

</div>

<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>
@endsection