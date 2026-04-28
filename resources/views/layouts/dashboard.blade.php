<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') – FreshMarket Admin</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans text-gray-800">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-gray-300 flex flex-col">

        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-bold text-xl">
                <i class="fas fa-leaf"></i>
                <span>FreshMarket</span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1">

                <li>
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-6 py-2.5 text-red-500">
                        <i class="fas fa-external-link-alt w-5 text-center"></i>
                        Voir la boutique
                    </a>
                </li>

                <li class="{{ request()->routeIs('dashboard') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        Dashboard
                    </a>
                </li>

                <li class="{{ request()->routeIs('produits.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('produits.index') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-box w-5 text-center"></i>
                        Articles
                    </a>
                </li>

                <li class="{{ request()->routeIs('commandes.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('commandes.index') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-list-ul w-5 text-center"></i>
                        Commandes
                    </a>
                </li>

                <li class="{{ request()->routeIs('categories.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-tags w-5 text-center"></i>
                        Catégories
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.creneaux.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('admin.creneaux.index') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-clock w-5 text-center"></i>
                        Créneaux
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.rapports.pertes') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('admin.rapports.pertes') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        Pertes
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-user-cog w-5 text-center"></i>
                        Utilisateurs
                    </a>
                </li>

                {{-- ✅ AJOUT FOURNISSEURS --}}
                <li class="{{ request()->routeIs('fournisseurs.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('fournisseurs.index') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-truck w-5 text-center"></i>
                        Fournisseurs
                    </a>
                </li>

                {{-- ✅ ACHATS --}}
                <li class="{{ request()->routeIs('achats.*') ? 'bg-slate-800 text-white border-l-4 border-red-600' : '' }}">
                    <a href="{{ route('achats.index') }}" class="flex items-center gap-3 px-6 py-2.5 hover:bg-slate-800">
                        <i class="fas fa-cart-plus w-5 text-center"></i>
                        Achats
                    </a>
                </li>

            </ul>
        </nav>

        <!-- LOGOUT -->
        <div class="px-6 py-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 text-sm hover:text-white">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">

            <h1 class="text-xl font-semibold">@yield('title')</h1>

            <div class="text-sm font-medium">
                {{ Auth::user()->nom ?? 'Admin' }}
            </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>