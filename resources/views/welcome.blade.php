@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-green-50 border border-black text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-lg"></i>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
</div>
@endif

<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Banner -->
        <div class="lg:col-span-2 relative  overflow-hidden aspect-[16/9] lg:aspect-auto flex items-center bg-[#f0f9f1] border border-black">
            <img src="images/hero.jpg" alt="Fresh Groceries"
                class="absolute inset-0 w-full h-full object-cover object-right opacity-90">

            <div class="relative z-10 p-8 md:p-12 max-w-lg">
                <h2 class="text-4xl md:text-5xl font-bold text-black leading-tight mb-4">
                    Nourriture Bio <br>Fraîche & Saine
                </h2>

                <p class="text-white mb-8 text-sm">
                    Livraison gratuite sur toutes vos commandes. Nous livrons, vous profitez.
                </p>

                <a href="#"
                    class="inline-flex items-center gap-2 bg-red-600 text-white px-8 py-3.5 rounded-full font-bold hover:bg-red-700 transition-colors shadow-lg">
                    Acheter maintenant <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Side Banners -->
        <div class="flex flex-col gap-6">

            <div class="relative overflow-hidden bg-gray-100 flex-1 min-h-[200px] border border-black">
                <img src="images/hero1.jpg" class="absolute inset-0 w-full h-full object-cover">
            </div>

            <div class="relative overflow-hidden flex-1 min-h-[200px] border border-black">
                <img src="images/hero2.jpg" class="absolute inset-0 w-full h-full object-cover">
            </div>

        </div>

    </div>
</section>
<!-- Features -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-white border border-black shadow-sm p-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Feature 1 -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center border border-black">
                    <i class="fas fa-leaf text-xl text-green-600"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Produits frais</h4>
                    <p class="text-xs text-gray-500">Sélection quotidienne de qualité</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-black/5 flex items-center justify-center border border-black">
                    <i class="fas fa-truck-fast text-xl text-black"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Livraison rapide</h4>
                    <p class="text-xs text-gray-500">Livré en un temps record</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center border border-black">
                    <i class="fas fa-tags text-xl text-yellow-600"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Prix abordables</h4>
                    <p class="text-xs text-gray-500">Meilleur rapport qualité/prix</p>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center border border-black">
                <i class="fas fa-lock text-xl text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Paiement sécurisé</h4>
                    <p class="text-xs text-gray-500">Transactions 100% sécurisées</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Categories -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <div class="flex justify-between items-end mb-10">
        <h2 class="text-3xl font-bold text-gray-900">Catégories Populaires</h2>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">

        @foreach($categories as $cat)

        <a href="#"
            class="group relative bg-white border border-black p-6 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <!-- TITLE -->
            <h3 class="font-bold text-gray-900 mb-1 group-hover:text-black transition">
                {{ $cat->nom }}
            </h3>
            <!-- bottom accent line -->
            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[2px] bg-black group-hover:w-1/2 transition-all duration-300"></span>
        </a>

        @endforeach

    </div>
</section>

<!-- PRODUCTS -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

    <div class="flex justify-between items-end mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Nos Produits Frais</h2>

        <a href="#" class="text-primary font-semibold hover:underline flex items-center gap-1">
            Voir tout <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    <!-- NO TOP BORDER -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-0 border-l border-black">

        @forelse($produits as $produit)

        <div class="group relative bg-white border border-black p-4 hover:shadow-lg transition-all flex flex-col">

            <!-- IMAGE -->
            <div class="h-48 w-full flex items-center justify-center mb-4 p-2 relative overflow-hidden">
                @if($produit->image)
                    <img src="{{ asset('storage/'.$produit->image) }}"
                        class="max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                @else
                    <i class="fas fa-image text-gray-300 text-6xl"></i>
                @endif
            </div>

            <div class="mt-auto flex justify-between items-end">

                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">
                        {{ $produit->categorie->nom }}
                    </p>

                    <h3 class="text-sm font-bold text-gray-800 mb-1 hover:text-primary cursor-pointer">
                        {{ $produit->nom }}
                    </h3>

                    <span class="font-black text-black">
                        {{ number_format($produit->prix, 0, ',', ' ') }} <small>FCFA</small>
                    </span>
                </div>

                <form action="{{ route('cart.add', $produit) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center hover:bg-black/80 transition shadow-sm">
                        <i class="fas fa-shopping-bag"></i>
                    </button>
                </form>

            </div>

        </div>

        @empty
        <div class="col-span-full py-12 text-center text-gray-400">
            Aucun produit disponible pour le moment.
        </div>
        @endforelse

    </div>
</section>

@endsection