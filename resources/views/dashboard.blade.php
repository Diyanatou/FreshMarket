@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">

    <!-- Bienvenue -->
    <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-8 text-white shadow-xl shadow-blue-100">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black mb-2 tracking-tight">Bienvenue, {{ Auth::user()->nom }} </h2>
                <p class="text-blue-100 text-sm font-medium">Voici l'état actuel de votre marché FreshMarket</p>
            </div>
            <i class="fas fa-chart-line text-8xl opacity-10 hidden md:block"></i>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-shopping-cart text-primary text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Commandes</p>
                <p class="text-2xl font-black text-gray-900">{{ $stats['total_commandes'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Ventes Totales</p>
                <p class="text-xl font-black text-gray-900">{{ number_format($stats['total_ventes'], 0, ',', ' ') }} <small class="text-xs">FCFA</small></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-hourglass-half text-orange-500 text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Stock Alerte</p>
                <p class="text-2xl font-black {{ $stats['stock_alerte'] > 0 ? 'text-orange-500' : 'text-gray-900' }}">{{ $stats['stock_alerte'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-times text-red-500 text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Expirés</p>
                <p class="text-2xl font-black {{ $stats['produits_expires'] > 0 ? 'text-red-500' : 'text-gray-900' }}">{{ $stats['produits_expires'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Commandes Récentes -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-black text-gray-900 uppercase tracking-tight text-sm">Dernières commandes</h3>
                <a href="{{ route('commandes.index') }}" class="text-xs text-primary hover:underline font-bold">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Client</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($commandes_recentes as $cmd)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-gray-900">#{{ $cmd->id }}</td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-600">{{ $cmd->utilisateur->nom }}</td>
                            <td class="px-6 py-4 text-xs font-black text-gray-900">{{ number_format($cmd->prix_total, 0, ',', ' ') }} FCFA</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-[9px] font-black uppercase rounded-full bg-blue-50 text-primary">
                                    {{ $cmd->statut }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Actions & Alertes -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black text-gray-900 uppercase tracking-tight text-sm mb-4">Actions rapides</h3>
                <div class="space-y-3">
                    <a href="{{ route('produits.index') }}" class="flex items-center justify-between p-4 rounded-xl bg-primary text-white hover:bg-secondary transition-all group">
                        <span class="text-sm font-bold">Nouveau Produit</span>
                        <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform"></i>
                    </a>
                    <a href="{{ route('categories.index') }}" class="flex items-center justify-between p-4 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 transition-all">
                        <span class="text-sm font-bold">Gérer Catégories</span>
                        <i class="fas fa-tags text-gray-400"></i>
                    </a>
                </div>
            </div>

            <!-- Alertes expiration -->
            @php
                $alertes = \App\Models\LotProduit::with('produit')
                    ->where('date_expiration', '>', now())
                    ->where('date_expiration', '<=', now()->addDays(15))
                    ->where('quantite', '>', 0)
                    ->orderBy('date_expiration')
                    ->take(3)
                    ->get();
            @endphp
            @if($alertes->count() > 0)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black text-red-500 uppercase tracking-tight text-sm mb-4 flex items-center gap-2">
                    <i class="fas fa-bell"></i> Alertes Expiration
                </h3>
                <div class="space-y-4">
                    @foreach($alertes as $lot)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-times text-red-500 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">{{ $lot->produit->nom }}</p>
                            <p class="text-[10px] text-gray-400">Expire le {{ $lot->date_expiration->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
