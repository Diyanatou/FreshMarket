<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $fillable = ['utilisateur_id'];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function lignes()
    {
        return $this->hasMany(LignePanier::class);
    }

    public function total()
    {
        return $this->lignes->sum(function ($ligne) {
            return $ligne->produit->prix * $ligne->quantite;
        });
    }

    public function nombreArticles()
    {
        return $this->lignes->sum('quantite');
    }
    public function scopeDisponible($query)
{
    return $query->whereHas('lots', function ($q) {
        $q->where('date_expiration', '>', now());
    });
}
}
