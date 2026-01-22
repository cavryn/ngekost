<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Profile; // ⬅️ INI YANG KURANG

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔗 Relasi ke profile (1 user punya 1 profile)
public function profile()
{
    return $this->hasOne(\App\Models\Profile::class);
}

public function laporans()
{
    return $this->hasMany(Laporan::class);
}

}
