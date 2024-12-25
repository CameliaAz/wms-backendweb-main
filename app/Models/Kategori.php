<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    
    // Nama tabel yang digunakan
    protected $table = 'kategori'; 
    protected $fillable = [
        'nama_kat',
    ]; // Kolom yang dapat diisi secara mass-assignment

    // Relasi: Satu kategori memiliki banyak barang
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id');
    }
}
