@extends('layouts.app')
@section('title', 'Dashboard Admin | STA-UMS')
@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-admin')
@endsection
@section('content')
<div class="da-wrap">
    <div class="da-header">
        <div>
            <h1 class="da-title">DASHBOARD ADMIN</h1>
            <p class="da-subtitle">Selamat datang, {{ auth()->user()->name }}.</p>
        </div>
        <div class="da-header-actions">
            <a href="{{ route('admin.semua-pengajuan') }}" class="da-btn-primary" style="text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <i data-lucide="clipboard-list" width="16" height="16"></i>
                Semua Pengajuan
            </a>
        </div>
    </div>

    <div class="da-stats-grid">
        <div class="da-stat-card da-stat-card--purple">
            <div class="da-stat-info">
                <div class="da-stat-label">BELUM SELESAI</div>
                <div class="da-stat-number" data-stat="belum_selesai">{{ $stats['belum_selesai'] }}</div>
            </div>
            <div class="da-stat-icon"><i data-lucide="clock" width="28" height="28"></i></div>
        </div>
        <div class="da-stat-card da-stat-card--cyan">
            <div class="da-stat-info">
                <div class="da-stat-label">MENUNGGU VERIFIKASI</div>
                <div class="da-stat-number" data-stat="submitted">{{ $stats['submitted'] }}</div>
            </div>
            <div class="da-stat-icon"><i data-lucide="file-check" width="28" height="28"></i></div>
        </div>
        <div class="da-stat-card da-stat-card--amber">
            <div class="da-stat-info">
                <div class="da-stat-label">MENUNGGU TTD DOSEN</div>
                <div class="da-stat-number" data-stat="dosen_ttd">{{ $stats['dosen_ttd'] }}</div>
            </div>
            <div class="da-stat-icon"><i data-lucide="pen-line" width="28" height="28"></i></div>
        </div>
        <div class="da-stat-card da-stat-card--white">
            <div class="da-stat-info">
                <div class="da-stat-label">LAYANAN SELESAI</div>
                <div class="da-stat-number" data-stat="completed">{{ $stats['selesai'] }}</div>
            </div>
            <div class="da-stat-icon"><i data-lucide="check-circle" width="28" height="28"></i></div>
        </div>
    </div>

    <div class="da-row-2">
        <div class="da-recent-panel" style="flex:1;">
            <div class="da-panel-header">
                <div class="da-panel-title">PENGAJUAN TERBARU (5)</div>
            </div>
            <div class="da-recent-list">
                @forelse($pengajuanTerbaru as $item)
                <a href="{{ route('admin.verifikasi.detail', $item) }}" class="da-recent-item" style="text-decoration:none;color:inherit;">
                    <div class="da-recent-info">
                        <div class="da-recent-name">{{ strtoupper($item->nama_mahasiswa) }}</div>
                        <div class="da-recent-meta">{{ $item->nim_mahasiswa }} · {{ $item->jenis_label }}</div>
                    </div>
                    <div class="da-recent-right">
                        <x-status-badge :pengajuan="$item" />
                        <div class="da-recent-time">{{ $item->created_at?->diffForHumans() }}</div>
                    </div>
                </a>
                @empty
                <p style="padding:16px;color:#888;">Belum ada pengajuan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
<script>lucide.createIcons();</script>
@endsection
