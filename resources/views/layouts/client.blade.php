<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FreshMarket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

<!-- HEADER -->
<header class="border-b border-slate-800 bg-slate-900">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center gap-6">

        <!-- LOGO -->
        <div class="flex items-center gap-2 text-xl font-bold text-green-400">
            🥬 <span>FreshMarket</span>
        </div>

        <!-- SEARCH -->
        <div class="flex-1">
            <input
                type="text"
                placeholder="Rechercher un produit, une catégorie..."
                class="w-full bg-slate-800 px-5 py-3 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-400"
            >
        </div>

        <!-- ICONS -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center">🛒</div>
            <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center">👤</div>
        </div>
    </div>

    <!-- MENU -->
    <nav class="border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center gap-8 text-sm text-gray-300">

            <!-- CATEGORY BUTTON -->
            <button class="flex items-center gap-2 text-white font-semibold">
                ☰ Toutes les catégories
            </button>

            <!-- LINKS -->
            <div class="flex gap-6 mx-auto">
                <a href="#" class="text-white font-semibold">Accueil</a>
                <a href="#">Produits</a>
                <a href="#">Promotions</a>
                <a href="#">Mon panier</a>
                <a href="#">Mes commandes</a>
            </div>
        </div>
    </nav>
</header>

<!-- CATEGORIES BAR -->
<section class="bg-slate-950 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-6 py-6 grid grid-cols-3 sm:grid-cols-5 md:grid-cols-9 gap-6 text-center text-sm text-gray-300">

        @php
            $categories = [
                ['icon' => '⭐', 'name' => 'Promotions'],
                ['icon' => '🥦', 'name' => 'Fruits & Légumes'],
                ['icon' => '🥩', 'name' => 'Viandes & Poissons'],
                ['icon' => '🥖', 'name' => 'Boulangerie'],
                ['icon' => '🥛', 'name' => 'Produits laitiers'],
                ['icon' => '🧃', 'name' => 'Boissons'],
                ['icon' => '🍪', 'name' => 'Épicerie sèche'],
                ['icon' => '❄️', 'name' => 'Surgelés'],
                ['icon' => '🧼', 'name' => 'Entretien'],
            ];
        @endphp

        @foreach($categories as $index => $cat)
            <div class="flex flex-col items-center gap-2 cursor-pointer">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center
                    {{ $index === 0 ? 'bg-green-200 text-green-700' : 'bg-slate-800' }}">
                    {{ $cat['icon'] }}
                </div>
                <span>{{ $cat['name'] }}</span>
            </div>
        @endforeach

    </div>
</section>

<!-- CONTENT -->
<main class="max-w-7xl mx-auto px-6 py-10">
    @yield('content')
</main>

</body>
</html>
