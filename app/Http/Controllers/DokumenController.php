<?php

namespace App\Http\Controllers;

use App\Models\DokumenPengajuan;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function download(DokumenPengajuan $dokumen)
    {
        $this->authorizeAccess($dokumen);

        abort_unless(Storage::disk('local')->exists($dokumen->path_file), 404);

        return Storage::disk('local')->download(
            $dokumen->path_file,
            $dokumen->nama_file_asli
        );
    }

    public function show(DokumenPengajuan $dokumen)
    {
        $this->authorizeAccess($dokumen);

        abort_unless(Storage::disk('local')->exists($dokumen->path_file), 404);

        return response(
            Storage::disk('local')->get($dokumen->path_file),
            200,
            [
                'Content-Type'        => $dokumen->mime_type ?? 'application/octet-stream',
                'Content-Disposition' => 'inline; filename="' . $dokumen->nama_file_asli . '"',
            ]
        );
    }

    private function authorizeAccess(DokumenPengajuan $dokumen): void
    {
        $user = auth()->user();
        $pengajuan = $dokumen->pengajuan;

        $allowed = $user->isAdmin()
            || ($user->isMahasiswa() && $pengajuan->mahasiswa_id === $user->id)
            || ($user->isDosen() && $pengajuan->dosen_id === $user->id);

        abort_unless($allowed, 403);
    }
}
