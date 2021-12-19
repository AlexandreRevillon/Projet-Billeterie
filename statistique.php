<?php 
    include "session.php"; 
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Statistiques carte</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
	<h1 class="text-center my-4">Statistiques</h1>

  <h2 class="text-center my-4">Validations et recharge</h2>
	<?php 
			include 'Fonctions.php';
			//Connexion à la base de données
    			include "connexion.php";
    			$con=connect();
    			if (!$con) {
        			echo "Probleme de connexion à la base";
        			exit;
     			}
      extract($_GET);

      $carte = (isset($carte)) ? $carte : $_SESSION['carte'];

      	$sql="select 
                  libs, 
                  CASE WHEN nbvalid is null THEN 0 ELSE nbvalid END AS nbvalid2, 
                  CASE WHEN nbrecharge is null THEN 0 ELSE nbrecharge END AS nbrecharge2 
              from 
                  (select s.nums, s.libs, count(*) as nbvalid from validation natural join bornevalidation natural join station s where numc=$carte group by s.nums ) as valid  natural full  join 
                  (select s.nums, s.libs, count(*) as nbrecharge from recharge natural join bornerecharge natural join station s where numc=$carte group by s.nums) as recharge;";

          $result=pg_query($sql);
      //Vérification du lancement de la requête
        if (!$result) {
        echo  "Probleme lors du lancement de la requete ";
        exit;
        }
  ?>
          
	<table class="table text-center table-hover table-striped">
  	<thead>
  	 <tr>
        <th>Station</th>
        <th>Nombre de validations</th>
        <th>Nombre de Rechargement</th>
    </tr>
  	</thead>
    <tbody>
  	<?php 
    	$ligne=pg_fetch_array($result);
    	while($ligne){
            echo "<tr><td>".$ligne['libs']."</td><td>".$ligne['nbvalid2']."</td><td>".$ligne['nbrecharge2']."</td></tr>";
            $ligne=pg_fetch_array($result);
      }
    ?>
    </tbody>
  </table>

  <h2 class='text-center mt-5'>Nombre de trajet par mois sur l'année 2021</h2>

  <div class='row'>
      <div class='col-2'>
          <table class='table-striped table-hover text-center table'>
              <?php 
                $tabmois = array(1 => 'Janv', 2 =>'Fev', 3 =>'Mars',4 =>'Avril', 5 =>'Mai', 6 =>'Juin',7 =>'Juil' ,8 =>'Août', 9 =>'Sept', 10 =>'Oct', 11 =>'Nov', 12 =>'Dec');
                
                $data = array();
                foreach ($tabmois as $num => $mois) {
                    echo "<tr>";
                    echo "<th>$mois</th>";

                    $sql = "SELECT count(*) as nbvalid FROM validation Where extract(YEAR FROM dateheurevalid) = 2021 and extract(MONTH FROM dateheurevalid) = $num and numc = $carte";
                    $result = pg_query($sql);

                    //Vérification du lancement de la requête
                        if (!$result) {
                        echo  "Probleme lors du lancement de la requete ";
                        exit;
                        }

                    $ligne = pg_fetch_array($result);

                    echo "<td>".$ligne['nbvalid']."</td>";
                    echo "</tr>";

                    array_push($data, $ligne['nbvalid']);
                }
                

               ?>
           </table>
       </div>
       <div class='offset-1 col-9'>
          <canvas id="myChart" class='h-100'></canvas>

          <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo "'".implode("','", $tabmois)."'"; ?>],
                    datasets: [{
                        label: 'Nombre de trajet',
                        data: [<?php echo implode(',', $data); ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
       </div>
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
