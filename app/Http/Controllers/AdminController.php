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
    public function dashboard()
    {
        $stats = [
            'total'          => Pengajuan::count(),
            'belum_selesai'  => Pengajuan::whereNotIn('status', ['selesai', 'ditolak'])->count(),
            'submitted'      => Pengajuan::byStatus('submitted')->count(),
            'admin_verifikasi'=> Pengajuan::byStatus('admin_verifikasi')->count(),
            'dosen_ttd'      => Pengajuan::byStatus('dosen_ttd')->count(),
            'selesai'        => Pengajuan::byStatus('selesai')->count(),
            'ditolak'        => Pengajuan::byStatus('ditolak')->count(),
            'hari_ini'       => Pengajuan::whereDate('created_at', today())->count(),
        ];

        $pengajuanTerbaru = Pengajuan::with('mahasiswa')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pengajuanTerbaru'));
    }

    public function verifikasiList(Request $request)
    {
        $query = Pengajuan::with('mahasiswa')
            ->whereIn('status', ['submitted', 'admin_verifikasi']);

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
                    ->orWhere('nim_mahasiswa', 'like', "%{$cari}%")
                    ->orWhere('nama_mahasiswa', 'like', "%{$cari}%");
            });
        }

        $pengajuan = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total'   => Pengajuan::whereIn('status', ['submitted', 'admin_verifikasi'])->count(),
            'submitted' => Pengajuan::byStatus('submitted')->count(),
            'waiting' => Pengajuan::byStatus('admin_verifikasi')->count(),
        ];

        return view('admin.verifikasi-list', compact('pengajuan', 'stats'));
    }

    public function semuaPengajuan(Request $request)
    {
        $query = Pengajuan::with(['mahasiswa', 'dosen']);

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
                    ->orWhere('nim_mahasiswa', 'like', "%{$cari}%")
                    ->orWhere('nama_mahasiswa', 'like', "%{$cari}%");
            });
        }

        $pengajuan = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'     => Pengajuan::count(),
            'submitted' => Pengajuan::byStatus('submitted')->count(),
            'waiting'   => Pengajuan::whereIn('status', ['admin_verifikasi', 'dosen_ttd'])->count(),
            'completed' => Pengajuan::byStatus('selesai')->count(),
        ];

        return view('admin.semua-pengajuan', compact('pengajuan', 'stats'));
    }

    public function approveSubmitted(Request $request, Pengajuan $pengajuan)
    {
        $request->validate(['catatan' => ['nullable', 'string', 'max:500']]);
        $request->merge(['status' => 'admin_verifikasi']);

        return $this->prosesUpdateStatus($request, $pengajuan, 'admin', [
            'admin_verifikasi_id' => auth()->id(),
            'catatan_admin'       => $request->catatan,
            'tanggal_verifikasi'  => now(),
        ]);
    }

    public function rejectPengajuan(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        $request->merge(['status' => 'ditolak']);

        return $this->prosesUpdateStatus($request, $pengajuan, 'admin', [
            'admin_verifikasi_id' => auth()->id(),
            'catatan_admin'       => $request->catatan,
        ]);
    }

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

    private function prosesUpdateStatus(
        Request $request,
        Pengajuan $pengajuan,
        string $actorRole,
        array $extraData = [],
        ?string $forceStatus = null,
        ?string $forceCatatan = null
    ) {
        $statusBaru  = $forceStatus ?? $request->status;
        $catatan     = $forceCatatan ?? $request->catatan;

        if (!$pengajuan->bisaTransisiKe($statusBaru)) {
            return back()->with('error',
                "Tidak bisa mengubah status dari '{$pengajuan->status}' ke '{$statusBaru}'. Status tidak boleh lompat tahap."
            );
        }

        DB::beginTransaction();
        try {
            $statusLama = $pengajuan->status;
            $updateData = array_merge(['status' => $statusBaru], $extraData);

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

    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load(['mahasiswa', 'dosen', 'dokumen', 'log.user', 'tandaTangan']);
        $daftarDosen = User::where('role', 'dosen')->get();

        return view('admin.verifikasi', compact('pengajuan', 'daftarDosen'));
    }
}
