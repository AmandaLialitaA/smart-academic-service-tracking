{{-- resources/views/mahasiswa/tracking.blade.php --}}
@extends('layouts.app')
@section('title', 'Tracking Pengajuan')
@section('head')
    @vite(['resources/css/tracking.css', 'resources/js/realtime.js'])
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
                    <div class="tbox-val">
                        <x-status-badge :pengajuan="$pengajuan" />
                    </div>
                </div>

                {{-- Jam pengajuan — diformat JS supaya sama dengan topbar --}}
                <div class="tracking-box">
                    <div class="tbox-label">TANGGAL &amp; JAM PENGAJUAN</div>
                    <div class="tbox-val">
                        {{--
                            PENTING: tidak ada teks PHP di sini.
                            data-at berisi ISO string dari server.
                            JS (realtime.js) yang format jam ini,
                            pakai fungsi fmtDatetime() yang SAMA dengan topbar.
                            Hasilnya: "14 Jun 2026, 14:45:41\n3 menit yang lalu"
                        --}}
                        <span class="live-elapsed"
                              data-at="{{ $pengajuan->tanggal_submit?->toIso8601String() }}">
                        </span>
                    </div>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="tracking-progress-box">
                <div class="progress-row">
                    <span class="progress-label">PROGRES KESELURUHAN</span>
                    <span class="progress-pct" id="progress-pct">0%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar"
                         id="progress-bar"
                         data-target="{{ $pengajuan->progress_percent ?? 0 }}"
                         style="width:0%">
                    </div>
                </div>
            </div>

            {{-- Selesai --}}
            @if($pengajuan->status === 'selesai' && $pengajuan->tandaTangan)
            <div style="margin:16px 0;padding:18px 20px;background:#f0fff4;border:2px solid #27AE60;">
                <div style="font-weight:800;color:#0a7a0a;font-size:14px;margin-bottom:8px;">
                    ✅ Pengajuan Selesai — Dokumen Siap Diunduh
                </div>
                <p style="font-size:13px;color:#555;margin-bottom:12px;">
                    Dokumen ditandatangani dosen pada
                    {{-- jam TTD juga diformat JS --}}
                    <strong>
                        <span class="live-dt"
                              data-at="{{ $pengajuan->tanggal_ttd?->toIso8601String() }}">
                        </span>
                    </strong>
                </p>
                <a href="{{ route('mahasiswa.ttd.unduh', $pengajuan->tandaTangan) }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#1565C0;color:#fff;text-decoration:none;font-size:13px;font-weight:700;">
                    ⬇ Unduh File TTD
                </a>
            </div>
            @elseif($pengajuan->status === 'selesai')
            <div style="margin:16px 0;padding:14px 18px;background:#f0fff4;border:2px solid #27AE60;">
                <div style="font-weight:700;color:#0a7a0a;">✅ Pengajuan Selesai</div>
                <p style="font-size:13px;color:#555;margin-top:4px;">Silakan hubungi admin untuk pengambilan dokumen.</p>
            </div>
            @endif

            {{-- Ditolak --}}
            @if($pengajuan->status === 'ditolak')
            <div style="margin:16px 0;padding:14px 18px;background:#fff6f6;border:2px solid #E53935;">
                <div style="font-weight:700;color:#a00;">❌ Pengajuan Ditolak</div>
                @if($pengajuan->catatan_penolakan)
                <p style="font-size:13px;color:#555;margin-top:6px;">
                    <strong>Alasan:</strong> {{ $pengajuan->catatan_penolakan }}
                </p>
                @endif
            </div>
            @endif

            {{-- LOG AKTIVITAS --}}
            <div class="log-section">
                <h2 class="log-title">📅 LOG AKTIVITAS</h2>

                @forelse($pengajuan->log->sortBy('created_at') as $log)
                <div class="activity-item done">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-name">{{ strtoupper($log->status_ke ?? 'UPDATE') }}</span>
                        </div>

                        {{--
                            PENTING: tidak ada teks jam dari PHP di sini.
                            .live-log + data-at → JS isi .log-dt dan .log-ago
                            hasilnya sinkron dengan jam topbar karena
                            pakai fmtDatetime() yang sama.
                        --}}
                        <div class="activity-date live-log"
                             data-at="{{ $log->created_at?->toIso8601String() }}">
                            <span class="log-dt" style="font-size:13px;"></span>
                            <span class="log-ago" style="font-size:11.5px;color:#999;margin-left:6px;"></span>
                        </div>

                        <div class="activity-desc">{{ $log->catatan }}</div>

                        @if($log->user)
                        <div class="activity-note">
                            Oleh: {{ ucfirst($log->actor_role ?? 'sistem') }}
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <p style="font-size:13px;color:#888;padding:12px 0;">Belum ada aktivitas tercatat.</p>
                @endforelse
            </div>

        </div>

        <div class="tracking-right">
            <div class="info-card info-card--teal">
                <div class="info-card-title">⚠️ PENTING!</div>
                <ul class="penting-list">
                    <li>Bawa KTM asli saat pengambilan.</li>
                    <li>Pengambilan tidak bisa diwakilkan kecuali dengan surat kuasa.</li>
                    <li>Pastikan data dokumen digital sudah sesuai sebelum dicetak.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<footer class="dashboard-footer">
    &copy; 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
</footer>
@endsection