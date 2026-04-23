<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function lots()
    {
        return $this->hasMany(LotProduit::class);
    }

    /**
     * Retourne les lots qui ne sont pas périmés et qui ont du stock
     */
    public function lotsValides()
    {
        return $this->hasMany(LotProduit::class)
            ->where(function($q) {
                $q->whereNull('date_expiration')
                  ->orWhere('date_expiration', '>', now());
            })
            ->where('quantite', '>', 0);
    }

    /**
     * Stock total incluant les produits périmés
     */
    public function stockTotal()
    {
        return $this->lots()->sum('quantite');
    }

    /**
     * Stock réellement vendable (non périmé)
     */
    public function stockDisponible()
    {
        return $this->lotsValides()->sum('quantite');
    }

    /**
     * Vérifie si le produit peut être affiché et vendu
     */
    public function isAvailable(): bool
    {
        return $this->actif && $this->stockDisponible() > 0;
    }

    /**
     * Décrémente le stock en utilisant les lots les plus anciens ou périmant bientôt en premier (FEFO)
     */
    public function decrementStock(int $quantite)
    {
        $lots = $this->lotsValides()
            ->orderByRaw('date_expiration IS NULL ASC') // Les produits sans date d'expiration en dernier
            ->orderBy('date_expiration', 'asc') // Les dates les plus proches en premier
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
            throw new \Exception("Stock insuffisant pour le produit : " . $this->nom);
        }
    }
}
