@extends('layouts.dashboard')

@section('title', 'Modifier Utilisateur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-4">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
        <h2 class="text-3xl font-black text-gray-900">Modifier : {{ $user->prenom }}</h2>
        <p class="text-sm text-gray-500">Mettez à jour les informations ou réinitialisez le mot de passe.</p>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('prenom') border-red-500 @enderror">
                @error('prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('nom') border-red-500 @enderror">
                @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email professionnel</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('email') border-red-500 @enderror">
            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Rôle / Accès</label>
            <select name="role_id" required class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3">
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ ucfirst($role->nom) }}</option>
                @endforeach
            </select>
            @error('role_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-6 border-t border-gray-50">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Changer le mot de passe (Laisser vide pour ne pas modifier)</p>
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Nouveau mot de passe</label>
                    <input type="password" name="password" class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3 @error('password') border-red-500 @enderror">
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Confirmer</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-200 focus:ring-primary focus:border-primary rounded-xl text-sm font-bold px-4 py-3">
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-primary text-white font-black rounded-xl hover:bg-secondary transition-all shadow-xl shadow-blue-100 flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection
