@extends('layouts.app')
@section('title', 'Verifikasi Dokumen')
@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-admin')
@endsection
@section('content')
<div class="verifikasi-wrap" style="padding:24px;">
    <a href="{{ route('admin.verifikasi') }}" style="font-size:13px;">← Kembali ke Antrian</a>
    <h1 class="page-title" style="margin-top:12px;">Verifikasi: {{ $pengajuan->kode }}</h1>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px;">
        <div style="border:2px solid #111;padding:16px;">
            <h3>Data Mahasiswa</h3>
            <p><strong>{{ $pengajuan->nama_mahasiswa }}</strong> ({{ $pengajuan->nim_mahasiswa }})</p>
            <p>Prodi: {{ $pengajuan->prodi_mahasiswa }}</p>
            <p>Jenis: {{ $pengajuan->jenis_label }}</p>
            <p>Keperluan: {{ $pengajuan->keperluan }}</p>
            <p>Tanggal: {{ $pengajuan->tanggal_submit?->format('d M Y, H:i') }}</p>
            <p>Status: <x-status-badge :pengajuan="$pengajuan" /></p>
        </div>

        <div style="border:2px solid #111;padding:16px;">
            <h3>Lampiran Mahasiswa</h3>
            @forelse($pengajuan->dokumen as $doc)
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;">
                <span>{{ $doc->nama_file_asli }}</span>
                <span>
                    <a href="{{ route('dokumen.show', $doc) }}" target="_blank">Preview</a>
                    <a href="{{ route('dokumen.download', $doc) }}" style="margin-left:8px;">Unduh</a>
                </span>
            </div>
            @empty
            <p>Tidak ada lampiran.</p>
            @endforelse
        </div>
    </div>

    @if($pengajuan->status === 'submitted')
    <div style="margin-top:20px;border:2px solid #111;padding:16px;">
        <h3>Verifikasi Admin</h3>
        <form method="POST" action="{{ route('admin.verifikasi.setuju', $pengajuan) }}" style="margin-bottom:12px;">
            @csrf
            <textarea name="catatan" placeholder="Catatan verifikasi (opsional)" rows="2" style="width:100%;margin-bottom:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#27AE60;color:#fff;border:none;cursor:pointer;">Setuju — Verifikasi Dokumen</button>
        </form>
        <form method="POST" action="{{ route('admin.verifikasi.tolak', $pengajuan) }}">
            @csrf
            <textarea name="catatan" placeholder="Alasan penolakan (wajib)" required rows="2" style="width:100%;margin-bottom:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#E53935;color:#fff;border:none;cursor:pointer;">Tidak Setuju — Tolak</button>
        </form>
    </div>
    @endif

    @if($pengajuan->status === 'admin_verifikasi')
    <div style="margin-top:20px;border:2px solid #a259e6;padding:16px;background:#faf5ff;">
        <h3>Teruskan ke Dosen untuk TTD</h3>
        <form method="POST" action="{{ route('admin.pengajuan.teruskan', $pengajuan) }}">
            @csrf
            <select name="dosen_id" required style="width:100%;padding:8px;margin-bottom:8px;">
                <option value="">-- Pilih Dosen --</option>
                @foreach($daftarDosen as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
            <textarea name="catatan" placeholder="Catatan untuk dosen (opsional)" rows="2" style="width:100%;margin-bottom:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#a259e6;color:#fff;border:none;cursor:pointer;">Teruskan ke Dosen</button>
        </form>
        <form method="POST" action="{{ route('admin.verifikasi.tolak', $pengajuan) }}" style="margin-top:12px;">
            @csrf
            <textarea name="catatan" placeholder="Alasan penolakan" required rows="2" style="width:100%;margin-bottom:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#E53935;color:#fff;border:none;cursor:pointer;">Tolak Pengajuan</button>
        </form>
    </div>
    @endif

    @if($pengajuan->status === 'dosen_ttd' && $pengajuan->tanggal_ttd)
    <div style="margin-top:20px;border:2px solid #111;padding:16px;">
        <h3>Checklist Selesai</h3>
        <p>Dosen sudah TTD pada {{ $pengajuan->tanggal_ttd->format('d M Y, H:i') }}.</p>
        <form method="POST" action="{{ route('admin.pengajuan.selesai', $pengajuan) }}">
            @csrf
            <textarea name="catatan" placeholder="Catatan selesai (opsional)" rows="2" style="width:100%;margin-bottom:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#27AE60;color:#fff;border:none;cursor:pointer;">Tandai Selesai — Siap Diambil</button>
        </form>
    </div>
    @endif
</div>
@endsection
