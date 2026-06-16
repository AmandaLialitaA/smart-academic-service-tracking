@extends('layouts.app')
@section('title', 'Detail Pengajuan Dosen')
@section('head')
    @vite(['resources/css/detail-pengajuan-dosen.css'])
@endsection
@section('sidebar')
    @include('components.sidebar-dosen')
@endsection
@section('content')
<div style="display:flex;height:calc(100vh - 56px);overflow:hidden;">

    {{-- ── PANEL KIRI ── --}}
    <div style="width:280px;min-width:280px;border-right:2px solid #111;overflow-y:auto;background:#fff;display:flex;flex-direction:column;">

        <div style="padding:16px;border-bottom:2px solid #111;">
            <a href="{{ route('dosen.menunggu') }}" style="font-size:12px;color:#888;text-decoration:none;">← Kembali</a>
            <p style="font-size:11px;color:#aaa;margin:8px 0 2px;text-transform:uppercase;letter-spacing:.05em;">Kode Pengajuan</p>
            <p style="font-size:14px;font-weight:800;margin:0;">{{ $pengajuan->kode }}</p>
        </div>

        <div style="padding:16px;border-bottom:1px solid #eee;">
            <p style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px;">Profil Mahasiswa</p>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:40px;height:40px;border-radius:50%;background:#a259e6;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                    {{ strtoupper(substr($pengajuan->nama_mahasiswa, 0, 1)) }}
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;margin:0;">{{ $pengajuan->nama_mahasiswa }}</p>
                    <p style="font-size:11px;color:#a259e6;margin:2px 0 0;">{{ $pengajuan->nim_mahasiswa }}</p>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;">
                <div style="background:#f5f5f5;border-radius:4px;padding:6px 8px;">
                    <p style="font-size:10px;color:#aaa;margin:0 0 1px;text-transform:uppercase;">Program Studi</p>
                    <p style="font-size:12px;font-weight:600;margin:0;">{{ $pengajuan->prodi_mahasiswa }}</p>
                </div>
                <div style="background:#f5f5f5;border-radius:4px;padding:6px 8px;">
                    <p style="font-size:10px;color:#aaa;margin:0 0 1px;text-transform:uppercase;">Semester</p>
                    <p style="font-size:12px;font-weight:600;margin:0;">{{ $pengajuan->semester_mahasiswa }}</p>
                </div>
            </div>
        </div>

        <div style="padding:16px;border-bottom:1px solid #eee;">
            <p style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px;">Detail Layanan</p>
            <p style="font-size:10px;color:#aaa;margin:0 0 2px;">JENIS LAYANAN</p>
            <p style="font-size:13px;font-weight:700;margin:0 0 10px;">{{ $pengajuan->jenis_label }}</p>
            <p style="font-size:10px;color:#aaa;margin:0 0 2px;">TANGGAL PENGAJUAN</p>
            <p style="font-size:13px;font-weight:600;margin:0 0 10px;">{{ $pengajuan->tanggal_submit?->format('d M Y, H:i') }}</p>
            @if($pengajuan->catatan_mahasiswa)
            <div style="background:#faf5ff;border-left:3px solid #a259e6;padding:8px;border-radius:0 4px 4px 0;font-size:12px;color:#555;margin-top:6px;">
                "{{ $pengajuan->catatan_mahasiswa }}"
            </div>
            @endif
            <div style="margin-top:10px;">
                <x-status-badge :pengajuan="$pengajuan" />
            </div>
        </div>

        {{-- Lampiran --}}
        <div style="padding:16px;border-bottom:1px solid #eee;flex:1;">
            <p style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px;">Lampiran ({{ $pengajuan->dokumen->count() }})</p>
            @forelse($pengajuan->dokumen as $i => $doc)
            <button onclick="tampilDokumen({{ $i }})"
                    id="dok-btn-{{ $i }}"
                    style="width:100%;text-align:left;padding:8px;border:1px solid #ddd;border-radius:6px;background:#fff;cursor:pointer;margin-bottom:6px;font-size:12px;display:flex;align-items:center;gap:8px;">
                <span style="font-size:16px;">{{ str_contains($doc->mime_type, 'pdf') ? '📄' : '🖼' }}</span>
                <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $doc->nama_file_asli }}</span>
            </button>
            @empty
            <p style="font-size:12px;color:#aaa;">Tidak ada lampiran.</p>
            @endforelse
        </div>

        {{-- Status TTD --}}
        @if($pengajuan->tandaTangan)
        <div style="padding:16px;background:#f0fff4;border-top:2px solid #27AE60;">
            <p style="font-size:11px;color:#0a7a0a;font-weight:700;margin:0 0 6px;">✅ SUDAH DITANDATANGANI</p>
            <p style="font-size:11px;color:#555;margin:0 0 8px;">{{ $pengajuan->tandaTangan->ditandatangani_pada?->format('d M Y, H:i') }}</p>
            <a href="{{ route('dosen.ttd.unduh', $pengajuan->tandaTangan) }}"
               style="display:block;padding:6px;background:#a259e6;color:#fff;border-radius:4px;text-decoration:none;font-size:12px;text-align:center;">
                ⬇ Unduh Dokumen ber-TTD
            </a>
        </div>
        @endif

    </div>

    {{-- ── PANEL KANAN ── --}}
    <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;background:#666;">

        {{-- Toolbar --}}
        <div style="background:#fff;border-bottom:2px solid #111;padding:10px 16px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;gap:12px;">
            <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
                <span id="viewer-filename" style="font-size:13px;font-weight:600;color:#333;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    @if($pengajuan->dokumen->count()) {{ $pengajuan->dokumen->first()->nama_file_asli }} @else Tidak ada dokumen @endif
                </span>
                {{-- Navigasi halaman PDF --}}
                <div id="page-nav" style="display:none;align-items:center;gap:6px;flex-shrink:0;">
                    <button onclick="changePage(-1)" style="padding:3px 8px;border:1px solid #ddd;border-radius:4px;background:#fff;cursor:pointer;font-size:12px;">‹</button>
                    <span style="font-size:12px;color:#555;white-space:nowrap;">
                        Hal <span id="page-current">1</span> / <span id="page-total">1</span>
                    </span>
                    <button onclick="changePage(1)" style="padding:3px 8px;border:1px solid #ddd;border-radius:4px;background:#fff;cursor:pointer;font-size:12px;">›</button>
                </div>
            </div>
            <a id="viewer-download" href="#"
               style="font-size:12px;padding:5px 12px;background:#111;color:#fff;border-radius:4px;text-decoration:none;flex-shrink:0;">
                ⬇ Unduh
            </a>
        </div>

        {{-- Hint bar TTD (hanya saat mode TTD aktif) --}}
        @if($pengajuan->status === 'dosen_ttd' && !$pengajuan->tanggal_ttd)
        <div id="hint-bar" style="background:#faf5ff;border-bottom:1px solid #d8b4fe;padding:7px 16px;font-size:12px;color:#7c3aed;flex-shrink:0;display:flex;align-items:center;gap:8px;">
            <span id="hint-text">👆 Klik area di PDF untuk meletakkan kotak TTD</span>
            <button id="btn-reset-ttd" onclick="resetTtdBox()" style="display:none;margin-left:auto;padding:3px 10px;border:1px solid #a259e6;border-radius:4px;background:#fff;color:#a259e6;font-size:11px;cursor:pointer;">↩ Pindah Kotak</button>
        </div>
        @endif

        {{-- Area viewer PDF.js --}}
        <div id="viewer-area" style="flex:1;overflow:auto;position:relative;display:flex;justify-content:center;align-items:flex-start;padding:20px;">

            {{-- Wrapper canvas PDF + overlay TTD --}}
            <div id="pdf-wrapper" style="position:relative;display:none;box-shadow:0 4px 20px rgba(0,0,0,.4);">
                <canvas id="pdf-canvas" style="display:block;"></canvas>

                {{-- Overlay klik (aktif sebelum kotak TTD diletakkan) --}}
                @if($pengajuan->status === 'dosen_ttd' && !$pengajuan->tanggal_ttd)
                <div id="click-overlay"
                     style="position:absolute;top:0;left:0;width:100%;height:100%;cursor:crosshair;z-index:5;"></div>

                {{-- Kotak TTD (muncul setelah klik) --}}
                <div id="ttd-box"
                     style="position:absolute;display:none;z-index:10;box-sizing:border-box;
                            border:2px solid #a259e6;border-radius:6px;
                            background:rgba(162,89,230,0.06);
                            width:200px;height:80px;">
                    {{-- Canvas gambar TTD --}}
                    <canvas id="sign-canvas"
                            style="position:absolute;top:0;left:0;width:100%;height:100%;
                                   border-radius:4px;cursor:crosshair;display:block;"></canvas>
                    {{-- Garis bantu --}}
                    <div style="position:absolute;bottom:18px;left:8px;right:8px;
                                border-bottom:1px dashed #c4b5fd;pointer-events:none;"></div>
                    <p style="position:absolute;bottom:2px;left:0;right:0;text-align:center;
                               font-size:10px;color:#c4b5fd;pointer-events:none;margin:0;">
                        Tanda tangan di atas garis
                    </p>
                    {{-- Handle resize --}}
                    <div id="ttd-resize"
                         style="position:absolute;right:-5px;bottom:-5px;width:12px;height:12px;
                                background:#a259e6;border-radius:2px;cursor:se-resize;z-index:11;"></div>
                </div>
                @endif
            </div>

            {{-- Image viewer (untuk lampiran non-PDF) --}}
            <div id="viewer-img-wrap" style="display:none;width:100%;justify-content:center;">
                <img id="viewer-img" src="" style="max-width:100%;box-shadow:0 4px 24px rgba(0,0,0,.3);border-radius:4px;">
            </div>

            {{-- Empty state --}}
            <div id="viewer-empty"
                 style="display:{{ $pengajuan->dokumen->count() ? 'none' : 'flex' }};
                        flex-direction:column;align-items:center;justify-content:center;
                        color:#ccc;gap:8px;width:100%;height:100%;">
                <span style="font-size:48px;">📂</span>
                <p style="font-size:14px;">Tidak ada lampiran</p>
            </div>

            {{-- Loading indicator --}}
            <div id="pdf-loading" style="display:none;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#fff;font-size:14px;">
                Memuat PDF...
            </div>
        </div>

        {{-- ── BOTTOM BAR TTD ── --}}
        @if($pengajuan->status === 'dosen_ttd' && !$pengajuan->tanggal_ttd)
        <div style="background:#fff;border-top:2px solid #111;padding:12px 16px;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">

                {{-- Kontrol TTD --}}
                <div style="display:flex;gap:6px;align-items:center;">
                    <button id="btn-clear" type="button"
                            style="padding:6px 12px;border:1px solid #ddd;border-radius:4px;background:#fff;font-size:11px;color:#555;cursor:pointer;">
                        🔄 Ulangi TTD
                    </button>
                </div>

                {{-- Catatan --}}
                <div style="flex:1;min-width:180px;">
                    <textarea id="input-catatan" rows="2"
                              placeholder="Catatan peninjau (opsional)..."
                              style="width:100%;font-size:12px;border:1px solid #ddd;border-radius:6px;
                                     padding:6px 8px;resize:none;box-sizing:border-box;font-family:inherit;"></textarea>
                </div>

                {{-- Tombol aksi --}}
                <div style="display:flex;gap:8px;align-items:center;flex-shrink:0;">
                    <button id="btn-tolak" type="button"
                            style="padding:8px 14px;border:2px solid #E53935;border-radius:6px;
                                   background:#fff;color:#E53935;font-size:12px;font-weight:700;cursor:pointer;">
                        ✕ Tolak
                    </button>
                    <button id="btn-submit" type="button"
                            style="padding:8px 18px;border:none;border-radius:6px;
                                   background:#a259e6;color:#fff;font-size:12px;font-weight:700;cursor:pointer;">
                        ✍ Approve & TTD
                    </button>
                </div>
            </div>
            <div id="feedback" style="display:none;font-size:12px;border-radius:6px;padding:8px 12px;margin-top:8px;"></div>
        </div>

        <form id="form-tolak" method="POST" action="{{ route('dosen.pengajuan.reject', $pengajuan) }}" style="display:none;">
            @csrf
            <input type="hidden" name="catatan" id="hidden-catatan-tolak">
        </form>

        @elseif($pengajuan->tanggal_ttd && !in_array($pengajuan->status, ['ditolak','selesai']))
        <div style="background:#f0fff4;border-top:2px solid #27AE60;padding:14px 16px;flex-shrink:0;">
            <p style="color:#0a7a0a;font-weight:700;font-size:13px;margin:0;">✅ Sudah ditandatangani pada {{ $pengajuan->tanggal_ttd->format('d M Y, H:i') }}.</p>
            <p style="font-size:12px;color:#555;margin:4px 0 0;">Menunggu checklist selesai dari Admin.</p>
        </div>
        @elseif($pengajuan->status === 'selesai')
        <div style="background:#f0fff4;border-top:2px solid #27AE60;padding:14px 16px;flex-shrink:0;">
            <p style="color:#0a7a0a;font-weight:700;font-size:13px;margin:0;">✅ Pengajuan ini telah Selesai diproses.</p>
        </div>
        @elseif($pengajuan->status === 'ditolak')
        <div style="background:#fff6f6;border-top:2px solid #E53935;padding:14px 16px;flex-shrink:0;">
            <p style="color:#a00;font-weight:700;font-size:13px;margin:0;">❌ Pengajuan ini telah Ditolak.</p>
            @if($pengajuan->catatan_penolakan)
            <p style="font-size:12px;color:#555;margin:4px 0 0;"><strong>Alasan:</strong> {{ $pengajuan->catatan_penolakan }}</p>
            @endif
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

