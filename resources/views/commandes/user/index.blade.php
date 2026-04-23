@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">

    <div class="max-w-5xl mx-auto px-4">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Mes commandes</h1>
            <p class="text-sm text-gray-500">Historique de vos achats</p>
        </div>

        <div class="space-y-4">

            @forelse($commandes as $commande)

            <div class="bg-white border border-gray-200 rounded-lg p-5">

                <!-- Top -->
                <div class="flex justify-between items-center mb-4">

                    <div>
                        <p class="text-xs text-gray-400">Commande</p>
                        <p class="font-semibold text-gray-900">
                            #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                    <span class="text-xs px-3 py-1 rounded-full
                        {{ $commande->statut == 'livree' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $commande->statut == 'en_attente' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $commande->statut == 'confirmee' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $commande->statut == 'annulee' ? 'bg-red-100 text-red-700' : '' }}
                    ">
                        {{ ucfirst($commande->statut) }}
                    </span>

                </div>

                <!-- Content -->
                <div class="grid md:grid-cols-3 gap-4 text-sm text-gray-600">

                    <!-- Produits -->
                    <div class="md:col-span-2">
                        <p class="font-medium text-gray-800 mb-2">Produits</p>

                        @foreach($commande->lignes as $ligne)
                            <p>• {{ $ligne->produit->nom ?? 'Produit supprimé' }} x{{ $ligne->quantite }}</p>
                        @endforeach
                    </div>

                    <!-- Infos -->
                    <div>
                        @if($commande->creneau)
                        <p class="font-medium text-gray-800 mb-2">Livraison</p>
                        <p>{{ $commande->creneau->date }}</p>
                        <p class="text-gray-500">
                            {{ $commande->creneau->heure_debut }} - {{ $commande->creneau->heure_fin }}
                        </p>
                        @endif

                        <div class="mt-3">
                            <p class="font-medium text-gray-800">Total</p>
                            <p class="text-primary font-bold">
                                {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            @empty

            <div class="text-center py-20 text-gray-500">
                <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                <p>Aucune commande pour le moment</p>
            </div>

            @endforelse

        </div>

    </div>

</div>
@endsection