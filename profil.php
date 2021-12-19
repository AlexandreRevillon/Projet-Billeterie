<?php 
    include "session.php"; 
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profil</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type='text/javascript'>
		function submitBday() {
		    var Bdate = document.getElementById('bday').value;
		    var Bday = +new Date(Bdate);
		    var Age = ~~ ((Date.now() - Bday) / (31557600000))+'ans';
		    var theBday = document.getElementById('resultBday');
		    theBday.innerHTML = Age;
		}
	</script>
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
		<h1 class="text-center my-4">Profil</h1>

		
		<?php 
			include 'Fonctions.php';
			//Connexion à la base de données
    			include "connexion.php";
    			$con=connect();
    			if (!$con) {
        			echo "Probleme de connexion à la base";
        			exit;
     			}

     		extract($_POST);	

     		if (isset($modif)) {
     			//Récupération des informations de l'utilisateur
	     			$sql = "UPDATE utilisateur SET nom='$nom', prenom='$prenom', dn='$dn', email='$email', adresse='$adresse' WHERE numu ='".$_SESSION['user']."';";
	     			$result = pg_query($sql);
	     			
	     		//Vérification de l'execution de la requete
					if (!$result) {
						echo  "Probleme lors du lancement de la requete 1";
						exit;
					} else {
						echo "<h3 class='text-center my-4'>Modification éfféctuées</h3>";
					}
     		}



     		//Récupération des informations de l'utilisateur
     			$sql = "SELECT * FROM utilisateur WHERE numu ='".$_SESSION['user']."';";
     			$resultat = pg_query($sql);
     			$user = pg_fetch_array($resultat);


     		//Récupération des information de la carte associée
     			$sql2 = "SELECT * FROM utilisateur NATURAL JOIN carte;";
     			$resultat = pg_query($sql);
     			$carte = pg_fetch_array($resultat);
		 ?>
		
		<div class='col-8 offset-2'>
			<h2>Informations personnelles:</h2>

			<form action="profil.php" method="POST">
				<div class='input-group my-3'>
					<span class='input-group-text col-3'>Nom</span>
					<input name="nom" class='form-control' value='<?php echo $user['nom'];?>'>
				</div>

				<div class='input-group my-3'>
					<span class='input-group-text col-3'>Prénom</span>
					<input name='prenom' class='form-control' value='<?php echo $user['prenom']; ?>'>
				</div>

				<div class='input-group my-3'>
					<span class='input-group-text col-3'>Date de naissance</span>
					<input onchange="submitBday()" id='bday' name="dn" class='form-control' type='date' value='<?php echo date('Y-m-d',strtotime($user['dn']));?>'>
					<span class='input-group-text' id='resultBday'> <?php echo age($user['dn'])." ans"; ?></span>
				</div>

				<div class='input-group my-3'>
					<span class='input-group-text col-3'>Adresse</span>
					<input name="adresse" class='form-control' value='<?php echo $user['adresse']; ?>'>
				</div>

				<div class='input-group my-3'>
					<span class='input-group-text col-3'>Email</span>
					<input name="email" class='form-control' value='<?php echo $user['email']; ?>'>
				</div>

				<input type="submit" name="modif" class="btn btn-outline-success offset-2 col-3" value="Modifier">
				<input type="reset" name="modif" class="btn btn-outline-danger offset-2 col-3" value="Annuler">
			</form>


			<h2 class="my-4">Informations carte :</h2>
			<?php 
				if (!isset($_SESSION['carte'])) {
					echo "<p>Aucune carte associé à ce compte</p>";
				} else {
					echo "<p>Numéro de carte : ".$_SESSION['carte']."</p>";
					
					//Récupération des informations concernant l'abonnement
	     			$sql3 = "SELECT * FROM titretransport WHERE codet ='".$user['codet']."';";
	     			$resultat = pg_query($sql3);
	     			$abo = pg_fetch_array($resultat);

	     			if (isset($abo['libt'])) {
	     				$echeance = date('d/m/Y', strtotime($user['datedebutabo']. ' + '.$abo['dureevalidjour'].' days'));
	     				echo "<p>Abonnement : ".$abo["libt"]."</p>";
	     				echo "<p>Date d'échéance: $echeance</p>";
	    			} else {
	     				echo "<p>Abonnement : Pas d'abonnement en cours</p>";
	     			}
					echo "<h3>Contenu de la carte :</h3>";

					//Récupération des information du solde de la carte
		     			$sql4 = "SELECT soldecarte.*, libt, type FROM soldecarte natural join titretransport WHERE numc = ".$_SESSION['carte'].";";
		     			$resultat = pg_query($sql4);
		     			$solde = pg_fetch_array($resultat);

		     			echo "<ul>";
		     			while ($solde) {
		     				echo "<li>".$solde['libt']." - ".$solde['quantite'].(($solde['type'] == 'Pass')? " - Début: ".date('d/m/Y',strtotime($solde['datedebut'])) : "")."</li>";
		     				$solde = pg_fetch_array($resultat);
		     			}
		     			echo "</ul><br>";

		     			echo "<div clas='my-4 row'>";
							echo "<a href='histo_valid.php' class='btn btn-info col-12 my-2'>Historique des validations</a>";		
							echo "<a href='histo_achat.php' class='btn btn-info col-12 my-2'>Historique des achats</a>";
							echo "<a href='statistique.php' class='btn btn-info col-12 my-2'>Statistiques</a>";
						echo "</div>";
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
