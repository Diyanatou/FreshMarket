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
        'fournisseur_id',   // ✅ ajouté
        'quantite',
        'prix_achat',       // ✅ ajouté
        'date_expiration',
    ];

    protected $casts = [
        'date_expiration' => 'date',
    ];

    // 🔗 RELATION PRODUIT
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    // 🔗 RELATION FOURNISSEUR
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    // ❌ EXPIRE
    public function isExpired(): bool
    {
        return $this->date_expiration && $this->date_expiration->isPast();
    }

    // ⚠️ BIENTÔT EXPIRÉ (7 jours)
    public function isExpiringSoon(): bool
    {
        return $this->date_expiration 
            && $this->date_expiration->isBetween(now(), now()->addDays(7));
    }

    // 💸 VALEUR DU LOT (utile pour pertes)
    public function valeur()
    {
        return $this->quantite * $this->prix_achat;
    }
}