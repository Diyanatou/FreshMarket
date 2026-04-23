<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - FreshMarket</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md border border-gray-200">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4 border border-black">
                <i class="fas fa-leaf text-green-600 text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Se connecter</h2>
            <p class="text-gray-600">Accédez à votre compte FreshMarket</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse e-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="exemple@gmail.com"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded focus:outline-none focus:ring-2 focus:ring-primary"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Votre mot de passe"
                    required
                    class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded focus:outline-none focus:ring-2 focus:ring-primary"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded hover:bg-secondary transition">
                Se connecter
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-primary hover:text-secondary font-medium">Créer un compte</a>
            </p>
        </div>
    </div>

</body>
</html>
