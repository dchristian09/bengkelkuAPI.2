<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['plat_nomor', 'harga_jasa', 'total_transaksi', 'status_transaksi', 'user_id', 'mechanic_id', 'bengkel_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bengkel(): BelongsTo
    {
        return $this->belongsTo(Bengkel::class);
    }

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function detail_transaksi(): HasMany
    {
        return $this->hasMany(Detail_Transaksi::class);
    }

}
