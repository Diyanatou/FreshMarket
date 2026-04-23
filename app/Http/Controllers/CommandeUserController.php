<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CommandeUserController extends Controller
{
    public function index()
    {
        $commandes = Auth::user()
            ->commandes()
            ->with(['creneau', 'lignes.produit'])
            ->latest()
            ->get();

        return view('commandes.user.index', compact('commandes'));
    }
}