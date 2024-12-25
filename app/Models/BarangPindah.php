<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangPindah extends Model
{
    use HasFactory;

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function rakSumber()
    {
        return $this->belongsTo(Rak::class, 'id_rak_sumber');
    }

    public function rakTujuan()
    {
        return $this->belongsTo(Rak::class, 'id_rak_tujuan');
    }
}
