<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riview extends Model
{
    protected $fillable = [
        'user_id',
        'produk_id',
        'rating',
        'komen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
