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
	include "Fonctions.php";
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
		<h1 class="text-center my-4">Validation</h1>
		<br>

		<?php
			extract($_POST);

			if (!isset($validborne) && !isset($validtitre)) {
				// Validation pas faite: formulaire d'achat

				//Blocage de la validation du formulaire si tout le formulaire n'est pas apparu en entier
					$disabled = "disabled";

				echo "<form action='validation.php' method='POST'>";
					//Affichage de la liste déroulante des stations
						echo "<label>Station: </label>";
						echo "<select name='station' onchange='submit()'>";
								echo "<option value='null'>--- Veuillez choisir une station---</option>";

								//Requete de selection des stations
									$sql1="SELECT * from station order by 1;";
									$result1=pg_query($sql1);

								//Vérification de l'execution de la requete
									if (!$result1) {
										echo  "Probleme lors du lancement de la requete 1";
										exit;
									}

								//lecture des resultats et affichage en liste déroulante
									$ligne1=pg_fetch_array($result1);
									while($ligne1){
										if (isset($station)) {
											$selected = ($station == $ligne1['nums']) ? "selected" :"" ;
										}
										echo "<option value='".$ligne1['nums']."' $selected>".$ligne1['libs']."</option>";
										$ligne1=pg_fetch_array($result1);
									}
							echo "</select>";

					echo "<br>";

					if (isset($station) && ($station != 'null')) {
						//Si station choisie, affichage de la liste des bornes de la station

						//Affichage de la liste déroulante des bornes
							echo "<label>Borne de validation: </label>";
							echo "<select name='borne' onchange='submit()'>";
									echo "<option value='null'>---Veuillez choisir une borne de validation---</option>";

										//Requete de selection des bornes reliées à la station
											$sql2="SELECT * from bornevalidation where nums = $station;";
											$result2=pg_query($sql2);

										//Vérification du lancement de la requête
											if (!$result2) {
												echo  "Probleme lors du lancement de la requete 2";
												exit;
											}

										//lecture des resultats et affichage en liste déroulante
											$ligne2=pg_fetch_array($result2);
											while($ligne2){
												if (isset($station)) {
													$selected2 = ($borne == $ligne2['codebv']) ? "selected" :"" ;
												}
												echo "<option value='".$ligne2['codebv']."' $selected2> Borne n°".$ligne2['codebv']."</option>";
												$ligne2=pg_fetch_array($result2);
											}
							echo "</select>";
					}

			 		echo "<br><br>";

				 	if (isset($station) && ($station != 'null') && isset($borne) && ($borne != 'null')){
						//Affichage du champ texte pour le numéro de la carte
							echo "<label>Numéro de carte</label>";
							$value_carte = (isset($_SESSION['carte'])) ? "value=".$_SESSION['carte'] : "" ;
							echo "<input type='text' name='numc' placeholder='000000' $value_carte required>";

						echo "<br>";

						//Tout le formulaire est affiché: on active la possibilité de valider le formulaire
						$disabled = "";
					}

				 	echo "<br>";

					//Affichage des bouton en bas du formulaire
					 	echo "<input type='submit' class='btn btn-outline-success' name='validborne' value='Valider' $disabled>";
					 	echo "<a href='index.php' class='btn btn-outline-danger'>Annuler</a>";

				echo "</form>";

			} else if (!isset($validtitre)){
				//Récupération du solde de la carte
					//Requete de selection destitres de transport sur la carte
						$sql="SELECT * from soldecarte natural join titretransport where numc = $numc;";
						$result=pg_query($sql);

					//Vérification du lancement de la requête
						if (!$result) {
							echo  "Probleme lors du lancement de la requete 3";
							exit;
						}

					//Récupération du solde de la carte
						$solde=pg_fetch_all($result, PGSQL_ASSOC);

				//Vérification de la présence d'un abonnement si la carte est une carte personnelle
					//Vérification du type de carte
						$sql = "SELECT * FROM carte where numc = $numc";
						$result=pg_query($sql);

					//Vérification du lancement de la requête
						if (!$result) {
							echo  "Probleme lors du lancement de la requete 4";
							exit;
						}

					//Récupération du type de la carte
						$ligne=pg_fetch_array($result);

					if ($ligne['codetype'] == 'CP') {
						//Vérification du type de carte
							$sql = "SELECT * FROM utilisateur natural join carte where numc = $numc";
							$result=pg_query($sql);

						//Vérification du lancement de la requête
							if (!$result) {
								echo  "Probleme lors du lancement de la requete 4";
								exit;
							}


						//Récupération du type de la carte
							$ligne=pg_fetch_array($result);
							if (isset($ligne['codet'])) {
								//Ajout dans la table validation
									//Requete d'ajout dans la base
										$sql = "INSERT INTO validation VALUES ($numc, '".$ligne['codet']."', $borne, '".date('Y-m-d H:i:s')."', 1) ";
										$result=pg_query($sql);

									//Vérification du lancement de la requête
										if (!$result) {
											echo  "Probleme lors du lancement de la requete 4";
											exit;
										}

								//Récupération du libellé de l'abonnement utilisé
									//Recherche dans la base
										$sql = "SELECT libt From titretransport where codet = '".$ligne['codet']."';";
										$result=pg_query($sql);

									//Vérification du lancement de la requête
										if (!$result) {
											echo  "Probleme lors du lancement de la requete 4";
											exit;
										}

									//Récupération du libellé
										$ligne=pg_fetch_array($result);
										echo "<h2>Carte validée, abonnement utilisé: ".$ligne['libt']."</h2>";
										echo "<a href='index.php' class='btn btn-outline-primary'>Retour à l'accueil</a>";
								exit;
							}
					} 
					


				//Vérification de la présence d'un Pass en cours de validité
					foreach ($solde as $key => $titre) {
						if ($titre['type']=="Pass") {
							//Recherche dans la base
								$sql = "SELECT * From titretransport where codet = '".$titre['codet']."';";
								$result=pg_query($sql);

							//Vérification du lancement de la requête
								if (!$result) {
									echo  "Probleme lors du lancement de la requete 4";
									exit;
								}

							//Récupération du libellé
								$ligne=pg_fetch_array($result);


							//Vérification date de validité
								if ( date('Y-m-d')<$titre['datedebut'] && $titre['datedebut']<date('Y-m-d',strtotime($titre['datedebut'].' + '.$ligne['dureevalidjour'].' days'))) {
									//Ajout dans la table validation 
										$sql = "INSERT INTO validation VALUES ($numc, '".$titre['codet']."', $borne, '".date('Y-m-d H:i:s')."', 1)";
										$result=pg_query($sql);

									//Vérification du lancement de la requête
										if (!$result) {
											echo  "Probleme lors du lancement de la requete 4";
											exit;
										}
									echo "<h2>Carté validée, pass utilisée : ".$ligne['libt']." </h2>";
									echo "<a href='index.php' class='btn btn-outline-primary'>Retour à l'accueil</a>";
									exit;
								 } 

						}
					}


				//Supression des Pass dans le tablaeu des titres de transports
					$solde = removeElementWithValue($solde, 'type', 'Pass');


				//Vérification de la présence de titres sur la carte
					if ($solde == "" || count($solde) == 0) {
						echo "<h2>Il n'y a aucun titre de transport à valider sur cette carte</h2>";
						echo "<a href='index.php' class='btn btn-outline-primary'>Retour à l'accueil</a>";
						exit;
					}

				//Choix du titre de transport à utiliser
					echo "<form method='POST' action='validation.php'>";
					foreach ($solde as $key => $titre) {
						if ($titre['type']!="Pass") {
							echo "<input type='radio' name='titrevalid' id='".$titre['codet']."' value='".$titre['codet']."'><label for='".$titre['codet']."'>".$titre['libt']."</label>";
							echo "<br>";
						}
					}
		    		echo "<input align='center' type='submit' value='Valider' name='validtitre' class='btn btn-outline-success'>";
		    		echo "<a href='index.php' class='btn btn-outline-danger'>Retour à l'accueil</a>";
					echo "</form>";

			} else {
				echo "Carte validé avec le titre $titrevalid";
			}
		?>
	</div>

</body>
</html>