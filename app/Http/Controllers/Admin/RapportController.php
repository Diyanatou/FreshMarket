<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotProduit;
use Carbon\Carbon;

class RapportController extends Controller
{
    public function pertes()
    {
        // lots expirés
        $lotsPerimes = LotProduit::with('produit')
            ->where('date_expiration', '<', now())
            ->get();

        // calcul pertes
        $totalPerte = 0;
        $details = [];

        foreach ($lotsPerimes as $lot) {
            $perteLot = $lot->quantite * ($lot->produit->prix ?? 0);

            $details[] = [
                'produit' => $lot->produit->nom ?? 'Produit supprimé',
                'quantite' => $lot->quantite,
                'prix_unitaire' => $lot->produit->prix ?? 0,
                'perte' => $perteLot,
                'date_expiration' => $lot->date_expiration,
            ];

            $totalPerte += $perteLot;
        }

        return view('admin.rapports.pertes', compact('details', 'totalPerte'));
    }
}

