<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') – FreshMarket Admin</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Personnalisation de la scrollbar pour qu'elle soit discrète */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-gray-300 flex flex-col flex-shrink-0">
            <!-- Logo Section -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-bold text-xl tracking-wide">
                    <i class="fas fa-leaf text-white"></i>
                    <span>FreshMarket</span>
                </a>
            </div>

            <!-- Menu Items -->
            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1">
                    <!-- Retour Boutique -->
                    <li>
                        <a href="{{ url('/') }}" class="flex items-center gap-3 px-6 py-2.5 text-red-600">
                            <i class="fas fa-external-link-alt w-5 text-center"></i>
                            <span class="text-sm font-bold">Voir la boutique</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 {{ request()->routeIs('dashboard') ? 'px-5' : 'px-6' }} py-2.5 hover:bg-slate-800 hover:text-white transition-colors">
                            <i class="fas fa-th-large w-5 text-center"></i>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                    </li>
                    <!-- Article (Produits) -->
                    <li class="{{ request()->routeIs('produits.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                        <a href="{{ route('produits.index') }}" class="flex items-center gap-3 {{ request()->routeIs('produits.*') ? 'px-5' : 'px-6' }} py-2.5 hover:bg-slate-800 hover:text-white transition-colors">
                            <i class="fas fa-box w-5 text-center"></i>
                            <span class="text-sm font-medium">Article</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('commandes.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                        <a href="{{ route('commandes.index') }}" class="flex items-center gap-3 {{ request()->routeIs('commandes.*') ? 'px-5' : 'px-6' }} py-2.5 hover:bg-slate-800 hover:text-white transition-colors">
                            <i class="fas fa-list-ul w-5 text-center"></i>
                            <span class="text-sm font-medium">Toutes les commandes</span>
                        </a>
                    </li>
                    <!-- Catégorie -->
                    <li class="{{ request()->routeIs('categories.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                        <a href="{{ route('categories.index') }}" class="flex items-center gap-3 {{ request()->routeIs('categories.*') ? 'px-5' : 'px-6' }} py-2.5 hover:bg-slate-800 hover:text-white transition-colors">
                            <i class="fas fa-tags w-5 text-center"></i>
                            <span class="text-sm font-medium">Catégorie</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.creneaux.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                        <a href="{{ route('admin.creneaux.index') }}" class="flex items-center gap-3 {{ request()->routeIs('admin.creneaux.*') ? 'px-5' : 'px-6' }} py-2.5 hover:bg-slate-800 hover:text-white transition-colors">
                            <i class="fas fa-clock w-5 text-center"></i>
                            <span class="text-sm font-medium">Créneaux</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800 hover:text-white transition-colors">
                            <i class="fas fa-database w-5 text-center"></i>
                            <span class="text-sm font-medium">Stock</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 {{ request()->routeIs('admin.users.*') ? 'px-5' : 'px-6' }} py-2.5 hover:bg-slate-800 hover:text-white transition-colors">
                            <i class="fas fa-user-cog w-5 text-center"></i>
                            <span class="text-sm font-medium">Utilisateur</span>
                        </a>
                    </li>
            </nav>

            <!-- Logout Bottom -->
            <div class="px-6 py-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-sm font-medium hover:text-white transition-colors w-full text-left">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            
            <!-- Topbar -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 flex-shrink-0 z-10 relative">
                <!-- Left: Title & Hamburger -->
                <div class="flex items-center gap-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                </div>

                <!-- Center: Search Bar -->
                <div class="flex-1 max-w-xl mx-8">
                    <div class="flex items-center w-full bg-gray-50 border border-gray-200 rounded-lg overflow-hidden focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                        <input type="text" placeholder="Recherche..." class="w-full px-4 py-2 bg-transparent outline-none text-sm text-gray-700">
                        <button class="bg-primary hover:bg-secondary text-white px-4 py-2 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Right: User Dropdown -->
                <div class="flex items-center gap-6">
                    <a href="{{ url('/') }}" class="hidden sm:flex items-center gap-2 text-sm font-bold text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-eye text-lg"></i>
                        Voir Boutique
                    </a>
                    <div class="relative group cursor-pointer">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <span>{{ Auth::check() ? Auth::user()->nom : 'Komche' }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>