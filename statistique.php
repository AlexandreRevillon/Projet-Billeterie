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
	<h1 class="text-center my-4">Statistiques</h1>
	<?php 
			include 'Fonctions.php';
			//Connexion à la base de données
    			include "connexion.php";
    			$con=connect();
    			if (!$con) {
        			echo "Probleme de connexion à la base";
        			exit;
     			}
	$sql="select 
    libs, 
    CASE WHEN nbvalid is null THEN 0 ELSE nbvalid END AS nbvalid2, 
    CASE WHEN nbrecharge is null THEN 0 ELSE nbrecharge END AS nbrecharge2 
from 
    (select s.nums, s.libs, count(*) as nbvalid from validation natural join bornevalidation natural join station s where numc=".$_SESSION['carte']." group by s.nums ) as valid  natural full  join 
    (select s.nums, s.libs, count(*) as nbrecharge from recharge natural join bornerecharge natural join station s where numc=".$_SESSION['carte']." group by s.nums) as recharge;";

    $result=pg_query($sql);
//Vérification du lancement de la requête
if (!$result) {
echo  "Probleme lors du lancement de la requete ";
exit;
}
?>
    
	<table class="table text-center table-hover table-striped">
	<thead>
	<tr><th>Station</th><th>Nombre de validations</th><th>Nombre de Rechargement</th>
	</thead>
	</tr>
	<?php 
	$ligne=pg_fetch_array($result);
	while($ligne){
        echo "<tr><td>".$ligne['libs']."</td><td>".$ligne['nbvalid2']."</td><td>".$ligne['nbrecharge2']."</td></tr>";
        $ligne=pg_fetch_array($result);
}
	?>
	</table>
    </div>
	</body>
</html>
