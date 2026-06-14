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

    @if(session('success'))
        <div style="background:#f0fff0;border:2px solid #27AE60;padding:12px 16px;margin-bottom:14px;color:#0a7a0a;font-weight:600;border-radius:6px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fff6f6;border:2px solid #E53935;padding:12px 16px;margin-bottom:14px;color:#a00;font-weight:600;border-radius:6px;">
            {{ session('error') }}
        </div>
    @endif

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
            {{-- POINT 6: tampilkan catatan opsional dari mahasiswa --}}
            @if($pengajuan->catatan_mahasiswa)
            <p style="margin-top:8px;padding:8px;background:#f5f5f5;border-left:3px solid #a259e6;font-size:13px;">
                <strong>Catatan Mahasiswa:</strong> {{ $pengajuan->catatan_mahasiswa }}
            </p>
            @endif
            <p style="margin-top:8px;">Tanggal: {{ $pengajuan->tanggal_submit?->format('d M Y, H:i') }}</p>
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

    {{-- POINT 1: TTD sudah ada — tampilkan + unduh --}}
    @if($pengajuan->tandaTangan)
    <div style="margin-bottom:20px;border:2px solid #27AE60;padding:16px;background:#f0fff4;border-radius:6px;">
        <h3 style="color:#0a7a0a;">✅ Tanda Tangan Anda</h3>
        <p style="font-size:13px;color:#555;margin-bottom:10px;">
            Ditandatangani pada {{ $pengajuan->tandaTangan->ditandatangani_pada?->format('d M Y, H:i') }}
        </p>
        <img src="{{ route('dosen.ttd.gambar', $pengajuan->tandaTangan) }}"
             alt="TTD"
             style="max-height:100px;border:1px solid #ccc;background:#fff;padding:4px;border-radius:4px;">
        <div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('dosen.ttd.gambar', $pengajuan->tandaTangan) }}"
               target="_blank"
               style="padding:7px 14px;background:#27AE60;color:#fff;border-radius:4px;text-decoration:none;font-size:13px;">
                👁 Lihat TTD
            </a>
            {{-- POINT 1: tombol unduh file TTD --}}
            <a href="{{ route('dosen.ttd.unduh', $pengajuan->tandaTangan) }}"
               style="padding:7px 14px;background:#1565C0;color:#fff;border-radius:4px;text-decoration:none;font-size:13px;">
                ⬇ Unduh TTD
            </a>
        </div>
    </div>
    @endif

    {{-- POINT 1 & 4: form TTD dan penolakan — hanya muncul jika belum TTD dan status dosen_ttd --}}
    @if($pengajuan->status === 'dosen_ttd' && !$pengajuan->tanggal_ttd)
    <div style="border:2px solid #a259e6;padding:20px;background:#faf5ff;border-radius:6px;margin-bottom:20px;">
        <h3>Tanda Tangan Pengajuan</h3>
        <p style="font-size:13px;color:#555;margin-bottom:12px;">
            Upload foto tanda tangan Anda (JPG/PNG). Tanda tangan akan disimpan sebagai dokumen resmi.
        </p>

        {{-- POINT 1: upload file TTD --}}
        <form method="POST" action="{{ route('dosen.ttd.store', $pengajuan) }}" enctype="multipart/form-data" style="display:grid;gap:10px;max-width:480px;">
            @csrf
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:4px;">
                    Upload Foto Tanda Tangan <span style="color:#E53935;">*</span>
                </label>
                <input type="file" name="signature_file" accept=".jpg,.jpeg,.png" required
                       style="border:1px solid #ccc;padding:6px;width:100%;border-radius:4px;">
                <span style="font-size:11px;color:#888;">Format JPG atau PNG. Maks. 5MB.</span>
            </div>
            <div>
                <label style="font-size:13px;font-weight:600;display:block;margin-bottom:4px;">
                    Catatan (Opsional)
                </label>
                <textarea name="catatan" placeholder="Catatan persetujuan (opsional)" rows="2"
                          style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;font-size:13px;"></textarea>
            </div>
            <button type="submit"
                    style="padding:10px;background:#a259e6;color:#fff;border:none;cursor:pointer;border-radius:4px;font-weight:600;">
                ✅ Upload TTD & Setujui
            </button>
        </form>

        <div style="margin-top:4px;font-size:12px;color:#888;">
            Ingin tanda tangan di canvas?
            <a href="{{ route('dosen.ttd.show', $pengajuan) }}" style="color:#a259e6;font-weight:600;">Buka Canvas TTD →</a>
        </div>
    </div>

    {{-- POINT 4 FIX: form tolak dosen — route menuju dosen.pengajuan.reject --}}
    <div style="border:2px solid #E53935;padding:16px;background:#fff6f6;border-radius:6px;">
        <h3 style="color:#a00;">Tolak Pengajuan</h3>
        <p style="font-size:13px;color:#555;margin-bottom:8px;">
            Jika ada kekurangan dokumen atau alasan lain, tolak pengajuan ini.
        </p>
        <form method="POST" action="{{ route('dosen.pengajuan.reject', $pengajuan) }}" style="max-width:480px;">
            @csrf
            <textarea name="catatan" placeholder="Alasan penolakan (wajib, min. 5 karakter)" required
                      rows="3"
                      style="width:100%;margin-bottom:8px;padding:8px;border:1px solid #E53935;border-radius:4px;font-size:13px;"></textarea>
            <button type="submit"
                    style="padding:10px 20px;background:#e11d48;color:#fff;border:none;cursor:pointer;border-radius:4px;font-weight:600;"
                    onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                ❌ Tolak Pengajuan
            </button>
        </form>
    </div>

    @elseif($pengajuan->tanggal_ttd && $pengajuan->status !== 'ditolak')
    <div style="padding:14px;background:#f0fff4;border:2px solid #27AE60;border-radius:6px;">
        <p style="color:#0a7a0a;font-weight:700;">
            ✅ Anda sudah menandatangani pengajuan ini pada {{ $pengajuan->tanggal_ttd->format('d M Y, H:i') }}.
        </p>
        <p style="font-size:13px;color:#555;margin-top:4px;">Menunggu checklist selesai dari Admin.</p>
    </div>

    @elseif($pengajuan->status === 'selesai')
    <div style="padding:14px;background:#f0fff4;border:2px solid #27AE60;border-radius:6px;">
        <p style="color:#0a7a0a;font-weight:700;">✅ Pengajuan ini telah Selesai diproses.</p>
    </div>

    @elseif($pengajuan->status === 'ditolak')
    <div style="padding:14px;background:#fff6f6;border:2px solid #E53935;border-radius:6px;">
        <p style="color:#a00;font-weight:700;">❌ Pengajuan ini telah Ditolak.</p>
        @if($pengajuan->catatan_penolakan)
        <p style="font-size:13px;color:#555;margin-top:4px;"><strong>Alasan:</strong> {{ $pengajuan->catatan_penolakan }}</p>
        @endif
    </div>
    @endif
</div>
@endsection