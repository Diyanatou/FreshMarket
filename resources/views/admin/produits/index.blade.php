@extends('layouts.dashboard')

@section('title', 'Produits')

@section('content')
<div class="flex flex-col lg:flex-row gap-6">

    <!-- Formulaire (Gauche) -->
    <div class="w-full lg:w-80 flex-shrink-0">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-plus-circle text-primary"></i>
                Ajouter un produit
            </h3>

            @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-100 text-primary rounded-lg text-sm flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <p class="font-bold mb-1">Oups ! Quelques erreurs :</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <!-- Nom -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Nom du produit *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Ex: Tomates cerises..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary @error('nom') border-red-400 @enderror" required>
                    @error('nom')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Catégorie *</label>
                    <select name="categorie_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary @error('categorie_id') border-red-400 @enderror" required>
                        <option value="">-- Choisir --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                    @error('categorie_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Prix + Seuil -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Prix (FCFA) *</label>
                        <input type="number" name="prix" value="{{ old('prix') }}" step="0.01" min="0" placeholder="0.00" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary @error('prix') border-red-400 @enderror" required>
                        @error('prix')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Seuil alerte</label>
                        <input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', 5) }}" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                    </div>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Type *</label>
                    <select name="type" id="type-select" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary @error('type') border-red-400 @enderror" required onchange="togglePerissable(this.value)">
                        <option value="classique" {{ old('type') == 'classique' ? 'selected' : '' }}>Classique</option>
                        <option value="perissable" {{ old('type') == 'perissable' ? 'selected' : '' }}>Périssable</option>
                    </select>
                    @error('type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Stock initial + Date exp (visible si perissable) -->
                <div class="border border-dashed border-gray-200 rounded-lg p-3 space-y-3">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Lot initial (optionnel)</p>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Quantité initiale</label>
                        <input type="number" name="quantite_initiale" value="{{ old('quantite_initiale') }}" min="0" placeholder="0" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary @error('quantite_initiale') border-red-400 @enderror">
                        @error('quantite_initiale')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div id="date-exp-field" class="{{ old('type') == 'perissable' ? '' : 'hidden' }}">
                        <label class="block text-xs text-gray-600 mb-1">Date d'expiration</label>
                        <input type="date" name="date_expiration" value="{{ old('date_expiration') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary text-gray-600 @error('date_expiration') border-red-400 @enderror">
                        @error('date_expiration')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Description</label>
                    <textarea name="description" rows="2" placeholder="Description courte..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                    @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Photo</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer @error('image') text-red-500 @enderror">
                    @error('image')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Actif -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="actif" id="actif" value="1" checked class="w-4 h-4 accent-primary">
                    <label for="actif" class="text-sm text-gray-600 cursor-pointer">Produit actif (visible en boutique)</label>
                </div>

                <button type="submit" class="w-full bg-primary text-white font-bold py-2.5 rounded-md hover:bg-secondary transition-all text-sm mt-2">
                    <i class="fas fa-plus mr-1"></i> Ajouter le produit
                </button>
            </form>
        </div>
    </div>

    <!-- Tableau (Droite) -->
    <div class="flex-1 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
            <div>
                <h3 class="text-base font-semibold text-gray-800">Liste des produits</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $produits->total() }} produit(s) au total</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Indicateur stock faible -->
                @php $lowStock = $produits->filter(fn($p) => $p->stockTotal() <= $p->seuil_alerte && $p->stockTotal() > 0)->count(); @endphp
                @if($lowStock > 0)
                <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full font-medium">
                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $lowStock }} stock(s) faible(s)
                </span>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto overflow-y-auto flex-1">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 bg-gray-50 border-b border-gray-200 uppercase font-bold sticky top-0">
                    <tr>
                        <th class="px-4 py-3 w-14">Photo</th>
                        <th class="px-4 py-3">Produit</th>
                        <th class="px-4 py-3">Catégorie</th>
                        <th class="px-4 py-3">Prix</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($produits as $produit)
                    @php $stock = $produit->stockTotal(); $isLow = $stock <= $produit->seuil_alerte; @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            @if($produit->image)
                                <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}" class="w-10 h-10 object-cover rounded-lg border border-gray-200">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                    <i class="fas fa-image text-gray-300 text-xs"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-900 text-sm">{{ $produit->nom }}</p>
                            @if($produit->description)
                            <p class="text-xs text-gray-400 truncate max-w-[160px]">{{ $produit->description }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded-full">{{ $produit->categorie->nom }}</span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-3">
                            <span class="font-bold {{ $stock == 0 ? 'text-red-600' : ($isLow ? 'text-orange-500' : 'text-primary') }}">
                                {{ $stock }}
                            </span>
                            @if($stock == 0)
                                <span class="ml-1 text-xs text-red-500">(Rupture)</span>
                            @elseif($isLow)
                                <span class="ml-1 text-xs text-orange-400">(Faible)</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium
                                {{ $produit->type === 'perissable' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $produit->type === 'perissable' ? 'Périssable' : 'Classique' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('produits.edit', $produit) }}" class="w-8 h-8 flex items-center justify-center text-blue-600" title="Modifier">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('produits.destroy', $produit) }}" method="POST" onsubmit="return confirm('Supprimer le produit « {{ $produit->nom }} » ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-red-500" title="Supprimer">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-gray-400">
                            <i class="fas fa-box-open text-4xl mb-3 block opacity-30"></i>
                            Aucun produit enregistré. Commencez par en ajouter un !
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($produits->hasPages())
        <div class="px-4 py-3 border-t border-gray-100 flex-shrink-0">
            {{ $produits->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function togglePerissable(val) {
    const field = document.getElementById('date-exp-field');
    if (val === 'perissable') { field.classList.remove('hidden'); }
    else { field.classList.add('hidden'); }
}
</script>
@endsection
