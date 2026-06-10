@extends('layouts.app')
@section('title', 'Dashboard Dosen')
@section('head')
    @vite(['resources/css/dashboard-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('content')
@section('topbar_name', 'lecturer')
@section('topbar_role', 'UMS Academic')
<div class="dosen-wrap">

    {{-- Header --}}
    <div class="dosen-header">
        <div class="dosen-header-left">
            <h1 class="dosen-title">DASHBOARD <span class="title-purple">DOSEN</span></h1>
            <p class="dosen-sub">Selamat datang kembali, Prof. Dr. Sutrisno. Anda memiliki <a href="#" class="link-purple">12 pengajuan</a> yang menunggu verifikasi hari ini.</p>
        </div>
        <div class="dosen-header-right">
            <button class="btn-rekap">⬇ Rekap Bulanan</button>
            <button class="btn-riwayat">Lihat Riwayat</button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="dosen-stats">
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">MENUNGGU TTD</div>
                <div class="dstat-number">12</div>
                <div class="dstat-sub">Perlu tindakan segera</div>
            </div>
            <div class="dstat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
        </div>
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">MAHASISWA TERLAYANI</div>
                <div class="dstat-number">148</div>
                <div class="dstat-sub">Total semester ini</div>
            </div>
            <div class="dstat-icon dstat-icon--teal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">SELESAI MINGGU INI</div>
                <div class="dstat-number">24</div>
                <div class="dstat-sub">Dokumen telah diproses</div>
            </div>
            <div class="dstat-icon dstat-icon--green">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
        </div>
    </div>

    {{-- Tabel Pengajuan --}}
    <div class="dosen-table-section">
        <div class="dosen-table-header">
            <h2 class="dosen-table-title">⏰ PENGAJUAN MENUNGGU TTD</h2>
            <div class="dosen-table-actions">
                <button class="btn-filter">▼ FILTER: TERBARU</button>
                <a href="#" class="link-lihat-semua">Lihat Semua →</a>
            </div>
        </div>

        <table class="dosen-table">
            <thead>
                <tr>
                    <th>MAHASISWA</th>
                    <th>LAYANAN</th>
                    <th>TANGGAL MASUK</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="mhs-info">
                            <img src="https://i.pravatar.cc/36?img=1" class="mhs-avatar" alt="">
                            <div>
                                <div class="mhs-name">AHMAD DAHLAN</div>
                                <div class="mhs-nim">L200210045</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="layanan-info">
                            <span class="layanan-icon"><i data-lucide="file-text" style="width:16px;height:16px;color:#a259e6;"></i></span>
                            <span>SURAT KETERANGAN AKTIF KULIAH</span>
                        </div>
                    </td>
                    <td>
                        <div class="tgl-info">
                            <div>24 Okt 2023</div>
                            <div class="tgl-sub">3 jam yang lalu</div>
                        </div>
                    </td>
                    <td><span class="dosen-badge badge-ttd">Menunggu TTD</span></td>
                    <td>
                        <div class="aksi-group">
                            <button class="btn-review">👁 Review</button>
                            <button class="btn-more">⋮</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="mhs-info">
                            <img src="https://i.pravatar.cc/36?img=5" class="mhs-avatar" alt="">
                            <div>
                                <div class="mhs-name">SITI WALIDAH</div>
                                <div class="mhs-nim">B100220112</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="layanan-info">
                            <span class="layanan-icon"><i data-lucide="file-text" style="width:16px;height:16px;color:#a259e6;"></i></span>
                            <span>TRANSKRIP NILAI SEMENTARA</span>
                        </div>
                    </td>
                    <td>
                        <div class="tgl-info">
                            <div>24 Okt 2023</div>
                            <div class="tgl-sub">3 jam yang lalu</div>
                        </div>
                    </td>
                    <td><span class="dosen-badge badge-ttd">Menunggu TTD</span></td>
                    <td>
                        <div class="aksi-group">
                            <button class="btn-review">👁 Review</button>
                            <button class="btn-more">⋮</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="mhs-info">
                            <img src="https://i.pravatar.cc/36?img=8" class="mhs-avatar" alt="">
                            <div>
                                <div class="mhs-name">HAIDAR NASHIR</div>
                                <div class="mhs-nim">J500210089</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="layanan-info">
                            <span class="layanan-icon"><i data-lucide="file-text" style="width:16px;height:16px;color:#a259e6;"></i></span>
                            <span>PENGAJUAN CUTI AKADEMIK</span>
                        </div>
                    </td>
                    <td>
                        <div class="tgl-info">
                            <div>23 Okt 2023</div>
                            <div class="tgl-sub">3 jam yang lalu</div>
                        </div>
                    </td>
                    <td><span class="dosen-badge badge-ttd">Menunggu TTD</span></td>
                    <td>
                        <div class="aksi-group">
                            <button class="btn-review">👁 Review</button>
                            <button class="btn-more">⋮</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="mhs-info">
                            <img src="https://i.pravatar.cc/36?img=9" class="mhs-avatar" alt="">
                            <div>
                                <div class="mhs-name">SALMA SALSABIL</div>
                                <div class="mhs-nim">A510210023</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="layanan-info">
                            <span class="layanan-icon"><i data-lucide="file-text" style="width:16px;height:16px;color:#a259e6;"></i></span>
                            <span>LEGALISIR IJAZAH</span>
                        </div>
                    </td>
                    <td>
                        <div class="tgl-info">
                            <div>23 Okt 2023</div>
                            <div class="tgl-sub">3 jam yang lalu</div>
                        </div>
                    </td>
                    <td><span class="dosen-badge badge-ttd">Menunggu TTD</span></td>
                    <td>
                        <div class="aksi-group">
                            <button class="btn-review">👁 Review</button>
                            <button class="btn-more">⋮</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="mhs-info">
                            <img src="https://i.pravatar.cc/36?img=12" class="mhs-avatar" alt="">
                            <div>
                                <div class="mhs-name">BUDI UTOMO</div>
                                <div class="mhs-nim">D400210056</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="layanan-info">
                            <span class="layanan-icon"><i data-lucide="file-text" style="width:16px;height:16px;color:#a259e6;"></i></span>
                            <span>SURAT REKOMENDASI BEASISWA</span>
                        </div>
                    </td>
                    <td>
                        <div class="tgl-info">
                            <div>22 Okt 2023</div>
                            <div class="tgl-sub">3 jam yang lalu</div>
                        </div>
                    </td>
                    <td><span class="dosen-badge badge-ttd">Menunggu TTD</span></td>
                    <td>
                        <div class="aksi-group">
                            <button class="btn-review">👁 Review</button>
                            <button class="btn-more">⋮</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="dosen-pagination">
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <span class="page-ellipsis">...</span>
            <button class="page-btn">12</button>
        </div>
    </div>

    {{-- Bottom Cards --}}
    <div class="dosen-bottom-cards">
        <div class="bottom-card bottom-card--pink">
            <div class="bottom-card-icon"><i data-lucide="users" style="width:24px;height:24px;color:#a259e6;"></i></div>
            <div>
                <div class="bottom-card-title">JADWAL TANDA TANGAN OFFLINE</div>
                <p>Bagi mahasiswa yang memerlukan tanda tangan basah untuk berkas khusus, jam pelayanan tersedia setiap Selasa & Kamis pukul 13.00 - 15.00 di Ruang Dosen Lt. 3.</p>
                <a href="#" class="bottom-card-link">Lihat Jadwal Lengkap</a>
            </div>
        </div>
        <div class="bottom-card bottom-card--teal">
            <div class="bottom-card-icon"><i data-lucide="check-circle" style="width:24px;height:24px;color:#a259e6;"></i></div>
            <div>
                <div class="bottom-card-title">TIPS VERIFIKASI CEPAT</div>
                <p>Gunakan fitur "Batch Signature" untuk menandatangani lebih dari 5 dokumen sekaligus dengan satu kali verifikasi OTP/Biometrik.</p>
                <a href="#" class="bottom-card-link">Pelajari Fitur</a>
            </div>
        </div>
    </div>

</div>

<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>
@endsection