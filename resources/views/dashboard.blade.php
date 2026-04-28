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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Commandes</p>
            <p class="text-2xl font-black">{{ $stats['total_commandes'] }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Ventes</p>
            <p class="text-xl font-black text-green-600">
                {{ number_format($chart['ventes'], 0, ',', ' ') }} FCFA
            </p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-xs text-gray-400">Pertes</p>
            <p class="text-xl font-black text-red-500">
                {{ number_format($chart['pertes'], 0, ',', ' ') }} FCFA
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
        <select name="periode" onchange="this.form.submit()"
            class="border px-3 py-2 rounded-lg">
            <option value="jour">Jour</option>
            <option value="semaine">Semaine</option>
            <option value="mois">Mois</option>
            <option value="annee">Année</option>
        </select>
    </form>

    <!-- GRAPH VENTES VS PERTES -->
    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="font-bold mb-4">📊 Ventes vs Pertes</h3>

        <canvas id="salesChart"></canvas>
    </div>

    <!-- COMMANDES -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 border-b font-bold">
            Dernières commandes
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>

            <tbody>
                @foreach($commandes_recentes as $cmd)
                <tr class="border-t">
                    <td class="p-3">#{{ $cmd->id }}</td>
                    <td>{{ $cmd->utilisateur->nom }}</td>
                    <td>{{ number_format($cmd->prix_total, 0, ',', ' ') }} FCFA</td>
                    <td class="text-blue-600">{{ $cmd->statut }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($chartLabels);
const ventes = @json($chartVentes);
const pertes = @json($chartPertes);

// 📊 VENTES VS PERTES
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Ventes',
                data: ventes,
                borderColor: '#22c55e',
                fill: true
            },
            {
                label: 'Pertes',
                data: pertes,
                borderColor: '#ef4444',
                fill: true
            }
        ]
    }
});

</script>
@endsection