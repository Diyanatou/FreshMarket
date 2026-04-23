<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreneauLivraison extends Model
{
    use HasFactory;

    protected $table = 'creneaux_livraison';

    protected $fillable = [
        'date',
        'heure_debut',
        'heure_fin',
        'capacite_max',
        'nombre_commandes',
        'statut',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'creneau_id');
    }

    public function isFull(): bool
    {
        return $this->nombre_commandes >= $this->capacite_max;
    }
}
