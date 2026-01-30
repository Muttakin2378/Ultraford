<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [
        'tanggal_masuk',
        'total_item',
        'catatan',
    ];

    public function detailBarangMasuks()
    {
        return $this->hasMany(DetailBarangMasuk::class);
    }
}
