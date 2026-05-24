<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPengajuan extends Model
{
    public $timestamps = false;

    protected $table = 'log_pengajuan';

    protected $fillable = [
        'pengajuan_id', 'user_id', 'status_dari',
        'status_ke', 'catatan', 'actor_role',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}