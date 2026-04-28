<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'adresse'
    ];

    // 🔗 RELATION : fournisseur → lots
    public function lots()
    {
        return $this->hasMany(LotProduit::class);
    }
}