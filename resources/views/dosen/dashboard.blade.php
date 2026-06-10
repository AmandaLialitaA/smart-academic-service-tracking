@extends('layouts.app')
@section('title', 'Dashboard Dosen')
@section('head')
    @vite(['resources/css/dashboard-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('content')

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

<div class="dosen-wrap">
    <div class="dosen-header">
        <div class="dosen-header-left">
            <h1 class="dosen-title">DASHBOARD <span class="title-purple">DOSEN</span></h1>
            <p class="dosen-sub">
                Selamat datang kembali, <strong>{{ $user->name }}</strong>.
                @if($stats['menunggu'] > 0)
                    Anda memiliki <strong>{{ $stats['menunggu'] }} pengajuan</strong> yang menunggu TTD.
                @else
                    Tidak ada pengajuan yang menunggu TTD saat ini.
                @endif
            </p>
        </div>
        <div class="dosen-header-right">
            <a href="{{ route('dosen.verifikasi') }}" class="btn-riwayat">Lihat Semua</a>
        </div>
    </div>

    <div class="dosen-stats">
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">MENUNGGU TTD</div>
                <div class="dstat-number">{{ $stats['menunggu'] }}</div>
                <div class="dstat-sub">Perlu tindakan segera</div>
            </div>
        </div>
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">SUDAH SELESAI</div>
                <div class="dstat-number">{{ $stats['disetujui'] }}</div>
                <div class="dstat-sub">Total diproses</div>
            </div>
        </div>
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">DITOLAK</div>
                <div class="dstat-number">{{ $stats['ditolak'] }}</div>
                <div class="dstat-sub">Total ditolak</div>
            </div>
        </div>
    </div>

    <div class="dosen-table-section">
        <div class="dosen-table-header">
            <h2 class="dosen-table-title">⏰ PENGAJUAN MENUNGGU TTD</h2>
        </div>

        @if($antrian->isEmpty())
            <div style="text-align:center;padding:2rem;color:#6b7280;">
                <p>Tidak ada pengajuan yang menunggu TTD saat ini.</p>
            </div>
        @else
        <table class="dosen-table">
            <thead>
                <tr>
                    <th>KODE</th>
                    <th>MAHASISWA</th>
                    <th>LAYANAN</th>
                    <th>TANGGAL MASUK</th>
                    <th>STATUS TTD</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($antrian as $p)
                <tr>
                    <td>{{ $p->kode }}</td>
                    <td>
                        <div class="mhs-info">
                            <div>
                                <div class="mhs-name">{{ strtoupper($p->mahasiswa->name ?? '-') }}</div>
                                <div class="mhs-nim">{{ $p->nim_mahasiswa }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ \App\Models\Pengajuan::JENIS_LABEL[$p->jenis_layanan] ?? $p->jenis_layanan }}</td>
                    <td>{{ $p->tanggal_submit?->format('d M Y') ?? '-' }}</td>
                    <td>
                        @if($p->tanggal_ttd)
                            <span class="dosen-badge" style="background:#dcfce7;color:#166534;">✓ Sudah TTD</span>
                        @else
                            <span class="dosen-badge badge-ttd">Belum TTD</span>
                        @endif
                    </td>
                    <td>
                        <div class="aksi-group">
                            <a href="{{ route('dosen.pengajuan.show', $p->id) }}"
                               class="btn-review">👁 Detail</a>
                            @if(!$p->tanggal_ttd)
                            <a href="{{ route('dosen.ttd.show', $p->id) }}"
                               style="padding:6px 12px;background:#059669;color:#fff;border-radius:6px;text-decoration:none;font-size:0.85rem;font-weight:600;">
                                ✍ TTD
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>
@endsection