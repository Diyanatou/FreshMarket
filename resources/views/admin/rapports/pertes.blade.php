@extends('layouts.dashboard')

@section('content')
<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold">📉 Rapport des pertes ERP</h1>

    {{-- ALERTES --}}
    @if($alerts->count())
        <div class="bg-orange-100 text-orange-700 p-3 rounded">
            ⚠️ {{ $alerts->count() }} lots bientôt expirés
        </div>
    @endif

    {{-- TOTAL --}}
    <div class="bg-red-100 p-4 rounded">
        💸 Total pertes :
        <b>{{ number_format($totalPerte,0,',',' ') }} FCFA</b>
    </div>

    {{-- FILTRES --}}
    <div class="flex gap-2">
        <a href="?filtre=semaine" class="px-3 py-1 bg-gray-200 rounded">Semaine</a>
        <a href="?filtre=mois" class="px-3 py-1 bg-gray-200 rounded">Mois</a>
        <a href="?filtre=annee" class="px-3 py-1 bg-gray-200 rounded">Année</a>
    </div>

    {{-- TABLE --}}
    <table class="w-full bg-white shadow rounded">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Produit</th>
                <th>Quantité</th>
                <th>Perte</th>
                <th>Expiration</th>
            </tr>
        </thead>

        <tbody>
        @foreach($lots as $lot)
            <tr class="border-t">

                <td class="p-2">
                    {{ $lot->produit->nom }}
                </td>

                <td>
                    {{ $lot->quantite }}
                </td>

                <td class="text-red-600 font-bold">
                    {{ $lot->quantite * $lot->produit->prix }}
                </td>

                <td>
                    {{ $lot->date_expiration }}
                </td>

            </tr>
        @endforeach
        </tbody>

    </table>

    {{-- CHART --}}
    <canvas id="chart"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Pertes',
            data: @json($chartData),
            backgroundColor: 'red'
        }]
    }
});
</script>

@endsection