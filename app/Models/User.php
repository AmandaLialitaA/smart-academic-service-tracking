<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'nim', 'prodi', 'semester',
        'nidn', 'jabatan',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Helper role ───────────────────────────────────────────
    public function isMahasiswa(): bool { return $this->role === 'mahasiswa'; }
    public function isDosen(): bool     { return $this->role === 'dosen'; }
    public function isAdmin(): bool     { return $this->role === 'admin'; }

    // ── Relasi ────────────────────────────────────────────────
    public function pengajuanSebagaiMahasiswa()
    {
        return $this->hasMany(Pengajuan::class, 'mahasiswa_id');
    }

    public function pengajuanSebagaiDosen()
    {
        return $this->hasMany(Pengajuan::class, 'dosen_id');
    }
}