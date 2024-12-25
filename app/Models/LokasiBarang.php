<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiBarang extends Model
{
    use HasFactory;
    // Nama tabel
    protected $table = 'lokasi_barang';

    // Kolom yang dapat diisi (mass-assignable)
    protected $fillable = [
        'nama_rak',
        'status',
    ];


//     public function barangMasuk()
// {
//     return $this->belongsTo(BarangMasuk::class, 'id_barang_masuk');
// }

public function rak()
{
    return $this->belongsTo(Rak::class, 'id_rak');
}

}
