<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'barang_keluar';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'id_barang',
        'id_rak',
        'id_user',
        'jumlah_keluar',
        'tanggal_keluar',
        'alasan',
    ];

    /**
     * Define the relationship with the Barang model (one to many inverse)
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /**
     * Define the relationship with the Rak model (one to many inverse)
     */
    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_rak');
    }

    /**
     * Define the relationship with the User model (one to many inverse)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
