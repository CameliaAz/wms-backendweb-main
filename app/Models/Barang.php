<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'barang';

    // Kolom yang dapat diisi secara mass-assignment
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
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id'); // Barang belongs to Kategori
    }

    // Relasi ke BarangMasuk
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang', 'id'); // Barang has many BarangMasuk
    }

    // Relasi ke LokasiBarang
    public function lokasiBarang()
    {
        return $this->hasMany(LokasiBarang::class, 'id_barang', 'id'); // Barang has many LokasiBarang
    }

    // Relasi ke BarangPindah
    public function barangPindah()
    {
        return $this->hasMany(BarangPindah::class, 'id_barang', 'id'); // Barang has many BarangPindah
    }

    // Relasi ke BarangKeluar
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_barang', 'id'); // Barang has many BarangKeluar
    }
}
