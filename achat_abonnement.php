<?php 
	include "session.php"; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Abonnement</title>
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

      </ul>

      <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
                <?php
                    if ($_SESSION['user'] != 'NA') {
                        echo "<a class='nav-link active' href='profil.php'>Profil</a>";
                    } else {
                        echo "<a class='nav-link active' href='carte.php'>Carte</a>";
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

    </div>
  </div>
</nav>
<!--------------------- Fin de la barre de navigation --------------------->

<div class="d-flex flex-column min-vh-100">
	<div class="container">
		<h1 class="text-center my-4">Achat - Abonnement</h1>
		<br>
		<?php 

			extract($_POST);

			if ($_SESSION['user']=="NA") {
				//utilisateur pas connecté
					echo "<h2 class='text-center'>Veuillez vous connecter ou vous inscrire d'abord</h2>";
					echo "<a href='index.php' class='p-2 my-2 btn btn-outline-info vol-2 offset-5'>Retour à l'accueil</a>";
			} else if (!isset($_SESSION['carte'])) {
				//utilisateur n'a pas de carte
					echo "<h2 class='text-center'>Vuos devez posséder une carte nominative pour pouvoir prendre un abonnement</h2>";
					echo "<a href='index.php' class='p-2 my-2 btn btn-outline-info vol-2 offset-5'>Retour à l'accueil</a>";
			}else {
				//Vérification abonnement en cours
					$sql = "SELECT * FROM utilisateur WHERE numu = '".$_SESSION['user']."';";
					$result = pg_query($sql);

				//vérifiaction de l'execution de la requete
					if (!$result) {
						echo $sql;
				        echo " Probleme lors du lancement de la requete 1";
				        exit;
				    }

				$ligne = pg_fetch_array($result);


				if (!is_null($ligne['codet']) ) {
					//Vérification de l'échéance
						$sql2 = "SELECT * FROM titretransport WHERE codet = '".$ligne['codet']."';";
						$result2 = pg_query($sql2);

					//vérifiaction de l'execution de la requete
						if (!$result) {
							echo $sql;
					        echo " Probleme lors du lancement de la requete 1";
					        exit;
					    }

					$ligne2 = pg_fetch_array($result2);

					$echeance = date('Y-m-d', strtotime($ligne['datedebutabo']. ' + '.$ligne2['dureevalidjour'].' days'));

					if ($echeance > date('Y-m-d')) {
						echo "<h2 class='text-center'>Vous possédez déjà un abonnement en cours de validité</h2>";
						echo "<a href='index.php' class='p-2 my-2 btn btn-outline-info vol-2 offset-5'>Retour à l'accueil</a>";
						exit;
					}
				}



				if (isset($transact)){
					//Ajout de l'abonnement pour l'utilisateur
					$sql = "UPDATE utilisateur SET codet = '$abo', datedebutabo = '$datedebut' WHERE numu = '".$_SESSION['user']."' ;";
					$result = pg_query($sql);

					//vérifiaction de l'execution de la requete
					if (!$result) {
						echo $sql;
				        echo " Probleme lors du lancement de la requete 1";
				        exit;
			        }
					$ligne = pg_fetch_array($result);

					echo "<h2 class='text-center'>Paiement réussi</h2>";
					echo "<a href='index.php' class='p-2 my-2 btn btn-outline-info vol-2 offset-5'>Retour à l'accueil</a>";


				} else if (isset($valid)){
					//Simulation de paiement en cours
						echo "<form method='POST' action='achat_abonnement.php' id='TheForm'>";
							foreach ($_POST as $key => $value) {
								echo "<input type='hidden' name='$key' value='$value'>";
							}
							echo "<input type='hidden' name='transact' value='1'>";
						echo "</form>";
						echo "<h2 class='text-center'>Paiement en cours</h2>";
						echo "<img class='col-2 offset-5' src='https://i.stack.imgur.com/ATB3o.gif'>";
						echo "<script type='text/javascript'>
							    function formSubmit(){
							          document.getElementById('TheForm').submit();
							    }

							    window.onload=function(){
							          window.setTimeout(formSubmit, 3000);
							    };
							  </script>";


				} else {
					//Recherche des abonnements possible selon le profil de la carte
					$sql = "SELECT * FROM titretransport WHERE codep ='".$_SESSION['profil']."';";
					$result = pg_query($sql);

					//vérifiaction de l'execution de la requete
					if (!$result) {
				        echo " Probleme lors du lancement de la requete 1";
				        exit;
			        }
					$ligne = pg_fetch_array($result);


					//Affichage du numéro de carte
					echo "<form method='POST' action='achat_abonnement.php' class='form col-8 offset-2 row'>";
						echo "<div class='my-2 col-12'>";
							echo "<labe class='form-label'>Numéro de carte</label>";
							echo "<input class='form-control' type='text' name='numc' value='".$_SESSION['carte']."' disabled>";
						echo "</div>";
						
						echo "<div class='my-2 col-12'>";
							echo "<label class='form-label'>Abonnement: </label>";
							echo "<select class='form-select' name='abo'>";
								while ($ligne) {
									echo "<option value='".$ligne['codet']."'>".$ligne['libt']."</option>";
									$ligne = pg_fetch_array($result);
								}
							echo "</select>";
						echo "</div>";

						echo "<div class='my-2 col-12'>";
							echo "<label class='form-label'>Date de debut</label>";
							echo "<input class='form-control' type ='date' name='datedebut' required>";
						echo "</div>";

			    		echo "<input align='center' type='submit' value='Acheter' name='valid' class='btn btn-outline-success offset-1 col-4 my-4'>";
			    		echo "<a href='index.php' class='btn btn-outline-danger offset-2 col-4 my-4'>Retour à l'accueil</a>";

					echo "</form>";

				} 
			}


			

		 ?>

	</div>

	
    <!-- Footer -->
  <footer class="bg-dark text-center text-white mt-auto">
    <!-- Grid container -->
    <div class="container-fluid pt-4 p-0 row">
      <!-- Section: Social media -->
      <section class="mb-4 col-12">
        <!-- Facebook -->
        <a class="btn btn-floating m-1" href="https://www.facebook.com/ileviaLille/" role="button">
          <img src="pictures/002-facebook.png">
        </a>

        <!-- Twitter -->
        <a class="btn btn-floating m-1" href="https://twitter.com/ilevia_actu" role="button">
          <img src="pictures/001-twitter.png">
        </a>

        <!-- Instagram -->
        <a class="btn btn-floating m-1" href="instagram.com/ilevia.officiel/?hl=fr" role="button">
          <img src="pictures/003-instagram.png">
        </a>

      </section>
      <!-- Section: Social media -->

      <!-- Section: Text -->
      <section class="mb-4 col-12">
        <p>
          Ilévia - Les transports de la MEL
        </p>
      </section>
      <!-- Section: Text -->

    <!-- Copyright -->
    <div class="text-center p-3 col-12" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2021 Copyright:
      Révillon - Tieha
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
 </div>
</body>
</html>