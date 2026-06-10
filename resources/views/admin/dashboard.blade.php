@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-admin')
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>DASHBOARD ADMINISTRATOR</h1>
    <div class="user-info">
        <span>{{ auth()->user()->name }}</span>
        <span>Biro Administrasi Akademik</span>
    </div>
</div>
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

<div class="dashboard-main">
    <p>Monitor dan kelola sistem layanan akademik Universitas Muhammadiyah Surakarta.</p>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['total_mahasiswa'] }}</div>
                <div class="stat-label">TOTAL MAHASISWA</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👨‍🏫</div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['total_dosen'] }}</div>
                <div class="stat-label">DOSEN AKTIF</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📄</div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['bulan_ini'] }}</div>
                <div class="stat-label">PENGAJUAN BULAN INI</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <div class="stat-number">{{ $stats['selesai'] }}</div>
                <div class="stat-label">SELESAI</div>
            </div>
        </div>
    </div>

    {{-- Pengajuan aktif menunggu tindakan --}}
    <div class="recent-activities" style="margin-top:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <h2>PENGAJUAN MENUNGGU TINDAKAN</h2>
            <a href="{{ route('admin.pengajuan') }}"
               style="color:#a259e6;font-weight:600;text-decoration:none;">Lihat Semua →</a>
        </div>

        @if($pengajuanTerbaru->isEmpty())
            <p style="color:#6b7280;padding:1rem 0;">Tidak ada pengajuan yang menunggu tindakan.</p>
        @else
        <table style="width:100%;border-collapse:collapse;font-size:0.95rem;">
            <thead>
                <tr style="border-bottom:2px solid #e5e7eb;">
                    <th style="text-align:left;padding:8px;">Kode</th>
                    <th style="text-align:left;padding:8px;">Mahasiswa</th>
                    <th style="text-align:left;padding:8px;">Layanan</th>
                    <th style="text-align:left;padding:8px;">Status</th>
                    <th style="text-align:left;padding:8px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuanTerbaru as $p)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td style="padding:8px;">{{ $p->kode }}</td>
                    <td style="padding:8px;">
                        {{ $p->mahasiswa->name ?? '-' }}<br>
                        <small style="color:#6b7280;">{{ $p->nim_mahasiswa }}</small>
                    </td>
                    <td style="padding:8px;">
                        {{ \App\Models\Pengajuan::JENIS_LABEL[$p->jenis_layanan] ?? $p->jenis_layanan }}
                    </td>
                    <td style="padding:8px;">
                        <span style="padding:4px 10px;border-radius:20px;font-size:0.82rem;font-weight:600;
                            background:{{ $p->status === 'submitted' ? '#fef3c7' : ($p->status === 'admin_verifikasi' ? '#dbeafe' : '#ede9fe') }};
                            color:{{ $p->status === 'submitted' ? '#92400e' : ($p->status === 'admin_verifikasi' ? '#1e40af' : '#5b21b6') }};">
                            {{ \App\Models\Pengajuan::STATUS_LABEL[$p->status] ?? $p->status }}
                        </span>
                    </td>
                    <td style="padding:8px;">
                        <a href="{{ route('admin.pengajuan.show', $p->id) }}"
                           style="padding:5px 12px;background:#a259e6;color:#fff;border-radius:6px;text-decoration:none;font-size:0.85rem;">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Ringkasan status --}}
    <div class="metrics-panels" style="margin-top:24px;">
        <div class="metric-panel">
            <h3>RINGKASAN STATUS PENGAJUAN</h3>
            <div class="metric-stats">
                <div>Menunggu Verifikasi Admin: <strong>{{ $stats['submitted'] }}</strong></div>
                <div>Sedang Diverifikasi Admin: <strong>{{ $stats['admin_verifikasi'] }}</strong></div>
                <div>Menunggu TTD Dosen: <strong>{{ $stats['dosen_ttd'] }}</strong></div>
                <div>Selesai: <strong>{{ $stats['selesai'] }}</strong></div>
                <div>Ditolak: <strong>{{ $stats['ditolak'] }}</strong></div>
            </div>
        </div>
        <div class="metric-panel">
            <h3>AKSI CEPAT</h3>
            <div style="display:flex;flex-direction:column;gap:8px;margin-top:8px;">
                <a href="{{ route('admin.pengajuan') }}?status=submitted"
                   style="padding:10px 16px;background:#fef3c7;color:#92400e;border-radius:8px;text-decoration:none;font-weight:600;">
                    📋 Verifikasi Pengajuan Baru ({{ $stats['submitted'] }})
                </a>
                <a href="{{ route('admin.pengajuan') }}?status=dosen_ttd"
                   style="padding:10px 16px;background:#ede9fe;color:#5b21b6;border-radius:8px;text-decoration:none;font-weight:600;">
                    ✍ Pengajuan Menunggu TTD ({{ $stats['dosen_ttd'] }})
                </a>
            </div>
        </div>
    </div>
</div>
@endsection