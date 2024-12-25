<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier'; // Nama tabel yang digunakan
    protected $fillable = [
        'nama_sup',
        'telepon',
        'alamat',
    ]; // Kolom yang dapat diisi secara mass-assignment

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_supplier');
    }
}