// ── Data dokumen dari controller ──
const dokumenList = @json($dokumenList);

// ── State global ──
let pdfDoc       = null;
let currentPage  = 1;
let totalPages   = 1;
let pdfScale     = 1.4;
let currentMime  = '';

// ── Elemen DOM ──
const pdfWrapper   = document.getElementById('pdf-wrapper');
const pdfCanvas    = document.getElementById('pdf-canvas');
const pdfCtx       = pdfCanvas ? pdfCanvas.getContext('2d') : null;
const imgWrap      = document.getElementById('viewer-img-wrap');
const emptyState   = document.getElementById('viewer-empty');
const pdfLoading   = document.getElementById('pdf-loading');
const pageNav      = document.getElementById('page-nav');
const pageCurrentEl= document.getElementById('page-current');
const pageTotalEl  = document.getElementById('page-total');
const filenameEl   = document.getElementById('viewer-filename');
const downloadEl   = document.getElementById('viewer-download');

// ── Render halaman PDF ──
async function renderPage(num) {
    if (!pdfDoc) return;
    const page     = await pdfDoc.getPage(num);
    const viewport = page.getViewport({ scale: pdfScale });

    pdfCanvas.width  = viewport.width;
    pdfCanvas.height = viewport.height;
    pdfWrapper.style.width  = viewport.width + 'px';
    pdfWrapper.style.height = viewport.height + 'px';

    await page.render({ canvasContext: pdfCtx, viewport }).promise;

    currentPage = num;
    if (pageCurrentEl) pageCurrentEl.textContent = num;
}

