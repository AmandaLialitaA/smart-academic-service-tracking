@extends('layouts.app')
@section('title', 'Menunggu TTD')
@section('head')
    @vite(['resources/css/dashboard-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('content')
<div class="dosen-wrap">
    <div class="dosen-header">
        <h1 class="dosen-title">MENUNGGU <span class="title-purple">TTD</span></h1>
        <p class="dosen-sub">Semua pengajuan yang belum ditandatangani oleh {{ auth()->user()->name }}.</p>
    </div>

    <form method="GET" class="riwayat-filter-bar" style="margin-bottom:16px;display:flex;gap:10px;">
        <input type="text" name="cari" placeholder="Cari nama/NIM/kode..." value="{{ request('cari') }}" style="flex:1;padding:8px;">
        <select name="jenis" onchange="this.form.submit()" style="padding:8px;">
            <option value="">Semua Layanan</option>
            @foreach(\App\Models\Pengajuan::JENIS_LABEL as $key => $label)
                <option value="{{ $key }}" {{ request('jenis') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-review">Filter</button>
    </form>

    <table class="dosen-table">
        <thead>
            <tr>
                <th>MAHASISWA</th>
                <th>LAYANAN</th>
                <th>TANGGAL</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuan as $item)
            <tr>
                <td>
                    <div class="mhs-name">{{ $item->nama_mahasiswa }}</div>
                    <div class="mhs-nim">{{ $item->nim_mahasiswa }}</div>
                </td>
                <td>{{ $item->jenis_label }}</td>
                <td>{{ $item->tanggal_submit?->format('d M Y') }}</td>
                <td><span class="status-badge waiting" data-id="{{ $item->kode }}" data-status="waiting">Menunggu TTD</span></td>
                <td><a href="{{ route('dosen.pengajuan.show', $item) }}" class="btn-review">Detail & TTD</a></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:20px;">Tidak ada pengajuan menunggu TTD.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $pengajuan->links() }}
</div>
@endsection
