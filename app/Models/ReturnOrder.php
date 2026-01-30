<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'transaksi_id',
        'user_id',
        'alasan',
        'foto_bukti',
        'no_resi',
        'status',
        'catatan_admin'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
