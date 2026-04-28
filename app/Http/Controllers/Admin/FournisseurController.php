<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    // 📄 LISTE + FORMULAIRE
    public function index()
    {
        $fournisseurs = Fournisseur::latest()->get();

        return view('admin.fournisseurs.index', compact('fournisseurs'));
    }

    // 💾 AJOUT
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string',
        ]);

        Fournisseur::create($request->all());

        return back()->with('success', 'Fournisseur ajouté avec succès');
    }

    // ✏️ FORM EDIT
    public function edit(Fournisseur $fournisseur)
    {
        return view('admin.fournisseurs.edit', compact('fournisseur'));
    }

    // 🔄 UPDATE
    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string',
        ]);

        $fournisseur->update($request->all());

        return redirect()
            ->route('fournisseurs.index')
            ->with('success', 'Fournisseur modifié avec succès');
    }

    // 🗑 DELETE
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return back()->with('success', 'Fournisseur supprimé');
    }
}