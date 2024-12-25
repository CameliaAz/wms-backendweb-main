<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }
}