<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'rak';

    protected $fillable = [
        'nama_rak',
    ];

    /**
     * Relasi ke produk jika ada.
     * Asumsi: relasi satu rak dapat memiliki banyak produk.
     */
    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function keluar()
    {
        return $this->hasMany(keluar::class);
    }

    public function pemindahan()
    {
        return $this->hasMany(pemindahan::class);
    }
}
