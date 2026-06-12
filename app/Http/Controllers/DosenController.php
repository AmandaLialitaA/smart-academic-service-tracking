<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $base = Pengajuan::where('dosen_id', $user->id);

        $stats = [
            'menunggu' => (clone $base)->byStatus('dosen_ttd')->whereNull('tanggal_ttd')->count(),
            'sudah_ttd'=> (clone $base)->byStatus('dosen_ttd')->whereNotNull('tanggal_ttd')->count(),
            'selesai'  => (clone $base)->byStatus('selesai')->count(),
            'ditolak'  => (clone $base)->byStatus('ditolak')->count(),
        ];

        $antrian = Pengajuan::where('dosen_id', $user->id)
            ->byStatus('dosen_ttd')
            ->whereNull('tanggal_ttd')
            ->with('mahasiswa')
            ->latest()
            ->take(5)
            ->get();

        return view('dosen.dashboard', compact('stats', 'antrian', 'user'));
    }

    public function menunggu(Request $request)
    {
        $user = auth()->user();
        $query = Pengajuan::where('dosen_id', $user->id)
            ->byStatus('dosen_ttd')
            ->whereNull('tanggal_ttd')
            ->with('mahasiswa');

        if ($request->filled('jenis')) {
            $query->where('jenis_layanan', $request->jenis);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('kode', 'like', "%{$cari}%")
                    ->orWhere('nama_mahasiswa', 'like', "%{$cari}%")
                    ->orWhere('nim_mahasiswa', 'like', "%{$cari}%");
            });
        }

        $pengajuan = $query->latest()->paginate(15)->withQueryString();

        return view('dosen.menunggu', compact('pengajuan', 'user'));
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $query = Pengajuan::where('dosen_id', $user->id)->with('mahasiswa');

        if ($request->filled('status')) {
            $statuses = Pengajuan::backendStatusesForDisplay($request->status);
            if ($statuses) {
                $query->whereIn('status', $statuses);
            }
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('kode', 'like', "%{$cari}%")
                    ->orWhere('nama_mahasiswa', 'like', "%{$cari}%");
            });
        }

        $pengajuan = $query->latest()->paginate(15)->withQueryString();

        return view('dosen.riwayat-dosen', compact('pengajuan', 'user'));
    }

    public function show(Pengajuan $pengajuan)
    {
        if ($pengajuan->dosen_id !== auth()->id()) {
            abort(403, 'Pengajuan ini tidak ditugaskan kepada Anda.');
        }

        $pengajuan->load(['mahasiswa', 'dokumen', 'log.user', 'tandaTangan']);

        return view('dosen.detail-pengajuan', compact('pengajuan'));
    }

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

        $pengajuan->update([
            'catatan_dosen' => $request->catatan ?? 'Disetujui oleh dosen.',
            'tanggal_ttd'   => now(),
        ]);

        \App\Models\LogPengajuan::create([
            'pengajuan_id' => $pengajuan->id,
            'user_id'      => auth()->id(),
            'status_dari'  => 'dosen_ttd',
            'status_ke'    => 'dosen_ttd',
            'catatan'      => '[TTD DIBERIKAN] ' . ($request->catatan ?? 'Dosen telah menyetujui dan menandatangani.'),
            'actor_role'   => 'dosen',
        ]);

        return back()->with('success', 'TTD berhasil diberikan. Menunggu checklist admin.');
    }

    public function reject(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        if ($pengajuan->dosen_id !== auth()->id()) {
            abort(403);
        }

        if (!$pengajuan->bisaTransisiKe('ditolak')) {
            return back()->with('error', 'Pengajuan tidak dapat ditolak pada tahap ini.');
        }

        $pengajuan->update([
            'status'            => 'ditolak',
            'catatan_penolakan' => $request->catatan,
            'tanggal_ditolak'   => now(),
        ]);

        \App\Models\LogPengajuan::create([
            'pengajuan_id' => $pengajuan->id,
            'user_id'      => auth()->id(),
            'status_dari'  => 'dosen_ttd',
            'status_ke'    => 'ditolak',
            'catatan'      => '[DITOLAK] ' . $request->catatan,
            'actor_role'   => 'dosen',
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}
