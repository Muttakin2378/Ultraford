<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'aksi',
        'model',
        'model_id',
        'keterangan',
        'ip',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
