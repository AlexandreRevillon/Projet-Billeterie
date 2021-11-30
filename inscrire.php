<?php 
    include "session.php"; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <!------------------------- Barre de navigation ------------------------->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Ilévia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Achat
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Carte</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Abonnement</a></li>
                <li><a class="dropdown-item" href="#">Ticket unitaire</a></li>
              </ul>
            </li>

            <li class="nav-item">
                <?php 
                    if ($_SESSION['user'] != 'NA') {
                        echo "<a class='nav-link active' href='profil.php'>Profil</a>";
                    } else {
                        echo "<a class='nav-link disabled' href='#' tabindex='-1' aria-disabled='true'>Profil</a>";
                    }

                 ?>
                                
            </li>

            <?php 
                if ($_SESSION['user'] != 'NA') {
                    echo " <li class='nav-item'>";
                        echo "<a class='nav-link active' href='disconnect.php'>Déconnexion</a>";
                    echo "</li>";
                } else {
                    echo " <li class='nav-item'>";
                        echo "<a class='nav-link active' href='Inscription.php'>Inscription</a>";
                    echo "</li>";

                    echo " <li class='nav-item'>";
                        echo "<a class='nav-link active' href='connect_user.php'>Connexion</a>";
                    echo "</li>";

                }

             ?>

          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
    <!--------------------- Fin de la barre de navigation --------------------->
    

    
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


//Vérification email identiques
    if ($email != $email2) {
        echo "<h2>Erreur lors de l'inscription : </h2>";
        echo "<p>Les 2 emails ne sont pas identiques</p>";
        echo "<a href='Inscription.php'>Retour au formulaire</a>";
        exit;
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
    $sql="INSERT INTO utilisateur (numu, nom, prenom, dn, adresse, codep, codet, datedebutabo, password, email) VALUES ($id,'$nom','$prenom','$dn','$adresserue $codepostal','TP',NULL,NULL, '$mdp', '$email');";

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
