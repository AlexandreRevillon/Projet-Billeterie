<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <h1 class="text-center my-4">Projet Billeterie electronique</h1>
    <table border=1 align="center" cellspacing="5">
        <tr>
            <td><th colspan="2"><a href="Accueil.html">Accueil</a></th></td>
            <td><th colspan="2"><a href="Abonnement.php">Abonnements</a></th></td>
            <td><th colspan="2"><a href="Inscription.php">S'inscrire</a></th></td>
            <td><th colspan="2"><a href="Rechargement.php">Rechargement</a></th></td>
            <td><th colspan="2"><a href="connect_user.php">Connexion</a></th></td>
        </tr>
        </table>
        <table align="right">
        <tr>
            <td><form action="Recherche.php" method=POST>
                <input type="text" name="recherche" placeholder="Votre recherche" />
                <input type="submit" value="Rechercher" />
            </td></form>
        </tr>
    </table>
</td>
</body>
</html>
