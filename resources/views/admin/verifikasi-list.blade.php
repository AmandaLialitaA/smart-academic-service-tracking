@extends('layouts.app')
@section('title', 'Antrian Verifikasi')
@section('head')
    @vite(['resources/css/dashboard-admin.css', 'resources/js/realtime.js'])
@endsection
@section('sidebar')
    @include('components.sidebar-admin')
@endsection
@section('content')
<div class="da-wrap">
    <div class="da-header">
        <div>
            <h1 class="da-title">ANTRIAN VERIFIKASI</h1>
            <p class="da-subtitle">Dokumen yang menunggu verifikasi Admin BAA.</p>
        </div>
    </div>

    <form method="GET" class="sp-filter-bar" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
        <input type="text" name="cari" placeholder="Cari..." value="{{ request('cari') }}" style="padding:8px;flex:1;">
        <select name="status" onchange="this.form.submit()" style="padding:8px;">
            <option value="">Semua Status</option>
            <option value="submitted" {{ request('status')==='submitted' ? 'selected' : '' }}>Submitted</option>
            <option value="waiting" {{ request('status')==='waiting' ? 'selected' : '' }}>On Process</option>
        </select>
        <button type="submit" class="da-btn-outline">Filter</button>
    </form>

    <table class="da-table" style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="text-align:left;border-bottom:2px solid #111;">
                <th style="padding:10px;">KODE</th>
                <th>MAHASISWA</th>
                <th>LAYANAN</th>
                <th>TANGGAL</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $item)
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:10px;">{{ $item->kode }}</td>
                <td>{{ $item->nama_mahasiswa }}<br><small>{{ $item->nim_mahasiswa }}</small></td>
                <td>{{ $item->jenis_label }}</td>
                <td>
                    @if($item->tanggal_submit)
                    <span class="live-dt-short" data-at="{{ $item->tanggal_submit->toIso8601String() }}"></span>
                    <br>
                    <span class="live-ago" data-at="{{ $item->tanggal_submit->toIso8601String() }}" style="font-size:11px;color:#888;"></span>
                    @else
                    -
                    @endif
                </td>
                <td><x-status-badge :pengajuan="$item" /></td>
                <td><a href="{{ route('admin.verifikasi.detail', $item) }}" class="da-btn-outline" style="padding:6px 10px;text-decoration:none;">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="6" style="padding:20px;text-align:center;">Tidak ada antrian verifikasi.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $pengajuan->links() }}
</div>
@endsection
