@extends('layouts.app')
@section('title', 'Tracking Pengajuan')
@section('head')
    @vite(['resources/css/tracking.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection
@section('content')
<div class="tracking-wrap">
    <a href="{{ route('mahasiswa.riwayat') }}" class="tracking-back">← Kembali ke Riwayat</a>

    <div class="tracking-title-row">
        <div>
            <h1 class="tracking-title">TRACKING PENGAJUAN</h1>
            <p class="tracking-sub">Lacak status layanan akademik Anda secara real-time.</p>
        </div>
        <div class="tracking-actions">
            <button class="btn-refresh" onclick="location.reload()">REFRESH STATUS</button>
        </div>
    </div>

    <div class="tracking-body">
        <div class="tracking-left">
            <div class="tracking-info-boxes">
                <div class="tracking-box">
                    <div class="tbox-label">ID PENGAJUAN</div>
                    <div class="tbox-val">{{ $pengajuan->kode }}</div>
                </div>
                <div class="tracking-box">
                    <div class="tbox-label">JENIS LAYANAN</div>
                    <div class="tbox-val">{{ $pengajuan->jenis_label }}</div>
                </div>
                <div class="tracking-box">
                    <div class="tbox-label">STATUS TERAKHIR</div>
                    <div class="tbox-val"><x-status-badge :pengajuan="$pengajuan" /></div>
                </div>
            </div>

            <div class="tracking-progress-box">
                <div class="progress-row">
                    <span class="progress-label">PROGRES KESELURUHAN</span>
                    <span class="progress-pct" id="progress-pct">0%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar" id="progress-bar" data-target="{{ $pengajuan->progress_percent }}" style="width:0%"></div>
                </div>
            </div>

            <div class="log-section">
                <h2 class="log-title">📅 LOG AKTIVITAS</h2>
                @foreach($pengajuan->log as $log)
                <div class="activity-item done">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-name">{{ strtoupper($log->status_ke ?? 'UPDATE') }}</span>
                        </div>
                        <div class="activity-date">{{ $log->created_at?->format('d M Y, H:i') }}</div>
                        <div class="activity-desc">{{ $log->catatan }}</div>
                        @if($log->user)
                        <div class="activity-note">Oleh: {{ $log->user->name }} ({{ $log->actor_role }})</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
