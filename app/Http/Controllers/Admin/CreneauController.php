<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreneauLivraison;
use Illuminate\Http\Request;

class CreneauController extends Controller
{
    public function index()
    {
        $creneaux = CreneauLivraison::orderBy('date', 'desc')
            ->orderBy('heure_debut', 'asc')
            ->paginate(15);

        return view('admin.creneaux.index', compact('creneaux'));
    }

    public function create()
    {
        return view('admin.creneaux.create');
    }

    public function edit(CreneauLivraison $creneau)
    {
        return view('admin.creneaux.edit', compact('creneau'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'capacite_max' => 'required|integer|min:1',
        ]);

        CreneauLivraison::create([
            'date' => $request->date,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'capacite_max' => $request->capacite_max,
            'statut' => 'ouvert',
        ]);

        return redirect()->route('admin.creneaux.index')->with('success', 'Créneau créé avec succès.');
    }

    public function update(Request $request, CreneauLivraison $creneau)
    {
        $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'capacite_max' => 'required|integer|min:1',
        ]);

        $creneau->update($request->only(['date', 'heure_debut', 'heure_fin', 'capacite_max']));

        return redirect()->route('admin.creneaux.index')->with('success', 'Créneau mis à jour.');
    }

    public function toggleStatus(CreneauLivraison $creneau)
    {
        $creneau->update([
            'statut' => $creneau->statut === 'ouvert' ? 'ferme' : 'ouvert'
        ]);

        return back()->with('success', 'Statut du créneau mis à jour.');
    }

    public function destroy(CreneauLivraison $creneau)
    {
        if ($creneau->commandes()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un créneau qui contient des commandes.');
        }

        $creneau->delete();
        return back()->with('success', 'Créneau supprimé.');
    }
}
