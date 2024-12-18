<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = ['nama_produk', 'id_kategori', 'harga', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function lokasiBarang()
    {
        return $this->hasMany(LokasiBarang::class, 'id_produk', 'id');
    }

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_produk', 'id');
    }

    public function pembelianDetail()
    {
        return $this->hasMany(PembelianDetail::class, 'id_produk', 'id');
    }
}
