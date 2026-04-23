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

    // 🏷️ RELATIONS
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

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

    // 📊 STOCK TOTAL (TOUS LOTS)
    public function stockTotal()
    {
        return $this->lots()->sum('quantite');
    }

    // 📊 STOCK DISPONIBLE (UNIQUEMENT VALIDE)
    public function stockDisponible()
    {
        return $this->lotsValides()->sum('quantite');
    }

    // ✅ DISPONIBILITÉ PRODUIT
    public function isAvailable(): bool
    {
        return $this->actif && $this->stockDisponible() > 0;
    }

    // 🔥 DIMINUTION STOCK (FEFO propre)
    public function decrementStock(int $quantite)
    {
        $lots = $this->lotsValides()
            ->orderBy('date_expiration', 'asc')
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

        if ($restant > 0) {
            throw new \Exception("Stock insuffisant pour : " . $this->nom);
        }
    }
}