// ── Load PDF via PDF.js ──
async function loadPdf(url) {
    pdfLoading.style.display = 'block';
    pdfWrapper.style.display = 'none';
    imgWrap.style.display    = 'none';

    try {
        pdfDoc     = await pdfjsLib.getDocument(url).promise;
        totalPages = pdfDoc.numPages;

        if (pageTotalEl) pageTotalEl.textContent = totalPages;
        if (pageNav) pageNav.style.display = totalPages > 1 ? 'flex' : 'none';

        await renderPage(1);

        pdfWrapper.style.display = 'block';
        pdfLoading.style.display = 'none';
        emptyState.style.display = 'none';

        // Reset posisi kotak TTD setelah PDF baru dimuat
        resetTtdBox();
    } catch (err) {
        pdfLoading.style.display = 'none';
        console.error('Gagal load PDF:', err);
    }
}

// ── Navigasi halaman ──
function changePage(delta) {
    const target = currentPage + delta;
    if (target < 1 || target > totalPages) return;
    renderPage(target);
}

// ── Tampil dokumen (dipanggil dari tombol sidebar) ──
function tampilDokumen(idx) {
    const dok = dokumenList[idx];
    if (!dok) return;

    filenameEl.textContent = dok.nama;
    downloadEl.href        = dok.unduh;
    currentMime            = dok.mime || '';
    pdfDoc                 = null;
    currentPage            = 1;

    const isPdf = currentMime.includes('pdf');

    if (isPdf) {
        imgWrap.style.display = 'none';
        loadPdf(dok.url);
    } else {
        pdfWrapper.style.display = 'none';
        if (pageNav) pageNav.style.display = 'none';
        imgWrap.style.display    = 'flex';
        emptyState.style.display = 'none';
        document.getElementById('viewer-img').src = dok.url;
        pdfLoading.style.display = 'none';
    }

    // Highlight tombol sidebar
    dokumenList.forEach((_, i) => {
        const btn = document.getElementById('dok-btn-' + i);
        if (!btn) return;
        btn.style.borderColor = i === idx ? '#a259e6' : '#ddd';
        btn.style.background  = i === idx ? '#faf5ff' : '#fff';
        btn.style.fontWeight  = i === idx ? '700' : '400';
    });
}

