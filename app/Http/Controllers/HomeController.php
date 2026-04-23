<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $produits = Produit::where('actif', true)
            ->whereHas('lotsValides')
            ->latest()
            ->take(12)
            ->get();
        $categories = Categorie::all();
        
        return view('welcome', compact('produits', 'categories'));
    }
}
