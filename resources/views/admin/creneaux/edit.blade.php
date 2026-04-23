@extends('layouts.dashboard')

@section('title', 'Modifier Créneau')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.creneaux.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-4">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
        <h2 class="text-3xl font-black text-gray-900">Modifier le Créneau</h2>
        <p class="text-sm text-gray-500">Mettez à jour les informations de ce créneau de livraison.</p>
    </div>

    <form action="{{ route('admin.creneaux.update', $creneau) }}" method="POST" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Date de livraison</label>
            <input type="date" name="date" value="{{ old('date', $creneau->date) }}" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('date') border-red-500 @enderror">
            @error('date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Heure de début</label>
                <input type="time" name="heure_debut" value="{{ old('heure_debut', \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i')) }}" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('heure_debut') border-red-500 @enderror">
                @error('heure_debut') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Heure de fin</label>
                <input type="time" name="heure_fin" value="{{ old('heure_fin', \Carbon\Carbon::parse($creneau->heure_fin)->format('H:i')) }}" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('heure_fin') border-red-500 @enderror">
                @error('heure_fin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Capacité maximale (Nombre de commandes)</label>
            <input type="number" name="capacite_max" value="{{ old('capacite_max', $creneau->capacite_max) }}" min="1" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('capacite_max') border-red-500 @enderror">
            @error('capacite_max') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            <p class="text-[10px] text-gray-400 italic font-medium mt-1">Actuellement : {{ $creneau->nombre_commandes }} commande(s) enregistrée(s).</p>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-xl hover:bg-secondary transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
