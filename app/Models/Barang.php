<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama',
        'kategori_id',
        'supplier_id',
        'stok',
        'expired',
        'harga_beli',
    ];

    /**
     * Relasi ke tabel Kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    /**
     * Relasi ke tabel Supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function masuk()
    {
        return $this->hasMany(masuk::class);
    }

    public function keluar()
    {
        return $this->hasMany(keluar::class);
    }

    public function pemindahan()
    {
        return $this->hasMany(pemindahan::class);
    }
}
