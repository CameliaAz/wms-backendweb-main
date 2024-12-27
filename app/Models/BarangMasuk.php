<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'id_barang',
        'id_supplier',
        'id_tujuan',
        'id_user',
        'jumlah_barang_masuk',
        'exp',
        'tgl_masuk',
        'harga',
        'total', // Include total in fillable
    ];

    protected static function boot()
    {
        parent::boot();

        // Menghitung total sebelum menyimpan data
        static::saving(function ($model) {
            $model->total = $model->harga * $model->jumlah_barang_masuk;
        });
    }

    // Relasi dengan model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Relasi dengan model Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    // Relasi dengan model Rak
    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_tujuan');
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
