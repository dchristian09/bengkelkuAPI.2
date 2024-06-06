<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bengkel extends Model
{
    use HasFactory;

    protected $fillable = ['nama_bengkel', 'alamat'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function mechanics(): HasMany
    {
        return $this->hasMany(Mechanic::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
