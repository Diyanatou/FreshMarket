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
        // 📅 FILTRE PÉRIODE
        $periode = request('periode', 'mois');

        $startDate = match ($periode) {
            'jour'    => now()->startOfDay(),
            'semaine' => now()->startOfWeek(),
            'mois'    => now()->startOfMonth(),
            'annee'   => now()->startOfYear(),
            default   => now()->startOfMonth(),
        };

        // 📊 STATS
        $stats = [
            'total_produits'   => Produit::count(),
            'total_commandes'  => Commande::count(),

            // ✅ VENTES = commandes livrées
            'total_ventes' => Commande::where('statut', 'livree')
                ->where('created_at', '>=', $startDate)
                ->sum('prix_total'),

            // ⚠️ STOCK ALERTE
            'stock_alerte' => Produit::all()
                ->filter(fn($p) => $p->stockDisponible() <= $p->seuil_alerte)
                ->count(),

            // 💀 PRODUITS EXPIRÉS
            'produits_expires' => LotProduit::where('date_expiration', '<', now())
                ->sum('quantite'),
        ];

        // 📦 COMMANDES RÉCENTES
        $commandes_recentes = Commande::with('utilisateur')
            ->latest()
            ->take(10)
            ->get();

        // 📅 FORMAT CHART
        $format = match ($periode) {
            'jour'    => '%H:00',
            'semaine' => '%d/%m',
            'mois'    => '%d/%m',
            'annee'   => '%m/%Y',
            default   => '%d/%m',
        };

        // 📊 VENTES
        $ventesData = DB::table('commandes')
            ->selectRaw("DATE_FORMAT(created_at, '$format') as date, SUM(prix_total) as total")
            ->where('statut', 'livree')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📉 PERTES
        $pertesData = DB::table('lots_produits')
            ->selectRaw("
                DATE_FORMAT(date_expiration, '$format') as date,
                SUM(quantite * prix_achat) as total
            ")
            ->whereDate('date_expiration', '<', now())
            ->whereDate('date_expiration', '>=', $startDate)
            ->whereNotNull('prix_achat')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📊 FORMAT CHART
        $chartLabels = $ventesData->pluck('date');
        $chartVentes = $ventesData->pluck('total')->map(fn($v) => round($v));

        $pertesMap   = $pertesData->pluck('total', 'date');
        $chartPertes = $chartLabels->map(fn($date) => round($pertesMap[$date] ?? 0));

        // 💰 TOTAUX
        $chart = [
            'ventes' => $chartVentes->sum(),
            'pertes' => $chartPertes->sum(),
        ];

        return view('dashboard', compact(
            'stats',
            'commandes_recentes',
            'chartLabels',
            'chartVentes',
            'chartPertes',
            'chart',
        ));
    }
}