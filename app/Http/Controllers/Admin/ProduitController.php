<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\LotProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with(['categorie', 'lots'])
            ->latest()
            ->paginate(15);

        $categories = Categorie::all();

        return view('admin.produits.index', compact('produits', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'type' => 'required|in:classique,perissable',
            'seuil_alerte' => 'required|integer|min:0',
            'actif' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'quantite_initiale' => 'nullable|integer|min:0',
            'date_expiration' => 'nullable|date',
        ]);

        // 📸 IMAGE
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
        }

        // 🧱 PRODUIT
        $produit = Produit::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
            'categorie_id' => $validated['categorie_id'],
            'type' => $validated['type'],
            'seuil_alerte' => $validated['seuil_alerte'],
            'actif' => $request->boolean('actif'),
            'image' => $imagePath,
        ]);

        // 📦 LOT INITIAL (SI VALIDE)
        if (
            !empty($validated['quantite_initiale']) &&
            $validated['quantite_initiale'] > 0
        ) {
            LotProduit::create([
                'produit_id' => $produit->id,
                'quantite' => $validated['quantite_initiale'],
                'date_expiration' => $validated['date_expiration'] ?? now()->addDays(7),
            ]);
        }

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Produit $produit)
    {
        $categories = Categorie::all();
        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'type' => 'required|in:classique,perissable',
            'seuil_alerte' => 'required|integer|min:0',
            'actif' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'prix' => $validated['prix'],
            'categorie_id' => $validated['categorie_id'],
            'type' => $validated['type'],
            'seuil_alerte' => $validated['seuil_alerte'],
            'actif' => $request->boolean('actif'),
        ];

        // 📸 IMAGE UPDATE
        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }

            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit supprimé.');
    }

    public function addLot(Request $request, Produit $produit)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
            'date_expiration' => 'nullable|date',
        ]);

        LotProduit::create([
            'produit_id' => $produit->id,
            'quantite' => $request->quantite,
            'date_expiration' => $request->date_expiration ?? now()->addDays(7),
        ]);

        return redirect()
            ->route('produits.edit', $produit)
            ->with('success', 'Lot ajouté.');
    }

    public function destroyLot(LotProduit $lot)
    {
        $produitId = $lot->produit_id;
        $lot->delete();

        return redirect()
            ->route('produits.edit', $produitId)
            ->with('success', 'Lot supprimé.');
    }
}