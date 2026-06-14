@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('head')
    @vite(['resources/css/pengajuan.css', 'resources/css/tracking.css', 'resources/js/realtime.js'])
    <style>
    .detail-wrap { font-family: 'Barlow', sans-serif; padding: 28px 36px 0; max-width: 900px; }
    .detail-back { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #555; text-decoration: none; margin-bottom: 10px; }
    .detail-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 18px; gap: 16px; flex-wrap: wrap; }
    .detail-title { font-family: 'Barlow Condensed', sans-serif; font-size: 34px; font-weight: 900; font-style: italic; text-transform: uppercase; color: #111; }
    .detail-section { border: 2.5px solid #111; background: white; margin-bottom: 18px; }
    .detail-section-header { padding: 13px 18px; border-bottom: 2.5px solid #111; font-weight: 900; text-transform: uppercase; }
    .detail-section-header.purple { background: #EDD6FF; }
    .detail-section-header.teal { background: #CCEFEF; }
    .detail-section-header.yellow { background: #FFF3CC; }
    .detail-section-body { padding: 20px 18px; }
    .detail-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .detail-item-label { font-size: 10px; font-weight: 800; text-transform: uppercase; color: #888; margin-bottom: 4px; display: block; }
    .detail-item-value { font-size: 14px; font-weight: 700; color: #111; }
    .lampiran-list { display: flex; flex-direction: column; gap: 10px; }
    .lampiran-item { display: flex; align-items: center; gap: 12px; border: 1.5px solid #DDD; padding: 12px 14px; background: #FAFAFA; }
    .lampiran-info { flex: 1; }
    .lampiran-name { font-size: 13px; font-weight: 700; }
    .lampiran-meta { font-size: 11.5px; color: #888; }
    .lampiran-btn { padding: 6px 12px; border: 1.5px solid #333; background: white; font-size: 12px; font-weight: 600; text-decoration: none; color: #222; margin-left: 6px; }
    .catatan-box { border: 1.5px dashed #BBB; padding: 14px 16px; background: #FAFAFA; font-size: 13px; line-height: 1.6; }
    </style>
@endsection

@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection

@section('content')
<div class="detail-wrap">
    <a href="{{ route('mahasiswa.riwayat') }}" class="detail-back">← Kembali ke Riwayat</a>

    <div class="detail-header">
        <div>
            <span class="detail-item-label">ID Pengajuan: {{ $pengajuan->kode }}</span>
            <h1 class="detail-title">{{ $pengajuan->jenis_label }}</h1>
        </div>
        <x-status-badge :pengajuan="$pengajuan" />
    </div>

    <div class="detail-section">
        <div class="detail-section-header purple">Data Pengajuan</div>
        <div class="detail-section-body">
            <div class="detail-grid-2">
                <div><span class="detail-item-label">Jenis Layanan</span><span class="detail-item-value">{{ $pengajuan->jenis_label }}</span></div>
                <div><span class="detail-item-label">Tanggal Diajukan</span><span class="detail-item-value">
                    @if($pengajuan->tanggal_submit)
                    <span class="live-dt-short" data-at="{{ $pengajuan->tanggal_submit->toIso8601String() }}"></span>
                    <br>
                    <span class="live-ago" data-at="{{ $pengajuan->tanggal_submit->toIso8601String() }}" style="font-size:11px;color:#888;"></span>
                    @else
                    -
                    @endif
                </span></div>
                <div><span class="detail-item-label">Keperluan</span><span class="detail-item-value">{{ $pengajuan->keperluan }}</span></div>
                <div><span class="detail-item-label">Dosen/Staf Penanggung Jawab</span><span class="detail-item-value">{{ $pengajuan->dosen?->name ?? 'Menunggu penugasan' }}</span></div>
                <div><span class="detail-item-label">Program Studi</span><span class="detail-item-value">{{ $pengajuan->prodi_mahasiswa }}</span></div>
                <div><span class="detail-item-label">NIM</span><span class="detail-item-value">{{ $pengajuan->nim_mahasiswa }}</span></div>
                <div><span class="detail-item-label">Semester</span><span class="detail-item-value">{{ $pengajuan->semester_mahasiswa ?? '-' }}</span></div>
                <div><span class="detail-item-label">Status Internal</span><span class="detail-item-value">{{ \App\Models\Pengajuan::STATUS_LABEL[$pengajuan->status] ?? $pengajuan->status }}</span></div>
                <div><span class="detail-item-label">Catatan Mahasiswa</span><span class="detail-item-value">{{ $pengajuan->catatan_mahasiswa ?? '-' }}</span></div>
            </div>
        </div>
    </div>

    <div class="detail-section">
        <div class="detail-section-header teal">Lampiran Dokumen</div>
        <div class="detail-section-body">
            <div class="lampiran-list">
                @forelse($pengajuan->dokumen as $doc)
                <div class="lampiran-item">
                    <div class="lampiran-info">
                        <div class="lampiran-name">{{ $doc->nama_file_asli }}</div>
                        <div class="lampiran-meta">{{ $doc->nama_dokumen }} · {{ $doc->ukuran_format }} · {{ $doc->created_at?->format('d M Y') }}</div>
                    </div>
                    <a href="{{ route('dokumen.show', $doc) }}" class="lampiran-btn" target="_blank">Preview</a>
                    <a href="{{ route('dokumen.download', $doc) }}" class="lampiran-btn">Unduh</a>
                </div>
                @empty
                <p style="color:#888;">Tidak ada lampiran.</p>
                @endforelse
            </div>
        </div>
    </div>

    @if($pengajuan->catatan_penolakan)
    <div class="detail-section">
        <div class="detail-section-header yellow">Catatan Penolakan</div>
        <div class="detail-section-body"><div class="catatan-box">{{ $pengajuan->catatan_penolakan }}</div></div>
    </div>
    @endif

    <div class="form-actions" style="margin-top:16px;display:flex;gap:10px;">
        <a href="{{ route('mahasiswa.riwayat') }}" class="btn-batal">Kembali</a>
        <a href="{{ route('mahasiswa.tracking', $pengajuan) }}" class="btn-kirim">Lihat Tracking Status</a>
    </div>
</div>
@endsection
