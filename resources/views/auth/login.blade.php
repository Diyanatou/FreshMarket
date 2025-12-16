<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

    <h2>Se connecter</h2>
    @if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

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

        <button type="submit">Se connecter</button>

        <p>
            Pas encore de compte ?
            <a href="{{ route('register') }}">S'inscrire</a>
        </p>
    
    </form>

</body>
</html>
