<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyseController extends Controller
{
    public function index()
    {
        // 1. Chiffre d'Affaires Total (Confirmé ou Livré)
        $totalRevenue = Commande::whereIn('statut', ['confirmee', 'livree'])->sum('prix_total');

        // 2. Nombre total de commandes
        $totalOrders = Commande::count();

        // 3. Panier Moyen
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / Commande::whereIn('statut', ['confirmee', 'livree'])->count() : 0;

        // 4. Ventes par jour (7 derniers jours)
        $salesPerDay = Commande::whereIn('statut', ['confirmee', 'livree'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(prix_total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 5. Top 5 Produits les plus vendus
        $topProducts = LigneCommande::select('produit_id', DB::raw('SUM(quantite) as total_qty'))
            ->with('produit')
            ->groupBy('produit_id')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        // 6. Répartition par Statut
        $statusDistribution = Commande::select('statut', DB::raw('count(*) as count'))
            ->groupBy('statut')
            ->get();

        return view('admin.analyses.index', compact(
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'salesPerDay',
            'topProducts',
            'statusDistribution'
        ));
    }
}
