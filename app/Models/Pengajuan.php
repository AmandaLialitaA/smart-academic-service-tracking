<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'kode', 'mahasiswa_id', 'dosen_id',
        'admin_verifikasi_id', 'admin_selesai_id',
        'jenis_layanan', 'nama_mahasiswa', 'nim_mahasiswa',
        'prodi_mahasiswa', 'semester_mahasiswa', 'keperluan',
        'status',
        'tanggal_submit', 'tanggal_verifikasi',
        'tanggal_ttd', 'tanggal_selesai', 'tanggal_ditolak',
        'catatan_admin', 'catatan_dosen', 'catatan_penolakan',
    ];

    protected $casts = [
        'tanggal_submit'      => 'datetime',
        'tanggal_verifikasi'  => 'datetime',
        'tanggal_ttd'         => 'datetime',
        'tanggal_selesai'     => 'datetime',
        'tanggal_ditolak'     => 'datetime',
    ];

    // ── Label & urutan status ─────────────────────────────────
    const STATUS_ORDER = [
        'submitted'        => 1,
        'admin_verifikasi' => 2,
        'dosen_ttd'        => 3,
        'selesai'          => 4,
        'ditolak'          => 99,
    ];

    const STATUS_LABEL = [
        'submitted'        => 'Menunggu Verifikasi Admin',
        'admin_verifikasi' => 'Sedang Diverifikasi Admin',
        'dosen_ttd'        => 'Menunggu TTD Dosen',
        'selesai'          => 'Selesai – Siap Diambil',
        'ditolak'          => 'Ditolak',
    ];

    const JENIS_LABEL = [
        'aktif-kuliah' => 'Surat Keterangan Aktif Kuliah',
        'transkrip'    => 'Transkrip Nilai Sementara',
        'cuti'         => 'Pengajuan Cuti Akademik',
        'legalisir'    => 'Legalisir Dokumen',
    ];

    // ── Validasi lompat tahap ─────────────────────────────────
    /**
     * Kembalikan true jika transisi status VALID (tidak lompat tahap).
     * 'ditolak' boleh dari status manapun selain 'selesai'.
     */
    public function bisaTransisiKe(string $statusBaru): bool
    {
        if ($this->status === 'selesai' || $this->status === 'ditolak') {
            return false; // status final, tidak bisa berubah
        }

        if ($statusBaru === 'ditolak') {
            return true; // bisa ditolak dari tahap manapun
        }

        $urutanSekarang = self::STATUS_ORDER[$this->status] ?? 0;
        $urutanBaru     = self::STATUS_ORDER[$statusBaru]    ?? 0;

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

    // ── Scopes ────────────────────────────────────────────────
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByMahasiswa($query, int $userId)
    {
        return $query->where('mahasiswa_id', $userId);
    }

    public function tandaTangan()
    {
        return $this->hasOne(\App\Models\TandaTangan::class, 'pengajuan_id');
    }
}