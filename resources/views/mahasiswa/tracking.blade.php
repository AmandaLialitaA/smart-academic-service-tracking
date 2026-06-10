@extends('layouts.app')
@section('title', 'Tracking Pengajuan')
@section('head')
    @vite(['resources/css/tracking.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>TRACKING PENGAJUAN</h1>
    <div class="user-info">
        <span>Universitas Muhammadiyah Surakarta</span>
        <span>{{ auth()->user()->prodi ?? '' }}</span>
    </div>
</div>
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>
<div class="tracking-main">
    <p>Lacak status layanan akademik Anda secara real-time.</p>

    @if($pengajuan->isEmpty())
        <div style="text-align:center;padding:3rem;color:#6b7280;">
            <p style="font-size:1.1rem;">Belum ada pengajuan.</p>
            <a href="{{ route('mahasiswa.pengajuan') }}"
               style="display:inline-block;margin-top:12px;padding:10px 24px;background:#a259e6;color:#fff;border-radius:8px;text-decoration:none;">
                Ajukan Layanan Sekarang →
            </a>
        </div>
    @else
        @foreach($pengajuan as $p)
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:24px;">

            {{-- Info pengajuan --}}
            <div class="tracking-info">
                <div class="tracking-box">
                    <div style="font-weight:700;font-size:1.08rem;">ID PENGAJUAN</div>
                    <div>{{ $p->kode }}</div>
                </div>
                <div class="tracking-box">
                    <div style="font-weight:700;font-size:1.08rem;">JENIS LAYANAN</div>
                    <div>{{ \App\Models\Pengajuan::JENIS_LABEL[$p->jenis_layanan] ?? $p->jenis_layanan }}</div>
                </div>
                <div class="tracking-box">
                    <div style="font-weight:700;font-size:1.08rem;">STATUS TERAKHIR</div>
                    <div>
                        <span class="status-badge {{ $p->status === 'selesai' ? 'selesai' : ($p->status === 'ditolak' ? 'ditolak' : 'dalam-proses') }}">
                            {{ \App\Models\Pengajuan::STATUS_LABEL[$p->status] ?? $p->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Progress bar --}}
            @php
                $progress = match($p->status) {
                    'submitted'        => 25,
                    'admin_verifikasi' => 50,
                    'dosen_ttd'        => 75,
                    'selesai'          => 100,
                    'ditolak'          => 100,
                    default            => 0,
                };
            @endphp
            <div class="tracking-progress" style="margin-top:16px;">
                <div class="progress-label">PROGRES KESELURUHAN</div>
                <div class="progress-bar-bg">
                    <div class="progress-bar"
                         style="width:{{ $progress }}%;background:{{ $p->status === 'ditolak' ? '#ef4444' : '#a259e6' }};"></div>
                </div>
            </div>

            {{-- Log aktivitas --}}
            @if($p->log->isNotEmpty())
            <div class="log-activity" style="margin-top:16px;">
                <h2>LOG AKTIVITAS</h2>
                <div class="activity-list">
                    @foreach($p->log as $log)
                    <div class="activity-item">
                        <div class="activity-status"
                             style="{{ $log->status_ke === 'ditolak' ? 'background:#fee2e2;color:#ef4444;border-color:#ef4444;' : '' }}">
                            ✓
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">
                                {{ \App\Models\Pengajuan::STATUS_LABEL[$log->status_ke] ?? strtoupper($log->status_ke) }}
                                <span class="status-badge selesai">SELESAI</span>
                            </div>
                            <div class="activity-date">
                                {{ $log->created_at->format('d M Y, H:i') }} WIB
                                — oleh {{ $log->user->name ?? 'Sistem' }}
                            </div>
                            @if($log->catatan)
                            <div class="activity-note">
                                <span style="color:#888;font-size:0.97em;">{{ $log->catatan }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
        @endforeach
    @endif
</div>
@endsection