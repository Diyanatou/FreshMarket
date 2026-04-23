@extends('layouts.dashboard')

@section('title', 'Modifier Commande #' . $commande->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('commandes.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-2">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <h2 class="text-3xl font-black text-gray-900">Modifier Commande #{{ $commande->id }}</h2>
            <p class="text-sm text-gray-500 font-medium">Client : {{ $commande->utilisateur->prenom }} {{ $commande->utilisateur->nom }}</p>
        </div>
        <div class="text-right">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Total Commande</span>
            <span class="text-2xl font-black text-primary">{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <form action="{{ route('commandes.update', $commande) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @method('PUT')

        <!-- Left: Form Fields -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Livraison Section -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fas fa-truck text-primary"></i> Détails de Livraison
                </h3>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Ville</label>
                        <input type="text" name="ville" value="{{ old('ville', $commande->ville) }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-2.5">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Quartier</label>
                        <input type="text" name="quartier" value="{{ old('quartier', $commande->quartier) }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-2.5">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Adresse précise</label>
                    <input type="text" name="adresse" value="{{ old('adresse', $commande->adresse) }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-2.5">
                </div>

                <div class="space-y-1 pt-4">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Choisir un nouveau créneau</label>
                    <select name="creneau_id" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-2.5">
                        @foreach($creneaux as $c)
                        <option value="{{ $c->id }}" {{ $commande->creneau_id == $c->id ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($c->date)->translatedFormat('l d M') }} : {{ \Carbon\Carbon::parse($c->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($c->heure_fin)->format('H:i') }}
                        </option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-gray-400 italic mt-1 px-1">Seuls les créneaux ouverts sont listés ici.</p>
                </div>
            </div>

            <!-- Articles (Read-only for now) -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Articles de la commande</h3>
                <div class="space-y-4">
                    @foreach($commande->lignes as $ligne)
                    <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                        <div class="w-12 h-12 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 flex-shrink-0">
                            @if($ligne->produit->image)
                                <img src="{{ asset('storage/'.$ligne->produit->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900">{{ $ligne->produit->nom }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Qté: {{ $ligne->quantite }} × {{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <span class="text-sm font-black text-gray-900">{{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Status & Action -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fas fa-flag text-primary"></i> État de la commande
                </h3>
                
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Statut actuel</label>
                        <select name="statut" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-2.5">
                            <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmee" {{ $commande->statut == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                            <option value="livree" {{ $commande->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                            <option value="annulee" {{ $commande->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-xl hover:bg-secondary transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>

            <div class="bg-blue-50/50 rounded-3xl p-6 border border-blue-100/50">
                <p class="text-[11px] text-gray-600 leading-relaxed font-medium">
                    <i class="fas fa-info-circle text-primary mr-1"></i>
                    La modification du créneau ou du statut "Annulé" mettra automatiquement à jour la capacité des créneaux de livraison.
                </p>
            </div>
        </div>
    </form>
</div>
@endsection
