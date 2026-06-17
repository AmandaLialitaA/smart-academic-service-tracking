@extends('layouts.app')
@section('title', 'Dashboard Dosen')
@section('head')
    @vite(['resources/css/dashboard-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('content')
<div class="dosen-wrap">
    <div class="dosen-header">
        <div class="dosen-header-left">
            <h1 class="dosen-title">DASHBOARD <span class="title-purple">DOSEN</span></h1>
            <p class="dosen-sub">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>. Anda memiliki <a href="{{ route('dosen.menunggu') }}" class="link-purple">{{ $stats['menunggu'] }} pengajuan</a> yang menunggu TTD.</p>
            @if(auth()->user()->nidn)
                <p class="dosen-sub" style="margin-top:4px;">
                    NIDN: <strong>{{ auth()->user()->nidn }}</strong>
                </p>
            @endif
        </div>
    </div>

    <div class="dosen-stats">
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">MENUNGGU TTD</div>
                <div class="dstat-number" data-stat="menunggu_ttd">{{ $stats['menunggu'] }}</div>
                <div class="dstat-sub">Perlu tindakan segera</div>
            </div>
        </div>
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">SUDAH TTD</div>
                <div class="dstat-number" data-stat="sudah_ttd">{{ $stats['sudah_ttd'] }}</div>
                <div class="dstat-sub">Menunggu checklist admin</div>
            </div>
        </div>
        <div class="dosen-stat-card">
            <div class="dstat-content">
                <div class="dstat-label">SELESAI</div>
                <div class="dstat-number" data-stat="selesai">{{ $stats['selesai'] }}</div>
                <div class="dstat-sub">Dokumen telah diproses</div>
            </div>
        </div>
    </div>

    <div class="dosen-table-section">
        <div class="dosen-table-header">
            <h2 class="dosen-table-title">⏰ PENGAJUAN MENUNGGU TTD (5 Terbaru)</h2>
            <a href="{{ route('dosen.menunggu') }}" class="link-lihat-semua">Lihat di Menunggu TTD →</a>
        </div>

        <table class="dosen-table">
            <thead>
                <tr>
                    <th>MAHASISWA</th>
                    <th>LAYANAN</th>
                    <th>TANGGAL MASUK</th>
                    <th>STATUS TTD</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrian as $item)
                <tr>
                    <td>
                        <div class="mhs-info">
                            <div>
                                <div class="mhs-name">{{ strtoupper($item->nama_mahasiswa) }}</div>
                                <div class="mhs-nim">{{ $item->nim_mahasiswa }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span>{{ strtoupper($item->jenis_label) }}</span></td>
                    <td>
                        <div class="tgl-info">
                            <div>{{ $item->tanggal_submit?->format('d M Y') }}</div>
                            <div class="tgl-sub">{{ $item->tanggal_submit?->diffForHumans() }}</div>
                        </div>
                    </td>
                    <td>
                        @if($item->tanggal_ttd)
                            <span class="dosen-badge badge-selesai status-badge completed" data-id="{{ $item->kode }}" data-status="completed">Sudah TTD</span>
                        @else
                            <span class="dosen-badge badge-ttd status-badge waiting" data-id="{{ $item->kode }}" data-status="waiting">Menunggu TTD</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dosen.pengajuan.show', $item) }}" class="btn-review">Detail & TTD</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:20px;">Tidak ada pengajuan menunggu TTD.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>
@endsection