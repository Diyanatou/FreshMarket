<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>

    <h2>Créer un compte</h2>

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nom complet</label><br>
            <input 
                type="text" 
                id="name" 
                name="name" 
                placeholder="Votre nom complet"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div>
            <label for="email">Adresse e-mail</label><br>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="exemple@gmail.com"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div>
            <label for="password">Mot de passe</label><br>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="Votre mot de passe"
                required
            >
        </div>

        <div>
            <label for="password_confirmation">Confirmez le mot de passe</label><br>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                placeholder="Confirmez le mot de passe"
                required
            >
        </div>

        <button type="submit">S'inscrire</button>

        <p>
            Déjà un compte ?
            <a href="{{ route('login') }}">Se connecter</a>
        </p>

    </form>

</body>
</html>
