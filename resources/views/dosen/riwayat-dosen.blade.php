@extends('layouts.app')
@section('title', 'Riwayat Dosen')
@section('head')
    @vite(['resources/css/dashboard-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('content')
<div class="dosen-wrap" style="padding:24px;">
    <h1 class="dosen-title">RIWAYAT PENGAJUAN</h1>
    <p class="dosen-sub">Semua pengajuan yang ditugaskan ke {{ auth()->user()->name }}.</p>

    <form method="GET" style="display:flex;gap:10px;margin:16px 0;flex-wrap:wrap;">
        <input type="text" name="cari" placeholder="Cari..." value="{{ request('cari') }}" style="padding:8px;flex:1;">
        <select name="status" onchange="this.form.submit()" style="padding:8px;">
            <option value="">Semua Status</option>
            <option value="waiting" {{ request('status')==='waiting' ? 'selected' : '' }}>Waiting</option>
            <option value="completed" {{ request('status')==='completed' ? 'selected' : '' }}>Completed</option>
            <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Rejected</option>
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
                <td>{{ $item->nama_mahasiswa }}<br><small>{{ $item->nim_mahasiswa }}</small></td>
                <td>{{ $item->jenis_label }}</td>
                <td>{{ $item->tanggal_submit?->format('d M Y') }}</td>
                <td><x-status-badge :pengajuan="$item" /></td>
                <td><a href="{{ route('dosen.pengajuan.show', $item) }}">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:20px;">Belum ada riwayat.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $pengajuan->links() }}
</div>
@endsection
