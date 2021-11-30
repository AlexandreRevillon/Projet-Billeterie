<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<h1>Inscription</h1>

<?php
//Import des fichiers nécessaires
include "connexion.php";
include "Fonctions.php";


//Connexion à la base de données
$con=connect();
if (!$con) {
    echo "Probleme de connexion à la base";
    exit;
 }

//Récupération des informations saisies dans le formulaire
    extract($_POST);


//Vérification mot de passe identique
    if ($mdp != $mdp2) {
        echo "<h2>Erreur lors de l'inscription : </h2>";
        echo "<p>Les 2 mots de passes ne sont pas identiques</p>";
        echo "<a href='Inscription.php'>Retour au formulaire</a>";
        exit;
    } else {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    }


//Boucle d'incrémentation du numero unique(numu) associé à chaque utilisateur
    $numu="select max(numu) as max from utilisateur";
    $resultat=pg_query($numu);

    if (!$resultat) {
        echo " Probleme lors du lancement de la requete 1";
        exit;
        }
    $ligne=pg_fetch_array($resultat);

    $id = $ligne['max']+1;


//Insertion du nouvel utilisateur dans la base
    $sql="INSERT INTO utilisateur (numu, nom, prenom, dn, adresse, codep, codet, datedebutabo, password) VALUES ($id,'$nom','$prenom','$dn','$adresserue $codepostal','TP',NULL,NULL, '$mdp');";

    $result=pg_query($sql);

    if (!$result) {
        echo " Probleme lors du lancement de la requete 2";
        exit;
        }
    else {
        echo "<h2>Inscription validée</h2>";
        echo "<a href='index.php'>Retour à l'accueil</a>";
    }
?>



</body>
</html>
