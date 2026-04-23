<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\LotProduit;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->cannot('viewAdminDashboard', User::class)) {
            return redirect('/')->with('error', 'Accès non autorisé.');
        }

        $stats = [
            'total_produits' => Produit::count(),
            'total_commandes' => Commande::count(),
            'total_ventes' => Commande::where('statut', 'livree')->sum('prix_total'),
            'produits_expires' => LotProduit::where('date_expiration', '<', now())->where('quantite', '>', 0)->count(),
            'stock_alerte' => Produit::all()->filter(fn($p) => $p->stockDisponible() <= $p->seuil_alerte)->count(),
        ];

        $commandes_recentes = Commande::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'commandes_recentes'));
    }
}
