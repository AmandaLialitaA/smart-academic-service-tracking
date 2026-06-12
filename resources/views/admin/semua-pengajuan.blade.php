@extends('layouts.app')
@section('title', 'Semua Pengajuan')
@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-admin')
@endsection
@section('content')
<div class="da-wrap">
    <div class="da-header">
        <div>
            <h1 class="da-title">SEMUA PENGAJUAN</h1>
            <p class="da-subtitle">Kelola seluruh pengajuan layanan akademik mahasiswa UMS.</p>
        </div>
    </div>

    <div class="da-stats-grid" style="margin-bottom:16px;">
        <div class="da-stat-card da-stat-card--purple"><div class="da-stat-label">TOTAL</div><div class="da-stat-number">{{ $stats['total'] }}</div></div>
        <div class="da-stat-card da-stat-card--cyan"><div class="da-stat-label">SUBMITTED</div><div class="da-stat-number" data-stat="submitted">{{ $stats['submitted'] }}</div></div>
        <div class="da-stat-card da-stat-card--amber"><div class="da-stat-label">ON PROCESS</div><div class="da-stat-number" data-stat="waiting">{{ $stats['waiting'] }}</div></div>
        <div class="da-stat-card da-stat-card--white"><div class="da-stat-label">COMPLETED</div><div class="da-stat-number" data-stat="completed">{{ $stats['completed'] }}</div></div>
    </div>

    <form method="GET" class="sp-filter-bar" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
        <input type="text" name="cari" placeholder="Cari kode/NIM/nama..." value="{{ request('cari') }}" style="padding:8px;flex:1;">
        <select name="status" onchange="this.form.submit()" style="padding:8px;">
            <option value="">Semua Status</option>
            <option value="submitted" {{ request('status')==='submitted' ? 'selected' : '' }}>Submitted</option>
            <option value="waiting" {{ request('status')==='waiting' ? 'selected' : '' }}>Waiting</option>
            <option value="completed" {{ request('status')==='completed' ? 'selected' : '' }}>Completed</option>
            <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <select name="jenis" onchange="this.form.submit()" style="padding:8px;">
            <option value="">Semua Layanan</option>
            @foreach(\App\Models\Pengajuan::JENIS_LABEL as $key => $label)
                <option value="{{ $key }}" {{ request('jenis')===$key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="da-btn-primary">Filter</button>
    </form>

    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="text-align:left;border-bottom:2px solid #111;">
                <th style="padding:10px;">KODE</th>
                <th>MAHASISWA</th>
                <th>LAYANAN</th>
                <th>DOSEN</th>
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
                <td>{{ $item->dosen?->name ?? '-' }}</td>
                <td>{{ $item->tanggal_submit?->format('d M Y') }}</td>
                <td><x-status-badge :pengajuan="$item" /></td>
                <td><a href="{{ route('admin.verifikasi.detail', $item) }}">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="7" style="padding:20px;text-align:center;">Tidak ada pengajuan.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $pengajuan->links() }}
</div>
@endsection
