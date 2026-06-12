@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('head')
    @vite(['resources/css/dashboard-mahasiswa.css'])
@endsection

@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection

@section('navbar')
<div class="navbar-content">
    <div>
        <h1>HALO, {{ strtoupper(auth()->user()->name) }} 👋</h1>
        <div class="user-info">
            <span>Universitas Muhammadiyah Surakarta</span>
            <span>{{ auth()->user()->prodi ?? 'Program Studi' }} · Semester {{ auth()->user()->semester ?? '-' }}</span>
        </div>
    </div>
    <a href="{{ route('mahasiswa.pengajuan') }}" class="btn-ajukan-layanan">+ Ajukan Layanan Baru</a>
</div>
@endsection

@section('content')
<div class="dashboard-main">

    <div class="dashboard-badges">
        <div class="badge badge-submitted">
            <div>
                <div class="badge-label">Menunggu Admin</div>
                <div class="badge-count" data-stat="submitted">{{ $stats['submitted'] }}</div>
            </div>
            <div class="badge-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </div>
        </div>
        <div class="badge badge-waiting">
            <div>
                <div class="badge-label">Proses / TTD</div>
                <div class="badge-count" data-stat="waiting">{{ $stats['waiting'] }}</div>
            </div>
            <div class="badge-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <div class="badge badge-completed">
            <div>
                <div class="badge-label">Selesai</div>
                <div class="badge-count" data-stat="completed">{{ $stats['completed'] }}</div>
            </div>
            <div class="badge-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
        </div>
        <div class="badge badge-rejected">
            <div>
                <div class="badge-label">Ditolak</div>
                <div class="badge-count" data-stat="rejected">{{ $stats['rejected'] }}</div>
            </div>
            <div class="badge-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
        </div>
    </div>

    <section class="latest-requests">
        <div class="section-header">
            <h2>Status Pengajuan Terbaru</h2>
            <a href="{{ route('mahasiswa.riwayat') }}" class="lihat-semua">Lihat Semua Riwayat &rarr;</a>
        </div>

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
                @forelse($riwayat as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->jenis_label }}</td>
                    <td>{{ $item->tanggal_submit?->format('d M Y') ?? '-' }}</td>
                    <td><em>{{ $item->dosen?->name ?? 'Menunggu penugasan' }}</em></td>
                    <td><x-status-badge :pengajuan="$item" /></td>
                    <td>
                        <div class="aksi-buttons">
                            <a href="{{ route('mahasiswa.pengajuan.detail', $item) }}" class="btn-track">Detail</a>
                            <a href="{{ route('mahasiswa.tracking', $item) }}" class="btn-track">Track</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:24px;color:#888;">Belum ada pengajuan. <a href="{{ route('mahasiswa.pengajuan') }}">Ajukan layanan sekarang</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <div class="dashboard-bottom-boxes">
        <div class="tips-box tips-box--purple">
            <b>💡 Tips Kecepatan Layanan</b>
            <ol>
                <li>Pastikan dokumen dalam format PDF, JPG, atau PNG dengan ukuran maksimal 10MB.</li>
                <li>Gunakan email akademik (@student.ums.ac.id) untuk korespondensi resmi.</li>
            </ol>
        </div>
        <div class="tips-box tips-box--dark">
            <b>Butuh Bantuan?</b>
            <p>Hubungi Biro Administrasi Akademik (BAA) jika pengajuan tertunda lebih dari 3 hari kerja.</p>
            <div class="tips-location">Lokasi BAA <b>Gedung Siti Walidah Lt. 2</b></div>
            <a href="{{ route('kontak.admin') }}" class="btn-contact btn-contact-dark">Kontak Admin</a>
        </div>
    </div>
</div>

<footer class="dashboard-footer">
    &copy; 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
</footer>
@endsection
