<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBarangMasuk extends Model
{
    protected $fillable = [
        'barang_masuk_id',
        'produk_id',
        'jumlah',
        'biaya_produksi',
        'total_biaya',
    ];

    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Event untuk menambah stok otomatis saat data dibuat
    protected static function booted()
    {
        static::created(function ($detail) {
            $produk = $detail->produk;
            $produk->stok += $detail->jumlah;
            $produk->save();
        });
    }
}