// Load dokumen pertama otomatis
if (dokumenList.length > 0) tampilDokumen(0);

// ══════════════════════════════════════════════
// ── TTD: Klik PDF → muncul kotak TTD ──
// ══════════════════════════════════════════════
(function () {
    const clickOverlay = document.getElementById('click-overlay');
    const ttdBox       = document.getElementById('ttd-box');
    const signCanvas   = document.getElementById('sign-canvas');
    const btnClear     = document.getElementById('btn-clear');
    const btnSubmit    = document.getElementById('btn-submit');
    const btnTolak     = document.getElementById('btn-tolak');
    const btnResetTtd  = document.getElementById('btn-reset-ttd');
    const hintText     = document.getElementById('hint-text');
    const feedback     = document.getElementById('feedback');
    const catatan      = document.getElementById('input-catatan');

    // Tidak ada elemen TTD = status bukan dosen_ttd
    if (!clickOverlay || !ttdBox || !signCanvas) return;

    const signCtx  = signCanvas.getContext('2d');
    let isDrawing  = false;
    let hasStrokes = false;
    let isDragging = false;
    let isResizing = false;
    let dragOffX   = 0, dragOffY = 0;
    let resizeStartX = 0, resizeStartY = 0;
    let resizeStartW = 0, resizeStartH = 0;

    // ── Setup sign-canvas ──
    function setupSignCanvas() {
        const rect  = signCanvas.getBoundingClientRect();
        const ratio = window.devicePixelRatio || 1;
        signCanvas.width  = rect.width  * ratio;
        signCanvas.height = rect.height * ratio;
        signCtx.scale(ratio, ratio);
        signCtx.strokeStyle = '#1a1a2e';
        signCtx.lineWidth   = 2;
        signCtx.lineCap     = 'round';
        signCtx.lineJoin    = 'round';
        hasStrokes = false;
    }

    // ── Klik di PDF → letakkan kotak TTD ──
    clickOverlay.addEventListener('click', function (e) {
        const rect  = pdfWrapper.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const clickY = e.clientY - rect.top;

        const boxW = ttdBox.offsetWidth  || 200;
        const boxH = ttdBox.offsetHeight || 80;

        // Tengahkan kotak di titik klik, clamp ke batas PDF
        let left = clickX - boxW / 2;
        let top  = clickY - boxH / 2;
        left = Math.max(0, Math.min(left, pdfCanvas.width  - boxW));
        top  = Math.max(0, Math.min(top,  pdfCanvas.height - boxH));

        ttdBox.style.left    = left + 'px';
        ttdBox.style.top     = top  + 'px';
        ttdBox.style.display = 'block';

        // Sembunyikan overlay klik, kotak TTD sudah aktif
        clickOverlay.style.display = 'none';

        // Update hint
        if (hintText) hintText.textContent = '✍ Gambar tanda tangan di dalam kotak ungu';
        if (btnResetTtd) btnResetTtd.style.display = 'inline-block';

        setupSignCanvas();
    });

    // ── Reset: kembali ke mode klik ──
    window.resetTtdBox = function () {
        ttdBox.style.display       = 'none';
        clickOverlay.style.display = 'block';
        if (hintText) hintText.textContent = '👆 Klik area di PDF untuk meletakkan kotak TTD';
        if (btnResetTtd) btnResetTtd.style.display = 'none';
        if (feedback) feedback.style.display = 'none';
        hasStrokes = false;
    };

    // ── DRAG kotak TTD ──
    ttdBox.addEventListener('mousedown', function (e) {
        // Jangan drag jika klik di resize handle atau sedang gambar
        if (e.target.id === 'ttd-resize' || e.target === signCanvas) return;
        e.preventDefault();
        isDragging = true;
        dragOffX   = e.clientX - ttdBox.getBoundingClientRect().left;
        dragOffY   = e.clientY - ttdBox.getBoundingClientRect().top;
        ttdBox.style.cursor = 'grabbing';
    });

    document.addEventListener('mousemove', function (e) {
        if (isDragging) {
            const wrapRect = pdfWrapper.getBoundingClientRect();
            let newLeft = e.clientX - wrapRect.left - dragOffX;
            let newTop  = e.clientY - wrapRect.top  - dragOffY;
            newLeft = Math.max(0, Math.min(newLeft, pdfCanvas.width  - ttdBox.offsetWidth));
            newTop  = Math.max(0, Math.min(newTop,  pdfCanvas.height - ttdBox.offsetHeight));
            ttdBox.style.left = newLeft + 'px';
            ttdBox.style.top  = newTop  + 'px';
        }
        if (isResizing) {
            const dx = e.clientX - resizeStartX;
            const dy = e.clientY - resizeStartY;
            ttdBox.style.width  = Math.max(120, resizeStartW + dx) + 'px';
            ttdBox.style.height = Math.max(50,  resizeStartH + dy) + 'px';
        }
    });

    document.addEventListener('mouseup', function () {
        if (isDragging) {
            ttdBox.style.cursor = 'move';
            isDragging = false;
            // Resize canvas sign setelah drag selesai
            if (hasStrokes) return; // jangan reset jika sudah ada TTD
            setupSignCanvas();
        }
        if (isResizing) {
            isResizing = false;
            setupSignCanvas();
        }
    });

    // ── RESIZE handle ──
    const resizeHandle = document.getElementById('ttd-resize');
    if (resizeHandle) {
        resizeHandle.addEventListener('mousedown', function (e) {
            e.preventDefault();
            e.stopPropagation();
            isResizing   = true;
            resizeStartX = e.clientX;
            resizeStartY = e.clientY;
            resizeStartW = ttdBox.offsetWidth;
            resizeStartH = ttdBox.offsetHeight;
        });
    }

    // ── DRAW tanda tangan ──
    function getPos(e) {
        const rect = signCanvas.getBoundingClientRect();
        const src  = e.touches ? e.touches[0] : e;
        return { x: src.clientX - rect.left, y: src.clientY - rect.top };
    }

    signCanvas.addEventListener('mousedown',  e => { e.preventDefault(); e.stopPropagation(); isDrawing = true; const p = getPos(e); signCtx.beginPath(); signCtx.moveTo(p.x, p.y); });
    signCanvas.addEventListener('mousemove',  e => { e.preventDefault(); if (!isDrawing) return; const p = getPos(e); signCtx.lineTo(p.x, p.y); signCtx.stroke(); hasStrokes = true; });
    signCanvas.addEventListener('mouseup',    e => { e.preventDefault(); isDrawing = false; });
    signCanvas.addEventListener('mouseleave', e => { isDrawing = false; });
    signCanvas.addEventListener('touchstart', e => { e.preventDefault(); e.stopPropagation(); isDrawing = true; const p = getPos(e); signCtx.beginPath(); signCtx.moveTo(p.x, p.y); }, { passive: false });
    signCanvas.addEventListener('touchmove',  e => { e.preventDefault(); if (!isDrawing) return; const p = getPos(e); signCtx.lineTo(p.x, p.y); signCtx.stroke(); hasStrokes = true; }, { passive: false });
    signCanvas.addEventListener('touchend',   e => { e.preventDefault(); isDrawing = false; }, { passive: false });

    // ── Ulangi TTD ──
    if (btnClear) btnClear.addEventListener('click', () => {
        setupSignCanvas();
        if (feedback) feedback.style.display = 'none';
    });

    // ── Submit TTD ──
    if (btnSubmit) btnSubmit.addEventListener('click', async () => {
        if (ttdBox.style.display === 'none') {
            showFeedback('Klik area di PDF untuk meletakkan kotak TTD dulu.', 'error');
            return;
        }
        if (!hasStrokes) {
            showFeedback('Tanda tangan masih kosong. Gambar dulu di kotak ungu.', 'error');
            return;
        }

        btnSubmit.disabled    = true;
        btnSubmit.textContent = 'Menyimpan...';

        // Hitung koordinat dalam fraksi (0–1) relatif terhadap canvas PDF
        const boxLeft = parseFloat(ttdBox.style.left) || 0;
        const boxTop  = parseFloat(ttdBox.style.top)  || 0;
        const boxW    = ttdBox.offsetWidth;
        const boxH    = ttdBox.offsetHeight;
        const cW      = pdfCanvas.width;
        const cH      = pdfCanvas.height;

        const formData = new FormData();
        formData.append('signature_data', signCanvas.toDataURL('image/png'));
        formData.append('catatan',        catatan ? catatan.value : '');
        formData.append('ttd_page',       currentPage);
        formData.append('ttd_x_pct',      (boxLeft / cW).toFixed(6));
        formData.append('ttd_y_pct',      (boxTop  / cH).toFixed(6));
        formData.append('ttd_w_pct',      (boxW    / cW).toFixed(6));
        formData.append('ttd_h_pct',      (boxH    / cH).toFixed(6));
        formData.append('_token',         '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route("dosen.ttd.store", $pengajuan->id) }}', {
                method: 'POST',
                body  : formData,
            });

            if (res.redirected) { window.location.href = res.url; return; }

            if (res.ok) {
                showFeedback('✓ Tanda tangan berhasil disimpan.', 'success');
                btnSubmit.textContent = 'Tersimpan';
                if (btnClear) btnClear.disabled = true;
                signCanvas.style.pointerEvents  = 'none';
                ttdBox.style.cursor             = 'default';
            } else {
                const json = await res.json().catch(() => ({}));
                showFeedback(json.message || 'Gagal menyimpan. Coba lagi.', 'error');
                btnSubmit.disabled    = false;
                btnSubmit.textContent = '✍ Approve & TTD';
            }
        } catch (err) {
            showFeedback('Gagal terhubung ke server.', 'error');
            btnSubmit.disabled    = false;
            btnSubmit.textContent = '✍ Approve & TTD';
        }
    });

    // ── Tolak ──
    if (btnTolak) btnTolak.addEventListener('click', () => {
        const alasan = catatan ? catatan.value.trim() : '';
        if (!alasan || alasan.length < 5) {
            showFeedback('Isi catatan alasan penolakan (min. 5 karakter).', 'error');
            if (catatan) catatan.focus();
            return;
        }
        if (!confirm('Yakin ingin menolak pengajuan ini?')) return;
        document.getElementById('hidden-catatan-tolak').value = alasan;
        document.getElementById('form-tolak').submit();
    });

    function showFeedback(msg, type) {
        if (!feedback) return;
        feedback.textContent      = msg;
        feedback.style.display    = 'block';
        feedback.style.background = type === 'success' ? '#f0fff4' : '#fff6f6';
        feedback.style.color      = type === 'success' ? '#0a7a0a' : '#a00';
        feedback.style.border     = type === 'success' ? '1px solid #27AE60' : '1px solid #E53935';
    }
})();
</script>
@endpush
@endsection