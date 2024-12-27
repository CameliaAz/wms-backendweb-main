<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangPindah extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'barang_pindah';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'id_barang',
        'id_lokasi_sumber',
        'id_lokasi_tujuan',
        'id_user',
        'jumlah_pindah',
    ];

    /**
     * Relasi dengan model Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /**
     * Relasi dengan model Lokasi Sumber (Rak Sumber)
     */
    public function lokasiSumber()
    {
        return $this->belongsTo(Rak::class, 'id_lokasi_sumber');
    }

    /**
     * Relasi dengan model Lokasi Tujuan (Rak Tujuan)
     */
    public function lokasiTujuan()
    {
        return $this->belongsTo(Rak::class, 'id_lokasi_tujuan');
    }

    /**
     * Relasi dengan model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
