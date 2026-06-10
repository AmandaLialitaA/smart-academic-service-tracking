@extends('layouts.app')

@section('title', 'Form Pengajuan Layanan')

@section('head')
    @vite(['resources/css/pengajuan.css'])
@endsection

@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection

@section('content')
<div class="pengajuan-wrap">

    {{-- Page Title --}}
    <div class="form-page-title">
        <h1>Form Pengajuan</h1>
        <p>Layanan Akademik Mahasiswa UMS</p>
    </div>

    {{-- ===== SECTION 01 ===== --}}
    <div class="form-section">
        <div class="form-section-header sec-purple">
            <div class="step-badge">01</div>
            <h2>Detail Pengajuan Utama</h2>
        </div>
        <div class="form-section-body">
            <div class="form-grid-2">
                <div class="form-group">
                    <label>Pilih Jenis Layanan</label>
                    <div class="select-wrap">
                        <select name="jenis_layanan" id="jenis_layanan">
                            <option value="" disabled selected>-- Pilih Layanan --</option>
                            <option value="aktif-kuliah">Surat Keterangan Aktif Kuliah</option>
                            <option value="transkrip">Transkrip Nilai Sementara</option>
                            <option value="cuti">Pengajuan Cuti Akademik</option>
                            <option value="legalisir">Legalisir Ijazah Elektronik</option>
                            <option value="magang">Surat Pengantar Magang</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <span class="select-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </span>
                    </div>
                    <span class="form-hint">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Pastikan data profil Anda sudah benar di Dashboard.
                    </span>
                </div>
                <div class="form-group">
                    <label>Judul Pengajuan</label>
                    <input type="text" name="judul" id="judul" placeholder="Contoh: Pengajuan SKA untuk Beasiswa">
                </div>
            </div>
        </div>
    </div>

    {{-- ===== SECTION 02 ===== --}}
    <div class="form-section">
        <div class="form-section-header sec-teal">
            <div class="step-badge">02</div>
            <h2>Unggah Dokumen Pendukung</h2>
        </div>
        <div class="form-section-body">

            {{-- File preview --}}
            <div class="file-preview" id="file-preview">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9B1FCA" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="file-preview-name" id="file-name-text"></span>
                <button type="button" class="file-remove" onclick="removeFile()">&#10005; Hapus</button>
            </div>

            {{-- Dropzone --}}
            <div class="upload-dropzone" id="dropzone">
                <input type="file" name="dokumen" id="dokumen-input" accept=".pdf,.doc,.docx" onchange="handleFile(this)">
                <div class="upload-icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#9B1FCA" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="12" y2="12"/><line x1="15" y1="15" x2="12" y2="12"/></svg>
                </div>
                <div class="upload-title">Tarik &amp; Lepas File ke Sini</div>
                <div class="upload-sub">Atau klik untuk memilih dari komputer Anda</div>
                <div class="upload-tags">
                    <span class="upload-tag">PDF</span>
                    <span class="upload-tag">DOCX</span>
                    <span class="upload-tag">MAX 5MB</span>
                </div>
            </div>

            {{-- Warning --}}
            <div class="warning-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div>
                    <div class="warning-title">Peringatan Penting</div>
                    <p>Pastikan dokumen sudah ditandatangani dan di-scan dengan jelas. Dokumen yang tidak terbaca akan ditolak otomatis oleh sistem.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== SECTION 03 ===== --}}
    <div class="form-section">
        <div class="form-section-header sec-yellow">
            <div class="step-badge">03</div>
            <h2>Catatan Tambahan</h2>
        </div>
        <div class="form-section-body">
            <div class="form-group">
                <label>Informasi Tambahan (Opsional)</label>
                <textarea name="catatan" placeholder="Tuliskan keterangan tambahan jika ada (misal: keperluan mendesak, detail alamat pengiriman, dll)..."></textarea>
            </div>
        </div>
    </div>

    {{-- ===== ACTIONS ===== --}}
    <div class="form-actions">
        <a href="/dashboard" class="btn-batal">Batal</a>
        <button type="button" class="btn-kirim" onclick="submitForm()">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            Kirim Pengajuan Sekarang
        </button>
    </div>

    {{-- Footer info --}}
    <div class="form-footer-bar">
        <div class="footer-info-item">
            <div class="footer-icon-box fi-purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <span class="fi-label">Format File</span>
                <span class="fi-val">PDF, DOC, DOCX</span>
            </div>
        </div>
        <div class="footer-info-item">
            <div class="footer-icon-box fi-teal">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div>
                <span class="fi-label">Keamanan</span>
                <span class="fi-val">Enkripsi Berkas Aktif</span>
            </div>
        </div>
    </div>

</div>

<script>
const dropzone = document.getElementById('dropzone');

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('drag-over');
});
dropzone.addEventListener('dragleave', () => dropzone.classList.remove('drag-over'));
dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file) showFilePreview(file);
});

function handleFile(input) {
    if (input.files[0]) showFilePreview(input.files[0]);
}

function showFilePreview(file) {
    if (file.size > 5 * 1024 * 1024) { alert('Ukuran file maksimal 5MB!'); return; }
    document.getElementById('file-name-text').textContent = file.name;
    document.getElementById('file-preview').style.display = 'flex';
    dropzone.style.display = 'none';
}

function removeFile() {
    document.getElementById('dokumen-input').value = '';
    document.getElementById('file-preview').style.display = 'none';
    dropzone.style.display = 'block';
}

function submitForm() {
    const layanan = document.getElementById('jenis_layanan').value;
    const judul   = document.getElementById('judul').value.trim();
    if (!layanan) { alert('Silakan pilih jenis layanan terlebih dahulu.'); return; }
    if (!judul)   { alert('Silakan isi judul pengajuan.'); return; }
    alert('Pengajuan berhasil dikirim! (demo)');
}
</script>
@endsection