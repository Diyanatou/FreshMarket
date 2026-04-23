@extends('layouts.dashboard')

@section('title', 'Nouveau Créneau')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.creneaux.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-4">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
        <h2 class="text-3xl font-black text-gray-900">Nouveau Créneau</h2>
        <p class="text-sm text-gray-500">Configurez une nouvelle plage horaire de livraison.</p>
    </div>

    <form action="{{ route('admin.creneaux.store') }}" method="POST" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
        @csrf

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Date de livraison</label>
            <input type="date" name="date" value="{{ old('date', now()->addDay()->format('Y-m-d')) }}" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('date') border-red-500 @enderror">
            @error('date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Heure de début</label>
                <input type="time" name="heure_debut" value="{{ old('heure_debut', '08:00') }}" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('heure_debut') border-red-500 @enderror">
                @error('heure_debut') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Heure de fin</label>
                <input type="time" name="heure_fin" value="{{ old('heure_fin', '10:00') }}" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('heure_fin') border-red-500 @enderror">
                @error('heure_fin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Capacité maximale (Nombre de commandes)</label>
            <input type="number" name="capacite_max" value="{{ old('capacite_max', 10) }}" min="1" required class="w-full border-gray-100 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold @error('capacite_max') border-red-500 @enderror">
            @error('capacite_max') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            <p class="text-[10px] text-gray-400 italic">Nombre maximum de commandes que vous pouvez livrer sur cette période.</p>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-xl hover:bg-secondary transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-2">
                <i class="fas fa-check-circle"></i> Créer le créneau
            </button>
        </div>
    </form>
</div>
@endsection
