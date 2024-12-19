<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluar extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_barang',
        'id_kategori',
        'jumlah',
        'lokasi_asal',
        'lokasitujuan',
        'id_user',
    ];

    // Relasi dengan barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    // Relasi dengan rak (lokasi asal)
    public function lokasiAsalRak()
    {
        return $this->belongsTo(Rak::class, 'lokasi_asal', 'id');
    }

    // Relasi dengan rak (lokasi tujuan)
    public function lokasiTujuanRak()
    {
        return $this->belongsTo(Rak::class, 'lokasitujuan', 'id');
    }

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
