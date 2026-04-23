@extends('layouts.dashboard')

@section('title', 'Nouvel Utilisateur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-4">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
        <h2 class="text-3xl font-black text-gray-900">Ajouter un Membre</h2>
        <p class="text-sm text-gray-500">Créez un nouvel accès pour votre équipe.</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('prenom') border-red-500 @enderror">
                @error('prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('nom') border-red-500 @enderror">
                @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email professionnel</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('email') border-red-500 @enderror">
            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Rôle / Accès</label>
            <select name="role_id" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3">
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->nom) }}</option>
                @endforeach
            </select>
            @error('role_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Mot de passe</label>
                <input type="password" name="password" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('password') border-red-500 @enderror">
                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Confirmer</label>
                <input type="password" name="password_confirmation" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3">
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-xl hover:bg-secondary transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-2">
                <i class="fas fa-user-plus"></i> Créer l'utilisateur
            </button>
        </div>
    </form>
</div>
@endsection
