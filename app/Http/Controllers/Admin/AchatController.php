<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Fournisseur;
use App\Models\LotProduit;

class AchatController extends Controller
{
    // 📄 PAGE UNIQUE (LISTE + FORMULAIRE)
    public function index()
    {
        $lots = LotProduit::with(['produit', 'fournisseur'])
            ->latest()
            ->get();

        return view('admin.achats.index', [
            'lots' => $lots,
            'produits' => Produit::all(),
            'fournisseurs' => Fournisseur::all(),
        ]);
    }

    // 💾 AJOUT STOCK
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'quantite' => 'required|integer|min:1',
            'prix_achat' => 'required|numeric|min:0',
            'date_expiration' => 'nullable|date'
        ]);

        LotProduit::create($request->all());

        return back()->with('success', 'Stock ajouté');
    }

    // ✏️ EDIT
    public function edit(LotProduit $lot)
    {
        return view('admin.achats.edit', [
            'lot' => $lot,
            'produits' => Produit::all(),
            'fournisseurs' => Fournisseur::all(),
        ]);
    }

    // 🔄 UPDATE
    public function update(Request $request, LotProduit $lot)
    {
        $lot->update($request->all());

        return redirect()->route('achats.index')
            ->with('success', 'Modifié');
    }

    // 🗑 DELETE
    public function destroy(LotProduit $lot)
    {
        $lot->delete();

        return back()->with('success', 'Supprimé');
    }
}