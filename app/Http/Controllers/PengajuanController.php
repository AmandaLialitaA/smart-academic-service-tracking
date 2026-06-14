<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengajuanRequest;
use App\Models\DokumenPengajuan;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index()
    {
        return view('mahasiswa.pengajuan');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $base = Pengajuan::byMahasiswa($user->id);

        $stats = [
            'submitted' => (clone $base)->byStatus('submitted')->count(),
            'waiting'   => (clone $base)->whereIn('status', ['admin_verifikasi', 'dosen_ttd'])->count(),
            'completed' => (clone $base)->byStatus('selesai')->count(),
            'rejected'  => (clone $base)->byStatus('ditolak')->count(),
        ];

        $riwayat = Pengajuan::byMahasiswa($user->id)
            ->with('dosen')
            ->latest()
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard', compact('stats', 'riwayat', 'user'));
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $query = Pengajuan::byMahasiswa($user->id)->with('dosen')->latest();

        if ($request->filled('status')) {
            $statuses = Pengajuan::backendStatusesForDisplay($request->status);
            if ($statuses) {
                $query->whereIn('status', $statuses);
            }
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_layanan', $request->jenis);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('kode', 'like', "%{$cari}%")
                    ->orWhere('keperluan', 'like', "%{$cari}%")
                    ->orWhere('jenis_layanan', 'like', "%{$cari}%");
            });
        }

        $pengajuan = $query->get();
        $base = Pengajuan::byMahasiswa($user->id);

        $stats = [
            'submitted' => (clone $base)->byStatus('submitted')->count(),
            'waiting'   => (clone $base)->whereIn('status', ['admin_verifikasi', 'dosen_ttd'])->count(),
            'completed' => (clone $base)->byStatus('selesai')->count(),
            'rejected'  => (clone $base)->byStatus('ditolak')->count(),
        ];

        return view('mahasiswa.riwayat', compact('pengajuan', 'stats', 'user'));
    }

    public function tracking(Pengajuan $pengajuan)
    {
        $user = auth()->user();

        if ($pengajuan->mahasiswa_id !== $user->id) {
            abort(403);
        }

        $pengajuan->load(['dokumen', 'log.user', 'dosen', 'tandaTangan']);

        return view('mahasiswa.tracking', compact('pengajuan'));
    }

    public function store(StorePengajuanRequest $request)
    {
        $user = auth()->user();

        if (empty($request->jenis_layanan) || empty($request->keperluan)) {
            return back()->with('error', 'Jenis layanan dan keperluan wajib diisi.');
        }

        DB::beginTransaction();
        try {
            $pengajuan = Pengajuan::create([
                'kode'               => Pengajuan::generateKode(),
                'mahasiswa_id'       => $user->id,
                'jenis_layanan'      => $request->jenis_layanan,
                'nama_mahasiswa'     => $user->name ?? 'Mahasiswa',
                'nim_mahasiswa'      => $user->nim ?? '-',
                'prodi_mahasiswa'    => $user->prodi ?? '-',
                'semester_mahasiswa' => $user->semester ?? 1,
                'keperluan'          => $request->keperluan,
                // POINT 6: simpan catatan opsional dari mahasiswa
                'catatan_mahasiswa'  => $request->catatan ?? null,
                'status'             => 'submitted',
                'tanggal_submit'     => now(),
            ]);

            $this->simpanDokumen($pengajuan, $request, 'file_ktm', 'KTM', 'ktm');
            $this->simpanDokumen($pengajuan, $request, 'file_surat', 'Surat Permohonan', 'surat_permohonan');

            if ($request->hasFile('file_tambahan')) {
                $this->simpanDokumen($pengajuan, $request, 'file_tambahan', 'Dokumen Tambahan', 'lainnya');
            }

            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id'      => $user->id,
                'status_dari'  => null,
                'status_ke'    => 'submitted',
                'catatan'      => 'Pengajuan berhasil dikirim oleh mahasiswa.'
                    . ($request->catatan ? ' Catatan: ' . $request->catatan : ''),
                'actor_role'   => 'mahasiswa',
            ]);

            DB::commit();

            // POINT 5: redirect dengan session success — TIDAK ada JS alert tambahan di sini
            // Flash message ditangani di layouts/app.blade.php, tidak double
            return redirect()->route('mahasiswa.riwayat')
                ->with('success', "Pengajuan berhasil dikirim! Kode: {$pengajuan->kode}");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan pengajuan', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
            return back()
                ->withInput()
                ->with('error', 'Gagal mengirim pengajuan: ' . $e->getMessage());
        }
    }

    public function show(Pengajuan $pengajuan)
    {
        $user = auth()->user();

        if ($user->isMahasiswa() && $pengajuan->mahasiswa_id !== $user->id) {
            abort(403);
        }

        $pengajuan->load(['dokumen', 'log.user', 'dosen', 'mahasiswa', 'tandaTangan']);

        return view('mahasiswa.detail-pengajuan', compact('pengajuan'));
    }

    private function simpanDokumen(
        Pengajuan $pengajuan,
        Request $request,
        string $inputName,
        string $namaDokumen,
        string $tipeDokumen
    ): void {
        if (!$request->hasFile($inputName)) {
            return;
        }

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