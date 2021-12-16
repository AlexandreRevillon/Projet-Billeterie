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
		<h1 class="text-center my-4">Achat - Abonnement</h1>
		<br>
		<?php 

			extract($_POST);

			if ($_SESSION['user']=="NA") {
				//utilisateur pas connecté
					echo "<h2 class='text-center'>Veuillez vous connecter ou vous inscrire d'abord</h2>";
			} else if (!isset($_SESSION['carte'])) {
				//utilisateur n'a pas de carte
					echo "<h2 class='text-center'>Vuos devez posséder une carte nominative pour pouvoir prendre un abonnement</h2>";
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
						echo "<h2>Vous possédez déjà un abonnement en cours de validité</h2>";
						echo "<a href='index.php' class='btn btn-outline-primary'>Retour à l'accueil</a>";
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

					echo "<h2>Paiement réussi</h2>";
					echo "<a href='index.php' class='btn btn-outline-primary'>Retour à l'accueil</a>";


				} else if (isset($valid)){
					//Simulation de paiement en cours
						echo "<form method='POST' action='achat_abonnement.php' id='TheForm'>";
							foreach ($_POST as $key => $value) {
								echo "<input type='hidden' name='$key' value='$value'>";
							}
							echo "<input type='hidden' name='transact' value='1'>";
						echo "</form>";
						echo "<h2>Paiement en cours</h2>";
						echo "<img src='https://i.stack.imgur.com/ATB3o.gif'>";
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
					echo "<form method='POST' action='achat_abonnement.php'>";
						echo "<label>Numéro de carte</label>";
						echo "<input type='text' name='numc' value='".$_SESSION['carte']."' disabled>";

						echo "<br>";

						echo "<label>Abonnement: </label>";
						echo "<select name='abo'>";

							while ($ligne) {
								echo "<option value='".$ligne['codet']."'>".$ligne['libt']."</option>";
								$ligne = pg_fetch_array($result);
							}

						echo "</select>";

						echo "<br>";

						echo "<label>Date de debut</label>";
						echo "<input type ='date' name='datedebut' required>";

						echo "<br>";

			    		echo "<input align='center' type='submit' value='Acheter' name='valid' class='btn btn-outline-success'>";
			    		echo "<a href='index.php' class='btn btn-outline-danger'>Retour à l'accueil</a>";

					echo "</form>";

				} 
			}


			

		 ?>

	</div>

</body>
</html>