@extends('layouts.app')

@section('title', 'UI Elements Reference')
@section('topbar_name', 'admin')
@section('topbar_role', 'UMS Academic')

@section('head')
    @vite(['resources/css/verifikasi-admin.css'])
    <style>
    .ui-wrap { font-family: 'Barlow', sans-serif; padding: 32px 36px 0; max-width: 1100px; }
    .ui-page-title { font-family:'Barlow Condensed',sans-serif; font-size:52px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#111; line-height:1; margin-bottom:8px; }
    .ui-page-sub { font-size:13.5px; color:#444; margin-bottom:8px; line-height:1.6; max-width:560px; }
    .ui-page-sub strong { text-decoration:underline; }
    .ui-divider { height:2.5px; background:#111; margin:20px 0 32px; }
    .ui-2col { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:32px; }
    .ui-card { border:2.5px solid #111; background:white; padding:22px 24px; }
    .ui-card-title { font-family:'Barlow Condensed',sans-serif; font-size:18px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#111; margin-bottom:6px; }
    .ui-card-sub { font-size:12px; color:#666; margin-bottom:16px; }
    .badges-row { display:flex; flex-wrap:wrap; gap:8px; }
    .sbadge { padding:5px 16px; border:1.5px solid #CCC; font-size:12.5px; font-weight:700; color:#111; background:white; }
    .sbadge-rejected { background:#E53935; color:white; border-color:#E53935; }
    .typo-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.2px; color:#888; margin-bottom:4px; display:block; }
    .typo-h1 { font-family:'Barlow Condensed',sans-serif; font-size:38px; font-weight:900; text-transform:uppercase; color:#111; line-height:1; margin-bottom:12px; }
    .typo-h2 { font-family:'Barlow Condensed',sans-serif; font-size:22px; font-weight:800; text-transform:uppercase; color:#111; margin-bottom:12px; }
    .typo-body { font-size:13px; color:#333; line-height:1.7; }
    .ui-wide-grid { display:grid; grid-template-columns:1fr 1.4fr; gap:32px; margin-bottom:32px; }
    .section-title-ul { font-family:'Barlow Condensed',sans-serif; font-size:26px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#111; border-bottom:3px solid #9B1FCA; display:inline-block; padding-bottom:4px; margin-bottom:12px; }
    .section-sub { font-size:12.5px; color:#444; margin-bottom:20px; line-height:1.6; }
    .section-sub strong { font-weight:800; }
    .timeline { border:2.5px solid #111; background:white; padding:20px 18px; display:flex; flex-direction:column; gap:0; }
    .tl-item { display:flex; gap:14px; align-items:flex-start; position:relative; padding-bottom:20px; }
    .tl-item:last-child { padding-bottom:0; }
    .tl-item::before { content:''; position:absolute; left:14px; top:28px; bottom:0; width:2px; background:#DDD; }
    .tl-item:last-child::before { display:none; }
    .tl-dot { width:28px; height:28px; border:2px solid #111; background:white; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:11px; font-weight:900; color:#111; position:relative; z-index:1; }
    .tl-dot-active { background:#9B1FCA; border-color:#9B1FCA; color:white; }
    .tl-title { font-family:'Barlow Condensed',sans-serif; font-size:14px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; color:#111; margin-bottom:3px; }
    .tl-desc { font-size:12px; color:#555; line-height:1.5; margin-bottom:4px; }
    .tl-time { font-size:11px; color:#999; font-style:italic; }
    .tl-status { font-size:11.5px; color:#9B1FCA; font-weight:700; font-style:italic; }
    .prim-section-title { font-family:'Barlow Condensed',sans-serif; font-size:26px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#111; margin-bottom:20px; }
    .prim-label { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#333; display:block; margin-bottom:6px; }
    .prim-input-wrap { margin-bottom:16px; }
    .prim-input { width:100%; padding:11px 14px; border:2px solid #9B1FCA; font-family:'Barlow',sans-serif; font-size:13.5px; color:#333; outline:none; background:white; }
    .prim-input::placeholder { color:#AAA; }
    .prim-textarea-wrap { margin-bottom:20px; }
    .prim-textarea { width:100%; padding:11px 14px; border:2px solid #CCC; font-family:'Barlow',sans-serif; font-size:13px; color:#333; outline:none; resize:vertical; min-height:90px; background:white; }
    .prim-textarea::placeholder { color:#AAA; }
    .btns-col { display:flex; flex-direction:column; gap:10px; }
    .prim-btn-primary { display:block; width:100%; padding:13px 20px; background:#9B1FCA; color:white; border:none; font-family:'Barlow',sans-serif; font-size:14px; font-weight:700; font-style:italic; cursor:pointer; text-align:center; transition:background 0.15s; }
    .prim-btn-primary:hover { background:#C44FEC; }
    .prim-btn-secondary { display:block; width:100%; padding:12px 20px; background:white; color:#111; border:2px solid #111; font-family:'Barlow',sans-serif; font-size:14px; font-weight:700; cursor:pointer; text-align:center; transition:all 0.15s; }
    .prim-btn-secondary:hover { background:#111; color:white; }
    .prim-btn-destructive { display:block; width:100%; padding:13px 20px; background:#E53935; color:white; border:none; font-family:'Barlow',sans-serif; font-size:14px; font-weight:700; font-style:italic; cursor:pointer; text-align:center; transition:background 0.15s; }
    .prim-btn-destructive:hover { background:#C62828; }
    .upload-box-title { font-family:'Barlow Condensed',sans-serif; font-size:16px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; color:#111; margin-bottom:14px; display:flex; align-items:center; gap:7px; }
    .upload-box-title i { width:16px; height:16px; color:#9B1FCA; }
    .upload-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .upload-dropzone-sm { border:2.5px dashed #BBB; padding:28px 20px; text-align:center; cursor:pointer; transition:all 0.15s; background:#FAFAFA; }
    .upload-dropzone-sm:hover { border-color:#9B1FCA; background:#FBF0FF; }
    .upload-icon-sm { width:48px; height:48px; border:2px solid #CCC; display:flex; align-items:center; justify-content:center; margin:0 auto 10px; background:white; }
    .upload-icon-sm i { width:24px; height:24px; color:#9B1FCA; }
    .upload-drop-title { font-family:'Barlow Condensed',sans-serif; font-size:16px; font-weight:900; font-style:italic; text-transform:uppercase; color:#111; margin-bottom:4px; }
    .upload-drop-sub { font-size:12px; color:#666; margin-bottom:6px; }
    .upload-drop-max { font-size:12px; font-weight:700; color:#111; }
    .sistem-verif { border:2.5px solid #111; background:white; padding:18px; }
    .sistem-verif-header { display:flex; align-items:flex-start; gap:12px; margin-bottom:14px; }
    .sistem-verif-icon { width:36px; height:36px; border:2px solid #CCC; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .sistem-verif-icon i { width:18px; height:18px; color:#9B1FCA; }
    .sistem-verif-title { font-size:13px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; color:#111; margin-bottom:2px; }
    .sistem-verif-sub { font-size:11.5px; color:#666; line-height:1.4; }
    .sistem-verif-divider { height:1.5px; background:#EEE; margin-bottom:12px; }
    .sistem-verif-item { display:flex; align-items:center; gap:7px; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#333; margin-bottom:7px; }
    .sistem-verif-item i { width:13px; height:13px; color:#9B1FCA; }
    .sistem-verif-note { font-size:11px; color:#888; line-height:1.5; margin-top:8px; font-style:italic; }
    .card-section-title { font-family:'Barlow Condensed',sans-serif; font-size:26px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#111; margin-bottom:20px; }
    .cards-3col { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:32px; }
    .service-card-new { border:2.5px solid #111; background:white; display:flex; flex-direction:column; transition:transform 0.1s; }
    .service-card-new:hover { transform:translateY(-2px); }
    .sc-header { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; border-bottom:1.5px solid #EEE; }
    .sc-code { font-size:10px; font-weight:900; letter-spacing:1px; text-transform:uppercase; color:white; background:#9B1FCA; padding:2px 8px; }
    .sc-file-icon i { width:16px; height:16px; color:#9B1FCA; }
    .sc-body { padding:16px 14px; flex:1; }
    .sc-title { font-family:'Barlow Condensed',sans-serif; font-size:18px; font-weight:900; text-transform:uppercase; letter-spacing:0.5px; color:#111; margin-bottom:6px; line-height:1.1; }
    .sc-desc { font-size:12.5px; color:#555; line-height:1.5; }
    .sc-footer { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; border-top:1.5px solid #EEE; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#333; }
    .sc-footer i { width:15px; height:15px; color:#555; }
    .dashboard-footer { text-align:center; color:#999; font-size:11.5px; padding:16px; border-top:1px solid #E0E0E0; margin-top:24px; }
    </style>
@endsection

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="ui-wrap">

    <h1 class="ui-page-title">UI Elements Reference</h1>
    <p class="ui-page-sub">Panduan komponen visual dan standar antarmuka untuk <strong>Sistem Tracking Layanan Akademik UMS</strong> berbasis estetika Neo-Brutalism.</p>
    <div class="ui-divider"></div>

    {{-- Status Badges + Typography --}}
    <div class="ui-2col">
        <div class="ui-card">
            <div class="ui-card-title">Status Badges</div>
            <div class="ui-card-sub">Standar indikator warna untuk siklus hidup pengajuan.</div>
            <div class="badges-row">
                <span class="sbadge">Submitted</span>
                <span class="sbadge">Waiting Lecturer</span>
                <span class="sbadge">Completed</span>
                <span class="sbadge sbadge-rejected">Rejected</span>
            </div>
        </div>
        <div class="ui-card">
            <div class="ui-card-title">Typography Scale</div>
            <span class="typo-label">Heading 1 – Extra Bold</span>
            <div class="typo-h1">Judul Besar Utama</div>
            <span class="typo-label">Heading 2 – Bold</span>
            <div class="typo-h2">Sub-Judul Konten</div>
            <span class="typo-label">Body Text – Regular</span>
            <p class="typo-body">Teks isi yang bersih dengan jarak antar baris yang luas untuk kemudahan membaca dokumen akademik.</p>
        </div>
    </div>

    {{-- Timeline + Primitives --}}
    <div class="ui-wide-grid">
        <div>
            <div class="section-title-ul">Timeline<br>Progress</div>
            <p class="section-sub">Komponen ini digunakan di halaman <strong>Tracking Status Mahasiswa</strong> untuk menunjukkan posisi berkas.</p>
            <div class="timeline">
                <div class="tl-item">
                    <div class="tl-dot"><i data-lucide="clock" style="width:14px;height:14px;"></i></div>
                    <div>
                        <div class="tl-title">Pengajuan Terkirim</div>
                        <div class="tl-desc">Mahasiswa telah mengunggah berkas awal.</div>
                        <div class="tl-time">12 Okt 2023, 08:30</div>
                    </div>
                </div>
                <div class="tl-item">
                    <div class="tl-dot"><i data-lucide="clock" style="width:14px;height:14px;"></i></div>
                    <div>
                        <div class="tl-title">Verifikasi Admin</div>
                        <div class="tl-desc">Pengecekan kelengkapan dokumen oleh BAA.</div>
                        <div class="tl-time">13 Okt 2023, 10:15</div>
                    </div>
                </div>
                <div class="tl-item">
                    <div class="tl-dot tl-dot-active">3</div>
                    <div>
                        <div class="tl-title">Menunggu TTD Dosen</div>
                        <div class="tl-desc">Sedang menunggu persetujuan digital Dosen Pembimbing.</div>
                        <div class="tl-status">Sedang Berjalan...</div>
                    </div>
                </div>
                <div class="tl-item">
                    <div class="tl-dot">4</div>
                    <div>
                        <div class="tl-title">Siap Diambil</div>
                        <div class="tl-desc">Dokumen fisik dapat diambil di Loket 1.</div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="prim-section-title">Interactive Primitives</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div>
                    <div class="prim-input-wrap">
                        <span class="prim-label">Input Field (Focus State)</span>
                        <input type="text" class="prim-input" placeholder="Masukkan NIM Mahasiswa...">
                    </div>
                    <div class="prim-textarea-wrap">
                        <span class="prim-label">Textarea Reference</span>
                        <textarea class="prim-textarea" placeholder="Tambahkan catatan untuk mahasiswa..."></textarea>
                    </div>
                </div>
                <div class="btns-col">
                    <button class="prim-btn-primary">Primary Action Button</button>
                    <button class="prim-btn-secondary">Secondary Action</button>
                    <button class="prim-btn-destructive">Destructive / Reject</button>
                </div>
            </div>

            <div class="upload-box-title" style="margin-top:20px;">
                <i data-lucide="upload"></i> Upload Box
            </div>
            <div class="upload-row">
                <div class="upload-dropzone-sm">
                    <div class="upload-icon-sm"><i data-lucide="upload"></i></div>
                    <div class="upload-drop-title">Unggah Dokumen</div>
                    <div class="upload-drop-sub">Klik untuk memilih atau seret file PDF/DOC ke sini</div>
                    <div class="upload-drop-max">Maksimal ukuran file: 5MB</div>
                </div>
                <div class="sistem-verif">
                    <div class="sistem-verif-header">
                        <div class="sistem-verif-icon"><i data-lucide="shield-check"></i></div>
                        <div>
                            <div class="sistem-verif-title">Sistem Verifikasi</div>
                            <div class="sistem-verif-sub">Informasi verifikasi tersedia di panel dokumen.</div>
                        </div>
                    </div>
                    <div class="sistem-verif-divider"></div>
                    <div class="sistem-verif-item"><i data-lucide="check-circle-2"></i> E-Signature Terintegrasi</div>
                    <div class="sistem-verif-item"><i data-lucide="check-circle-2"></i> Validasi BAA Otomatis</div>
                    <p class="sistem-verif-note">Seluruh dokumen diproses melalui protokol keamanan Smart Academic UMS.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Layout Patterns --}}
    <div class="ui-divider"></div>
    <div class="card-section-title">Card Layout Patterns</div>
    <div class="cards-3col">
        @foreach(['CODE-01','CODE-02','CODE-03'] as $code)
        <div class="service-card-new">
            <div class="sc-header">
                <span class="sc-code">{{ $code }}</span>
                <span class="sc-file-icon"><i data-lucide="file-text"></i></span>
            </div>
            <div class="sc-body">
                <div class="sc-title">Legalitas Ijazah {{ $loop->iteration }}</div>
                <div class="sc-desc">Layanan pengesahan fotokopi ijazah untuk keperluan melamar pekerjaan atau studi lanjut.</div>
            </div>
            <div class="sc-footer">
                <span>Estimasi: 2 Hari Kerja</span>
                <i data-lucide="chevron-right"></i>
            </div>
        </div>
        @endforeach
    </div>

    <footer class="dashboard-footer">
        &copy; 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.
    </footer>

</div>
@endsection