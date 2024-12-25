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
        'nama_lokasi', // Menambahkan nama_lokasi ke dalam fillable
        'jumlah',      // Menambahkan jumlah ke dalam fillable
        'status',
        'id_barang',   // Menambahkan id_barang untuk relasi dengan tabel barang
        'exp',          // Menambahkan exp (tanggal kedaluwarsa) ke dalam fillable
    ];

    public function barang()
    {
    return $this->belongsTo(Barang::class, 'id_barang');
    }

    /**
     * Relasi dengan LokasiBarang (rak bisa memiliki banyak lokasi barang)
     */
    public function lokasiBarang()
    {
        return $this->hasMany(LokasiBarang::class);
    }

    /**
     * Relasi dengan BarangPindah (rak bisa memiliki banyak barang pindah)
     */
    public function barangPindah()
    {
        return $this->hasMany(BarangPindah::class);
    }

    /**
     * Relasi dengan BarangKeluar (rak bisa memiliki banyak barang keluar)
     */
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
