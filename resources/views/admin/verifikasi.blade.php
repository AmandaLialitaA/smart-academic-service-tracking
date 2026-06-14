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
            <p>Tanggal: {{ $pengajuan->tanggal_submit?->format('d M Y, H:i:s') }}</p>
            @if($pengajuan->catatan_mahasiswa)
            <p style="margin-top:8px;padding:8px;background:#f5f5f5;border-left:3px solid #a259e6;font-size:13px;">
                <strong>Catatan Mahasiswa:</strong> {{ $pengajuan->catatan_mahasiswa }}
            </p>
            @endif
            <p style="margin-top:8px;">Status: <x-status-badge :pengajuan="$pengajuan" /></p>
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

    @if($pengajuan->tandaTangan)
    <div style="margin-top:20px;border:2px solid #27AE60;padding:16px;background:#f0fff4;">
        <h3 style="color:#0a7a0a;">✅ Tanda Tangan Dosen</h3>
        <p style="font-size:13px;color:#555;margin-bottom:10px;">
            Ditandatangani oleh <strong>{{ $pengajuan->dosen?->name }}</strong>
            pada {{ $pengajuan->tandaTangan->ditandatangani_pada?->format('d M Y, H:i') }}
        </p>
        <img src="{{ route('dosen.ttd.gambar', $pengajuan->tandaTangan) }}"
             alt="TTD Dosen"
             style="max-height:100px;border:1px solid #ccc;background:#fff;padding:4px;border-radius:4px;">
        <div style="margin-top:10px;display:flex;gap:10px;">
            <a href="{{ route('admin.ttd.unduh', $pengajuan->tandaTangan) }}"
               style="padding:8px 14px;background:#1565C0;color:#fff;border-radius:4px;text-decoration:none;font-size:13px;">
                ⬇ Unduh TTD
            </a>
        </div>
    </div>
    @endif

    @if($pengajuan->status === 'submitted')
    <div style="margin-top:20px;border:2px solid #111;padding:16px;">
        <h3>Verifikasi Admin</h3>
        <form method="POST" action="{{ route('admin.verifikasi.setuju', $pengajuan) }}" style="margin-bottom:12px;">
            @csrf
            <textarea name="catatan" placeholder="Catatan verifikasi (opsional)" rows="2" style="width:100%;margin-bottom:8px;padding:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#27AE60;color:#fff;border:none;cursor:pointer;border-radius:4px;">
                ✅ Setuju — Verifikasi Dokumen
            </button>
        </form>
        <form method="POST" action="{{ route('admin.verifikasi.tolak', $pengajuan) }}">
            @csrf
            <textarea name="catatan" placeholder="Alasan penolakan (wajib)" required rows="2" style="width:100%;margin-bottom:8px;padding:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#E53935;color:#fff;border:none;cursor:pointer;border-radius:4px;">
                ❌ Tidak Setuju — Tolak
            </button>
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
            <textarea name="catatan" placeholder="Catatan untuk dosen (opsional)" rows="2" style="width:100%;margin-bottom:8px;padding:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#a259e6;color:#fff;border:none;cursor:pointer;border-radius:4px;">
                📤 Teruskan ke Dosen
            </button>
        </form>
    </div>
    @endif

    @if($pengajuan->status === 'dosen_ttd' && $pengajuan->tanggal_ttd)
    <div style="margin-top:20px;border:2px solid #111;padding:16px;">
        <h3>Checklist Selesai</h3>
        <p>Dosen sudah TTD pada <strong>{{ $pengajuan->tanggal_ttd->format('d M Y, H:i') }}</strong>.</p>
        <form method="POST" action="{{ route('admin.pengajuan.selesai', $pengajuan) }}" style="margin-top:12px;">
            @csrf
            <textarea name="catatan" placeholder="Catatan selesai (opsional)" rows="2" style="width:100%;margin-bottom:8px;padding:8px;"></textarea>
            <button type="submit" style="padding:10px 20px;background:#27AE60;color:#fff;border:none;cursor:pointer;border-radius:4px;">
                ✅ Tandai Selesai
            </button>
        </form>
    </div>
    @elseif($pengajuan->status === 'dosen_ttd' && !$pengajuan->tanggal_ttd)
    <div style="margin-top:20px;border:2px solid #f59e0b;padding:16px;background:#fffbeb;">
        <p style="color:#92400e;">⏳ Menunggu dosen menandatangani...</p>
    </div>
    @endif

    @if($pengajuan->log->count())
    <div style="margin-top:24px;border:1px solid #ddd;padding:16px;border-radius:6px;">
        <h3 style="margin-bottom:12px;">📅 Log Aktivitas</h3>
        @foreach($pengajuan->log as $log)
        <div style="padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px;">
            <div style="font-weight:600;color:#333;">{{ strtoupper($log->status_ke ?? '-') }}</div>
            <div style="color:#888;font-size:12px;">{{ $log->created_at?->format('d M Y, H:i:s') }}</div>
            <div style="color:#555;margin-top:2px;">{{ $log->catatan }}</div>
            @if($log->user)
            <div style="color:#999;font-size:11px;margin-top:1px;">Oleh: {{ $log->user->name }} ({{ $log->actor_role }})</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection