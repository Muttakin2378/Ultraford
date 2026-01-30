<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'alamat_id',
        'nama_penerima',
        'no_telp_penerima',
        'tanggal_transaksi',
        'tanggal_selesai',      
        'total_harga',
        'ekspedisi',
        'no_resi',            
        'order_id',             
        'snap_token',           
        'status',
        'ongkir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
    public function returnOrder()
    {
        return $this->hasOne(ReturnOrder::class);
    }


    public function getStatusColorAttribute()
    {
        return match (strtolower(trim($this->status))) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'dikemas' => 'bg-green-100 text-green-700',
            'dikirim' => 'bg-blue-100 text-blue-700',
            'dibatalkan' => 'bg-red-100 text-red-700',
            'return' => 'bg-gray-100 text-gray-700',
            default => 'bg-purple-100 text-gray-700',
        };
    }
}
