<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama_produk',
        'jenis',
        'stok',
        'harga_jual',
        'deskripsi',
        'gambar',
    ];

    public function totalTerjual()
    {
        return $this->detailTransaksis()->sum('jumlah');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function detailBarangMasuks()
    {
        return $this->hasMany(DetailBarangMasuk::class);
    }

    public function gambars()
    {
        return $this->hasMany(ProdukGambar::class);
    }

    public function reviews()
    {
        return $this->hasMany(Riview::class);
    }

    public function averageRating()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
