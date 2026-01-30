<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // event model untuk update stok
    protected static function booted()
    {
        static::created(function ($detail) {
            $produk = $detail->produk;
            $produk->stok -= $detail->jumlah;
            $produk->save();
        });
    }
}
