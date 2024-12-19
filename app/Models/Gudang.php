<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gudang',
        'rak_id',
    ];

    // Relasi dengan rak
    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id', 'id');
    }
}
