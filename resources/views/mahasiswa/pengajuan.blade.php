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
        <span>{{ auth()->user()->prodi ?? 'Universitas Muhammadiyah Surakarta' }}</span>
        <span>2023/2024</span>
    </div>
</div>
@endsection
@section('content')
<script>document.body.classList.add('mahasiswa-page');</script>

@if(session('error'))
    <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:12px 16px;margin-bottom:16px;">
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:12px 16px;margin-bottom:16px;">
        <ul style="margin:0;padding-left:1rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="pengajuan-main">
    <p>Pilih jenis layanan akademik yang ingin Anda ajukan. Pastikan Anda telah mempersiapkan dokumen yang diperlukan.</p>

    {{-- Pilih layanan --}}
    <div class="service-selection" id="serviceSelection">
        <h2>Pilih Jenis Layanan</h2>
        <div class="service-grid">
            <div class="service-card" data-service="aktif-kuliah" data-label="Surat Keterangan Aktif Kuliah">
                <div class="service-icon">📄</div>
                <h3>Surat Keterangan Aktif Kuliah</h3>
                <p>Surat keterangan untuk keperluan administrasi eksternal</p>
                <button class="btn-select" type="button">Pilih Layanan</button>
            </div>
            <div class="service-card" data-service="transkrip" data-label="Transkrip Nilai Sementara">
                <div class="service-icon">📊</div>
                <h3>Transkrip Nilai Sementara</h3>
                <p>Dokumen nilai akademik untuk berbagai keperluan</p>
                <button class="btn-select" type="button">Pilih Layanan</button>
            </div>
            <div class="service-card" data-service="cuti" data-label="Pengajuan Cuti Akademik">
                <div class="service-icon">📅</div>
                <h3>Pengajuan Cuti Akademik</h3>
                <p>Permohonan cuti studi untuk semester tertentu</p>
                <button class="btn-select" type="button">Pilih Layanan</button>
            </div>
            <div class="service-card" data-service="legalisir" data-label="Legalisir Dokumen">
                <div class="service-icon">✅</div>
                <h3>Legalisir Dokumen</h3>
                <p>Legalitas dokumen akademik dengan cap basah</p>
                <button class="btn-select" type="button">Pilih Layanan</button>
            </div>
        </div>
    </div>

    {{-- Form pengajuan - tersembunyi sampai layanan dipilih --}}
    <div class="pengajuan-form" id="pengajuanForm" style="display:none;">
        <h2>Form Pengajuan — <span id="selectedServiceLabel"></span></h2>

        <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Hidden: jenis layanan dari pilihan card --}}
            <input type="hidden" name="jenis_layanan" id="inputJenisLayanan">

            {{-- Data mahasiswa diisi otomatis dari database --}}
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" value="{{ auth()->user()->name }}" disabled
                       style="background:#f3f3f3;color:#888;">
            </div>
            <div class="form-group">
                <label>NIM</label>
                <input type="text" value="{{ auth()->user()->nim ?? '-' }}" disabled
                       style="background:#f3f3f3;color:#888;">
            </div>
            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" value="{{ auth()->user()->prodi ?? '-' }}" disabled
                       style="background:#f3f3f3;color:#888;">
            </div>
            <div class="form-group">
                <label>Semester</label>
                <input type="text" value="{{ auth()->user()->semester ?? '-' }}" disabled
                       style="background:#f3f3f3;color:#888;">
            </div>
            <div class="form-group">
                <label for="keperluan">Keperluan <span style="color:red">*</span></label>
                <textarea id="keperluan" name="keperluan" rows="4"
                          placeholder="Jelaskan keperluan pengajuan ini..."
                          required>{{ old('keperluan') }}</textarea>
            </div>

            {{-- Upload dokumen --}}
            <div class="form-group">
                <label for="file_ktm">KTM (Kartu Tanda Mahasiswa) <span style="color:red">*</span></label>
                <input type="file" id="file_ktm" name="file_ktm"
                       accept=".pdf,.jpg,.jpeg,.png" required>
                <small style="color:#888;">Format: PDF/JPG/PNG, maks 2MB</small>
            </div>
            <div class="form-group">
                <label for="file_surat">Surat Permohonan <span style="color:red">*</span></label>
                <input type="file" id="file_surat" name="file_surat"
                       accept=".pdf,.jpg,.jpeg,.png" required>
                <small style="color:#888;">Format: PDF/JPG/PNG, maks 2MB</small>
            </div>
            <div class="form-group">
                <label for="file_tambahan">Dokumen Tambahan (opsional)</label>
                <input type="file" id="file_tambahan" name="file_tambahan"
                       accept=".pdf,.jpg,.jpeg,.png">
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
        const card    = this.parentElement;
        const service = card.dataset.service;
        const label   = card.dataset.label;

        document.getElementById('inputJenisLayanan').value     = service;
        document.getElementById('selectedServiceLabel').textContent = label;
        document.getElementById('serviceSelection').style.display  = 'none';
        document.getElementById('pengajuanForm').style.display      = 'block';
    });
});

function backToSelection() {
    document.getElementById('pengajuanForm').style.display     = 'none';
    document.getElementById('serviceSelection').style.display  = 'block';
}
</script>
@endsection