<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrakan extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'judul',
    'alamat',
    'harga',
    'max_penghuni',
    'jumlah_penghuni',
    'deskripsi',
    'foto',
    'latitude',
    'longitude',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporans()
{
    return $this->hasMany(Laporan::class);
}

}

