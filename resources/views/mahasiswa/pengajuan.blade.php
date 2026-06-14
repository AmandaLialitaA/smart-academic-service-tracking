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
    {{-- POINT 5: Flash error/sukses HANYA dari session, tidak ada JS alert tambahan --}}
    @if(session('error'))
        <div style="background:#fff6f6;border:2px solid #E53935;padding:14px 18px;margin-bottom:16px;color:#a00;font-weight:600;">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background:#fff6f6;border:2px solid #E53935;padding:14px 18px;margin-bottom:16px;color:#a00;">
            <strong>Form belum valid:</strong>
            <ul style="margin:8px 0 0 18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="pengajuan-form" method="POST" action="{{ route('mahasiswa.pengajuan.store') }}" enctype="multipart/form-data">
        @csrf

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
                            <select name="jenis_layanan" id="jenis_layanan" required>
                                <option value="" disabled {{ old('jenis_layanan') ? '' : 'selected' }}>-- Pilih Layanan --</option>
                                <option value="cuti" {{ old('jenis_layanan') === 'cuti' ? 'selected' : '' }}>Pengajuan Cuti Akademik</option>
                                <option value="legalisir" {{ old('jenis_layanan') === 'legalisir' ? 'selected' : '' }}>Legalisir Ijazah Elektronik</option>
                                <option value="magang" {{ old('jenis_layanan') === 'magang' ? 'selected' : '' }}>Surat Pengantar Magang</option>
                                <option value="lainnya" {{ old('jenis_layanan') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <span class="select-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        </div>
                        <span class="form-hint">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Pastikan data profil Anda sudah benar di Dashboard.
                        </span>
                        @error('jenis_layanan')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Keperluan Pengajuan</label>
                        <input type="text" name="keperluan" id="keperluan" value="{{ old('keperluan') }}" placeholder="Contoh: Pengajuan Legalisir untuk Beasiswa" required>
                        @error('keperluan')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
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
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>KTM / Kartu Mahasiswa</label>
                        <input type="file" name="file_ktm" id="file_ktm" accept=".pdf,.jpg,.jpeg,.png" required>
                        <span class="form-hint">Wajib diunggah. Maks. 10MB. Format PDF, JPG, atau PNG.</span>
                        @error('file_ktm')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Surat Permohonan</label>
                        <input type="file" name="file_surat" id="file_surat" accept=".pdf,.jpg,.jpeg,.png" required>
                        <span class="form-hint">Wajib diunggah. Maks. 10MB. Format PDF, JPG, atau PNG.</span>
                        @error('file_surat')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Dokumen Tambahan (Opsional)</label>
                    <input type="file" name="file_tambahan" id="file_tambahan" accept=".pdf,.jpg,.jpeg,.png">
                    <span class="form-hint">Opsional. Maks. 5MB. PDF, JPG, atau PNG.</span>
                    @error('file_tambahan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="file-guidelines">
                    <p><strong>Catatan:</strong> Hanya terima file PDF, JPG, atau PNG. Ukuran maksimal 10MB setiap file.</p>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 03 ===== --}}
        {{-- POINT 6: textarea catatan sudah ada, name="catatan" dikirim ke controller --}}
        <div class="form-section">
            <div class="form-section-header sec-yellow">
                <div class="step-badge">03</div>
                <h2>Catatan Tambahan</h2>
            </div>
            <div class="form-section-body">
                <div class="form-group">
                    <label>Informasi Tambahan (Opsional)</label>
                    <textarea name="catatan" placeholder="Tuliskan keterangan tambahan jika ada (misal: keperluan mendesak, detail alamat pengiriman, dll)...">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ===== ACTIONS ===== --}}
        <div class="form-actions">
            <a href="/dashboard" class="btn-batal">Batal</a>
            {{-- POINT 5: tombol submit biasa — tidak ada onclick JS alert, tidak ada double submit --}}
            <button type="submit" class="btn-kirim" id="btn-kirim">
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
                    <span class="fi-val">PDF, JPG, PNG</span>
                </div>
            </div>
            <div class="footer-info-item">
                <div class="footer-icon-box fi-teal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </div>
                <div>
                    <span class="fi-label">Ukuran Maksimal</span>
                    <span class="fi-val">10MB per File</span>
                </div>
            </div>
            <div class="footer-info-item">
                <div class="footer-icon-box fi-purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div>
                    <span class="fi-label">Keamanan</span>
                    <span class="fi-val">Enkripsi Berkas Aktif</span>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- POINT 5: Cegah double submit — disable tombol setelah klik pertama --}}
<script>
    document.getElementById('pengajuan-form').addEventListener('submit', function () {
        const btn = document.getElementById('btn-kirim');
        btn.disabled = true;
        btn.innerHTML = '⏳ Mengirim...';
    });
</script>
@endsection