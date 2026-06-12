@props(['pengajuan'])

@php
    $badgeClass = $pengajuan->status_badge_class;
    if (auth()->user()?->isDosen() && $pengajuan->status === 'dosen_ttd' && $pengajuan->tanggal_ttd) {
        $badgeClass = 'completed';
    }
    $label = $pengajuan->display_status_label;
    if (auth()->user()?->isDosen() && $pengajuan->status === 'dosen_ttd' && $pengajuan->tanggal_ttd) {
        $label = 'Sudah TTD';
    }
@endphp

<span class="status-badge {{ $badgeClass }}"
      data-id="{{ $pengajuan->kode }}"
      data-status="{{ $pengajuan->display_status }}"
      data-backend="{{ $pengajuan->status }}"
      data-label="{{ $label }}">
    {{ $label }}
</span>
