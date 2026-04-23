<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Liste des commandes
     */
    public function index(Request $request)
    {
        $query = Commande::with(['utilisateur', 'creneau'])->latest();

        // Filtre par statut
        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }

        $commandes = $query->paginate(15);
        
        return view('admin.commandes.index', compact('commandes'));
    }

    /**
     * Détails d'une commande
     */
    public function show(Commande $commande)
    {
        $commande->load(['utilisateur', 'creneau', 'lignes.produit']);
        return view('admin.commandes.show', compact('commande'));
    }

    /**
     * Mettre à jour le statut
     */
    public function updateStatus(Request $request, Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,annulee,livree',
        ]);

        $oldStatus = $commande->statut;
        $newStatus = $request->statut;

        $commande->update(['statut' => $newStatus]);

        // Si la commande passe de "non-annulée" à "annulée", on libère une place dans le créneau
        if ($oldStatus !== 'annulee' && $newStatus === 'annulee') {
            if ($commande->creneau) {
                $commande->creneau->decrement('nombre_commandes');
            }
        }
        // Si la commande passe de "annulée" à un autre statut, on occupe à nouveau une place
        elseif ($oldStatus === 'annulee' && $newStatus !== 'annulee') {
            if ($commande->creneau) {
                $commande->creneau->increment('nombre_commandes');
            }
        }

        return redirect()->back()->with('success', 'Statut de la commande mis à jour.');
    }

    /**
     * Formulaire de modification
     */
    public function edit(Commande $commande)
    {
        $commande->load(['utilisateur', 'creneau']);
        $creneaux = \App\Models\CreneauLivraison::where('statut', 'ouvert')->get();
        return view('admin.commandes.edit', compact('commande', 'creneaux'));
    }

    /**
     * Mettre à jour la commande
     */
    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'ville' => 'required|string',
            'quartier' => 'required|string',
            'adresse' => 'required|string',
            'statut' => 'required|in:en_attente,confirmee,livree,annulee',
            'creneau_id' => 'required|exists:creneau_livraisons,id'
        ]);

        $oldStatus = $commande->statut;
        $oldCreneauId = $commande->creneau_id;
        $newStatus = $request->statut;
        $newCreneauId = $request->creneau_id;

        // Gestion de la capacité si le créneau change
        if ($oldCreneauId != $newCreneauId) {
            // Libérer l'ancien (si non annulé)
            if ($oldStatus !== 'annulee' && $commande->creneau) {
                $commande->creneau->decrement('nombre_commandes');
            }
            // Occuper le nouveau (si non annulé)
            if ($newStatus !== 'annulee') {
                $newCreneau = \App\Models\CreneauLivraison::find($newCreneauId);
                $newCreneau->increment('nombre_commandes');
            }
        } else {
            // Même créneau, mais changement de statut vers/depuis annulé
            if ($oldStatus !== 'annulee' && $newStatus === 'annulee') {
                $commande->creneau->decrement('nombre_commandes');
            } elseif ($oldStatus === 'annulee' && $newStatus !== 'annulee') {
                $commande->creneau->increment('nombre_commandes');
            }
        }

        $commande->update($request->all());

        return redirect()->route('commandes.index')->with('success', 'Commande #' . $commande->id . ' mise à jour avec succès.');
    }

    /**
     * Supprimer une commande
     */
    public function destroy(Commande $commande)
    {
        // On libère la place dans le créneau si la commande n'était pas déjà annulée
        if ($commande->statut !== 'annulee' && $commande->creneau) {
            $commande->creneau->decrement('nombre_commandes');
        }

        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande supprimée.');
    }
}
