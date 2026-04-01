@extends('layouts.app')
@section('title', 'Upload Dokumen')
@section('head')
    @vite(['resources/css/upload.css'])
@endsection
@section('sidebar')
<div class="sidebar-header">Smart Academic UMS</div>
<nav class="sidebar-menu">
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/pengajuan">Ajukan Layanan</a></li>
        <li class="active"><a href="/upload">Upload Dokumen</a></li>
        <li><a href="/tracking">Riwayat Pengajuan</a></li>
    </ul>
</nav>
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>UPLOAD DOKUMEN PENGAJUAN</h1>
    <div class="user-info">
        <span>Universitas Muhammadiyah Surakarta</span>
        <span>2023/2024</span>
    </div>
</div>
@endsection
@section('content')
<div class="upload-main">
    <p>Silakan unggah dokumen yang diperlukan untuk melengkapi pengajuan layanan akademik Anda.</p>

    <div class="upload-progress">
        <div class="progress-step completed">
            <div class="step-number">1</div>
            <div class="step-label">Pilih Layanan</div>
        </div>
        <div class="progress-line completed"></div>
        <div class="progress-step active">
            <div class="step-number">2</div>
            <div class="step-label">Upload Dokumen</div>
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="step-number">3</div>
            <div class="step-label">Verifikasi</div>
        </div>
    </div>

    <div class="upload-section">
        <h2>Dokumen Wajib</h2>
        <div class="upload-grid">
            <div class="upload-card">
                <div class="upload-icon">📄</div>
                <h3>KTM (Kartu Tanda Mahasiswa)</h3>
                <p>Format: PDF, JPG, PNG | Max: 2MB</p>
                <div class="upload-area" id="ktm-upload">
                    <input type="file" id="ktm-file" accept=".pdf,.jpg,.png" style="display: none;">
                    <div class="upload-placeholder">
                        <div class="upload-icon-small">📎</div>
                        <p>Klik untuk upload atau drag & drop</p>
                        <button type="button" class="btn-upload" onclick="document.getElementById('ktm-file').click()">Pilih File</button>
                    </div>
                </div>
                <div class="file-status" id="ktm-status"></div>
            </div>
            <div class="upload-card">
                <div class="upload-icon">📋</div>
                <h3>Surat Permohonan</h3>
                <p>Format: PDF | Max: 1MB</p>
                <div class="upload-area" id="surat-upload">
                    <input type="file" id="surat-file" accept=".pdf" style="display: none;">
                    <div class="upload-placeholder">
                        <div class="upload-icon-small">📎</div>
                        <p>Klik untuk upload atau drag & drop</p>
                        <button type="button" class="btn-upload" onclick="document.getElementById('surat-file').click()">Pilih File</button>
                    </div>
                </div>
                <div class="file-status" id="surat-status"></div>
            </div>
        </div>
    </div>

    <div class="upload-section">
        <h2>Dokumen Tambahan (Opsional)</h2>
        <div class="upload-grid">
            <div class="upload-card">
                <div class="upload-icon">📊</div>
                <h3>KHS (Kartu Hasil Studi)</h3>
                <p>Format: PDF | Max: 2MB</p>
                <div class="upload-area" id="khs-upload">
                    <input type="file" id="khs-file" accept=".pdf" style="display: none;">
                    <div class="upload-placeholder">
                        <div class="upload-icon-small">📎</div>
                        <p>Klik untuk upload atau drag & drop</p>
                        <button type="button" class="btn-upload" onclick="document.getElementById('khs-file').click()">Pilih File</button>
                    </div>
                </div>
                <div class="file-status" id="khs-status"></div>
            </div>
            <div class="upload-card">
                <div class="upload-icon">📄</div>
                <h3>Dokumen Pendukung Lain</h3>
                <p>Format: PDF, JPG, PNG | Max: 3MB</p>
                <div class="upload-area" id="lain-upload">
                    <input type="file" id="lain-file" accept=".pdf,.jpg,.png" style="display: none;">
                    <div class="upload-placeholder">
                        <div class="upload-icon-small">📎</div>
                        <p>Klik untuk upload atau drag & drop</p>
                        <button type="button" class="btn-upload" onclick="document.getElementById('lain-file').click()">Pilih File</button>
                    </div>
                </div>
                <div class="file-status" id="lain-status"></div>
            </div>
        </div>
    </div>

    <div class="upload-actions">
        <button type="button" class="btn-secondary" onclick="window.location.href='/pengajuan'">Kembali</button>
        <button type="button" class="btn-primary" onclick="submitUpload()">Lanjutkan ke Verifikasi</button>
    </div>

    <div class="info-panel">
        <h3>Tips Upload Dokumen</h3>
        <ul>
            <li>Pastikan dokumen dalam format yang benar dan ukuran file tidak melebihi batas</li>
            <li>Gunakan scanner atau kamera dengan resolusi tinggi untuk dokumen fisik</li>
            <li>Periksa kembali dokumen sebelum upload untuk menghindari kesalahan</li>
            <li>Dokumen yang diupload akan diverifikasi oleh staf akademik</li>
        </ul>
    </div>
</div>

<script>
function handleFileUpload(inputId, statusId, fileName) {
    const input = document.getElementById(inputId);
    const status = document.getElementById(statusId);

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            status.innerHTML = `<span style="color:#1fae51;">✓ ${file.name} (${(file.size/1024/1024).toFixed(2)} MB)</span>`;
        }
    });
}

handleFileUpload('ktm-file', 'ktm-status', 'KTM');
handleFileUpload('surat-file', 'surat-status', 'Surat Permohonan');
handleFileUpload('khs-file', 'khs-status', 'KHS');
handleFileUpload('lain-file', 'lain-status', 'Dokumen Lain');

function submitUpload() {
    // Logic untuk submit upload
    alert('Upload berhasil! Melanjutkan ke verifikasi...');
    window.location.href = '/tracking';
}

// Drag and drop functionality
document.querySelectorAll('.upload-area').forEach(area => {
    area.addEventListener('dragover', (e) => {
        e.preventDefault();
        area.classList.add('dragover');
    });

    area.addEventListener('dragleave', () => {
        area.classList.remove('dragover');
    });

    area.addEventListener('drop', (e) => {
        e.preventDefault();
        area.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const input = area.querySelector('input[type="file"]');
            input.files = files;
            input.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection
