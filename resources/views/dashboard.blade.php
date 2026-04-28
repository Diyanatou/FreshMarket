@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-8 text-white shadow-xl">
        <h2 class="text-3xl font-black">
            Bienvenue, {{ Auth::user()->nom }}
        </h2>
        <p class="text-blue-100 text-sm">
            Dashboard FreshMarket - Gestion intelligente du stock
        </p>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Commandes</p>
            <p class="text-2xl font-black">{{ $stats['total_commandes'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Ventes</p>
            <p class="text-xl font-black text-green-600">
                {{ number_format($stats['total_ventes'], 0, ',', ' ') }} FCFA
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Pertes</p>
            <p class="text-xl font-black text-red-500">
                {{ number_format($chart['pertes'], 0, ',', ' ') }} FCFA
            </p>
        </div>

        <!-- 💰 PROFIT -->
        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Profit</p>
            <p class="text-xl font-black text-blue-600">
                {{ number_format($stats['total_ventes'] - $chart['pertes'], 0, ',', ' ') }} FCFA
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Stock alerte</p>
            <p class="text-2xl font-black text-orange-500">
                {{ $stats['stock_alerte'] }}
            </p>
        </div>

    </div>

    <!-- FILTRE -->
    <form method="GET" class="flex gap-3 items-center">
        <select name="periode" onchange="this.form.submit()" class="border px-3 py-2 rounded-lg">
            <option value="jour"    {{ request('periode') === 'jour' ? 'selected' : '' }}>Jour</option>
            <option value="semaine" {{ request('periode') === 'semaine' ? 'selected' : '' }}>Semaine</option>
            <option value="mois"    {{ request('periode', 'mois') === 'mois' ? 'selected' : '' }}>Mois</option>
            <option value="annee"   {{ request('periode') === 'annee' ? 'selected' : '' }}>Année</option>
        </select>
    </form>

    <!-- GRAPH -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="font-bold mb-4">📊 Ventes vs Pertes</h3>
        <canvas id="salesChart"></canvas>
    </div>

    <!-- COMMANDES RECENTES -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 border-b font-bold">
            Dernières commandes
        </div>

        @if($commandes_recentes->isEmpty())
            <p class="p-4 text-gray-400 text-sm">Aucune commande pour le moment.</p>
        @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Client</th>
                    <th class="p-3 text-left">Total</th>
                    <th class="p-3 text-left">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes_recentes as $cmd)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">#{{ $cmd->id }}</td>
                    <td class="p-3">{{ $cmd->utilisateur->nom ?? '—' }}</td>
                    <td class="p-3">{{ number_format($cmd->prix_total, 0, ',', ' ') }} FCFA</td>
                    <td class="p-3">
                        @php
                            $couleur = match($cmd->statut) {
                                'livree'   => 'text-green-600',
                                'annulee'  => 'text-red-500',
                                'en_cours' => 'text-orange-500',
                                default    => 'text-blue-600',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $couleur }} bg-gray-100">
                            {{ ucfirst($cmd->statut) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($chartLabels);
const ventes = @json($chartVentes);
const pertes = @json($chartPertes);

new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Ventes (FCFA)',
                data: ventes,
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,0.1)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Pertes (FCFA)',
                data: pertes,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239,68,68,0.1)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            tooltip: {
                callbacks: {
                    label: ctx => ctx.dataset.label + ' : ' + ctx.parsed.y.toLocaleString('fr-FR') + ' FCFA'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: val => val.toLocaleString('fr-FR') + ' F'
                }
            }
        }
    }
});
</script>
@endsection