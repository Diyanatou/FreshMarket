<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'utilisateur_id',
        'creneau_id',
        'statut',
        'prix_total',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function creneau()
    {
        return $this->belongsTo(CreneauLivraison::class, 'creneau_id');
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
