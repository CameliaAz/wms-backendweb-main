<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'rak';

    // Kolom yang dapat diisi (mass-assignable)
    protected $fillable = [
        'nama_rak',
        'status',
    ];

    public function lokasiBarang()
    {
        return $this->hasMany(LokasiBarang::class);
    }

    public function barangPindah()
    {
        return $this->hasMany(BarangPindah::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
