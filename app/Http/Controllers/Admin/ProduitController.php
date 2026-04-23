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
    /**
     * Afficher la liste + formulaire d'ajout
     */
    public function index()
    {
        $produits = Produit::with(['categorie', 'lots'])->latest()->paginate(15);
        $categories = Categorie::all();
        return view('admin.produits.index', compact('produits', 'categories'));
    }

    /**
     * Enregistrer un nouveau produit (+ lot initial si perissable)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'description'  => 'nullable|string',
            'prix'         => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'type'         => 'required|in:classique,perissable',
            'seuil_alerte' => 'required|integer|min:0',
            'actif'        => 'nullable',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // Champs lot initial
            'quantite_initiale'  => 'nullable|integer|min:0',
            'date_expiration'    => 'nullable|date|after_or_equal:today',
        ]);

        // dd($validated);

        // Gestion image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
        }

        try {
            $produit = Produit::create([
                'nom'          => $validated['nom'],
                'description'  => $validated['description'] ?? null,
                'prix'         => $validated['prix'],
                'categorie_id' => $validated['categorie_id'],
                'type'         => $validated['type'],
                'seuil_alerte' => $validated['seuil_alerte'],
                'actif'        => $request->has('actif') ? 1 : 0,
                'image'        => $imagePath,
            ]);

            // Créer un lot initial si une quantité est fournie
            if (!empty($validated['quantite_initiale']) && $validated['quantite_initiale'] > 0) {
                LotProduit::create([
                    'produit_id'      => $produit->id,
                    'quantite'        => $validated['quantite_initiale'],
                    'date_expiration' => $validated['date_expiration'] ?? null,
                ]);
            }

            return redirect()->route('produits.index')->with('success', 'Produit "' . $produit->nom . '" créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['db_error' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()]);
        }
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Produit $produit)
    {
        $categories = Categorie::all();
        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    /**
     * Mettre à jour le produit
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'description'  => 'nullable|string',
            'prix'         => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'type'         => 'required|in:classique,perissable',
            'seuil_alerte' => 'required|integer|min:0',
            'actif'        => 'nullable',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nom'          => $validated['nom'],
            'description'  => $validated['description'] ?? null,
            'prix'         => $validated['prix'],
            'categorie_id' => $validated['categorie_id'],
            'type'         => $validated['type'],
            'seuil_alerte' => $validated['seuil_alerte'],
            'actif'        => $request->has('actif') ? 1 : 0,
        ];

        // Remplacer l'image si une nouvelle est uploadée
        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update($data);

        return redirect()->route('produits.index')->with('success', 'Produit "' . $produit->nom . '" mis à jour.');
    }

    /**
     * Supprimer le produit (et son image)
     */
    public function destroy(Produit $produit)
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }
        $nom = $produit->nom;
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit "' . $nom . '" supprimé.');
    }

    /**
     * Ajouter un lot à un produit existant
     */
    public function addLot(Request $request, Produit $produit)
    {
        $request->validate([
            'quantite'        => 'required|integer|min:1',
            'date_expiration' => 'nullable|date|after_or_equal:today',
        ]);

        LotProduit::create([
            'produit_id'      => $produit->id,
            'quantite'        => $request->quantite,
            'date_expiration' => $request->date_expiration,
        ]);

        return redirect()->route('produits.edit', $produit)->with('success', 'Lot ajouté avec succès.');
    }

    /**
     * Supprimer un lot
     */
    public function destroyLot(LotProduit $lot)
    {
        $produitId = $lot->produit_id;
        $lot->delete();
        return redirect()->route('produits.edit', $produitId)->with('success', 'Lot supprimé.');
    }
}
