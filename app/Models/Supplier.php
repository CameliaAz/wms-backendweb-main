<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = ['nama_supplier', 'kontak', 'alamat'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function masuk()
    {
        return $this->hasMany(masuk::class);
    }
}
