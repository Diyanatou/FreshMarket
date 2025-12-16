<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshMarket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white m-0 p-0">

<!-- NAVBAR -->
<nav class="flex flex-col md:flex-row items-center justify-between px-6 md:px-12 py-5 gap-4 md:gap-0">
    <div class="flex items-center gap-3">
        <div class="bg-blue-500 text-white w-12 h-12 flex items-center justify-center rounded-lg font-bold">Logo</div>
        <span class="font-bold text-lg">FreshMarket</span>
    </div>

    <ul class="flex flex-col md:flex-row items-center gap-4 md:gap-8 text-gray-700">
        <li><a href="#" class="hover:text-blue-500">Accueil</a></li>
        <li><a href="#" class="hover:text-blue-500">Blog</a></li>
        <li><a href="#" class="hover:text-blue-500">Contact</a></li>
    </ul>

    <div class="flex items-center gap-2 md:gap-4">
        <input type="text" placeholder="Search..."
               class="bg-gray-100 rounded-full px-4 py-2 outline-none w-full md:w-auto">
        <a href="{{ route('login') }}" class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <span class="font-medium hidden md:inline">Login</span>
        </a>
        <button class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full hover:bg-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7a1 1 0 00.9 1.5h12.1a1 1 0 00.9-1.5L17 13M7 13V6h10v7M5 21h2m10 0h2"/>
            </svg>
        </button>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="relative grid grid-cols-1 md:grid-cols-2 px-6 md:px-12 pt-10 pb-16 gap-8 md:gap-0">
    <!-- Petits plus rouges -->
    <div class="absolute top-5 left-72 text-blue-500 text-3xl font-bold rotate-12">+</div>
    <div class="absolute top-40 left-80 text-red-500 text-3xl font-bold -rotate-12">+</div>
    <!-- Grand rond jaune -->
    <div class="absolute top-32 right-20 w-16 h-16 bg-red-500 rounded-full z-10"></div>

    <!-- LEFT TEXT -->
    <div class="flex flex-col justify-center z-10">
        <p class="text-blue-500 font-semibold tracking-wide">EPICERIE EN LIGNE</p>
        <h1 class="text-4xl md:text-5xl font-bold leading-tight mt-2">
            Faites Vos Courses <br>
            <span class="text-blue-500 drop-shadow-lg">Livrées Rapidement</span>
        </h1>
        <p class="text-gray-500 mt-4 text-sm md:text-base">
            Commandez vos produits d’épicerie préférés en quelques clics et recevez-les chez vous.  
            Gestion facile du stock et suivi de vos commandes en temps réel.
        </p>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="relative z-0 flex justify-center items-center">
        <img src="{{ asset('images/food4.png') }}" class="w-full max-w-md h-auto object-contain" alt="Food Bag Image">
    </div>
</section>

