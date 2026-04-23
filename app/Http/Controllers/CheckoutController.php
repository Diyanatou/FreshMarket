<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CreneauLivraison;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Afficher la page de checkout
     */
    public function index()
    {
        $panier = Auth::user()->panier;

        if (!$panier || $panier->lignes->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Récupérer les créneaux ouverts pour les 7 prochains jours
        $creneaux = CreneauLivraison::where('statut', 'ouvert')
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('date');

        return view('checkout.index', compact('panier', 'creneaux'));
    }

    /**
     * Valider la commande
     */
    public function process(Request $request)
    {
        $request->validate([
            'creneau_id' => 'required|exists:creneaux_livraison,id',
        ]);

        $panier = Auth::user()->panier;
        if (!$panier || $panier->lignes->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $creneau = CreneauLivraison::findOrFail($request->creneau_id);
        if ($creneau->isFull() || $creneau->statut !== 'ouvert') {
            return redirect()->back()->with('error', 'Ce créneau n\'est plus disponible.');
        }

        try {
            DB::beginTransaction();

            // 1. Créer la commande
            $commande = Commande::create([
                'utilisateur_id' => Auth::id(),
                'creneau_id' => $creneau->id,
                'statut' => 'en_attente',
                'prix_total' => $panier->total(),
            ]);

            // 2. Vérifier et transférer les lignes + décrémenter le stock
            foreach ($panier->lignes as $ligne) {
                // Vérifier si le produit est toujours disponible (non périmé et stock > 0)
                if (!$ligne->produit->isAvailable()) {
                    throw new \Exception("Le produit '{$ligne->produit->nom}' n'est plus disponible ou a expiré entre-temps.");
                }

                if ($ligne->produit->stockDisponible() < $ligne->quantite) {
                    throw new \Exception("Désolé, le stock pour '{$ligne->produit->nom}' est insuffisant pour votre commande.");
                }

                // Décrémenter le stock réellement (FEFO)
                $ligne->produit->decrementStock($ligne->quantite);

                // Créer la ligne de commande
                LigneCommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $ligne->produit_id,
                    'quantite' => $ligne->quantite,
                    'prix_unitaire' => $ligne->produit->prix,
                    'sous_total' => $ligne->sousTotal(),
                ]);
            }

            // 3. Mettre à jour le créneau
            $creneau->increment('nombre_commandes');

            // 4. Vider le panier
            $panier->lignes()->delete();

            // 5. Envoyer une notification à l'utilisateur
            Auth::user()->notify(new \App\Notifications\OrderConfirmedNotification($commande));

            DB::commit();

            return redirect()->route('checkout.success', $commande);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la validation de votre commande : ' . $e->getMessage());
        }
    }

    /**
     * Page de succès
     */
    public function success(Commande $commande)
    {
        // Vérifier que la commande appartient à l'utilisateur
        if ($commande->utilisateur_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('commande'));
    }
}
