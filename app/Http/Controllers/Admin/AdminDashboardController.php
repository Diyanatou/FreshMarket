<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\LotProduit;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 📊 STATS
        $stats = [
            'total_produits' => Produit::count(),
            'total_commandes' => Commande::count(),
            'total_ventes' => Commande::where('statut', 'livree')->sum('prix_total'),

            'stock_alerte' => Produit::all()
                ->filter(fn($p) => $p->stockDisponible() <= $p->seuil_alerte)
                ->count(),

            'produits_expires' => LotProduit::where('date_expiration', '<', now())
                ->sum('quantite'),
        ];

        // 📦 COMMANDES
        $commandes_recentes = Commande::with('utilisateur')
            ->latest()
            ->take(10)
            ->get();

        // 📅 FILTRE
        $periode = request('periode', 'mois');

        switch ($periode) {
            case 'jour':
                $format = '%H:00';
                break;
            case 'semaine':
                $format = '%d/%m';
                break;
            case 'annee':
                $format = '%m/%Y';
                break;
            default:
                $format = '%d/%m';
        }

        // 📊 VENTES
        $ventesData = DB::table('commandes')
            ->selectRaw("DATE_FORMAT(created_at, '$format') as date, SUM(prix_total) as total")
            ->where('statut', 'livree')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📉 PERTES (sans prix_achat)
        $pertesData = DB::table('lots_produits')
            ->join('produits', 'produits.id', '=', 'lots_produits.produit_id')
            ->selectRaw("
                DATE_FORMAT(date_expiration, '$format') as date,
                SUM(lots_produits.quantite * produits.prix) as total
            ")
            ->whereDate('date_expiration', '<', now())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📊 FORMAT CHART
        $chartLabels = $ventesData->pluck('date');
        $chartVentes = $ventesData->pluck('total');

        $pertesMap = $pertesData->pluck('total', 'date');

        $chartPertes = $chartLabels->map(function ($date) use ($pertesMap) {
            return $pertesMap[$date] ?? 0;
        });

        $chart = [
            'ventes' => $chartVentes->sum(),
            'pertes' => $chartPertes->sum(),
        ];

        // ❌ TOP PRODUITS désactivé (temporaire)
        $topLabels = [];
        $topData = [];

        return view('dashboard', compact(
            'stats',
            'commandes_recentes',
            'chartLabels',
            'chartVentes',
            'chartPertes',
            'chart',
            'topLabels',
            'topData'
        ));
    }
}