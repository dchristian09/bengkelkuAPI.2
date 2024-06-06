<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['bengkel_id', 'nama_barang', 'harga_jual', 'kode_barang'];

    public function detail_transaksi(): HasMany
    {
        return $this->hasMany(Detail_Transaksi::class);
    }

    public function bengkel(): BelongsTo
    {
        return $this->belongsTo(Bengkel::class);
    }

    public function barang_masuk(): HasMany
    {
        return $this->hasMany(Barang_Masuk::class);
    }
}
