<?php 
    include "session.php"; 
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
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
     	?>


			
			<?php 
				extract($_POST);

				if (isset($carte)){
					$sql="SELECT * from carte where numc=$carte";
					$result=pg_query($sql);

				//Vérification de l'execution de la requete
			      if (!$result) {
			          echo  "Probleme lors du lancement de la requete ";
			          exit;
			      }

			     $ligne=pg_fetch_array($result);

			    if (isset($ligne['numc'])){
			    	echo "<h2 class='my-4'>Informations carte :</h2>";

					echo "<p>Numéro de carte : $carte</p>";
	     			
					echo "<h3>Contenu de la carte :</h3>";

					//Récupération des information du solde de la carte
		     			$sql4 = "SELECT soldecarte.*, libt FROM soldecarte natural join titretransport WHERE numc = $carte;";
		     			$resultat = pg_query($sql4);
		     			$solde = pg_fetch_array($resultat);

		     			echo "<ul>";
		     			while ($solde) {
		     				echo "<li>".$solde['libt']." - ".$solde['quantite']."</li>";
		     				$solde = pg_fetch_array($resultat);
		     			}
		     			echo "</ul><br>";
				
					echo "<div class='my-4 row'>";
						echo "<a href='histo_valid.php?carte=$carte' class='btn btn-info col-12 my-2'>Historique des validations</a>	";	
						echo "<a href='histo_achat.php?carte=$carte' class='btn btn-info col-12 my-2'>Historique des achats</a>";
						echo "<a href='statistique.php?carte=$carte' class='btn btn-info col-12 my-2'>Statistiques</a>";
					echo "</div>";
			    } else {
			    	echo "<h2 class='text-center my-2'>Ce numéro de carte n'existe pas</h2>";
			    	echo "<a href='index.php' class='btn btn-outline-info col-2 offset-5 my-4'>Retour à l'accueil</a>";
			    }

				} else {
					echo "<form method='POST' action='carte.php' class='form col-8 offset-2'>";
						echo "<div class='col-12'>";
							echo "<label class='form-label'>Numéro de carte</label>";
							echo "<input class='form-control' name='carte' placeholder='000000'>";
						echo "</div>";
						echo "<input type='submit' value='Valider' class='btn btn-outline-success col-4 offset-1 my-4'>";
						echo "<a href='index.php' class='btn btn-outline-danger col-4 offset-2 my-4'>Retour à l'accueil</a>";
					echo "</form>";
				}
			?>
		</div>
	</div>


</body>
</html>
