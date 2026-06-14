@extends('layouts.auth')
@section('head')
    @vite(['public/css/tracking.css'])
@endsection
@section('content')
<div class="tracking-container">
    <aside class="sidebar">
        <div class="sidebar-header">Smart Academic UMS</div>
        <nav class="sidebar-menu">
            <ul>
                <li><a href="/dashboard-mahasiswa">Dashboard</a></li>
                <li><a href="/ajukan-layanan">Ajukan Layanan</a></li>
                <li class="active"><a href="/riwayat-pengajuan">Riwayat Pengajuan</a></li>
            </ul>
        </nav>
    </aside>
    <main class="tracking-main">
        <div class="tracking-header">
            <a href="/riwayat-pengajuan" style="color:#a259e6;font-weight:700;text-decoration:underline;font-size:1.01rem;">&larr; Kembali ke Riwayat</a>
            <h1>TRACKING PENGAJUAN</h1>
            <p>Lacak status layanan akademik Anda secara real-time.</p>
        </div>
        <div class="tracking-info">
            <div class="tracking-box">
                <div style="font-weight:700;font-size:1.08rem;">ID PENGAJUAN</div>
                <div>REQ-2023-08912</div>
            </div>
            <div class="tracking-box">
                <div style="font-weight:700;font-size:1.08rem;">JENIS LAYANAN</div>
                <div>Surat Keterangan</div>
            </div>
            <div class="tracking-box">
                <div style="font-weight:700;font-size:1.08rem;">STATUS TERAKHIR</div>
                <div><span class="status-badge dalam-proses">IN REVIEW</span></div>
            </div>
        </div>
        <div class="tracking-progress">
            <div class="progress-label">PROGRES KESELURUHAN</div>
            <div class="progress-bar-bg">
                <div class="progress-bar" style="width:75%"></div>
            </div>
        </div>
        <div class="log-activity">
            <h2>LOG AKTIVITAS</h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-status">✓</div>
                    <div class="activity-content">
                        <div class="activity-title">SUBMITTED <span class="status-badge selesai">SELESAI</span></div>
                        <div class="activity-date">12 Okt 2023, 09:00</div>
                        <div class="activity-note">Pengajuan telah diterima oleh sistem.<br><span style="color:#888;font-size:0.97em;">Catatan: "Dokumen awal telah diunggah dengan benar."</span></div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-status">✓</div>
                    <div class="activity-content">
                        <div class="activity-title">VERIFIED BY ADMIN <span class="status-badge selesai">SELESAI</span></div>
                        <div class="activity-date">12 Okt 2023, 14:20</div>
                        <div class="activity-note">Pengecekan kelengkapan berkas oleh Biro Administrasi.<br><span style="color:#888;font-size:0.97em;">Catatan: "Data mahasiswa sesuai dengan database SIAKAD."</span></div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-status">⏳</div>
                    <div class="activity-content">
                        <div class="activity-title">WAITING LECTURER SIGNATURE <span class="status-badge dalam-proses">DALAM PROSES</span></div>
                        <div class="activity-date">13 Okt 2023, 08:03</div>
                        <div class="activity-note">Menunggu tanda tangan digital dari Kaprodi / Dosen Wali.<br><span style="color:#888;font-size:0.97em;">Catatan: "Sedang dalam antrean tanda tangan Bapak Dr. Ahmad Yani."</span></div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-status" style="background:#eee;color:#bbb;border:2px solid #eee;">✓</div>
                    <div class="activity-content">
                        <div class="activity-title">COMPLETED (READY FOR PICKUP)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tracking-info" style="margin-top:0;">
            <div class="info-panel" style="max-width:350px;">
                <h3>LOKASI PENGAMBILAN</h3>
                <div>Layanan dilakukan di TU FKI Universitas Muhammadiyah Surakarta.<br><br><b>LOKET PELAYANAN:</b><br>Gedung J, Kampus 2<br>Jam Operasional: 08.00 - 15.00 WIB</div>
            </div>
            <div class="info-panel" style="max-width:350px;">
                <h3>PENTING</h3>
                <div class="important">Bawa Kartu Tanda Mahasiswa KTM asli saat pengambilan.<br>Pengambilan tidak dapat diwakilkan kecuali dengan surat kuasa.<br>Pastikan data pada dokumen digital sudah sesuai sebelum dicetak.</div>
            </div>
        </div>
        <div style="margin-top:30px;display:flex;gap:12px;">
            <button class="btn-secondary">BANTUAN</button>
            <button class="btn-primary">REFRESH STATUS</button>
        </div>
    </main>
</div>
@endsection
