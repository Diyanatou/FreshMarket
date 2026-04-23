@extends('layouts.dashboard')

@section('title', 'Gestion des Commandes')

@section('content')
<div class="space-y-6">
    
    <!-- Filtres -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <h2 class="text-lg font-bold text-gray-800">Toutes les commandes</h2>
            <span class="px-2.5 py-0.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">{{ $commandes->total() }}</span>
        </div>
        
        <form action="{{ route('commandes.index') }}" method="GET" class="flex items-center gap-3">
            <select name="statut" onchange="this.form.submit()" class="text-sm  rounded-lg focus:ring-primary focus:border-primary">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="confirmee" {{ request('statut') == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                <option value="livree" {{ request('statut') == 'livree' ? 'selected' : '' }}>Livrée</option>
                <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
            </select>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-blue-50 border border-blue-100 text-primary px-4 py-3 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-bold text-black-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-4 text-xs font-bold text-black-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-black-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-xs font-bold text-black-500 uppercase tracking-wider">Créneau</th>
                    <th class="px-6 py-4 text-xs font-bold text-black-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-xs font-bold text-black-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
            @php
                $statusClasses = [
                    'en_attente' => 'bg-yellow-100 text-yellow-700',
                    'confirmee' => 'bg-blue-100 text-blue-700',
                    'livree' => 'bg-blue-100 text-primary',
                    'annulee' => 'bg-red-100 text-red-700',
                ];
            @endphp
                @forelse($commandes as $commande)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-gray-800">{{ $commande->utilisateur->nom }}</span>
                            <span class="text-xs text-gray-500">{{ $commande->utilisateur->email }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $commande->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-black text-gray-900">
                        {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col text-xs">
                            <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($commande->creneau->date)->format('d/m/Y') }}</span>
                            <span class="text-gray-500">{{ $commande->creneau->heure_debut }} - {{ $commande->creneau->heure_fin }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('commandes.updateStatus', $commande) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="statut" onchange="this.form.submit()" 
                                    class="text-[10px] font-black uppercase rounded-full px-2 py-1 border-none focus:ring-2 focus:ring-primary cursor-pointer {{ $statusClasses[$commande->statut] }}">
                                <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmee" {{ $commande->statut == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                                <option value="livree" {{ $commande->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                                <option value="annulee" {{ $commande->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('commandes.edit', $commande) }}" class="w-8 h-8 flex items-center justify-center text-blue-500" title="Modifier">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form action="{{ route('commandes.destroy', $commande) }}" method="POST" onsubmit="return confirm('Supprimer cette commande ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-red-500">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">
                        Aucune commande trouvée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $commandes->links() }}
    </div>
</div>
@endsection
