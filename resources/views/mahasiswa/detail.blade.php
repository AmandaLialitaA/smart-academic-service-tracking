@extends('layouts.app')
@section('title', 'Detail Pengajuan')
@section('head')
    @vite(['resources/css/detail-mahasiswa.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>DETAIL PENGAJUAN</h1>
    <div class="user-info">
        <span>Universitas Muhammadiyah Surakarta</span>
        <span>2023/2024</span>
    </div>
</div>
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>
<div class="detail-main">
    <p>Rincian lengkap data pengajuan yang telah Anda kirimkan, beserta lampiran dokumen dan riwayat proses.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="detail-header">
        <div>
            <div class="kode">{{ $pengajuan->kode }}</div>
            <div class="jenis">{{ \App\Models\Pengajuan::JENIS_LABEL[$pengajuan->jenis_layanan] ?? $pengajuan->jenis_layanan }}</div>
        </div>
        <span class="status-badge {{ $pengajuan->status }}">
            {{ \App\Models\Pengajuan::STATUS_LABEL[$pengajuan->status] ?? $pengajuan->status }}
        </span>
    </div>

    <div class="detail-card">
        <h2>Data Pengajuan</h2>
        <div class="detail-grid">
            <div class="detail-item">
                <label>Nama Lengkap</label>
                <div class="value">{{ $pengajuan->nama_mahasiswa }}</div>
            </div>
            <div class="detail-item">
                <label>NIM</label>
                <div class="value">{{ $pengajuan->nim_mahasiswa }}</div>
            </div>
            <div class="detail-item">
                <label>Program Studi</label>
                <div class="value">{{ $pengajuan->prodi_mahasiswa }}</div>
            </div>
            <div class="detail-item">
                <label>Semester</label>
                <div class="value">{{ $pengajuan->semester_mahasiswa }}</div>
            </div>
            <div class="detail-item">
                <label>Tanggal Pengajuan</label>
                <div class="value">{{ optional($pengajuan->tanggal_submit)->translatedFormat('d F Y, H:i') }} WIB</div>
            </div>
            <div class="detail-item">
                <label>Dosen Penanggung Jawab</label>
                <div class="value">{{ $pengajuan->dosen->name ?? '-' }}</div>
            </div>
            <div class="detail-item full">
                <label>Keperluan</label>
                <div class="value">{{ $pengajuan->keperluan }}</div>
            </div>
            @if ($pengajuan->status === 'ditolak' && $pengajuan->catatan_penolakan)
                <div class="detail-item full">
                    <label>Alasan Penolakan</label>
                    <div class="value">{{ $pengajuan->catatan_penolakan }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <h2>Lampiran Dokumen</h2>
        <div class="dokumen-list">
            @forelse ($pengajuan->dokumen as $dok)
                <div class="dokumen-item">
                    <div class="dokumen-info">
                        <div class="nama">{{ $dok->nama_dokumen }}</div>
                        <div class="meta">{{ $dok->nama_file_asli }} &middot; {{ $dok->ukuran_format }}</div>
                    </div>
                    <a href="{{ route('dokumen.show', $dok) }}" target="_blank" class="btn-view">Lihat File</a>
                </div>
            @empty
                <p>Tidak ada dokumen yang dilampirkan.</p>
            @endforelse
        </div>
    </div>

    <div class="detail-card">
        <h2>Riwayat Proses</h2>
        <div class="log-list">
            @forelse ($pengajuan->log as $item)
                <div class="log-item">
                    <div class="log-title">{{ \App\Models\Pengajuan::STATUS_LABEL[$item->status_ke] ?? $item->status_ke }}</div>
                    <div class="log-date">{{ $item->created_at->translatedFormat('d F Y, H:i') }} WIB &middot; oleh {{ $item->user->name ?? 'Sistem' }}</div>
                    @if ($item->catatan)
                        <div class="log-note">{{ $item->catatan }}</div>
                    @endif
                </div>
            @empty
                <p>Belum ada riwayat proses.</p>
            @endforelse
        </div>
    </div>

    <div class="detail-actions">
        <a href="{{ route('mahasiswa.tracking') }}" class="btn-secondary">Kembali ke Riwayat</a>
    </div>
</div>
@endsection