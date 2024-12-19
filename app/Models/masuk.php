<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang',
        'id_kategori',
        'id_supplier',
        'jumlah',
        'expired',
        'harga_beli',
    ];

    // Relasi dengan barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi dengan supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
