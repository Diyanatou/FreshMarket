<!DOCTYPE html>
    <html lang= "fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion</title>
        </head>
        <body>
            <div class="">
                <h2>Se connecter </h2>
                <form action ="{{route('login.post')}}" method="post">
                    @csrf
                    <div class="">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" placeholder="exemple@gmail.com" required>
                    </div>
                    <div class="">
                        <label for="password"></label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                    </div>
                    <button type="submit" class="">Se connecter</button>
                    <div class="">
                        <p>Pas encore de compte ? <a href="{{route('register')}}">S'inscrire</a></p>
                </form>
        </body>
</html>