<!-- BLOG SECTION -->
<section class="max-w-6xl mx-auto py-16 px-6">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-blue-500 mb-3">Notre Blog</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto rounded-full mb-4"></div>
        <p class="mt-4 text-gray-500 text-sm md:text-base">Découvrez nos conseils, recettes et nouveautés pour mieux profiter de vos courses en ligne.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <!-- ARTICLE 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="{{ asset('images/foodware.jpg') }}" alt="Recette rapide" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl md:text-2xl font-bold mb-2">5 Recettes rapides avec vos courses</h3>
                <p class="text-gray-500 mb-4 text-sm md:text-base">Découvrez comment préparer des repas délicieux et rapides avec les produits que vous commandez chez FreshMarket.</p>
                <a href="#" class="text-blue-500 font-semibold hover:underline">Lire la suite →</a>
            </div>
        </div>
        <!-- ARTICLE 2 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="{{ asset('images/foodware1.jpg') }}" alt="Conservation aliments" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl md:text-2xl font-bold mb-2">Bien conserver vos produits frais</h3>
                <p class="text-gray-500 mb-4 text-sm md:text-base">Astuces simples pour que vos fruits, légumes et produits laitiers restent frais plus longtemps.</p>
                <a href="#" class="text-blue-500 font-semibold hover:underline">Lire la suite →</a>
            </div>
        </div>
        <!-- ARTICLE 3 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="{{ asset('images/foodware2.jpg') }}" alt="Nouveautés ShopFresh" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl md:text-2xl font-bold mb-2">Nouveautés de la semaine</h3>
                <p class="text-gray-500 mb-4 text-sm md:text-base">Découvrez les nouveaux produits ajoutés à notre catalogue et profitez de nos promotions exclusives.</p>
                <a href="#" class="text-blue-500 font-semibold hover:underline">Lire la suite →</a>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="max-w-6xl mx-auto py-16 px-6">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-blue-500 mb-3">Contactez-nous</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto rounded-full mb-4"></div>
        <p class="text-gray-600 text-sm md:text-base">Nous sommes là pour répondre à toutes vos questions et vous aider à profiter pleinement de vos courses en ligne.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
        <!-- FORMULAIRE -->
        <div class="bg-white shadow-lg rounded-xl p-6 md:p-8">
            <h3 class="text-2xl md:text-3xl font-bold mb-4 text-blue-500">Envoyez-nous un message</h3>
            <form action="#" method="POST" class="flex flex-col gap-4">
                @csrf
                <input type="text" name="name" placeholder="Votre nom"
                    class="border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-3 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                <input type="email" name="email" placeholder="Votre email"
                    class="border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-3 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                <textarea name="message" rows="5" placeholder="Votre message"
                    class="border border-gray-300 rounded-lg px-3 py-2 md:px-4 md:py-3 focus:outline-none focus:ring-2 focus:ring-red-500 transition"></textarea>
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-red-600 transition">Envoyer</button>
            </form>
        </div>

        <!-- INFO SUPPLÉMENTAIRE -->
        <div class="flex flex-col gap-6">
            <div class="bg-white shadow-lg rounded-xl p-6 md:p-8">
                <h3 class="text-2xl md:text-3xl font-bold mb-3 text-blue-500">Pourquoi nous choisir</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2 text-sm md:text-base">
                    <li>Produits frais et de qualité directement livrés chez vous.</li>
                    <li>Livraison rapide et fiable à domicile.</li>
                    <li>Suivi en temps réel de vos commandes.</li>
                    <li>Paiement sécurisé et facilité de commande.</li>
                </ul>
            </div>
            <div class="bg-white shadow-lg rounded-xl p-6 md:p-8">
                <h3 class="text-2xl md:text-3xl font-bold mb-3 text-blue-500">Nos horaires</h3>
                <p>Lundi - Vendredi: 08:00 - 20:00</p>
                <p>Samedi: 08:00 - 18:00</p>
                <p>Dimanche: Fermé</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-blue-500 text-white py-12 mt-16">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h3 class="text-xl font-bold mb-4">À propos</h3>
            <p class="text-gray-100 text-sm md:text-base">FreshMarket est votre épicerie en ligne de confiance. Commandez vos produits préférés et recevez-les rapidement chez vous.</p>
        </div>
        <div>
            <h3 class="text-xl font-bold mb-4">Liens rapides</h3>
            <ul class="space-y-2 text-sm md:text-base">
                <li><a href="#" class="hover:underline">Accueil</a></li>
                <li><a href="#" class="hover:underline">Blog</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-xl font-bold mb-4">Contact</h3>
            <p class="text-sm md:text-base"><strong>Email:</strong> contact@epicerieenligne.tg</p>
            <p class="text-sm md:text-base"><strong>Téléphone:</strong> +228 90 00 00 00</p>
            <p class="text-sm md:text-base"><strong>Adresse:</strong> 123 Rue de l'Épicerie, Lomé, Togo</p>
        </div>
    </div>
    <div class="mt-12 border-t border-white-500 pt-6 text-center text-gray-100 text-sm md:text-base">
        &copy; 2025 FreshMarket. Tous droits réservés.
    </div>
</footer>

</body>
</html>
