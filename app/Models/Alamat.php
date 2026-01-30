<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $fillable = [
        'user_id', 
        'label',
        'nama_penerima',
        'telepon_penerima',
        'alamat_lengkap',
        'kota',
        'kode_pos',
        'is_default',
    ];

    // 🔗 Relasi: alamat milik satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔗 Relasi: alamat bisa dipakai di banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'alamat_id');
    }
}
