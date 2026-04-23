<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotProduit extends Model
{
    use HasFactory;

    protected $table = 'lots_produits';

    protected $fillable = [
        'produit_id',
        'quantite',
        'date_expiration',
    ];

    protected $casts = [
        'date_expiration' => 'date',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function isExpired(): bool
    {
        return $this->date_expiration && $this->date_expiration->isPast();
    }

    public function isExpiringSoon(): bool
    {
        return $this->date_expiration && $this->date_expiration->isBetween(now(), now()->addDays(7));
    }
}
