@extends('layouts.app')
@section('title', 'Detail Pengajuan Dosen')
@section('head')
    @vite(['resources/css/detail-pengajuan-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('content')
<div class="detail-wrap" style="padding:24px;">
    <a href="{{ route('dosen.menunggu') }}" style="font-size:13px;color:#555;">← Kembali</a>

    <h1 style="font-size:28px;font-weight:900;margin:12px 0;">{{ $pengajuan->kode }} — {{ $pengajuan->jenis_label }}</h1>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
        <div class="detail-card" style="border:2px solid #111;padding:16px;">
            <h3>Profil Mahasiswa</h3>
            <p><strong>{{ $pengajuan->nama_mahasiswa }}</strong></p>
            <p>NIM: {{ $pengajuan->nim_mahasiswa }}</p>
            <p>Prodi: {{ $pengajuan->prodi_mahasiswa }}</p>
            <p>Semester: {{ $pengajuan->semester_mahasiswa }}</p>
        </div>
        <div class="detail-card" style="border:2px solid #111;padding:16px;">
            <h3>Detail Layanan</h3>
            <p>Keperluan: {{ $pengajuan->keperluan }}</p>
            <p>Tanggal: {{ $pengajuan->tanggal_submit?->format('d M Y, H:i') }}</p>
            <p>Status: <x-status-badge :pengajuan="$pengajuan" /></p>
        </div>
    </div>

    <div style="border:2px solid #111;padding:16px;margin-bottom:20px;">
        <h3>Lampiran Mahasiswa</h3>
        @forelse($pengajuan->dokumen as $doc)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #eee;">
            <span>{{ $doc->nama_file_asli }} ({{ $doc->nama_dokumen }})</span>
            <span>
                <a href="{{ route('dokumen.show', $doc) }}" target="_blank">Preview</a>
                <a href="{{ route('dokumen.download', $doc) }}" style="margin-left:8px;">Unduh</a>
            </span>
        </div>
        @empty
        <p>Tidak ada lampiran.</p>
        @endforelse
    </div>

    @if($pengajuan->tandaTangan)
    <div style="margin-bottom:20px;">
        <h3>Tanda Tangan Terupload</h3>
        <img src="{{ route('dosen.ttd.gambar', $pengajuan->tandaTangan) }}" alt="TTD" style="max-height:120px;border:1px solid #ccc;">
    </div>
    @endif

    @if($pengajuan->status === 'dosen_ttd' && !$pengajuan->tanggal_ttd)
    <div style="border:2px solid #a259e6;padding:20px;background:#faf5ff;">
        <h3>Insert Foto TTD</h3>
        <form method="POST" action="{{ route('dosen.ttd.store', $pengajuan) }}" enctype="multipart/form-data" style="display:grid;gap:10px;max-width:480px;">
            @csrf
            <input type="file" name="signature_file" accept=".jpg,.jpeg,.png" required>
            <textarea name="catatan" placeholder="Catatan (opsional)" rows="2"></textarea>
            <button type="submit" class="btn-approve" style="padding:10px;background:#a259e6;color:#fff;border:none;cursor:pointer;">Upload TTD & Setujui</button>
        </form>

        <form method="POST" action="{{ route('dosen.pengajuan.reject', $pengajuan) }}" style="margin-top:16px;max-width:480px;">
            @csrf
            <textarea name="catatan" placeholder="Alasan penolakan (wajib)" required rows="2" style="width:100%;margin-bottom:8px;"></textarea>
            <button type="submit" style="padding:10px;background:#e11d48;color:#fff;border:none;cursor:pointer;">Tolak Pengajuan</button>
        </form>
    </div>
    @elseif($pengajuan->tanggal_ttd)
    <p style="color:#0a7a0a;font-weight:700;">✓ Anda sudah menandatangani pengajuan ini pada {{ $pengajuan->tanggal_ttd->format('d M Y, H:i') }}.</p>
    @endif
</div>
@endsection
