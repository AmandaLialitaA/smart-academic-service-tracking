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
    <h1>HALO, {{ strtoupper($user->name) }} 👋</h1>
    <div class="user-info">
        <span>{{ $user->prodi ?? 'Universitas Muhammadiyah Surakarta' }}</span>
        <span>Semester {{ $user->semester ?? '-' }}</span>
    </div>
</div>
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>

@if(session('success'))
    <div style="background:#dcfce7;color:#166534;border-radius:8px;padding:12px 16px;margin-bottom:16px;">
        ✓ {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:12px 16px;margin-bottom:16px;">
        {{ session('error') }}
    </div>
@endif

<div class="dashboard-main">
    <p>Selamat datang kembali di portal layanan akademik UMS. Berikut adalah ringkasan pengajuan Anda.</p>

    <div class="dashboard-stats">
        <div class="stat">
            <h2>{{ $stats['total'] }}</h2>
            <p>Total Pengajuan</p>
        </div>
        <div class="stat">
            <h2>{{ $stats['proses'] }}</h2>
            <p>Sedang Diproses</p>
        </div>
        <div class="stat">
            <h2>{{ $stats['selesai'] }}</h2>
            <p>Selesai</p>
        </div>
        <div class="stat">
            <h2>{{ $stats['ditolak'] }}</h2>
            <p>Ditolak</p>
        </div>
    </div>

    <section class="latest-requests">
        <h2>Status Pengajuan Terbaru</h2>
        @if($riwayat->isEmpty())
            <div style="text-align:center;padding:2rem;color:#6b7280;">
                <p>Belum ada pengajuan. <a href="{{ route('mahasiswa.pengajuan') }}">Ajukan sekarang →</a></p>
            </div>
        @else
        <table class="requests-table">
            <thead>
                <tr>
                    <th>ID Pengajuan</th>
                    <th>Jenis Layanan</th>
                    <th>Tanggal Diajukan</th>
                    <th>Dosen</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $p)
                <tr>
                    <td>{{ $p->kode }}</td>
                    <td>{{ \App\Models\Pengajuan::JENIS_LABEL[$p->jenis_layanan] ?? $p->jenis_layanan }}</td>
                    <td>{{ $p->tanggal_submit?->format('d M Y') ?? '-' }}</td>
                    <td>{{ $p->dosen->name ?? '-' }}</td>
                    <td>
                        <span class="status {{ $p->status }}">
                            {{ \App\Models\Pengajuan::STATUS_LABEL[$p->status] ?? $p->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('mahasiswa.pengajuan.show', $p->id) }}"
                           class="btn-track">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </section>

    <section class="info-boxes">
        <div class="info-box">
            <h3>Tips Kecepatan Layanan</h3>
            <ul>
                <li>Pastikan dokumen yang diunggah dalam format PDF dengan ukuran maksimal 2MB.</li>
                <li>Gunakan email akademik untuk korespondensi resmi dengan dosen penanggung jawab.</li>
            </ul>
        </div>
        <div class="info-box">
            <h3>Butuh Bantuan?</h3>
            <p>Jika pengajuan Anda tertunda lebih dari 3 hari kerja, silakan hubungi Biro Administrasi Akademik (BAA).</p>
            <a href="#" class="btn-contact">Kontak Admin</a>
        </div>
    </section>
</div>
@endsection