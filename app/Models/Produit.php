<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'categorie_id',
        'type',
        'seuil_alerte',
        'actif',
        'image',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    // 🏷️ RELATION : CATEGORIE
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // 📦 RELATION : LOTS
    public function lots()
    {
        return $this->hasMany(LotProduit::class);
    }

    // 📦 LOTS VALIDES (non expirés + stock > 0)
    public function lotsValides()
    {
        return $this->hasMany(LotProduit::class)
            ->where(function ($q) {
                $q->whereNull('date_expiration')
                  ->orWhere('date_expiration', '>', now());
            })
            ->where('quantite', '>', 0);
    }

    // 📊 STOCK TOTAL (tous les lots)
    public function stockTotal()
    {
        return $this->lots()->sum('quantite');
    }

    // 📊 STOCK DISPONIBLE (lots valides uniquement)
    public function stockDisponible()
    {
        return $this->lotsValides()->sum('quantite');
    }

    // ⚠️ STOCK EN ALERTE
    public function isStockAlerte(): bool
    {
        return $this->stockDisponible() <= $this->seuil_alerte;
    }

    // ✅ DISPONIBILITÉ PRODUIT
    public function isAvailable(): bool
    {
        return $this->actif && $this->stockDisponible() > 0;
    }

    // 💸 VALEUR DU STOCK (basée sur prix achat)
    public function valeurStock()
    {
        return $this->lots()->sum(function ($lot) {
            return $lot->quantite * $lot->prix_achat;
        });
    }

    // 🔥 SORTIE STOCK (FIFO / FEFO)
    public function decrementStock(int $quantite)
    {
        $lots = $this->lotsValides()
            ->orderByRaw('date_expiration IS NULL') // NULL en dernier
            ->orderBy('date_expiration', 'asc')     // FEFO
            ->get();

        $restant = $quantite;

        foreach ($lots as $lot) {

            if ($restant <= 0) break;

            if ($lot->quantite >= $restant) {
                $lot->decrement('quantite', $restant);
                $restant = 0;
            } else {
                $restant -= $lot->quantite;
                $lot->update(['quantite' => 0]);
            }
        }

        // ❌ sécurité
        if ($restant > 0) {
            throw new \Exception("Stock insuffisant pour : " . $this->nom);
        }
    }
}