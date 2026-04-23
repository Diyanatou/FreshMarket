@extends('layouts.dashboard')

@section('title', 'Gestion des Créneaux')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 shadow-sm">
        <div>
            <h2 class="text-2xl font-black text-gray-900">Créneaux de Livraison</h2>
            <p class="text-sm text-gray-500">Gérez les horaires et la capacité de livraison.</p>
        </div>
        <a href="{{ route('admin.creneaux.create') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-xl">
            <i class="fas fa-plus"></i> Nouveau Créneau
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-check-circle text-lg"></i>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-lg"></i>
        <span class="font-bold">{{ session('error') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-sm  overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black text-black-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-4 text-[10px] font-black text-black-400 uppercase tracking-widest">Horaire</th>
                        <th class="px-6 py-4 text-[10px] font-black text-black-400 uppercase tracking-widest">Capacité</th>
                        <th class="px-6 py-4 text-[10px] font-black text-black-400 uppercase tracking-widest">Statut</th>
                        <th class="px-6 py-4 text-[10px] font-black text-black-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($creneaux as $creneau)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($creneau->date)->translatedFormat('l d F Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-black text-gray-900  px-3 py-1">
                                {{ \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($creneau->heure_fin)->format('H:i') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-2 bg-gray-100 rounded-full max-w-[100px] overflow-hidden">
                                    @php $percent = ($creneau->nombre_commandes / $creneau->capacite_max) * 100; @endphp
                                    <div class="h-full {{ $percent >= 100 ? 'bg-red-500' : ($percent >= 80 ? 'bg-orange-500' : 'bg-primary') }}" style="width: {{ min($percent, 100) }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">{{ $creneau->nombre_commandes }} / {{ $creneau->capacite_max }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($creneau->statut === 'ferme')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Fermé
                                </span>
                            @elseif($creneau->isFull())
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Complet
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Ouvert
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.creneaux.edit', $creneau) }}" class="p-2 text-blue-500" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.creneaux.toggle', $creneau) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 {{ $creneau->statut === 'ouvert' ? 'text-green-600' : 'text-green-500 hover:bg-green-50' }} rounded-xl transition-colors" title="{{ $creneau->statut === 'ouvert' ? 'Fermer' : 'Ouvrir' }}">
                                        <i class="fas {{ $creneau->statut === 'ouvert' ? 'fa-lock' : 'fa-lock-open' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.creneaux.destroy', $creneau) }}" method="POST" onsubmit="return confirm('Supprimer ce créneau ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                            <i class="far fa-calendar-times text-4xl mb-3 block opacity-20"></i>
                            Aucun créneau configuré.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($creneaux->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $creneaux->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
