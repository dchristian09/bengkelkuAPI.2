<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detail_Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['transaksi_id', 'barang_id', 'jumlah_barang', 'keuntungan_bersih'];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
