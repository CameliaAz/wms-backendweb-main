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
        'id_user', // Tambahkan id_user
        'jumlah_barang_masuk',
        'exp',
        'tgl_masuk',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_tujuan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // Relasi ke user
    }
}
