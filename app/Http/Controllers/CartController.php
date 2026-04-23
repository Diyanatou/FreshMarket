<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Panier;
use App\Models\LignePanier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Afficher le panier
     */
    public function index()
    {
        $panier = $this->getOrCreatePanier();
        $panier->load('lignes.produit');
        
        return view('cart.index', compact('panier'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request, Produit $produit)
    {
        if (!$produit->isAvailable()) {
            return redirect()->back()->with('error', 'Désolé, ce produit n\'est plus disponible ou est arrivé à expiration.');
        }

        $quantite = $request->input('quantite', 1);
        $stockDispo = $produit->stockDisponible();

        if ($stockDispo < $quantite) {
            return redirect()->back()->with('error', "Désolé, seulement $stockDispo unités sont actuellement disponibles (hors produits périmés).");
        }

        $panier = $this->getOrCreatePanier();
        
        $ligne = $panier->lignes()->where('produit_id', $produit->id)->first();

        if ($ligne) {
            $nouvelleQuantite = $ligne->quantite + $quantite;
            if ($stockDispo < $nouvelleQuantite) {
                return redirect()->back()->with('error', "Vous avez déjà ce produit au panier. Le stock total disponible est de $stockDispo.");
            }
            $ligne->increment('quantite', $quantite);
        } else {
            $panier->lignes()->create([
                'produit_id' => $produit->id,
                'quantite' => $quantite,
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Mettre à jour la quantité d'une ligne
     */
    public function update(Request $request, LignePanier $ligne)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $ligne->update([
            'quantite' => $request->quantite,
        ]);

        return redirect()->route('cart.index')->with('success', 'Panier mis à jour.');
    }

    /**
     * Supprimer un article du panier
     */
    public function remove(LignePanier $ligne)
    {
        $ligne->delete();
        return redirect()->route('cart.index')->with('success', 'Article retiré du panier.');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        $panier = $this->getOrCreatePanier();
        $panier->lignes()->delete();
        
        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
    }

    /**
     * Récupérer ou créer le panier pour l'utilisateur connecté
     */
    private function getOrCreatePanier()
    {
        // Pour l'instant, on impose l'auth pour simplifier
        // (On pourrait gérer via session pour les invités plus tard)
        if (!Auth::check()) {
            // On pourrait lever une exception ou rediriger, 
            // mais normalement le middleware gère ça.
            abort(401);
        }

        return Auth::user()->panier ?: Panier::create(['utilisateur_id' => Auth::id()]);
    }
}
