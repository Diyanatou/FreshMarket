<html lang="fr"> 
    <head> 
        <meta charset="UTF-8"> 
        <title>Admin – FreshMarket</title>
         <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
         @vite('resources/css/app.css') 
        </head> 
        <body class="bg-gray-100 min-h-screen"> 
            <div class="flex min-h-screen">
<aside class="w-64 bg-gray-900 text-white flex flex-col">
    <div class="px-6 py-5 text-xl font-bold border-b border-gray-700">
        FreshMarket
    </div>

    <nav class="flex-1 px-4 py-6 text-sm space-y-4">


        <!-- ADMIN -->
        <details open class="group">
            <summary class="flex items-center justify-between px-4 py-2 rounded cursor-pointer hover:bg-gray-700">
                <span class="font-semibold">Admin</span>
                <span class="group-open:rotate-90 transition-transform">▶</span>
            </summary>

            <div class="ml-2 mt-2 space-y-3">

                <!-- PRODUITS -->
                <details class="group">
                    <summary class="flex justify-between px-4 py-2 rounded cursor-pointer hover:bg-gray-700">
                        <span>Produits</span>
                        <span class="group-open:rotate-90 transition-transform">▶</span>
                    </summary>
                    <div class="ml-4 mt-2 space-y-1 text-gray-300">
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">➕ Ajouter produit</a>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">📦 Gestion produits</a>
                    </div>
                </details>

                <!-- CATEGORIES -->
                <details class="group">
                    <summary class="flex justify-between px-4 py-2 rounded cursor-pointer hover:bg-gray-700">
                        <span>Catégories</span>
                        <span class="group-open:rotate-90 transition-transform">▶</span>
                    </summary>
                    <div class="ml-4 mt-2 space-y-1 text-gray-300">
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">➕ Ajouter catégorie</a>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">📂 Gestion catégories</a>
                    </div>
                </details>

                <!-- CLIENTS -->
                <details class="group">
                    <summary class="flex justify-between px-4 py-2 rounded cursor-pointer hover:bg-gray-700">
                        <span>Clients</span>
                        <span class="group-open:rotate-90 transition-transform">▶</span>
                    </summary>
                    <div class="ml-4 mt-2 space-y-1 text-gray-300">
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Gestion des clients</a>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Ajout de client</a>
                    </div>
                </details>

                <!-- COMMANDES -->
                <details class="group">
                    <summary class="flex justify-between px-4 py-2 rounded cursor-pointer hover:bg-gray-700">
                        <span>Commandes</span>
                        <span class="group-open:rotate-90 transition-transform">▶</span>
                    </summary>
                    <div class="ml-4 mt-2 space-y-1 text-gray-300">
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">📄 Liste commandes</a>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">🔍 Détails commande</a>
                        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">💸 Remboursements</a>
                    </div>
                </details>

            </div>
        </details>

        <!-- CUSTOMER -->
        <details class="group">
            <summary class="flex items-center justify-between px-4 py-2 rounded cursor-pointer hover:bg-gray-700">
                <span class="font-semibold">Customer</span>
                <span class="group-open:rotate-90 transition-transform">▶</span>
            </summary>

            <div class="ml-4 mt-2">
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700 text-gray-300">
                    🏠 Accueil
                </a>
            </div>
        </details>

    </nav>

    <div class="px-6 py-4 border-t border-gray-700 text-xs text-gray-400">
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
     <!-- PAGE CONTENT --> <main class="flex-1 p-6"> @yield('content') </main> 
    </div> 
    </div> 
    </body> 
      </html>