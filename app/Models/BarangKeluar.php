<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

     /**
     * Table associated with the model.
     *
     * @var string
     */
    protected $table = 'barang_keluar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_barang',
        'id_rak',
        'id_user',
        'jumlah_keluar',
        'tanggal_keluar',
        'alasan',
        'harga',
        'total',
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

    /**
     * Accessor for formatted total value.
     *
     * @return string
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    /**
     * Mutator to automatically calculate the total based on jumlah_keluar and harga.
     *
     * @return void
     */
    public function setTotalAttribute()
    {
        $this->attributes['total'] = $this->jumlah_keluar * $this->harga;
    }
}