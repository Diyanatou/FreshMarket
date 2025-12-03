<!DOCTYPE html>
    <html lang= "fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inscription</title>
        </head>
        <body>
            <div class="">
                <h2>Creer un Compte</h2>
                <form action ="{{route('register.post')}}" method="post">
                    @csrf
                    <div class="">
                        <label for="firstname">Prenom</label>
                        <input type="text" id="prenom" name="prenom" placeholder="Votre prenom" required>
                    </div>
                    <div class="">
                        <label for="lastname">nom</label>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" placeholder="exemple@gmail.com" required>
                    </div>
                    <div class="">
                        <label for="password"></label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                    </div>
                    <div class="">
                        <label for="password_confirnation">Confirmez le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Comfirmez le mot de passe" required>
                    </div>

                    <button type="submit" class="">S'inscrire</button>
                    <div class="">
                        <p>Deja un compte ? <a href="{{route('login')}}">Se connecter</a></p>
                </form>
        </body>
</html>