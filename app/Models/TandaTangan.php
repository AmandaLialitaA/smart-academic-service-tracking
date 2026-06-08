<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TandaTangan extends Model
{
    use HasFactory;

    protected $table = 'tanda_tangan';

    public $timestamps = false;

    protected $fillable = [
        'pengajuan_id',
        'dosen_id',
        'path_file',
        'nama_file',
        'ip_address',
        'ditandatangani_pada',
    ];

    protected $casts = [
        'ditandatangani_pada' => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // ── Helpers ───────────────────────────────────────────────

    /** Route untuk stream gambar TTD (file disimpan di disk local, tidak publik) */
    public function urlGambar(): string
    {
        return route('dosen.ttd.gambar', $this->id);
    }

    /** Hapus file PNG dari storage saat record dihapus */
    public function hapusFile(): void
    {
        Storage::disk('local')->delete($this->path_file);
    }
}
