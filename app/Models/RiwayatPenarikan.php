<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenarikan extends Model{
    protected $fillable = [
        'id',
        'user_id',
        'kode_penarikan',
        'nominal',
        'tujuan',
        'rekening',
        'tanggal_penarikan',
        'tanggal_final',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}