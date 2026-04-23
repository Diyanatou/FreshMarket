<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshMarket - @yield('title', 'Boutique Bio')</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white text-gray-800 antialiased">

    <!-- Middle Header -->
    <header class="py-6 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center gap-8">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 text-3xl font-bold text-primary">
                <i class="fas fa-leaf text-primary"></i>
                <span>FreshMarket</span>
            </a>

            <!-- Search Bar -->
            <div class="flex-1 max-w-2xl hidden md:flex">
                <div class="flex w-full border border-gray-200 rounded-lg overflow-hidden focus-within:border-primary transition-colors">
                    <input type="text" placeholder="Rechercher un produit..." class="flex-1 px-4 py-3 outline-none text-sm text-gray-700">
                    <button class="bg-primary text-white px-8 py-3 font-semibold hover:bg-secondary transition-colors">Rechercher</button>
                </div>
            </div>

            <!-- Icons -->
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <a href="#" class="text-primary hover:text-secondary transition-colors relative">
                        <i class="far fa-bell text-2xl"></i>
                        @php $notifCount = Auth::check() ? Auth::user()->unreadNotifications->count() : 0; @endphp
                        @if($notifCount > 0)
                        <span class="absolute -top-2 -right-2 bg-primary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">{{ $notifCount }}</span>
                        @endif
                    </a>
                    
                    <!-- Dropdown Notifications (Simplifié) -->
                    @auth
                    <div class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 py-4 hidden group-hover:block z-[100]">
                        <div class="px-6 py-2 border-b border-gray-50 flex justify-between items-center mb-2">
                            <span class="text-xs font-black uppercase tracking-widest text-gray-400">Notifications</span>
                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] text-primary font-bold hover:underline">Tout marquer comme lu</button>
                            </form>
                        </div>
                        <div class="max-h-64 overflow-y-auto no-scrollbar">
                            @forelse(Auth::user()->unreadNotifications as $notification)
                            <div class="px-6 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                <p class="text-xs text-gray-800 font-medium">{{ $notification->data['message'] }}</p>
                                <span class="text-[9px] text-gray-400 uppercase font-black">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            @empty
                            <div class="px-6 py-8 text-center">
                                <i class="far fa-bell-slash text-2xl text-gray-200 mb-2 block"></i>
                                <p class="text-xs text-gray-400 italic">Aucune nouvelle notification</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @endauth
                </div>

                <div class="h-8 w-px bg-gray-200"></div>
                <div class="relative group">
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-3">
                        <div class="relative">
                            <i class="fas fa-shopping-bag text-2xl text-primary group-hover:text-secondary transition-colors"></i>
                            @php $cartCount = Auth::check() && Auth::user()->panier ? Auth::user()->panier->nombreArticles() : 0; @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-accent text-primary text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">{{ $cartCount }}</span>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-primary text-white hidden md:block relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-14">
            <div class="flex items-center gap-8 text-sm">
                <a href="/" class="text-red-600 font-bold transition-colors">Accueil</a>
                @auth
                <a href="#" class="text-white hover:text-accent transition-colors font-medium">Mes commandes</a>
                @can('viewAdminDashboard', App\Models\User::class)
                <a href="{{ route('dashboard') }}" class="bg-red-600 text-white px-4 py-1.5 rounded-lg font-bold flex items-center gap-2 shadow-sm">
                    <i class="fas fa-chart-line"></i> Dashboard Admin
                </a>
                @endcan
                @endauth
            </div>
            <div class="flex items-center gap-4 text-sm font-medium">
                @auth
                    <span class="text-white flex items-center gap-2"><i class="fas fa-user-circle text-lg text-red-600"></i> {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    <div class="h-4 w-px bg-blue-400/30"></div>
                    <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="text-white hover:text-red-600 transition-colors flex items-center gap-1"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-red-600 transition-colors flex items-center gap-1"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                    <div class="h-4 w-px bg-blue-400/30"></div>
                    <a href="{{ route('register') }}" class="text-white hover:text-red-600 transition-colors flex items-center gap-1"><i class="fas fa-user-plus text-white"></i> Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 border-t-[10px] border-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 pb-12">
                <div class="lg:col-span-2">
                    <a href="/" class="flex items-center gap-2 text-3xl font-bold text-white mb-6">
                        <i class="fas fa-leaf text-primary"></i>
                        <span>FreshMarket</span>
                    </a>
                    <p class="text-sm text-gray-400 mb-6 max-w-sm">
                        FreshMarket est votre marché bio de confiance. Nous vous offrons les meilleurs produits frais tous les jours.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Mon Compte</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Mon Profil</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">Panier</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Aide</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 py-6 flex justify-between items-center text-sm text-gray-500">
                <p>FreshMarket © 2024. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

</body>
</html>
