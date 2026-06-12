<?php

namespace App\Http\Controllers;

use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TandaTanganController extends Controller
{
    /**
     * Halaman e-sign canvas untuk dosen.
     * GET /dosen/pengajuan/{pengajuan}/ttd
     */
    public function show(Pengajuan $pengajuan)
    {
        $this->authorizeDosen($pengajuan);

        $ttdExisting = $pengajuan->tandaTangan; // null kalau belum ada
        $pengajuan->load(['mahasiswa', 'dokumen']);

        return view('dosen.ttd', compact('pengajuan', 'ttdExisting'));
    }

    /**
     * Simpan TTD dari canvas (base64 PNG).
     * POST /dosen/pengajuan/{pengajuan}/ttd
     */
    public function store(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeDosen($pengajuan);

        $request->validate([
            'signature_data' => ['nullable', 'string'],
            'signature_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'catatan'        => ['nullable', 'string', 'max:500'],
        ]);

        $decoded = null;
        $ext     = 'png';

        if ($request->hasFile('signature_file')) {
            $file    = $request->file('signature_file');
            $decoded = file_get_contents($file->getRealPath());
            $ext     = $file->getClientOriginalExtension();
        } elseif ($request->filled('signature_data') && preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $request->signature_data)) {
            $base64  = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $request->signature_data);
            $decoded = base64_decode($base64);
            $ext     = 'png';
        }

        if (!$decoded || strlen($decoded) < 500) {
            return back()->with('error', 'Tanda tangan tidak boleh kosong. Unggah foto TTD atau gambar di canvas.');
        }

        DB::beginTransaction();
        try {
            // Hapus TTD lama kalau dosen mau gambar ulang
            if ($pengajuan->tandaTangan) {
                $pengajuan->tandaTangan->hapusFile();
                $pengajuan->tandaTangan->delete();
            }

            // Simpan PNG ke storage/app/private/ttd/{pengajuan_id}/
            $namaFile = 'ttd_' . $pengajuan->id . '_' . time() . '.' . $ext;
            $pathFile = 'ttd/' . $pengajuan->id . '/' . $namaFile;
            Storage::disk('local')->put($pathFile, $decoded);

            // Simpan record ke tabel tanda_tangan
            TandaTangan::create([
                'pengajuan_id'        => $pengajuan->id,
                'dosen_id'            => auth()->id(),
                'path_file'           => $pathFile,
                'nama_file'           => $namaFile,
                'ip_address'          => $request->ip(),
                'ditandatangani_pada' => now(),
            ]);

            // Update kolom di pengajuan
            $pengajuan->update([
                'catatan_dosen' => $request->catatan ?? 'Disetujui dan ditandatangani oleh dosen.',
                'tanggal_ttd'   => now(),
            ]);

            // Tulis log
            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id'      => auth()->id(),
                'status_dari'  => $pengajuan->status,
                'status_ke'    => $pengajuan->status,
                'catatan'      => '[TTD DIBERIKAN] ' . ($request->catatan ?? 'Dosen telah menandatangani dokumen secara digital.'),
                'actor_role'   => 'dosen',
            ]);

            DB::commit();

            return redirect()
                ->route('dosen.pengajuan.show', $pengajuan)
                ->with('success', 'Tanda tangan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan tanda tangan: ' . $e->getMessage());
        }
    }

    /**
     * Stream gambar TTD ke browser.
     * File disimpan di disk 'local' (tidak publik), jadi harus lewat sini.
     * GET /dosen/ttd/{tandaTangan}/gambar
     */
    public function gambar(TandaTangan $tandaTangan)
    {
        $user = auth()->user();

        $boleh = $user->isAdmin()
            || $user->id === $tandaTangan->dosen_id
            || $user->id === $tandaTangan->pengajuan->mahasiswa_id;

        abort_if(!$boleh, 403);
        abort_if(!Storage::disk('local')->exists($tandaTangan->path_file), 404, 'File tidak ditemukan.');

        return response(
            Storage::disk('local')->get($tandaTangan->path_file),
            200,
            [
                'Content-Type'        => 'image/png',
                'Content-Disposition' => 'inline; filename="' . $tandaTangan->nama_file . '"',
            ]
        );
    }

    /**
     * Hapus TTD (kalau dosen mau gambar ulang, atau admin reset).
     * DELETE /dosen/ttd/{tandaTangan}
     */
    public function destroy(TandaTangan $tandaTangan)
    {
        $user = auth()->user();

        abort_if(
            !$user->isAdmin() && $user->id !== $tandaTangan->dosen_id,
            403,
            'Tidak punya izin menghapus tanda tangan ini.'
        );

        $tandaTangan->hapusFile();
        $tandaTangan->delete();

        return back()->with('success', 'Tanda tangan dihapus. Silakan menggambar ulang.');
    }

    // ── Private helper ────────────────────────────────────────

    private function authorizeDosen(Pengajuan $pengajuan): void
    {
        abort_if(!auth()->user()->isDosen(), 403, 'Hanya dosen yang dapat menandatangani.');
        abort_if(
            $pengajuan->dosen_id !== auth()->id(),
            403,
            'Pengajuan ini tidak ditugaskan kepada Anda.'
        );
        abort_if(
            $pengajuan->status !== 'dosen_ttd',
            422,
            'Pengajuan ini tidak dalam tahap TTD Dosen.'
        );
    }
}
