@extends('layouts.dashboard')

@section('title', 'Achats / Entrée Stock')

@section('content')
<div class="flex flex-col lg:flex-row gap-6 h-full">
    
    <!-- FORMULAIRE AJOUT -->
    <div class="w-full lg:w-1/4 bg-white rounded-lg shadow-sm border p-5 flex flex-col">
        <h3 class="text-lg font-semibold mb-4">➕ Ajouter un achat</h3>

        <form action="{{ route('achats.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- PRODUIT -->
            <div>
                <label class="text-sm font-semibold">Produit</label>
                <select name="produit_id" class="w-full border rounded px-3 py-2">
                    @foreach($produits as $p)
                        <option value="{{ $p->id }}">{{ $p->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- FOURNISSEUR -->
            <div>
                <label class="text-sm font-semibold">Fournisseur</label>
                <select name="fournisseur_id" class="w-full border rounded px-3 py-2">
                    @foreach($fournisseurs as $f)
                        <option value="{{ $f->id }}">{{ $f->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- QUANTITE -->
            <div>
                <label class="text-sm font-semibold">Quantité</label>
                <input type="number" name="quantite" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- PRIX ACHAT -->
            <div>
                <label class="text-sm font-semibold">Prix d'achat</label>
                <input type="number" step="0.01" name="prix_achat" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- EXPIRATION -->
            <div>
                <label class="text-sm font-semibold">Expiration</label>
                <input type="date" name="date_expiration" class="w-full border rounded px-3 py-2">
            </div>

            <button class="w-full bg-primary text-white py-2 rounded font-bold">
                Ajouter
            </button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="w-full lg:w-3/4 bg-white rounded-lg shadow-sm border flex flex-col">
        <div class="p-4 border-b flex justify-between">
            <h3 class="font-semibold">📦 Historique des achats</h3>
            <span class="text-sm text-gray-500">{{ $lots->count() }} au total</span>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase">
                    <tr>
                        <th class="p-3">Produit</th>
                        <th>Fournisseur</th>
                        <th>Qté</th>
                        <th>Prix</th>
                        <th>Expiration</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($lots as $lot)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-bold">{{ $lot->produit->nom }}</td>
                        <td>{{ $lot->fournisseur->nom ?? '-' }}</td>
                        <td>{{ $lot->quantite }}</td>
                        <td>{{ number_format($lot->prix_achat, 0, ',', ' ') }} FCFA</td>
                        <td>
                            {{ $lot->date_expiration?->format('d/m/Y') ?? '-' }}
                        </td>
                        <td class="flex gap-3 p-3">
                            <a href="{{ route('achats.edit', $lot) }}" class="text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form method="POST" action="{{ route('achats.destroy', $lot) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center p-6 text-gray-400">
                            Aucun achat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection