<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function notificationCount()
    {
        $user = auth()->user();
        $count = 0;

        if ($user->isMahasiswa()) {
            $count = Pengajuan::byMahasiswa($user->id)
                ->whereIn('status', ['submitted', 'admin_verifikasi', 'dosen_ttd'])
                ->count();
        } elseif ($user->isDosen()) {
            $count = Pengajuan::where('dosen_id', $user->id)
                ->byStatus('dosen_ttd')
                ->whereNull('tanggal_ttd')
                ->count();
        } elseif ($user->isAdmin()) {
            $count = Pengajuan::whereIn('status', ['submitted', 'admin_verifikasi'])->count();
        }

        return response()->json(['count' => $count]);
    }

    public function pengajuanStatus(Request $request)
    {
        $ids = collect(explode(',', $request->query('ids', '')))
            ->filter()
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return response()->json([]);
        }

        $user = auth()->user();
        $query = Pengajuan::whereIn('kode', $ids);

        if ($user->isMahasiswa()) {
            $query->where('mahasiswa_id', $user->id);
        } elseif ($user->isDosen()) {
            $query->where('dosen_id', $user->id);
        }

        $result = [];
        foreach ($query->get() as $p) {
            $label = Pengajuan::STATUS_LABEL[$p->status] ?? $p->status;
            $badgeClass = $p->status_badge_class;

            if ($user->isDosen() && $p->status === 'dosen_ttd' && $p->tanggal_ttd) {
                $label = 'Sudah TTD';
                $badgeClass = 'completed';
            }

            $result[$p->kode] = [
                'display' => $p->display_status,
                'label'   => $label,
                'class'   => $badgeClass,
                'backend' => $p->status,
            ];
        }

        return response()->json($result);
    }

    public function dashboardStats()
    {
        $user = auth()->user();

        if ($user->isMahasiswa()) {
            $base = Pengajuan::byMahasiswa($user->id);
            return response()->json([
                'submitted' => (clone $base)->byStatus('submitted')->count(),
                'waiting'   => (clone $base)->whereIn('status', ['admin_verifikasi', 'dosen_ttd'])->count(),
                'completed' => (clone $base)->byStatus('selesai')->count(),
                'rejected'  => (clone $base)->byStatus('ditolak')->count(),
            ]);
        }

        if ($user->isDosen()) {
            $base = Pengajuan::where('dosen_id', $user->id);
            return response()->json([
                'menunggu_ttd' => (clone $base)->byStatus('dosen_ttd')->whereNull('tanggal_ttd')->count(),
                'sudah_ttd'    => (clone $base)->byStatus('dosen_ttd')->whereNotNull('tanggal_ttd')->count(),
                'selesai'      => (clone $base)->byStatus('selesai')->count(),
            ]);
        }

        if ($user->isAdmin()) {
            return response()->json([
                'belum_selesai' => Pengajuan::whereNotIn('status', ['selesai', 'ditolak'])->count(),
                'submitted'     => Pengajuan::byStatus('submitted')->count(),
                'dosen_ttd'     => Pengajuan::byStatus('dosen_ttd')->count(),
                'completed'     => Pengajuan::byStatus('selesai')->count(),
            ]);
        }

        return response()->json([]);
    }
}
