<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<?php
//Connexion à la base de données
    include "connexion.php";
    $con=connect();
    if (!$con) {
        echo "Probleme de connexion à la base";
        exit;
     }
?>

<div class="container">
    <h1 class="text-center my-4"> Inscription</h1>

    <form action="inscrire.php" method=POST class >
    <table>
        <tr>
            <td>Entrez votre nom :</td>
            <td><input type="text" name="nom" required></td>
        </tr>
        <tr>
            <td>Entrez votre prenom :</td>
            <td><input type="text" name="prenom" required></td>
        </tr>
        <tr>
            <td>Date de naissance : </td>
            <td><input type=date name="dn" required></td>
        </tr>
        <tr>
            <td>Adresse : </td>
            <td>N° et nom de rue : <input type="text" name="adresserue" required></td>
        </tr>
        <tr>
            <td></td><td>Code postal : <input type="text" name="codepostal" required></td>
        </tr>
        <tr>
            <td>Mot de passe : </td>
            <td><input type="password" name="mdp" required></td>
        </tr>
        <tr>
            <td> Confirmez votre mot de passe : </td>
            <td><input type="password" name="mdp2" required></td>
        </tr>
        <tr>
            <td>Email : </td>
            <td><input type="email" name="email" required></td>
        </tr>
        <tr>
            <td> Confirmez votre email: </td>
            <td><input type="email" name="email2" required></td>
        </tr>
    </table>

    </br>
    <input align="center" type="submit" value="S'inscrire" class="btn btn-outline-success">
    <a href='index.php' class="btn btn-outline-danger">Retour à l'accueil</a>
    </form>
</div>

</body>
</html>
