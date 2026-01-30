<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * 🔐 INI YANG DIPAKAI FILAMENT
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->is_admin === true;
        }

        return false;
    }

    /* ================== RELATIONS ================== */

    // 1 user punya banyak alamat
    public function alamats()
    {
        return $this->hasMany(Alamat::class, 'user_id');
    }

    // 1 user punya banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    // 1 user banyak penarikan
    public function riwayatPenarikan()
    {
        return $this->hasMany(RiwayatPenarikan::class);
    }

    // 1 user banyak notif
    public function notif()
    {
        return $this->hasMany(Notif::class);
    }

    public function riview()
    {
        return $this->hasMany(Riview::class);
    }

    /* ================== HELPER ================== */

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}
