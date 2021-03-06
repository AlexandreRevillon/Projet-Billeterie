<?php
	include "session.php";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ticket</title>
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
	<div class='container'>
		<div class='col-8 offset-2'>
			<h1 class='text-center my-4'>Achat - Ticket</h1>

			<?php
				extract($_POST);

				if (!isset($validation)) {
					// Validation pas faite: formulaire d'achat

					//Blocage de la validation du formulaire si tout le formulaire n'est pas apparu en entier
						$disabled = "disabled";

					echo "<form action='achat_ticket.php' method='POST' class='form row'>";
						//Affichage de la liste déroulante des stations
							echo "<div class='my-2'>";
								echo "<label class='form-label'>Station: </label>";
								echo "<select name='station' onchange='submit()' class='form-select'>";
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
							echo '</div>';

						echo "<br>";

						if (isset($station) && ($station != 'null')) {
							//Si station choisie, affichage de la liste des bornes de la station

							//Affichage de la liste déroulante des bornes
								echo "<div class='my-2'>";
									echo "<label class='form-label'>Borne de recharge: </label>";
									echo "<select name='borne' onchange='submit()' class='form-select'>";
											echo "<option value='null'>---Veuillez choisir une borne de recharge---</option>";

												//Requete de selection des bornes reliées à la station
													$sql2="SELECT * from bornerecharge where nums = $station;";
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
															$selected2 = ($borne == $ligne2['codebr']) ? "selected" :"" ;
														}
														echo "<option value='".$ligne2['codebr']."' $selected2> Borne n°".$ligne2['codebr']."</option>";
														$ligne2=pg_fetch_array($result2);
													}
									echo "</select>";
								echo "</div>";
						}

				 		echo "<br><br>";

					 	if (isset($station) && ($station != 'null') && isset($borne) && ($borne != 'null')){
							//Si station et borne choisies, affichage des titres de transports

							//Requete de selection des titres de transport hors abonnement
								$sql3="SELECT * from titretransport where codep is null;";
								$result3=pg_query($sql3);

							//Vérification du lancement de la requête
								if (!$result3) {
									echo  "Probleme lors du lancement de la requete 3";
									exit;
								}

							//lecture des resultats et affichage des différents titres avec un champs nombre
								$ligne3=pg_fetch_array($result3);
								while($ligne3){
									//Affichage du titre dans le formulaire
										$max = ($ligne3['type']=='Pass') ? 1 : 20 ;
										echo "<div class='my-2 ".(($ligne3['type']=='Pass') ? 'col-6' : '' )."'>";
											echo "<label class='form-label'>".$ligne3['libt']." (".number_format($ligne3['prix'], 2, ',', ' ')."€)</label> <input class='form-control' type='number' min='0' max='$max' value='0' name='".$ligne3['codet']."'>";
										echo "</div>";
									//Si Pass, saisir la date du debut
										echo ($ligne3['type']=='Pass') ? "<div class='my-2 col-6'><label class='form-label'>Date de début</label><input class='form-control' type='date' name='date".$ligne3['codet']."'></div>" : "";

										echo "<br>";
										$ligne3=pg_fetch_array($result3);
								}

							echo "<br>";

							//Affichage du champ texte pour le numéro de la carte
								echo "<div class='my-2'>";
									echo "<label class='form-label'>Numéro de carte</label>";
									$value_carte = (isset($_SESSION['carte'])) ? "value=".$_SESSION['carte'] : "" ;
									echo "<input class='form-control' type='text' name='numc' placeholder='000000' $value_carte required>";
								echo "</div>";

							echo "<br>";

							//Tout le formulaire est affiché: on active la possibilité de valider le formulaire
							$disabled = "";
						}

					 	echo "<br>";

						//Affichage des bouton en bas du formulaire
						 	echo "<input type='submit' class='btn btn-outline-success offset-2 col-3 my-4' name='validation' value='Acheter' $disabled>";
						 	echo "<a href='index.php' class='btn btn-outline-danger offset-2 col-3 my-4'>Annuler</a>";

					echo "</form>";

				} else if (isset($transact)) {
						//validation faite: Traitement de l'achat

						//Controle des données saisies dans le formulaire
							//Recherche du numéro de carte dans la base
								$sql4="SELECT * from carte where numc = '$numc';";
								$result4=pg_query($sql4);

							//Vérification du lancement de la requête
								if (!$result4) {
									echo  "Probleme lors du lancement de la requete 4";
									exit;
								}

							//Vérification de l'existance du numéro de carte
								$ligne4=pg_fetch_array($result4);
								if ($ligne4['numc']==$numc) {
									//La carte existe: ajout des titres de transport sur la Carte
									//Recherche des titres existants dans la base
										$sql="SELECT * from titretransport where codep is null;";
										$result=pg_query($sql);

									//Vérification du lancement de la requête
										if (!$result) {
											echo  "Probleme lors du lancement de la requete 5";
											exit;
										}

									$i = 6;
									$ligne=pg_fetch_array($result);
									while ($ligne) {
										if ($_POST[$ligne['codet']] != 0) {
											//Si quantité saisi différente de 0
												if ($ligne['type'] != 'Pass') {
													// Si trajet zap ou Unitaire
														//vérification si deja créer dans la base
															$sql2="SELECT * from soldecarte WHERE numc = $numc and codet = '".$ligne['codet']."';";
															$result2=pg_query($sql2);

														//Vérification du lancement de la requête
															if (!$result2) {
																echo  "Probleme lors du lancement de la requete $i";
																exit;
															}
															$i++;

														$ligne2=pg_fetch_array($result2);
														if ($ligne2['numc'] == 0) {
															//TU ou TZ n'existe pas, création de la ligne
															$sql3 = "INSERT INTO soldecarte VALUES ($numc, '".$ligne['codet']."', '".date('Y-m-d')."', ".$_POST[$ligne['codet']].")";
														} else {
															//TU ou TZ existe, incrémentation de la quantité de la ligne
															$sql3= "UPDATE soldecarte SET quantite = quantite+".$_POST[$ligne['codet']]." WHERE numc = $numc and codet = '".$ligne['codet']."';";
														}
												} else {
													$sql3 = "INSERT INTO soldecarte	VALUES ($numc, '".$ligne['codet']."', '".$_POST['date'.$ligne['codet']]."', ".$_POST[$ligne['codet']].")";
												}

												//Ajout du solde pour ce titre sur la carte
													$result3=pg_query($sql3);

												//Vérification du lancement de la requête
													if (!$result3) {
														echo  "Probleme lors du lancement de la requete $i";
														echo $sql3;
														exit;
													}
												$i++;

											//Ajout dans l'historique des achats
												$sql3 = "INSERT INTO recharge VALUES ($numc, '".$ligne['codet']."', $borne, '".date('Y-m-d h:i:s')."', ".$_POST[$ligne['codet']].")";
												$result3=pg_query($sql3);
											//Vérification du lancement de la requête
													if (!$result3) {
														echo  "Probleme lors du lancement de la requete $i";
														echo $sql3;
														exit;
													}
												$i++;
										}
										$ligne=pg_fetch_array($result);
									}

									echo "<h2 class='text-center'>Paiement réussi</h2>";
									echo "<a href='index.php' class='btn btn-outline-info col-4 offset-4 my-4'>Retour à l'accueil</a>";

								} else {
									//La carte n'existe pas, retour au formulaire avec données pré-remplies
									echo "<h2 class='text-center'>La carte '$numc' n'existe pas, le paiement n'a pas abouti</h2>";
									echo "<a href='index.php' class='btn btn-outline-info col-3 offset-2 my-4'>Retour à l'accueil</a>";
									echo "<a href='achat_ticket.php' class='btn btn-outline-info col-3 offset-2 my-4'>Retour au formulaire</a>";
								}
					} else {
						//Simulation de paiement en cours
						echo "<form method='POST' action='achat_ticket.php' id='TheForm'>";
							foreach ($_POST as $key => $value) {
								echo "<input type='hidden' name='$key' value='$value'>";
							}
							echo "<input type='hidden' name='transact' value='1'>";
						echo "</form>";
						echo "<h2 class='text-center'>Paiement en cours</h2>";
						echo "<img src='https://i.stack.imgur.com/ATB3o.gif' class='col-4 offset-4'>"; 
						echo "<script type='text/javascript'>
							    function formSubmit(){
							          document.getElementById('TheForm').submit();
							    }

							    window.onload=function(){
							          window.setTimeout(formSubmit, 3000);
							    };
							  </script>";
					}
			?>
		</div>
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
