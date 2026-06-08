<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'nim', 'prodi', 'semester'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'semester'          => 'integer',
        ];
    }

    // ── Role helpers ──────────────────────────────────────────
    // Dipakai di StorePengajuanRequest, RoleMiddleware, DosenController, AdminController

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ── Relationships ─────────────────────────────────────────

    /** Pengajuan yang dibuat mahasiswa ini */
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'mahasiswa_id');
    }

    /** Pengajuan yang ditugaskan ke dosen ini */
    public function pengajuanDosen()
    {
        return $this->hasMany(Pengajuan::class, 'dosen_id');
    }

    /** TTD digital yang pernah dibuat dosen ini */
    public function tandaTangan()
    {
        return $this->hasMany(TandaTangan::class, 'dosen_id');
    }
}