<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengajuanRequest;
use App\Models\DokumenPengajuan;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    // ── Halaman pilih layanan ─────────────────────────────────
    public function index()
    {
        return view('mahasiswa.pengajuan');
    }

    // ── Halaman upload dokumen ────────────────────────────────
    public function showUpload()
    {
        return view('mahasiswa.upload');
    }

    // ── Halaman tracking ──────────────────────────────────────
    public function tracking()
    {
        $user      = auth()->user();
        $pengajuan = Pengajuan::byMahasiswa($user->id)
            ->with(['dokumen', 'log.user', 'dosen'])
            ->latest()
            ->get();

        return view('mahasiswa.tracking', compact('pengajuan'));
    }

    // ── Dashboard mahasiswa ───────────────────────────────────
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'total'     => Pengajuan::byMahasiswa($user->id)->count(),
            'proses'    => Pengajuan::byMahasiswa($user->id)
                            ->whereNotIn('status', ['selesai', 'ditolak'])->count(),
            'selesai'   => Pengajuan::byMahasiswa($user->id)->byStatus('selesai')->count(),
            'ditolak'   => Pengajuan::byMahasiswa($user->id)->byStatus('ditolak')->count(),
        ];

        $riwayat = Pengajuan::byMahasiswa($user->id)->latest()->take(5)->get();

        return view('mahasiswa.dashboard', compact('stats', 'riwayat', 'user'));
    }

    // ── TAMBAH PENGAJUAN ──────────────────────────────────────
    public function store(StorePengajuanRequest $request)
    {
        $user = auth()->user();

        DB::beginTransaction();
        try {
            // 1. Buat record pengajuan
            $pengajuan = Pengajuan::create([
                'kode'             => Pengajuan::generateKode(),
                'mahasiswa_id'     => $user->id,
                'jenis_layanan'    => $request->jenis_layanan,
                'nama_mahasiswa'   => $user->name,
                'nim_mahasiswa'    => $user->nim,
                'prodi_mahasiswa'  => $user->prodi,
                'semester_mahasiswa' => $user->semester,
                'keperluan'        => $request->keperluan,
                'status'           => 'submitted',
                'tanggal_submit'   => now(),
            ]);

            // 2. Simpan dokumen wajib
            $this->simpanDokumen($pengajuan, $request, 'file_ktm', 'KTM', 'ktm');
            $this->simpanDokumen($pengajuan, $request, 'file_surat', 'Surat Permohonan', 'surat_permohonan');

            // 3. Simpan dokumen opsional
            if ($request->hasFile('file_tambahan')) {
                $this->simpanDokumen($pengajuan, $request, 'file_tambahan', 'Dokumen Tambahan', 'lainnya');
            }

            // 4. Tulis log pertama
            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id'      => $user->id,
                'status_dari'  => null,
                'status_ke'    => 'submitted',
                'catatan'      => 'Pengajuan berhasil dikirim oleh mahasiswa.',
                'actor_role'   => 'mahasiswa',
            ]);

            DB::commit();

            return redirect()->route('mahasiswa.tracking')
                ->with('success', "Pengajuan berhasil dikirim! Kode: {$pengajuan->kode}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengirim pengajuan: ' . $e->getMessage());
        }
    }

    // ── AMBIL DETAIL PENGAJUAN ────────────────────────────────
    public function show(Pengajuan $pengajuan)
    {
        $user = auth()->user();

        // Mahasiswa hanya boleh lihat miliknya sendiri
        if ($user->isMahasiswa() && $pengajuan->mahasiswa_id !== $user->id) {
            abort(403);
        }

        $pengajuan->load(['dokumen', 'log.user', 'dosen', 'mahasiswa']);

        return view('mahasiswa.detail', compact('pengajuan'));
    }

    // ── Helper simpan file ────────────────────────────────────
    private function simpanDokumen(
        Pengajuan $pengajuan,
        Request $request,
        string $inputName,
        string $namaDokumen,
        string $tipeDokumen
    ): void {
        if (!$request->hasFile($inputName)) return;

        $file     = $request->file($inputName);
        $filename = time() . '_' . $tipeDokumen . '_' . $pengajuan->id . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs("pengajuan/{$pengajuan->id}", $filename, 'local');

        DokumenPengajuan::create([
            'pengajuan_id'   => $pengajuan->id,
            'nama_dokumen'   => $namaDokumen,
            'tipe_dokumen'   => $tipeDokumen,
            'path_file'      => $path,
            'nama_file_asli' => $file->getClientOriginalName(),
            'ukuran_file'    => $file->getSize(),
            'mime_type'      => $file->getMimeType(),
        ]);
    }
}