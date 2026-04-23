@extends('layouts.dashboard')

@section('title', 'Modifier : ' . $produit->nom)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('produits.index') }}" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 shadow-sm transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Modifier le produit</h2>
            <p class="text-xs text-gray-400">Vous modifiez : <span class="font-semibold text-gray-600">{{ $produit->nom }}</span></p>
        </div>
        @if($produit->actif)
            <span class="ml-auto px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium"><span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block mr-1"></span>Actif</span>
        @else
            <span class="ml-auto px-3 py-1 bg-gray-100 text-gray-500 text-xs rounded-full font-medium"><span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block mr-1"></span>Inactif</span>
        @endif
    </div>

    @if(session('success'))
    <div class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Formulaire principal -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-4 pb-3 border-b border-gray-100 uppercase tracking-wide flex items-center gap-2">
                <i class="fas fa-edit text-primary"></i> Informations du produit
            </h3>

            <form action="{{ route('produits.update', $produit) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nom + Catégorie -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Nom du produit *</label>
                        <input type="text" name="nom" value="{{ old('nom', $produit->nom) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary @error('nom') border-red-400 @enderror" required>
                        @error('nom')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Catégorie *</label>
                        <select name="categorie_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $produit->categorie_id == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Prix + Seuil + Type -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Prix (FCFA) *</label>
                        <input type="number" name="prix" value="{{ old('prix', $produit->prix) }}" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Seuil alerte</label>
                        <input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', $produit->seuil_alerte) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Type *</label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" required>
                            <option value="classique" {{ $produit->type == 'classique' ? 'selected' : '' }}>Classique</option>
                            <option value="perissable" {{ $produit->type == 'perissable' ? 'selected' : '' }}>Périssable</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary resize-none">{{ old('description', $produit->description) }}</textarea>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Photo du produit</label>
                    <div class="flex items-center gap-4">
                        @if($produit->image)
                            <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200 shadow-sm">
                        @else
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-dashed border-gray-300">
                                <i class="fas fa-image text-gray-300 text-lg"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                            <p class="text-xs text-gray-400 mt-1">Laissez vide pour garder l'image actuelle. Max 2 Mo.</p>
                        </div>
                    </div>
                </div>

                <!-- Actif -->
                <div class="flex items-center gap-3 pt-1">
                    <input type="checkbox" name="actif" id="actif" value="1" {{ $produit->actif ? 'checked' : '' }} class="w-4 h-4 accent-primary">
                    <label for="actif" class="text-sm text-gray-600 cursor-pointer">Produit actif (visible en boutique)</label>
                </div>

                <!-- Boutons -->
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <button type="submit" class="flex-1 bg-primary text-white font-bold py-2.5 rounded-lg hover:bg-secondary transition-all text-sm shadow-sm">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                    <a href="{{ route('produits.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all text-sm">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Colonne droite : Lots -->
        <div class="space-y-4">
            <!-- Stock total -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Stock total</h4>
                @php $totalStock = $produit->stockTotal(); @endphp
                <p class="text-4xl font-black {{ $totalStock == 0 ? 'text-red-500' : ($totalStock <= $produit->seuil_alerte ? 'text-orange-500' : 'text-primary') }}">
                    {{ $totalStock }}
                </p>
                <p class="text-xs text-gray-400 mt-1">unités en stock · Seuil : {{ $produit->seuil_alerte }}</p>
                @if($totalStock == 0)
                    <p class="text-xs text-red-500 mt-2 font-medium"><i class="fas fa-exclamation-triangle mr-1"></i>Rupture de stock</p>
                @elseif($totalStock <= $produit->seuil_alerte)
                    <p class="text-xs text-orange-500 mt-2 font-medium"><i class="fas fa-exclamation-triangle mr-1"></i>Stock faible</p>
                @endif
            </div>

            <!-- Ajouter un lot -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-primary"></i> Ajouter un lot
                </h4>
                <form action="{{ route('produits.lots.store', $produit) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Quantité *</label>
                        <input type="number" name="quantite" min="1" placeholder="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" required>
                    </div>
                    @if($produit->type === 'perissable')
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Date d'expiration</label>
                        <input type="date" name="date_expiration" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary text-gray-600">
                    </div>
                    @endif
                    <button type="submit" class="w-full bg-slate-800 text-white text-sm font-semibold py-2 rounded-lg hover:bg-slate-700 transition-all">
                        Ajouter ce lot
                    </button>
                </form>
            </div>

            <!-- Liste des lots -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Lots existants ({{ $produit->lots->count() }})</h4>
                @forelse($produit->lots as $lot)
                <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $lot->quantite }} unités</p>
                        @if($lot->date_expiration)
                            <p class="text-xs {{ $lot->isExpired() ? 'text-red-500 font-semibold' : ($lot->isExpiringSoon() ? 'text-orange-500' : 'text-gray-400') }}">
                                @if($lot->isExpired())
                                    <i class="fas fa-times-circle mr-1"></i>Expiré le
                                @elseif($lot->isExpiringSoon())
                                    <i class="fas fa-clock mr-1"></i>Expire le
                                @else
                                    <i class="fas fa-calendar mr-1"></i>
                                @endif
                                {{ $lot->date_expiration->format('d/m/Y') }}
                            </p>
                        @else
                            <p class="text-xs text-gray-400">Pas de date d'exp.</p>
                        @endif
                    </div>
                    <form action="{{ route('produits.lots.destroy', $lot) }}" method="POST" onsubmit="return confirm('Supprimer ce lot ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
                @empty
                <p class="text-xs text-gray-400 italic text-center py-3">Aucun lot enregistré.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
