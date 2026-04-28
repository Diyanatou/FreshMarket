<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    protected $fillable = [
        'fournisseur_id',
        'produit_id',
        'quantite',
        'prix_achat',
        'date_expiration'
    ];

    // 🔗 RELATIONS
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}