@extends('layouts.dashboard')

@section('title', 'Catégories')

@section('content')
<div class="flex flex-col lg:flex-row gap-6 h-full">
    
    <!-- Formulaire (Gauche) -->
    <div class="w-full lg:w-1/4 bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ajouter une catégorie</h3>
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4 flex-1">
            @csrf
            
            <!-- Nom -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nom de la catégorie</label>
                <input type="text" name="nom" placeholder="Ex: Fruits, Légumes..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary " required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description (Optionnel)</label>
                <textarea name="description" rows="4" placeholder="Description de la catégorie..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-2 px-4 rounded-md transition-colors">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- Tableau (Droite) -->
    <div class="w-full lg:w-3/4 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Liste des catégories</h3>
            <span class="text-sm text-gray-500">{{ $categories->count() }} au total</span>
        </div>
        
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-800 bg-gray-50 border-b border-gray-200 uppercase font-bold">
                    <tr>
                        <th class="px-4 py-3 w-16">ID</th>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Date création</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-400">#{{ $category->id }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $category->nom }}</td>
                        <td class="px-4 py-3 text-gray-500 italic">{{ Str::limit($category->description, 50) ?: 'Aucune description' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                            {{ $category->created_at->format('d/m/Y') }}<br>
                            <span class="text-xs text-gray-400">{{ $category->created_at->format('H:i:s') }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400 italic">
                            Aucune catégorie trouvée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
