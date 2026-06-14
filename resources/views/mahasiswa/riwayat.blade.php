@extends('layouts.app')
@section('title', 'Riwayat Pengajuan')
@section('head')
    @vite(['resources/css/dashboard-mahasiswa.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection
@section('content')
<div class="dashboard-main">
    @if(session('error'))
        <div style="background:#fff6f6;border:2px solid #E53935;padding:14px 18px;margin-bottom:16px;color:#a00;font-weight:600;">
            {{ session('error') }}
        </div>
    @endif

    <div class="dashboard-header">
        <h2 class="dashboard-title">RIWAYAT PENGAJUAN</h2>
        <p class="dashboard-desc">Semua pengajuan layanan akademik yang pernah Anda buat.</p>
    </div>

    <form method="GET" action="{{ route('mahasiswa.riwayat') }}" class="riwayat-filter-bar">
        <input type="text" name="cari" class="riwayat-search" placeholder="Cari ID atau jenis layanan..." value="{{ request('cari') }}">
        <div class="riwayat-filter-group">
            <select name="status" class="riwayat-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="waiting" {{ request('status') === 'waiting' ? 'selected' : '' }}>Waiting</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <select name="jenis" class="riwayat-select" onchange="this.form.submit()">
                <option value="">Semua Layanan</option>
                @foreach(\App\Models\Pengajuan::JENIS_LABEL as $key => $label)
                    <option value="{{ $key }}" {{ request('jenis') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-track" style="border:none;cursor:pointer;">Filter</button>
        </div>
    </form>

    <div class="dashboard-badges">
        <div class="badge badge-submitted"><div class="badge-label">SUBMITTED</div><div class="badge-count" data-stat="submitted">{{ $stats['submitted'] }}</div></div>
        <div class="badge badge-waiting"><div class="badge-label">WAITING</div><div class="badge-count" data-stat="waiting">{{ $stats['waiting'] }}</div></div>
        <div class="badge badge-completed"><div class="badge-label">COMPLETED</div><div class="badge-count" data-stat="completed">{{ $stats['completed'] }}</div></div>
        <div class="badge badge-rejected"><div class="badge-label">REJECTED</div><div class="badge-count" data-stat="rejected">{{ $stats['rejected'] }}</div></div>
    </div>

    <section class="latest-requests">
        <div class="section-header">
            <h2>SEMUA PENGAJUAN</h2>
            <span class="riwayat-count">Menampilkan {{ $pengajuan->count() }} pengajuan</span>
        </div>
        <table class="requests-table">
            <thead>
                <tr>
                    <th>ID PENGAJUAN</th>
                    <th>JENIS LAYANAN</th>
                    <th>TANGGAL DIAJUKAN</th>
                    <th>DOSEN/STAFF PENANGGUNG JAWAB</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->jenis_label }}</td>
                    <td>{{ $item->tanggal_submit?->format('d M Y') ?? '-' }}</td>
                    <td><em>{{ $item->dosen?->name ?? 'Menunggu penugasan' }}</em></td>
                    <td><x-status-badge :pengajuan="$item" /></td>
                    <td>
                        <div class="aksi-buttons">
                            <a href="{{ route('mahasiswa.pengajuan.detail', $item) }}" class="btn-track">Detail</a>
                            <a href="{{ route('mahasiswa.tracking', $item) }}" class="btn-track">Track</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:24px;">Belum ada pengajuan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>
@endsection
