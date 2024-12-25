<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'barang_masuk';
    protected $fillable = [
        'id_barang',
        'id_supplier',
        'jumlah_barang_masuk',
        'exp',
        'tgl_masuk',
    ];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
