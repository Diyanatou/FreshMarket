@extends('layouts.dashboard')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
            <a href="{{ route('categories.index') }}" class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full text-gray-500 hover:bg-gray-200 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h3 class="text-xl font-bold text-gray-800">Modifier : {{ $category->nom }}</h3>
                <p class="text-sm text-gray-500">Mettez à jour les informations de la catégorie</p>
            </div>
        </div>

        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Nom -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de la catégorie</label>
                <input type="text" name="nom" value="{{ old('nom', $category->nom) }}" class="w-full border border-gray-300 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="6" class="w-full border border-gray-300 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="flex-1 bg-primary text-white font-bold py-3 px-6 rounded-md hover:bg-secondary transition-all shadow-sm">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('categories.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-md hover:bg-gray-200 transition-all">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
