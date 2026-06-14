{{-- resources/views/dosen/ttd.blade.php --}}

@extends('layouts.app')

@section('title', 'Tanda Tangan Digital — ' . $pengajuan->kode)

@section('content')
<div style="max-width:680px;margin:0 auto;padding:32px 16px;">

    {{-- Header --}}
    <div style="margin-bottom:24px;">
        <a href="{{ route('dosen.menunggu') }}"
           style="font-size:13px;color:#888;text-decoration:none;">← Kembali</a>
        <h1 style="font-size:22px;font-weight:700;margin:10px 0 2px;">Tanda Tangan Digital</h1>
        <p style="font-size:13px;color:#888;">{{ $pengajuan->kode }}</p>
    </div>

    {{-- Info pengajuan --}}
    <div style="border:2px solid #111;border-radius:8px;padding:18px;margin-bottom:16px;background:#fff;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
            <div>
                <p style="font-size:11px;color:#aaa;margin-bottom:3px;text-transform:uppercase;letter-spacing:.05em;">Mahasiswa</p>
                <p style="font-size:14px;font-weight:600;margin:0;">{{ $pengajuan->nama_mahasiswa }}</p>
                <p style="font-size:12px;color:#888;margin:2px 0 0;">{{ $pengajuan->nim_mahasiswa }}</p>
            </div>
            <div>
                <p style="font-size:11px;color:#aaa;margin-bottom:3px;text-transform:uppercase;letter-spacing:.05em;">Jenis Layanan</p>
                <p style="font-size:14px;font-weight:600;margin:0;">{{ \App\Models\Pengajuan::JENIS_LABEL[$pengajuan->jenis_layanan] }}</p>
            </div>
        </div>

        {{-- Dokumen persyaratan --}}
        @if($pengajuan->dokumen->count())
        <div style="border-top:1px solid #eee;padding-top:14px;">
            <p style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">Dokumen Persyaratan</p>
            <div style="display:flex;flex-direction:column;gap:6px;">
                @foreach($pengajuan->dokumen as $dok)
                <a href="{{ Storage::url($dok->path_file) }}"
                   target="_blank"
                   style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#a259e6;text-decoration:none;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ $dok->nama_file_asli }}
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- TTD sudah ada --}}
    @if($ttdExisting)
    <div style="border:2px solid #27AE60;border-radius:8px;padding:16px;margin-bottom:16px;background:#f0fff4;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
            <div>
                <p style="font-size:13px;font-weight:700;color:#0a7a0a;margin:0 0 4px;">✓ Sudah ditandatangani</p>
                <p style="font-size:12px;color:#4a9a6a;margin:0;">
                    {{ $ttdExisting->ditandatangani_pada->format('d M Y, H:i') }} WIB
                </p>
            </div>
            <img src="{{ $ttdExisting->urlGambar() }}"
                 alt="TTD"
                 style="height:56px;border:1px solid #ccc;border-radius:4px;background:#fff;padding:4px;object-fit:contain;">
        </div>
        <p style="font-size:12px;color:#888;margin:10px 0 0;">
            Gambar ulang tanda tangan di bawah jika ingin mengubah.
        </p>
    </div>
    @endif

    {{-- Canvas area --}}
    <div style="border:2px solid #111;border-radius:8px;padding:20px;background:#fff;">
        <p style="font-size:13px;font-weight:700;margin:0 0 14px;">
            {{ $ttdExisting ? 'Gambar Ulang Tanda Tangan' : 'Tanda Tangan Digital' }}
        </p>

        {{-- Canvas --}}
        <div style="position:relative;border:2px dashed #d1d5db;border-radius:8px;background:#f9fafb;touch-action:none;">
            <canvas id="sign-canvas"
                    style="display:block;width:100%;height:200px;border-radius:8px;cursor:crosshair;">
            </canvas>
            {{-- Garis bantu --}}
            <div style="position:absolute;bottom:32px;left:20px;right:20px;border-bottom:1px solid #d1d5db;pointer-events:none;"></div>
            <p style="position:absolute;bottom:8px;left:0;right:0;text-align:center;font-size:11px;color:#bbb;pointer-events:none;margin:0;">
                Tanda tangan di atas garis
            </p>
        </div>

        {{-- Tombol --}}
        <div style="display:flex;gap:10px;margin-top:14px;">
            <button id="btn-clear"
                    type="button"
                    style="flex:1;padding:10px;border:2px solid #ddd;border-radius:6px;background:#fff;font-size:13px;color:#555;cursor:pointer;font-weight:600;">
                Ulangi
            </button>
            <button id="btn-submit"
                    type="button"
                    style="flex:1;padding:10px;border:none;border-radius:6px;background:#a259e6;color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                Simpan Tanda Tangan
            </button>
        </div>

        {{-- Feedback --}}
        <div id="feedback" style="display:none;margin-top:12px;font-size:13px;border-radius:6px;padding:10px 14px;"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    const canvas   = document.getElementById('sign-canvas');
    const ctx      = canvas.getContext('2d');
    const btnClear = document.getElementById('btn-clear');
    const btnSave  = document.getElementById('btn-submit');
    const feedback = document.getElementById('feedback');
    const catatan  = document.getElementById('input-catatan');

    let isDrawing  = false;
    let hasStrokes = false;

    function resizeCanvas() {
        const rect  = canvas.getBoundingClientRect();
        const ratio = window.devicePixelRatio || 1;
        canvas.width  = rect.width  * ratio;
        canvas.height = rect.height * ratio;
        ctx.scale(ratio, ratio);
        ctx.strokeStyle = '#1a1a2e';
        ctx.lineWidth   = 2.5;
        ctx.lineCap     = 'round';
        ctx.lineJoin    = 'round';
    }

    resizeCanvas();
    window.addEventListener('resize', () => { resizeCanvas(); hasStrokes = false; });

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const src  = e.touches ? e.touches[0] : e;
        return { x: src.clientX - rect.left, y: src.clientY - rect.top };
    }

    function startDraw(e) {
        e.preventDefault();
        isDrawing = true;
        const p = getPos(e);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
    }

    function draw(e) {
        e.preventDefault();
        if (!isDrawing) return;
        const p = getPos(e);
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
        hasStrokes = true;
    }

    function stopDraw(e) { e.preventDefault(); isDrawing = false; }

    canvas.addEventListener('mousedown',  startDraw);
    canvas.addEventListener('mousemove',  draw);
    canvas.addEventListener('mouseup',    stopDraw);
    canvas.addEventListener('mouseleave', stopDraw);
    canvas.addEventListener('touchstart', startDraw, { passive: false });
    canvas.addEventListener('touchmove',  draw,      { passive: false });
    canvas.addEventListener('touchend',   stopDraw,  { passive: false });

    btnClear.addEventListener('click', () => {
        const rect = canvas.getBoundingClientRect();
        ctx.clearRect(0, 0, rect.width, rect.height);
        hasStrokes = false;
        feedback.style.display = 'none';
    });

    btnSave.addEventListener('click', async () => {
        if (!hasStrokes) {
            showFeedback('Tanda tangan masih kosong.', 'error');
            return;
        }

        btnSave.disabled    = true;
        btnSave.textContent = 'Menyimpan...';

        const formData = new FormData();
        formData.append('signature_data', canvas.toDataURL('image/png'));
        formData.append('catatan', catatan.value);
        formData.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route("dosen.ttd.store", $pengajuan->id) }}', {
                method: 'POST',
                body: formData,
            });

            if (res.redirected) {
                window.location.href = res.url;
                return;
            }

            if (res.ok) {
                showFeedback('✓ Tanda tangan berhasil disimpan.', 'success');
                btnSave.textContent        = 'Tersimpan';
                btnClear.disabled          = true;
                canvas.style.pointerEvents = 'none';
            } else {
                showFeedback('Gagal menyimpan. Coba lagi.', 'error');
                btnSave.disabled    = false;
                btnSave.textContent = 'Simpan Tanda Tangan';
            }
        } catch (err) {
            showFeedback('Gagal terhubung ke server.', 'error');
            btnSave.disabled    = false;
            btnSave.textContent = 'Simpan Tanda Tangan';
        }
    });

    function showFeedback(msg, type) {
        feedback.textContent   = msg;
        feedback.style.display = 'block';
        feedback.style.background = type === 'success' ? '#f0fff4' : '#fff6f6';
        feedback.style.color      = type === 'success' ? '#0a7a0a' : '#a00';
        feedback.style.border     = type === 'success' ? '1px solid #27AE60' : '1px solid #E53935';
    }
})();
</script>
@endpush