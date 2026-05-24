<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStatusRequest;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ── Dashboard admin ───────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_dosen'     => User::where('role', 'dosen')->count(),
            'submitted'       => Pengajuan::byStatus('submitted')->count(),
            'admin_verifikasi'=> Pengajuan::byStatus('admin_verifikasi')->count(),
            'dosen_ttd'       => Pengajuan::byStatus('dosen_ttd')->count(),
            'selesai'         => Pengajuan::byStatus('selesai')->count(),
            'ditolak'         => Pengajuan::byStatus('ditolak')->count(),
            'bulan_ini'       => Pengajuan::whereMonth('created_at', now()->month)->count(),
        ];

        $pengajuanTerbaru = Pengajuan::with('mahasiswa')
            ->whereNotIn('status', ['selesai', 'ditolak'])
            ->latest()->take(10)->get();

        $daftarDosen = User::where('role', 'dosen')->get();

        return view('admin.dashboard', compact('stats', 'pengajuanTerbaru', 'daftarDosen'));
    }

    // ── Daftar semua pengajuan ────────────────────────────────
    public function listPengajuan(Request $request)
    {
        $query = Pengajuan::with(['mahasiswa', 'dosen']);

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_layanan', $request->jenis);
        }
        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode', 'like', "%{$request->cari}%")
                  ->orWhere('nim_mahasiswa', 'like', "%{$request->cari}%")
                  ->orWhere('nama_mahasiswa', 'like', "%{$request->cari}%");
            });
        }

        $pengajuan = $query->latest()->paginate(20);

        return view('admin.list-pengajuan', compact('pengajuan'));
    }

    // ── UPDATE STATUS: Admin verifikasi ───────────────────────
    public function verifikasi(UpdateStatusRequest $request, Pengajuan $pengajuan)
    {
        // Admin hanya boleh set ke admin_verifikasi atau ditolak dari submitted
        if (!in_array($request->status, ['admin_verifikasi', 'ditolak'])) {
            return back()->with('error', 'Admin hanya bisa memverifikasi atau menolak pengajuan.');
        }

        return $this->prosesUpdateStatus($request, $pengajuan, 'admin', [
            'admin_verifikasi_id' => auth()->id(),
            'catatan_admin'       => $request->catatan,
            'tanggal_verifikasi'  => now(),
        ]);
    }

    // ── UPDATE STATUS: Teruskan ke dosen ─────────────────────
    public function teruskeDosen(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'dosen_id' => ['required', 'exists:users,id'],
            'catatan'  => ['nullable', 'string', 'max:500'],
        ]);

        $dosen = User::findOrFail($request->dosen_id);
        if (!$dosen->isDosen()) {
            return back()->with('error', 'User yang dipilih bukan dosen.');
        }

        if (!$pengajuan->bisaTransisiKe('dosen_ttd')) {
            return back()->with('error', 'Pengajuan tidak bisa diteruskan ke dosen pada tahap ini.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pengajuan->status;

            $pengajuan->update([
                'status'   => 'dosen_ttd',
                'dosen_id' => $request->dosen_id,
            ]);

            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id'      => auth()->id(),
                'status_dari'  => $statusLama,
                'status_ke'    => 'dosen_ttd',
                'catatan'      => $request->catatan ?? "Diteruskan ke Dosen {$dosen->name} untuk TTD.",
                'actor_role'   => 'admin',
            ]);

            DB::commit();
            return back()->with('success', "Pengajuan diteruskan ke {$dosen->name}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal meneruskan pengajuan: ' . $e->getMessage());
        }
    }

    // ── UPDATE STATUS: Checklist selesai ─────────────────────
    public function checklist(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        if (!$pengajuan->bisaTransisiKe('selesai')) {
            return back()->with('error', 'Pengajuan belum siap untuk diselesaikan. Pastikan sudah ada TTD dosen.');
        }

        return $this->prosesUpdateStatus(
            $request,
            $pengajuan,
            'admin',
            [
                'admin_selesai_id' => auth()->id(),
                'tanggal_selesai'  => now(),
            ],
            'selesai',
            $request->catatan ?? 'Pengajuan selesai diproses. Dokumen siap diambil.'
        );
    }

    // ── Helper proses update status ───────────────────────────
    private function prosesUpdateStatus(
        Request $request,
        Pengajuan $pengajuan,
        string $actorRole,
        array $extraData = [],
        ?string $forceStatus = null,
        ?string $forceCatatan = null
    ) {
        $statusBaru   = $forceStatus  ?? $request->status;
        $catatan      = $forceCatatan ?? $request->catatan;

        if (!$pengajuan->bisaTransisiKe($statusBaru)) {
            return back()->with('error',
                "Tidak bisa mengubah status dari '{$pengajuan->status}' ke '{$statusBaru}'. Status tidak boleh lompat tahap."
            );
        }

        DB::beginTransaction();
        try {
            $statusLama = $pengajuan->status;

            $updateData = array_merge(['status' => $statusBaru], $extraData);

            // Set timestamp penolakan jika ditolak
            if ($statusBaru === 'ditolak') {
                $updateData['tanggal_ditolak']   = now();
                $updateData['catatan_penolakan'] = $catatan;
            }

            $pengajuan->update($updateData);

            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id'      => auth()->id(),
                'status_dari'  => $statusLama,
                'status_ke'    => $statusBaru,
                'catatan'      => $catatan,
                'actor_role'   => $actorRole,
            ]);

            DB::commit();

            $label = Pengajuan::STATUS_LABEL[$statusBaru] ?? $statusBaru;
            return back()->with('success', "Status diubah menjadi: {$label}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    // ── Detail pengajuan ──────────────────────────────────────
    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load(['mahasiswa', 'dosen', 'dokumen', 'log.user']);
        $daftarDosen = User::where('role', 'dosen')->get();
        return view('admin.detail-pengajuan', compact('pengajuan', 'daftarDosen'));
    }
}