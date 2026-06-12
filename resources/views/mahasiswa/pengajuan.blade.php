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

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="service-selection">
        <h2>Pilih Jenis Layanan</h2>
        <div class="service-grid">
            <div class="service-card" data-service="cuti">
                <div class="service-icon">📅</div>
                <h3>Pengajuan Cuti Akademik</h3>
                <p>Permohonan cuti studi untuk semester tertentu</p>
                <button type="button" class="btn-select">Pilih Layanan</button>
            </div>
            <div class="service-card" data-service="legalisir">
                <div class="service-icon">✅</div>
                <h3>Legalisir Dokumen</h3>
                <p>Legalitas dokumen akademik dengan cap basah</p>
                <button type="button" class="btn-select">Pilih Layanan</button>
            </div>
        </div>
    </div>

    <div class="pengajuan-form" id="pengajuanForm" style="display: none;">
        <h2>Form Pengajuan - <span id="selectedService"></span></h2>
        <form action="{{ route('mahasiswa.pengajuan.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jenis_layanan" id="jenis_layanan" value="{{ old('jenis_layanan') }}">

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" value="{{ auth()->user()->name }}" disabled>
            </div>
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" value="{{ auth()->user()->nim }}" disabled>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input type="text" id="prodi" value="{{ auth()->user()->prodi }}" disabled>
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" id="semester" value="{{ auth()->user()->semester }}" disabled>
            </div>
            <div class="form-group">
                <label for="keperluan">Keperluan</label>
                <textarea id="keperluan" name="keperluan" rows="4" minlength="10" maxlength="1000" placeholder="Jelaskan keperluan pengajuan ini (minimal 10 karakter)..." required>{{ old('keperluan') }}</textarea>
            </div>

            <div class="form-group">
                <label for="file_ktm">KTM (Kartu Tanda Mahasiswa)</label>
                <input type="file" id="file_ktm" name="file_ktm" accept=".pdf,.jpg,.jpeg,.png" required>
                <small>Format: PDF, JPG, JPEG, PNG &mdash; Maks: 10MB</small>
            </div>
            <div class="form-group">
                <label for="file_surat">Surat Permohonan</label>
                <input type="file" id="file_surat" name="file_surat" accept=".pdf,.jpg,.jpeg,.png" required>
                <small>Format: PDF, JPG, JPEG, PNG &mdash; Maks: 10MB</small>
            </div>
            <div class="form-group">
                <label for="file_tambahan">Dokumen Tambahan (Opsional)</label>
                <input type="file" id="file_tambahan" name="file_tambahan" accept=".pdf,.jpg,.jpeg,.png">
                <small>Format: PDF, JPG, JPEG, PNG &mdash; Maks: 10MB</small>
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
const serviceNames = {
    cuti: 'Pengajuan Cuti Akademik',
    legalisir: 'Legalisir Dokumen'
};

document.querySelectorAll('.btn-select').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = this.parentElement;
        const service = card.dataset.service;
        const serviceName = card.querySelector('h3').textContent;

        document.getElementById('selectedService').textContent = serviceName;
        document.getElementById('jenis_layanan').value = service;
        document.querySelector('.service-selection').style.display = 'none';
        document.getElementById('pengajuanForm').style.display = 'block';
    });
});

function backToSelection() {
    document.getElementById('pengajuanForm').style.display = 'none';
    document.querySelector('.service-selection').style.display = 'block';
}

// Jika ada error validasi / old input, tampilkan kembali form
@if ($errors->any() || old('jenis_layanan'))
    (function() {
        const jenis = "{{ old('jenis_layanan') }}";
        document.getElementById('selectedService').textContent = serviceNames[jenis] || '';
        document.querySelector('.service-selection').style.display = 'none';
        document.getElementById('pengajuanForm').style.display = 'block';
    })();
@endif
</script>
@endsection