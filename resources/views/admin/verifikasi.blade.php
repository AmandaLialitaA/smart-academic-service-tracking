@extends('layouts.app')

@section('title', 'Verifikasi Dokumen')
@section('topbar_name', 'admin')
@section('topbar_role', 'UMS Academic')

@section('head')
    @vite(['resources/css/dashboard-admin.css'])
@endsection

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="verifikasi-wrap">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="page-topbar">
        <a href="/admin/verifikasi" class="back-link">
            <i data-lucide="arrow-left"></i> Back to Verification Queue
        </a>
        <div class="page-id">
            <span class="page-id-label">ID Pengajuan</span>
            <span class="page-id-value">REQ-UMS-2023-9941</span>
        </div>
    </div>

    <h1 class="page-title">Verifikasi Dokumen</h1>
    <div class="page-divider"></div>

    {{-- ===== MAIN GRID ===== --}}
    <div class="verif-grid">

        {{-- LEFT --}}
        <div class="verif-left">

            <div class="student-card">
                <div class="student-header">
                    <div class="student-avatar">
                        <i data-lucide="user"></i>
                    </div>
                    <div>
                        <span class="student-name">Ahmad Fauzi</span>
                        <span class="student-nim">L200210156</span>
                    </div>
                </div>
                <div class="student-details">
                    <div class="detail-row">
                        <i data-lucide="book-open"></i>
                        <div>
                            <span class="detail-label">Program Studi</span>
                            <span class="detail-value">Informatika – Fakultas Komunikasi &amp; Informatika</span>
                        </div>
                    </div>
                    <div class="detail-row">
                        <i data-lucide="file-text"></i>
                        <div>
                            <span class="detail-label">Jenis Layanan</span>
                            <span class="detail-value">Surat Keterangan Aktif Kuliah</span>
                        </div>
                    </div>
                    <div class="detail-row">
                        <i data-lucide="calendar"></i>
                        <div>
                            <span class="detail-label">Tanggal Pengajuan</span>
                            <span class="detail-value">24 Oktober 2023</span>
                        </div>
                    </div>
                    <div class="detail-row">
                        <i data-lucide="clock"></i>
                        <div>
                            <span class="detail-label">Sifat Layanan</span>
                            <span class="urgent-badge">URGENT</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="log-card">
                <div class="log-header">
                    <i data-lucide="activity"></i>
                    <span>Log Aktivitas</span>
                </div>
                <div class="log-list">
                    <div class="log-item">
                        <div class="log-dot log-dot-black"></div>
                        <div>
                            <div class="log-time">24 Okt, 09:12</div>
                            <div class="log-desc">Pengajuan diajukan oleh Mahasiswa</div>
                        </div>
                    </div>
                    <div class="log-item">
                        <div class="log-dot log-dot-purple"></div>
                        <div>
                            <div class="log-time">24 Okt, 10:45</div>
                            <div class="log-desc log-desc-bold">Anda Mulai Memeriksa Dokumen</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="verif-right">

            <div class="doc-preview-card">
                <div class="doc-preview-header">
                    <div class="doc-filename">
                        <i data-lucide="file"></i>
                        <span>L200210156_SURATAKTIF.PDF</span>
                    </div>
                    <div class="doc-actions">
                        <button class="btn-doc"><i data-lucide="download"></i> Download</button>
                        <button class="btn-doc"><i data-lucide="external-link"></i> Preview</button>
                    </div>
                </div>
                <div class="doc-preview-body">
                    <div class="doc-mock">
                        <div class="doc-mock-lines">
                            <div class="doc-line doc-line-long"></div>
                            <div class="doc-line doc-line-medium"></div>
                            <div class="doc-line doc-line-short"></div>
                            <div class="doc-line doc-line-long"></div>
                            <div class="doc-line doc-line-medium"></div>
                        </div>
                        <div class="doc-mock-icon">
                            <i data-lucide="file-text"></i>
                        </div>
                    </div>
                    <div class="signature-placeholder">
                        <span>Signature Area Placeholder</span>
                    </div>
                </div>
            </div>

            <div class="workflow-card">
                <div class="workflow-header">
                    <i data-lucide="shield-check"></i>
                    <span>Workflow Verifikasi</span>
                </div>

                <div class="checklist-section">
                    <div class="checklist-title">
                        <i data-lucide="check-circle-2"></i>
                        Checklist Kelengkapan Dokumen
                    </div>
                    <div class="checklist-grid">
                        <label class="check-item check-checked">
                            <input type="checkbox" checked>
                            <span class="check-box"></span>
                            <span>Scan KTM (Valid)</span>
                        </label>
                        <label class="check-item">
                            <input type="checkbox">
                            <span class="check-box"></span>
                            <span>Pas Foto 3x4 (Terlampir)</span>
                        </label>
                        <label class="check-item check-checked">
                            <input type="checkbox" checked>
                            <span class="check-box"></span>
                            <span>Bukti Pembayaran SKS</span>
                        </label>
                    </div>
                </div>

                <div class="catatan-section">
                    <div class="catatan-label">Catatan Verifikasi</div>
                    <textarea class="catatan-input" placeholder="Masukkan catatan revisi atau instruksi tambahan untuk dosen/mahasiswa..."></textarea>
                </div>

                <div class="selesai-box">
                    <label class="selesai-item">
                        <input type="checkbox">
                        <span class="check-box"></span>
                        <div>
                            <span class="selesai-title">Sudah Selesai &amp; Bisa Diambil</span>
                            <span class="selesai-desc">Mencentang ini akan mengirim notifikasi "Ready for Pickup" ke mahasiswa setelah status diupdate.</span>
                        </div>
                    </label>
                </div>

                <div class="workflow-actions">
                    <div class="workflow-actions-top">
                        <button class="btn-reject">
                            <i data-lucide="x-circle"></i> Reject
                        </button>
                        <button class="btn-revision">
                            <i data-lucide="rotate-ccw"></i> Revision Required
                        </button>
                    </div>
                    <button class="btn-verified">
                        <i data-lucide="send"></i> Verified &amp; Send to Lecturer
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- STATUS FINAL --}}
    <div class="status-final-bar">
        <div>
            <span class="status-final-label">Status Final Setelah Update</span>
            <span class="status-final-value">Verified – Waiting Signature</span>
        </div>
        <i data-lucide="check-circle-2" class="status-final-icon"></i>
    </div>

    <footer class="dashboard-footer">
        &copy; 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
    </footer>

</div>
@endsection