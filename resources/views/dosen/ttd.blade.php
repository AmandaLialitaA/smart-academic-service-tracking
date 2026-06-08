{{-- resources/views/dosen/ttd.blade.php --}}

@extends('layouts.app')

@section('title', 'Tanda Tangan Digital — ' . $pengajuan->kode)

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">

    {{-- Info pengajuan --}}
    <div class="bg-white rounded-xl border shadow-sm p-5 mb-6">
        <p class="text-xs text-gray-400 mb-1">Kode Pengajuan</p>
        <p class="text-lg font-semibold text-gray-800">{{ $pengajuan->kode }}</p>

        <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
            <div>
                <p class="text-gray-400 text-xs">Mahasiswa</p>
                <p class="font-medium">{{ $pengajuan->nama_mahasiswa }}</p>
                <p class="text-gray-500 text-xs">{{ $pengajuan->nim_mahasiswa }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs">Jenis Layanan</p>
                <p class="font-medium">{{ \App\Models\Pengajuan::JENIS_LABEL[$pengajuan->jenis_layanan] }}</p>
            </div>
        </div>

        {{-- Dokumen persyaratan --}}
        @if($pengajuan->dokumen->count())
        <div class="mt-4 border-t pt-3">
            <p class="text-xs text-gray-400 mb-2">Dokumen Persyaratan</p>
            <div class="space-y-1">
                @foreach($pengajuan->dokumen as $dok)
                <a href="{{ Storage::url($dok->path_file) }}"
                   target="_blank"
                   class="flex items-center gap-2 text-sm text-blue-600 hover:underline">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    {{-- TTD sudah ada sebelumnya --}}
    @if($ttdExisting)
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-green-800">✓ Sudah ditandatangani</p>
                <p class="text-xs text-green-600 mt-0.5">
                    {{ $ttdExisting->ditandatangani_pada->format('d M Y, H:i') }} WIB
                </p>
            </div>
            <img src="{{ $ttdExisting->urlGambar() }}"
                 alt="TTD"
                 class="h-16 border rounded bg-white p-1 object-contain">
        </div>
        <p class="text-xs text-gray-500 mt-3">
            Gambar ulang tanda tangan di bawah jika ingin mengubah.
        </p>
    </div>
    @endif

    {{-- Canvas area --}}
    <div class="bg-white rounded-xl border shadow-sm p-5">
        <p class="text-sm font-medium text-gray-700 mb-3">
            {{ $ttdExisting ? 'Gambar Ulang Tanda Tangan' : 'Tanda Tangan Digital' }}
        </p>

        <div class="relative border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 select-none"
             style="touch-action: none;">
            <canvas id="sign-canvas"
                    class="block w-full rounded-lg cursor-crosshair"
                    style="height: 200px;">
            </canvas>
            {{-- Garis bantu --}}
            <div class="absolute bottom-8 left-6 right-6 border-b border-gray-300 pointer-events-none"></div>
            <p class="absolute bottom-2 left-0 right-0 text-center text-xs text-gray-400 pointer-events-none">
                Tanda tangan di atas garis
            </p>
        </div>

        {{-- Form catatan --}}
        <div class="mt-4">
            <label class="block text-xs text-gray-500 mb-1">Catatan (opsional)</label>
            <textarea id="input-catatan"
                      rows="2"
                      placeholder="Disetujui dan ditandatangani..."
                      class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none"></textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex gap-3 mt-4">
            <button id="btn-clear"
                    type="button"
                    class="flex-1 py-2.5 rounded-lg border text-sm text-gray-600 hover:bg-gray-50 transition">
                Ulangi
            </button>
            <button id="btn-submit"
                    type="button"
                    class="flex-1 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Simpan Tanda Tangan
            </button>
        </div>

        {{-- Feedback --}}
        <div id="feedback" class="mt-3 hidden text-sm rounded-lg px-4 py-3"></div>
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

    // Setup canvas resolusi tinggi (retina-safe)
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
        feedback.classList.add('hidden');
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
            const res  = await fetch('{{ route("dosen.ttd.store", $pengajuan->id) }}', {
                method: 'POST',
                body: formData,
            });

            if (res.redirected) {
                // Laravel redirect → ikuti redirect-nya
                window.location.href = res.url;
                return;
            }

            const text = await res.text();
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
        feedback.textContent = msg;
        feedback.className   = 'mt-3 text-sm rounded-lg px-4 py-3 ' +
            (type === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700');
    }
})();
</script>
@endpush
