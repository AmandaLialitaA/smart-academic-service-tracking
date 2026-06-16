<?php

namespace App\Http\Controllers;

use App\Models\DokumenPengajuan;
use App\Models\Pengajuan;
use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class TandaTanganController extends Controller
{
    // ── Show form TTD (jika ada view terpisah) ────────────────
    public function show(Pengajuan $pengajuan)
    {
        abort_unless(
            $pengajuan->status === 'dosen_ttd' && !$pengajuan->tanggal_ttd,
            403
        );
        return view('dosen.detail-pengajuan', compact('pengajuan'));
    }

    // ── Simpan TTD + embed ke PDF ─────────────────────────────
    public function store(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'signature_data' => 'required|string',
            'ttd_page'       => 'required|integer|min:1',
            'ttd_x_pct'      => 'required|numeric|between:0,1',
            'ttd_y_pct'      => 'required|numeric|between:0,1',
            'ttd_w_pct'      => 'required|numeric|between:0,1',
            'ttd_h_pct'      => 'required|numeric|between:0,1',
        ]);

        // 1. Ambil dokumen PDF pertama (selain KTM)
        // DokumenPengajuan tidak punya kolom 'jenis', filter via nama_dokumen
        $dokumen = $pengajuan->dokumen()
            ->where('mime_type', 'application/pdf')
            ->where('nama_dokumen', '!=', 'ktm')
            ->first();

        abort_unless($dokumen, 404, 'Dokumen PDF tidak ditemukan.');

        // 2. Decode base64 signature → simpan sebagai PNG sementara
        $sigBase64  = preg_replace('/^data:image\/\w+;base64,/', '', $request->signature_data);
        $sigBinary  = base64_decode($sigBase64);
        $sigTempRel = 'temp/sig_' . uniqid() . '.png';
        Storage::disk('local')->put($sigTempRel, $sigBinary);
        $sigAbsPath = Storage::disk('local')->path($sigTempRel);

        // 3. Buka PDF asli dengan FPDI
        $pdfAbsPath = Storage::disk('local')->path($dokumen->path_file);
        $fpdi       = new Fpdi();
        $pageCount  = $fpdi->setSourceFile($pdfAbsPath);
        $targetPage = min((int) $request->ttd_page, $pageCount);

        for ($p = 1; $p <= $pageCount; $p++) {
            $tplId = $fpdi->importPage($p);
            $size  = $fpdi->getTemplateSize($tplId);
            $ori   = $size['width'] > $size['height'] ? 'L' : 'P';

            $fpdi->AddPage($ori, [$size['width'], $size['height']]);
            $fpdi->useTemplate($tplId);

            if ($p === $targetPage) {
                $pageW = $size['width'];
                $pageH = $size['height'];

                $x = (float) $request->ttd_x_pct * $pageW;
                $y = (float) $request->ttd_y_pct * $pageH;
                $w = (float) $request->ttd_w_pct * $pageW;
                $h = (float) $request->ttd_h_pct * $pageH;

                // Clamp agar tidak keluar batas halaman
                $x = max(0, min($x, $pageW - $w));
                $y = max(0, min($y, $pageH - $h));

                $fpdi->Image($sigAbsPath, $x, $y, $w, $h, 'PNG');
            }
        }

        // 4. Simpan PDF hasil ke storage
        $pdfRelPath = 'ttd/pdf/' . $pengajuan->id . '_' . time() . '.pdf';
        Storage::disk('local')->makeDirectory('ttd/pdf');
        $fpdi->Output(Storage::disk('local')->path($pdfRelPath), 'F');

        // 5. Simpan PNG signature ke storage (ikuti pola existing: path_file + nama_file)
        $sigRelPath  = 'ttd/sig_' . $pengajuan->id . '_' . time() . '.png';
        $sigNamaFile = 'ttd_' . $pengajuan->kode . '.png';
        Storage::disk('local')->put($sigRelPath, $sigBinary);

        // 6. Bersihkan file temp
        Storage::disk('local')->delete($sigTempRel);

        // 7. Simpan/update record TandaTangan
        TandaTangan::updateOrCreate(
            ['pengajuan_id' => $pengajuan->id],
            [
                'dosen_id'           => auth()->id(),
                'path_file'          => $sigRelPath,       // PNG signature
                'nama_file'          => $sigNamaFile,
                'path_pdf_ttd'       => $pdfRelPath,       // PDF ber-TTD (kolom baru)
                'ip_address'         => $request->ip(),
                'catatan'            => $request->catatan,
                'ditandatangani_pada'=> now(),
                'ttd_page'           => $targetPage,
                'ttd_x_pct'         => $request->ttd_x_pct,
                'ttd_y_pct'         => $request->ttd_y_pct,
                'ttd_w_pct'         => $request->ttd_w_pct,
                'ttd_h_pct'         => $request->ttd_h_pct,
            ]
        );

        // 8. Update status pengajuan
        $pengajuan->update(['tanggal_ttd' => now()]);

        return redirect()
            ->route('dosen.pengajuan.show', $pengajuan)
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }

    // ── Stream gambar TTD (PNG) ───────────────────────────────
    // Route: dosen.ttd.gambar & admin.ttd.gambar
    public function gambar(TandaTangan $tandaTangan)
    {
        abort_unless(Storage::disk('local')->exists($tandaTangan->path_file), 404);

        return response(
            Storage::disk('local')->get($tandaTangan->path_file),
            200,
            ['Content-Type' => 'image/png']
        );
    }

    // ── Unduh TTD ─────────────────────────────────────────────
    // Jika ada PDF ber-TTD → unduh PDF; jika tidak → unduh PNG
    // Route: dosen.ttd.unduh, admin.ttd.unduh, mahasiswa.ttd.unduh
    public function unduh(TandaTangan $tandaTangan)
    {
        // Prioritas: PDF ber-TTD
        if (
            !empty($tandaTangan->path_pdf_ttd) &&
            Storage::disk('local')->exists($tandaTangan->path_pdf_ttd)
        ) {
            return Storage::disk('local')->download(
                $tandaTangan->path_pdf_ttd,
                'dokumen-ttd-' . $tandaTangan->pengajuan->kode . '.pdf'
            );
        }

        // Fallback: PNG signature
        abort_unless(Storage::disk('local')->exists($tandaTangan->path_file), 404);

        return Storage::disk('local')->download(
            $tandaTangan->path_file,
            $tandaTangan->nama_file ?? 'tanda-tangan.png'
        );
    }

    // ── Hapus TTD ─────────────────────────────────────────────
    public function destroy(TandaTangan $tandaTangan)
    {
        Storage::disk('local')->delete($tandaTangan->path_file);

        if ($tandaTangan->path_pdf_ttd) {
            Storage::disk('local')->delete($tandaTangan->path_pdf_ttd);
        }

        $tandaTangan->delete();

        return back()->with('success', 'TTD berhasil dihapus.');
    }
}