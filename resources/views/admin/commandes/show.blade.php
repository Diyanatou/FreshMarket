@extends('layouts.dashboard')

@section('title', 'Commande #' . $commande->id)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('commandes.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-primary hover:bg-gray-50 transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-xl font-black text-gray-900 tracking-tight">Commande #{{ $commande->id }}</h2>
                <p class="text-xs text-gray-500 font-medium">Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            @php
                $statusClasses = [
                    'en_attente' => 'bg-yellow-100 text-yellow-700',
                    'confirmee' => 'bg-blue-100 text-blue-700',
                    'livree' => 'bg-blue-100 text-primary',
                    'annulee' => 'bg-red-100 text-red-700',
                ];
                $statusLabels = [
                    'en_attente' => 'En attente',
                    'confirmee' => 'Confirmée',
                    'livree' => 'Livrée',
                    'annulee' => 'Annulée',
                ];
            @endphp
            <span class="px-4 py-1.5 text-xs font-black uppercase rounded-full shadow-sm {{ $statusClasses[$commande->statut] }}">
                {{ $statusLabels[$commande->statut] }}
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Articles -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Articles commandés</h3>
                    <span class="text-xs font-bold text-gray-400">{{ $commande->lignes->count() }} items</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Produit</th>
                                <th class="px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Prix Unit.</th>
                                <th class="px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Qté</th>
                                <th class="px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($commande->lignes as $ligne)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-50 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0">
                                            @if($ligne->produit->image)
                                                <img src="{{ asset('storage/'.$ligne->produit->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-200"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-sm font-bold text-gray-800">{{ $ligne->produit->nom }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700">
                                    x{{ $ligne->quantite }}
                                </td>
                                <td class="px-6 py-4 text-sm font-black text-gray-900 text-right">
                                    {{ number_format($ligne->sous_total, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm font-bold text-gray-600 text-right">TOTAL</td>
                                <td class="px-6 py-4 text-lg font-black text-primary text-right">
                                    {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Historique / Note (Placeholder) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Note interne</h3>
                <textarea rows="3" placeholder="Ajouter une note sur cette commande..." class="w-full border-gray-200 rounded-xl focus:ring-primary focus:border-primary text-sm resize-none"></textarea>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            
            <!-- Changer Statut -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-cog text-primary"></i> Actions
                </h3>
                <form action="{{ route('commandes.updateStatus', $commande) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Statut de livraison</label>
                        <select name="statut" class="w-full border-gray-200 rounded-xl focus:ring-primary focus:border-primary text-sm font-bold">
                            <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmee" {{ $commande->statut == 'confirmee' ? 'selected' : '' }}>Confirmer la commande</option>
                            <option value="livree" {{ $commande->statut == 'livree' ? 'selected' : '' }}>Marquer comme Livrée</option>
                            <option value="annulee" {{ $commande->statut == 'annulee' ? 'selected' : '' }}>Annuler la commande</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-xl hover:bg-secondary transition-all shadow-lg shadow-blue-50 text-sm">
                        Enregistrer le statut
                    </button>
                </form>
            </div>

            <!-- Infos Client -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-primary"></i> Informations Client
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 flex-shrink-0">
                            <i class="fas fa-user-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $commande->utilisateur->nom }} {{ $commande->utilisateur->prenom }}</p>
                            <p class="text-xs text-gray-500">{{ $commande->utilisateur->email }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50 text-xs space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Commandes totales :</span>
                            <span class="font-bold text-gray-700">{{ $commande->utilisateur->commandes()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livraison -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-truck text-primary"></i> Livraison
                </h3>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Créneau prévu :</p>
                    <p class="text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($commande->creneau->date)->format('l d F Y') }}</p>
                    <p class="text-xs text-gray-600 mt-1">Entre {{ $commande->creneau->heure_debut }} et {{ $commande->creneau->heure_fin }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
