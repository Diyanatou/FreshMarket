<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    @vite('resources/css/app.css') <!-- Assure-toi que Tailwind est bien importé -->
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Créer un compte</h2>

        {{-- Affichage des erreurs --}}
        @if ($errors->any())
            <ul class="mb-4 text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block mb-1 font-medium">Nom complet</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Votre nom complet"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <div>
                <label for="email" class="block mb-1 font-medium">Adresse e-mail</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="exemple@gmail.com"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <div>
                <label for="password" class="block mb-1 font-medium">Mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Votre mot de passe"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 font-medium">Confirmez le mot de passe</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Confirmez le mot de passe"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors">
                S'inscrire
            </button>

            <p class="text-center text-gray-600 text-sm mt-4">
                Déjà un compte ? 
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Se connecter</a>
            </p>
        </form>
    </div>

</body>
</html>
