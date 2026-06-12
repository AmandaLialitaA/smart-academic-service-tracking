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
        <span>2023/2024</span>
    </div>
</div>
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>
<div class="tracking-main">
    <p>Lacak status layanan akademik Anda secara real-time.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @forelse ($pengajuan as $item)
        @php
            $order = \App\Models\Pengajuan::STATUS_ORDER[$item->status] ?? 0;
            $progress = $item->status === 'ditolak' ? 100 : min(100, ($order / 4) * 100);
            $statusClass = in_array($item->status, ['selesai']) ? 'selesai'
                : ($item->status === 'ditolak' ? 'ditolak' : 'dalam-proses');
        @endphp
        <div class="tracking-info">
            <div class="tracking-box">
                <div style="font-weight:700;font-size:1.08rem;">ID PENGAJUAN</div>
                <div>{{ $item->kode }}</div>
            </div>
            <div class="tracking-box">
                <div style="font-weight:700;font-size:1.08rem;">JENIS LAYANAN</div>
                <div>{{ \App\Models\Pengajuan::JENIS_LABEL[$item->jenis_layanan] ?? $item->jenis_layanan }}</div>
            </div>
            <div class="tracking-box">
                <div style="font-weight:700;font-size:1.08rem;">STATUS TERAKHIR</div>
                <div><span class="status-badge {{ $statusClass }}">{{ \App\Models\Pengajuan::STATUS_LABEL[$item->status] ?? $item->status }}</span></div>
            </div>
        </div>

        <div class="tracking-progress">
            <div class="progress-label">PROGRES KESELURUHAN</div>
            <div class="progress-bar-bg">
                <div class="progress-bar" style="width:{{ $progress }}%; {{ $item->status === 'ditolak' ? 'background:#dc2626;' : '' }}"></div>
            </div>
        </div>

        <div class="log-activity">
            <h2>LOG AKTIVITAS</h2>
            <div class="activity-list">
                @foreach ($item->log as $log)
                    <div class="activity-item">
                        <div class="activity-status">{{ $log->status_ke === 'ditolak' ? '✕' : '✓' }}</div>
                        <div class="activity-content">
                            <div class="activity-title">
                                {{ \App\Models\Pengajuan::STATUS_LABEL[$log->status_ke] ?? $log->status_ke }}
                            </div>
                            <div class="activity-date">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</div>
                            @if ($log->catatan)
                                <div class="activity-note">
                                    <span style="color:#888;font-size:0.97em;">Catatan: "{{ $log->catatan }}"</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div style="margin-top:0;margin-bottom:30px;display:flex;gap:12px;">
            <a href="{{ route('mahasiswa.pengajuan.show', $item) }}" class="btn-primary" style="text-decoration:none;display:inline-block;text-align:center;">LIHAT DETAIL</a>
        </div>
        <hr style="border:none;border-top:2px dashed #e0e0e0;margin-bottom:30px;">
    @empty
        <div class="info-panel">
            <h3>BELUM ADA PENGAJUAN</h3>
            <div>Anda belum memiliki pengajuan layanan akademik. Silakan ajukan layanan baru pada menu "Ajukan Layanan".</div>
        </div>
    @endforelse

    <div class="tracking-info" style="margin-top:0;">
        <div class="info-panel" style="max-width:350px;">
            <h3>LOKASI PENGAMBILAN</h3>
            <div>Layanan dilakukan di loket resmi Biro Administrasi Akademik (BAA) Universitas Muhammadiyah Surakarta.<br><br><b>LOKET PELAYANAN:</b><br>Gedung Siti Walidah, Lantai 2<br>Jam Operasional: 08.00 - 15.00 WIB</div>
        </div>
        <div class="info-panel" style="max-width:350px;">
            <h3>PENTING</h3>
            <div class="important">Bawa Kartu Tanda Mahasiswa KTM asli saat pengambilan.<br>Pengambilan tidak dapat diwakilkan kecuali dengan surat kuasa.<br>Pastikan data pada dokumen digital sudah sesuai sebelum dicetak.</div>
        </div>
    </div>
</div>
@endsection