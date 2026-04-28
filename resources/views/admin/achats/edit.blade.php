@extends('layouts.dashboard')

@section('title', 'Modifier Achat')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-bold mb-4">✏️ Modifier Achat</h2>

    <form method="POST" action="{{ route('achats.update', $lot) }}">
        @csrf
        @method('PUT')

        <div class="space-y-4">

            <div>
                <label>Produit</label>
                <select name="produit_id" class="w-full border p-2 rounded">
                    @foreach($produits as $p)
                        <option value="{{ $p->id }}" {{ $p->id == $lot->produit_id ? 'selected' : '' }}>
                            {{ $p->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Fournisseur</label>
                <select name="fournisseur_id" class="w-full border p-2 rounded">
                    @foreach($fournisseurs as $f)
                        <option value="{{ $f->id }}" {{ $f->id == $lot->fournisseur_id ? 'selected' : '' }}>
                            {{ $f->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Quantité</label>
                <input type="number" name="quantite" value="{{ $lot->quantite }}" class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Prix achat</label>
                <input type="number" step="0.01" name="prix_achat" value="{{ $lot->prix_achat }}" class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Date expiration</label>
                <input type="date" name="date_expiration"
                       value="{{ optional($lot->date_expiration)->format('Y-m-d') }}"
                       class="w-full border p-2 rounded">
            </div>

            <button class="bg-primary text-white px-4 py-2 rounded">
                Mettre à jour
            </button>

        </div>
    </form>
</div>

@endsection