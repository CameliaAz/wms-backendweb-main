<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang'; // Nama tabel yang digunakan
    // Menambahkan properti $fillable untuk mencegah mass assignment vulnerability
    protected $fillable = [
        'nama_barang',
        'id_kategori',
        'varian',
        'ukuran',
        'deskripsi',
        'gambar',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    // Relasi ke BarangMasuk
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang', 'id');
    }

    // Relasi ke LokasiBarang
    public function lokasiBarang()
    {
        return $this->hasMany(LokasiBarang::class, 'id_barang', 'id');
    }

    // Relasi ke BarangPindah
    public function barangPindah()
    {
        return $this->hasMany(BarangPindah::class, 'id_barang', 'id');
    }

    // Relasi ke BarangKeluar
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_barang', 'id');
    }
}
