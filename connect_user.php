<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

	<div class="container">

		<h1 class="text-center">Connexion</h1>

		<?php 
			//Connexion à la base de données
    			include "connexion.php";
    			$con=connect();
    			if (!$con) {
        			echo "Probleme de connexion à la base";
        			exit;
     			}

     		//Récupération des données du formulaire
				extract($_POST);


			if (isset($email) && isset($mdp)) {
				$sql= "SELECT email, password FROM utilisateur WHERE email = '$email';";
				$resultat=pg_query($sql);

			    if (!$resultat) {
			        echo " Probleme lors du lancement de la requete 1";
			        exit;
			    }
    			
    			$ligne=pg_fetch_array($resultat);
    			$hash = $ligne['password'];

    			if (password_verify($mdp, $hash)){
    				echo "Connexion réussie";
   					echo "<a href='index.php'>Retour à l'accueil</a>";
    			} else {
    				echo "Connexion échouée, email et/ou mot de passe incorrect";
    				echo "<a href='connect_user.php'>Retour au formulaire</a>";
    			}
			} else {
				echo "<form action='#' method='POST'>";
					echo "<label>Email:</label>";
					echo "<input type='email' name='email' required>";

					echo "<br>";

					echo "<label>Mot de passe</label>";
					echo "<input type='password' name='mdp' required>";

					echo "<br>";

		    		echo "<input align='center' type='submit' value=\"S'inscrire\" class='btn btn-outline-success'>";
		    		echo "<a href='index.php' class='btn btn-outline-danger'>Retour à l'accueil</a>";
				echo "</form>";
			}
		 ?>

	</div>
	
</body>
</html>