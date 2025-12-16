<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin – FreshMarket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="px-6 py-5 text-xl font-bold border-b border-gray-700">
            FreshMarket
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Produits</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Catégories</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Commandes</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Utilisateurs</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Rapports</a>
        </nav>

        <div class="px-6 py-4 border-t border-gray-700 text-sm">
            © {{ date('Y') }} FreshMarket
        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">
                @yield('title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Admin</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 hover:underline text-sm">
                        Déconnexion
                    </button>
                </form>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
