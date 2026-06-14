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
                {{-- POINT 7: jam pengajuan real-time dari DB, tampilkan dengan format lengkap --}}
                <div class="tracking-box">
                    <div class="tbox-label">TANGGAL & JAM PENGAJUAN</div>
                    <div class="tbox-val" id="tgl-submit">
                        {{ $pengajuan->tanggal_submit?->format('d M Y, H:i:s') ?? '-' }}
                    </div>
                    <div style="font-size:12px;color:#888;margin-top:2px;">
                        {{ $pengajuan->tanggal_submit?->diffForHumans() ?? '' }}
                    </div>
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

            {{-- POINT 8: jika status selesai, tampilkan tombol unduh surat ber-TTD --}}
            @if($pengajuan->status === 'selesai' && $pengajuan->tandaTangan)
            <div style="margin:16px 0;padding:18px 20px;background:#f0fff4;border:2px solid #27AE60;border-radius:8px;">
                <div style="font-weight:700;color:#0a7a0a;font-size:15px;margin-bottom:8px;">
                    ✅ Pengajuan Selesai — Dokumen Siap Diunduh
                </div>
                <p style="font-size:13px;color:#555;margin-bottom:12px;">
                    Dokumen Anda telah ditandatangani oleh dosen pada
                    <strong>{{ $pengajuan->tanggal_ttd?->format('d M Y, H:i') }}</strong>.
                </p>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    {{-- Preview TTD --}}
                    <a href="{{ route('dosen.ttd.gambar', $pengajuan->tandaTangan) }}"
                       target="_blank"
                       style="padding:9px 18px;background:#27AE60;color:#fff;border-radius:6px;text-decoration:none;font-size:13px;font-weight:600;">
                        👁 Lihat Tanda Tangan Dosen
                    </a>
                    {{-- Unduh TTD --}}
                    <a href="{{ route('dosen.ttd.unduh', $pengajuan->tandaTangan) }}"
                       style="padding:9px 18px;background:#1565C0;color:#fff;border-radius:6px;text-decoration:none;font-size:13px;font-weight:600;">
                        ⬇ Unduh File TTD
                    </a>
                </div>
            </div>
            @elseif($pengajuan->status === 'selesai')
            <div style="margin:16px 0;padding:14px 18px;background:#f0fff4;border:2px solid #27AE60;border-radius:8px;">
                <div style="font-weight:700;color:#0a7a0a;">✅ Pengajuan Selesai</div>
                <p style="font-size:13px;color:#555;margin-top:4px;">
                    Dokumen Anda telah selesai diproses. Silakan hubungi admin untuk pengambilan.
                </p>
            </div>
            @endif

            {{-- Jika ditolak --}}
            @if($pengajuan->status === 'ditolak')
            <div style="margin:16px 0;padding:14px 18px;background:#fff6f6;border:2px solid #E53935;border-radius:8px;">
                <div style="font-weight:700;color:#a00;">❌ Pengajuan Ditolak</div>
                @if($pengajuan->catatan_penolakan)
                <p style="font-size:13px;color:#555;margin-top:6px;">
                    <strong>Alasan:</strong> {{ $pengajuan->catatan_penolakan }}
                </p>
                @endif
            </div>
            @endif

            <div class="log-section">
                <h2 class="log-title">📅 LOG AKTIVITAS</h2>
                @foreach($pengajuan->log as $log)
                <div class="activity-item done">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-name">{{ strtoupper($log->status_ke ?? 'UPDATE') }}</span>
                        </div>
                        {{-- POINT 7: tampilkan jam log lengkap dengan detik --}}
                        <div class="activity-date">{{ $log->created_at?->format('d M Y, H:i:s') }}</div>
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

@push('scripts')
<script>
    // Animasi progress bar
    document.addEventListener('DOMContentLoaded', function () {
        const bar    = document.getElementById('progress-bar');
        const pctEl  = document.getElementById('progress-pct');
        const target = parseInt(bar?.dataset.target ?? 0);

        if (!bar) return;

        let current = 0;
        const step  = target / 40;
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            bar.style.width = current + '%';
            if (pctEl) pctEl.textContent = Math.round(current) + '%';
            if (current >= target) clearInterval(timer);
        }, 20);
    });
</script>
@endpush
@endsection