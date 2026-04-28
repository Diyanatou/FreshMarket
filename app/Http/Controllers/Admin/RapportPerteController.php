<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotProduit;
use Carbon\Carbon;

class RapportPerteController extends Controller
{
    public function index(Request $request)
    {
        $query = LotProduit::with('produit');

        // 🔎 SEARCH
        if ($request->search) {
            $query->whereHas('produit', function ($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->search.'%');
            });
        }

        // 📅 FILTRES
        if ($request->filtre == 'semaine') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        if ($request->filtre == 'mois') {
            $query->whereMonth('created_at', now()->month);
        }

        if ($request->filtre == 'annee') {
            $query->whereYear('created_at', now()->year);
        }

        $lots = $query->get();

        // 💸 PERTE
        $totalPerte = $lots->sum(function ($lot) {
            return $lot->quantite * $lot->produit->prix;
        });

        // 🚨 ALERTES
        $alerts = $lots->filter(function ($lot) {
            return Carbon::parse($lot->date_expiration)
                ->diffInDays(now()) <= 3;
        });

        // 📊 CHART
        $chartLabels = $lots->map(fn($l) => $l->produit->nom);
        $chartData = $lots->map(fn($l) => $l->quantite * $l->produit->prix);

        return view('admin.rapports.pertes', compact(
            'lots',
            'totalPerte',
            'alerts',
            'chartLabels',
            'chartData'
        ));
    }
}