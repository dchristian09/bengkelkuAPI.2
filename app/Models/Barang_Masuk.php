<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang_Masuk extends Model
{
    use HasFactory;

    protected $fillable = ['barang_id', 'kuantitas_barang', 'harga_modal'];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
