<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStatusRequest;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    // ── Dashboard dosen ───────────────────────────────────────
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'menunggu' => Pengajuan::where('dosen_id', $user->id)
                            ->byStatus('dosen_ttd')->count(),
            'disetujui'=> Pengajuan::where('dosen_id', $user->id)
                            ->byStatus('selesai')->count(),
            'ditolak'  => Pengajuan::where('dosen_id', $user->id)
                            ->byStatus('ditolak')->count(),
        ];

        $antrian = Pengajuan::where('dosen_id', $user->id)
            ->byStatus('dosen_ttd')
            ->with('mahasiswa')
            ->latest()->get();

        return view('dosen.dashboard', compact('stats', 'antrian', 'user'));
    }

    // ── Daftar pengajuan untuk dosen ini ──────────────────────
    public function listPengajuan(Request $request)
    {
        $user  = auth()->user();
        $query = Pengajuan::where('dosen_id', $user->id)->with('mahasiswa');

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        $pengajuan = $query->latest()->paginate(15);
        return view('dosen.verifikasi', compact('pengajuan'));
    }

    // ── Detail pengajuan ──────────────────────────────────────
    public function show(Pengajuan $pengajuan)
    {
        // Dosen hanya boleh lihat yang ditugaskan kepadanya
        if ($pengajuan->dosen_id !== auth()->id()) {
            abort(403, 'Pengajuan ini tidak ditugaskan kepada Anda.');
        }

        $pengajuan->load(['mahasiswa', 'dokumen', 'log.user']);
        return view('dosen.detail', compact('pengajuan'));
    }

    // ── APPROVE: Dosen setujui (TTD) ─────────────────────────
    public function approve(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        if ($pengajuan->dosen_id !== auth()->id()) {
            abort(403);
        }

        if ($pengajuan->status !== 'dosen_ttd') {
            return back()->with('error', 'Pengajuan ini tidak dalam tahap TTD Dosen.');
        }

        // Dosen approve → status ke 'selesai' belum, karena admin masih perlu checklist
        // Kita buat status intermediate: tetap dosen_ttd tapi tandai sudah TTD
        // Lebih tepat: setelah dosen TTD, admin yang klik "selesai"
        // Jadi dosen approve → log saja, status tetap dosen_ttd sampai admin checklist
        DB::beginTransaction();
        try {
            $pengajuan->update([
                'catatan_dosen'   => $request->catatan ?? 'Disetujui oleh dosen.',
                'tanggal_ttd'     => now(),
            ]);

            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id'      => auth()->id(),
                'status_dari'  => 'dosen_ttd',
                'status_ke'    => 'dosen_ttd', // status tetap, menunggu admin checklist
                'catatan'      => '[TTD DIBERIKAN] ' . ($request->catatan ?? 'Dosen telah menyetujui dan menandatangani.'),
                'actor_role'   => 'dosen',
            ]);

            DB::commit();
            return back()->with('success', 'TTD berhasil diberikan. Menunggu checklist admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memberikan TTD: ' . $e->getMessage());
        }
    }

    // ── REJECT: Dosen tolak ───────────────────────────────────
    public function reject(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'min:5', 'max:500'],
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi.',
            'catatan.min'      => 'Alasan penolakan minimal 5 karakter.',
        ]);

        if ($pengajuan->dosen_id !== auth()->id()) {
            abort(403);
        }

        if ($pengajuan->status !== 'dosen_ttd') {
            return back()->with('error', 'Pengajuan ini tidak dalam tahap TTD Dosen.');
        }

        if (!$pengajuan->bisaTransisiKe('ditolak')) {
            return back()->with('error', 'Pengajuan tidak dapat ditolak pada tahap ini.');
        }

        DB::beginTransaction();
        try {
            $pengajuan->update([
                'status'            => 'ditolak',
                'catatan_penolakan' => $request->catatan,
                'tanggal_ditolak'   => now(),
            ]);

            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id'      => auth()->id(),
                'status_dari'  => 'dosen_ttd',
                'status_ke'    => 'ditolak',
                'catatan'      => '[DITOLAK] ' . $request->catatan,
                'actor_role'   => 'dosen',
            ]);

            DB::commit();
            return back()->with('success', 'Pengajuan berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menolak pengajuan: ' . $e->getMessage());
        }
    }
}