<?php 
	include "session.php"; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carte</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
		
	<?php
	include "connexion.php";
	$con=connect();
	if (!$con) {
	    echo "Probleme de connexion à la base";
	    exit;
	 }
	?>

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
            <li><a class="dropdown-item" href="achat_carte.php">Carte</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="achat_abonnement.php">Abonnement</a></li>
            <li><a class="dropdown-item" href="achat_ticket.php">Ticket unitaire</a></li>
          </ul>
        </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="validation.php">Validation</a>
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
	<div class="container">
		<h1 class="text-center my-4">Achat - Carte</h1>
		<br>
		<?php 

			extract($_GET);

			if (isset($typec)){
				//Choix de la carte fait
				if ($typec=="CP" && $_SESSION['user']!="NA") {
					// Carte personnelle et utilisateur connecté
					if (isset($_SESSION['carte'])) {
						//Utilisateur à déjà une carte
						echo "<h2 class='text-center'>Vous posséder déjà une carte personnelle, il n'est pas possible d'en avoir plusieurs.</h2>";

					} else if (isset($valid)) {
						//Simulation de paiement en cours
						echo "<h2>Paiement en cours</h2>";
						echo "<img src='https://i.stack.imgur.com/ATB3o.gif'>";
						header("Refresh: 3;url=achat_carte.php?typec=CP&trasact=1");

					} else if(isset($trasact)){
						//Affectation d'un numéro de carte

							//Recherche du max des numero de carte
							$sql = "SELECT Max(numc) as numc FROM carte;";
							$result = pg_query($sql);
							if (!$result) {
						        echo " Probleme lors du lancement de la requete 1";
						        exit;
					        }
							$ligne = pg_fetch_array($result);

							//Incrémentation du numéro de carte
							$numc = $ligne['numc']+1;

							//Affichage du numéro de carte
							echo "<h2>Achat réalisé avec succes</h2>";
							echo "<p>Numéro de carte: $numc</p>";

							//Création du numéro de carte dans la BD + liaison avec l'utilisateur
							$sql = "INSERT INTO carte VALUES ($numc, '".$_SESSION['user']."', 'CP')";
							$result = pg_query($sql);
							if (!$result) {
						        echo " Probleme lors du lancement de la requete 2";
						        exit;
					        }

					        //Ajoute de la carte dans la variable session associée
					        $_SESSION['carte'] = $numc;

					} else {
						//Carte personnelle choisi: Affichage du prix + validation de l'achat
						echo "<p>Carte personnelle \t Prix: 5€</p><br>";
						echo "<a href='achat_carte.php?typec=CP&valid=1' class='btn btn-outline-success'>Valider mon achat</a>";
						echo "<a href='index.php' class='btn btn-outline-danger'>Annuler</a>";
					}



				} else if($typec=="CNP"){
					//Carte non personnelle 
					if (isset($valid)) {
						//Simulation de paiement en cours
						echo "<h2>Paiement en cours</h2>";
						echo "<img src='https://i.stack.imgur.com/ATB3o.gif'>";
						header("Refresh: 3;url=achat_carte.php?typec=CNP&trasact=1");

					} else if(isset($trasact)){
						//Affectation d'un numéro de carte

							//Recherche du max des numero de carte
							$sql = "SELECT Max(numc) as numc FROM carte;";
							$result = pg_query($sql);
							if (!$result) {
						        echo " Probleme lors du lancement de la requete 3";
						        exit;
					        }
							$ligne = pg_fetch_array($result);

							//Incrémentation du numéro de carte
							$numc = $ligne['numc']+1;

							//Affichage du numéro de carte
							echo "<h2>Achat réalisé avec succes</h2>";
							echo "<p>Numéro de carte: $numc</p>";

							//Créatio du numéro de carte dans la BD
							$sql = "INSERT INTO carte VALUES ($numc, NULL, 'CNP')";
							$result = pg_query($sql);
							if (!$result) {
						        echo " Probleme lors du lancement de la requete 4";
						        exit;
					        }

					} else {
						echo "<p>Carte non personnelle \t Prix: 1€</p><br>";
						echo "<a href='achat_carte.php?typec=CNP&valid=1' class='btn btn-outline-success'>Valider mon achat</a>";
						echo "<a href='index.php' class='btn btn-outline-danger'>Annuler</a>";
					}

				} else {
					//Carte personelle et utilisateur pas connecté
					echo "<h2 class='text-center'>Veuillez vous connecter ou vous inscrire d'abord</h2>";

				}

			} else {
				//Choix de la carte pas encore fait
				echo "<a href='achat_carte.php?typec=CP'>Carte personelle</a><br>";
				echo "<a href='achat_carte.php?typec=CNP'>Carte non personelle</a><br>";
			}
		 ?>




	</div>

</body>
</html>