@extends('layouts.app')
@section('title', 'Form Pengajuan Layanan')
@section('head')
    @vite(['resources/css/pengajuan.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-mahasiswa')
@endsection
@section('navbar')
<div class="navbar-content">
    <h1>AJUKAN LAYANAN AKADEMIK</h1>
    <div class="user-info">
        <span>Universitas Muhammadiyah Surakarta</span>
        <span>2023/2024</span>
    </div>
</div>
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>
<div class="pengajuan-main">
    <p>Pilih jenis layanan akademik yang ingin Anda ajukan. Pastikan Anda telah mempersiapkan dokumen yang diperlukan.</p>

    <div class="service-selection">
        <h2>Pilih Jenis Layanan</h2>
        <div class="service-grid">
            <div class="service-card" data-service="aktif-kuliah">
                <div class="service-icon">📄</div>
                <h3>Surat Keterangan Aktif Kuliah</h3>
                <p>Surat keterangan untuk keperluan administrasi eksternal</p>
                <button class="btn-select">Pilih Layanan</button>
            </div>
            <div class="service-card" data-service="transkrip">
                <div class="service-icon">📊</div>
                <h3>Transkrip Nilai Sementara</h3>
                <p>Dokumen nilai akademik untuk berbagai keperluan</p>
                <button class="btn-select">Pilih Layanan</button>
            </div>
            <div class="service-card" data-service="cuti">
                <div class="service-icon">📅</div>
                <h3>Pengajuan Cuti Akademik</h3>
                <p>Permohonan cuti studi untuk semester tertentu</p>
                <button class="btn-select">Pilih Layanan</button>
            </div>
            <div class="service-card" data-service="legalisir">
                <div class="service-icon">✅</div>
                <h3>Legalisir Dokumen</h3>
                <p>Legalitas dokumen akademik dengan cap basah</p>
                <button class="btn-select">Pilih Layanan</button>
            </div>
        </div>
    </div>

    <div class="pengajuan-form" id="pengajuanForm" style="display: none;">
        <h2>Form Pengajuan - <span id="selectedService"></span></h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input type="text" id="prodi" name="prodi" required>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="number" id="semester" name="semester" required>
            </div>
            <div class="form-group">
                <label for="keperluan">Keperluan</label>
                <textarea id="keperluan" name="keperluan" rows="4" placeholder="Jelaskan keperluan pengajuan ini..." required></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="backToSelection()">Kembali</button>
                <button type="submit" class="btn-primary">Ajukan Layanan</button>
            </div>
        </form>
    </div>

    <div class="info-panel">
        <h3>Persyaratan Umum</h3>
        <ul>
            <li>KTM (Kartu Tanda Mahasiswa) aktif</li>
            <li>IPK minimal 2.00 untuk layanan tertentu</li>
            <li>Tidak dalam masa cuti akademik</li>
            <li>Membayar biaya administrasi sesuai jenis layanan</li>
        </ul>
    </div>
</div>

<script>
document.querySelectorAll('.btn-select').forEach(btn => {
    btn.addEventListener('click', function() {
        const service = this.parentElement.dataset.service;
        const serviceName = this.parentElement.querySelector('h3').textContent;

        document.getElementById('selectedService').textContent = serviceName;
        document.querySelector('.service-selection').style.display = 'none';
        document.getElementById('pengajuanForm').style.display = 'block';
    });
});

function backToSelection() {
    document.getElementById('pengajuanForm').style.display = 'none';
    document.querySelector('.service-selection').style.display = 'block';
}
</script>
@endsection
