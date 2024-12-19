<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemindahan extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_barang',
        'lokasi_asal',
        'lokasitujuan',
        'jumlah',
        'id_user',
    ];

    // Relasi dengan barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Relasi dengan rak asal (lokasi asal)
    public function rakAsal()
    {
        return $this->belongsTo(Rak::class, 'lokasi_asal', 'id');
    }

    // Relasi dengan rak tujuan (lokasi tujuan)
    public function rakTujuan()
    {
        return $this->belongsTo(Rak::class, 'lokasitujuan', 'id');
    }

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
