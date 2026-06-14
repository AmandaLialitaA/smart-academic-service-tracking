<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'kode', 'mahasiswa_id', 'dosen_id',
        'admin_verifikasi_id', 'admin_selesai_id',
        'jenis_layanan', 'nama_mahasiswa', 'nim_mahasiswa',
        'prodi_mahasiswa', 'semester_mahasiswa', 'keperluan',
        // POINT 6: catatan opsional dari mahasiswa
        'catatan_mahasiswa',
        'status',
        'tanggal_submit', 'tanggal_verifikasi',
        'tanggal_ttd', 'tanggal_selesai', 'tanggal_ditolak',
        'catatan_admin', 'catatan_dosen', 'catatan_penolakan',
    ];

    protected $casts = [
        'tanggal_submit'     => 'datetime',
        'tanggal_verifikasi' => 'datetime',
        'tanggal_ttd'        => 'datetime',
        'tanggal_selesai'    => 'datetime',
        'tanggal_ditolak'    => 'datetime',
    ];

    // ── Label & urutan status ─────────────────────────────────
    const STATUS_ORDER = [
        'submitted'        => 1,
        'admin_verifikasi' => 2,
        'dosen_ttd'        => 3,
        'selesai'          => 4,
        'ditolak'          => 99,
    ];

    // POINT 8: label "selesai" berubah dari "Selesai – Siap Diambil" → "Selesai"
    const STATUS_LABEL = [
        'submitted'        => 'Menunggu Verifikasi Admin',
        'admin_verifikasi' => 'Sedang Diverifikasi Admin',
        'dosen_ttd'        => 'Menunggu TTD Dosen',
        'selesai'          => 'Selesai',
        'ditolak'          => 'Ditolak',
    ];

    const JENIS_LABEL = [
        'cuti'      => 'Pengajuan Cuti Akademik',
        'legalisir' => 'Legalisir Ijazah Elektronik',
        'magang'    => 'Surat Pengantar Magang',
        'lainnya'   => 'Layanan Lainnya',
    ];

    const DISPLAY_STATUS_MAP = [
        'submitted'        => 'submitted',
        'admin_verifikasi' => 'waiting',
        'dosen_ttd'        => 'waiting',
        'selesai'          => 'completed',
        'ditolak'          => 'rejected',
    ];

    const DISPLAY_LABEL = [
        'submitted' => 'Submitted',
        'waiting'   => 'Waiting',
        'completed' => 'Completed',
        'rejected'  => 'Rejected',
    ];

    public function getDisplayStatusAttribute(): string
    {
        return self::DISPLAY_STATUS_MAP[$this->status] ?? 'submitted';
    }

    public function getDisplayStatusLabelAttribute(): string
    {
        return self::STATUS_LABEL[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'submitted'        => 'submitted',
            'admin_verifikasi' => 'waiting',
            'dosen_ttd'        => 'ttd',
            'selesai'          => 'completed',
            'ditolak'          => 'rejected',
            default            => 'submitted',
        };
    }

    public function getJenisLabelAttribute(): string
    {
        return self::JENIS_LABEL[$this->jenis_layanan] ?? $this->jenis_layanan;
    }

    public function getProgressPercentAttribute(): int
    {
        return match ($this->status) {
            'submitted'        => 25,
            'admin_verifikasi' => 50,
            'dosen_ttd'        => $this->tanggal_ttd ? 85 : 75,
            'selesai'          => 100,
            'ditolak'          => 0,
            default            => 10,
        };
    }

    public static function backendStatusesForDisplay(string $display): array
    {
        return match ($display) {
            'submitted' => ['submitted'],
            'waiting'   => ['admin_verifikasi', 'dosen_ttd'],
            'completed' => ['selesai'],
            'rejected'  => ['ditolak'],
            default     => [],
        };
    }

    // ── Validasi lompat tahap ─────────────────────────────────
    /**
     * Kembalikan true jika transisi status VALID.
     * POINT 4 FIX: 'ditolak' boleh dari status manapun kecuali 'selesai' dan 'ditolak'.
     * Method reject di controller menggunakan logika sendiri sehingga lebih fleksibel.
     */
    public function bisaTransisiKe(string $statusBaru): bool
    {
        // Status final tidak bisa berubah lagi
        if ($this->status === 'selesai' || $this->status === 'ditolak') {
            return false;
        }

        // Bisa ditolak dari tahap manapun (selain final)
        if ($statusBaru === 'ditolak') {
            return true;
        }

        $urutanSekarang = self::STATUS_ORDER[$this->status] ?? 0;
        $urutanBaru     = self::STATUS_ORDER[$statusBaru]   ?? 0;

        // Hanya boleh naik 1 tahap
        return $urutanBaru === $urutanSekarang + 1;
    }

    // ── Generate kode unik ────────────────────────────────────
    public static function generateKode(): string
    {
        $tahun = date('Y');
        $last  = static::whereYear('created_at', $tahun)->count() + 1;
        return sprintf('REQ-%s-%05d', $tahun, $last);
    }

    // ── Relasi ────────────────────────────────────────────────
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function adminVerifikasi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_verifikasi_id');
    }

    public function adminSelesai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_selesai_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenPengajuan::class);
    }

    public function log(): HasMany
    {
        return $this->hasMany(LogPengajuan::class)->orderBy('created_at', 'asc');
    }

    public function tandaTangan(): HasOne
    {
        return $this->hasOne(TandaTangan::class);
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByMahasiswa($query, int $userId)
    {
        return $query->where('mahasiswa_id', $userId);
    }
}