@extends('layouts.app')
@section('title', 'Tracking Pengajuan')
@section('head')
    @vite(['resources/css/tracking.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>
<div class="tracking-wrap">

    <a href="/riwayat" class="tracking-back">← Kembali ke Riwayat</a>

    <div class="tracking-title-row">
        <div>
            <h1 class="tracking-title">TRACKING PENGAJUAN</h1>
            <p class="tracking-sub">Lacak status layanan akademik Anda secara real-time.</p>
        </div>
        <div class="tracking-actions">
            <button class="btn-bantuan">BANTUAN</button>
            <button class="btn-refresh">REFRESH STATUS</button>
        </div>
    </div>

    <div class="tracking-body">
        {{-- Kolom kiri --}}
        <div class="tracking-left">
            <div class="tracking-info-boxes">
                <div class="tracking-box">
                    <div class="tbox-label">ID PENGAJUAN</div>
                    <div class="tbox-val">REQ-2023-08912</div>
                </div>
                <div class="tracking-box">
                    <div class="tbox-label">JENIS LAYANAN</div>
                    <div class="tbox-val">Surat Keterangan</div>
                </div>
                <div class="tracking-box">
                    <div class="tbox-label">STATUS TERAKHIR</div>
                    <div class="tbox-val"><span class="status-badge dalam-proses">IN REVIEW</span></div>
                </div>
            </div>

            <div class="tracking-progress-box">
                <div class="progress-row">
                    <span class="progress-label">PROGRES KESELURUHAN</span>
                    <span class="progress-pct">75%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar" style="width:75%"></div>
                </div>
            </div>

            <div class="log-section">
                <h2 class="log-title">📅 LOG AKTIVITAS</h2>

                <div class="activity-item done">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-name">SUBMITTED</span>
                            <span class="status-badge selesai">SELESAI</span>
                        </div>
                        <div class="activity-date">12 Okt 2023, 09:00</div>
                        <div class="activity-desc">Pengajuan telah diterima oleh sistem.</div>
                        <div class="activity-note">💬 Catatan: "Dokumen awal telah diunggah dengan benar."</div>
                    </div>
                </div>

                <div class="activity-item done">
                    <div class="activity-icon">✓</div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-name">VERIFIED BY ADMIN</span>
                            <span class="status-badge selesai">SELESAI</span>
                        </div>
                        <div class="activity-date">12 Okt 2023, 14:20</div>
                        <div class="activity-desc">Pengecekan kelengkapan berkas oleh Biro Administrasi.</div>
                        <div class="activity-note">💬 Catatan: "Data mahasiswa sesuai dengan database SIAKAD."</div>
                    </div>
                </div>

                <div class="activity-item progress">
                    <div class="activity-icon">⏳</div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-name">WAITING LECTURER SIGNATURE</span>
                            <span class="status-badge dalam-proses">DALAM PROSES</span>
                        </div>
                        <div class="activity-date">13 Okt 2023, 08:00</div>
                        <div class="activity-desc">Menunggu tanda tangan digital dari Kaprodi / Dosen Wali.</div>
                        <div class="activity-note">💬 Catatan: "Sedang dalam antrean tanda tangan Bapak Dr. Ahmad Yani."</div>
                    </div>
                </div>

                <div class="activity-item pending">
                    <div class="activity-icon activity-icon--gray">✓</div>
                    <div class="activity-content">
                        <div class="activity-header">
                            <span class="activity-name">COMPLETED (READY FOR PICKUP)</span>
                        </div>
                        <div class="activity-desc">Dokumen sudah tersedia dan siap diambil di loket BAA.</div>
                        <div class="activity-note">💬 Catatan: "QR Code akan aktif setelah status selesai."</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom kanan --}}
        <div class="tracking-right">
            <div class="info-card info-card--purple">
                <div class="info-card-title">📍 LOKASI PENGAMBILAN</div>
                <p>Layanan dilakukan di loket resmi Biro Administrasi Akademik (BAA) Universitas Muhammadiyah Surakarta.</p>
                <div class="loket-box">
                    <div class="loket-label">LOKET PELAYANAN:</div>
                    <div class="loket-val">Gedung Siti Walidah, Lantai 2</div>
                    <div class="loket-jam">Jam Operasional: 08.00 - 15.00 WIB</div>
                </div>
            </div>

            <div class="info-card info-card--teal">
                <div class="info-card-title">⚠️ PENTING!</div>
                <ul class="penting-list">
                    <li>Bawa Kartu Tanda Mahasiswa (KTM) asli saat pengambilan.</li>
                    <li>Pengambilan tidak dapat diwakilkan kecuali dengan surat kuasa.</li>
                    <li>Pastikan data pada dokumen digital sudah sesuai sebelum dicetak.</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<footer class="dashboard-footer">© 2026 Universitas Muhammadiyah Surakarta. Smart Academic Service Tracking.</footer>
@endsection