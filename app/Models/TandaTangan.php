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
        'path_pdf_ttd',      // ← baru: PDF ber-TTD
        'catatan',           // ← baru: catatan dosen
        'ip_address',
        'ditandatangani_pada',
        'ttd_page',          // ← baru: koordinat
        'ttd_x_pct',
        'ttd_y_pct',
        'ttd_w_pct',
        'ttd_h_pct',
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

    /** Route untuk stream gambar TTD */
    public function urlGambar(): string
    {
        return route('dosen.ttd.gambar', $this->id);
    }

    /** Apakah sudah ada PDF ber-TTD */
    public function hasPdf(): bool
    {
        return !empty($this->path_pdf_ttd)
            && Storage::disk('local')->exists($this->path_pdf_ttd);
    }

    /** Hapus semua file terkait dari storage */
    public function hapusFile(): void
    {
        Storage::disk('local')->delete($this->path_file);
        if ($this->path_pdf_ttd) {
            Storage::disk('local')->delete($this->path_pdf_ttd);
        }
    }
}