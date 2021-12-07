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
	            <li><a class="dropdown-item" href="#">Carte</a></li>
	            <li><hr class="dropdown-divider"></li>
	            <li><a class="dropdown-item" href="#">Abonnement</a></li>
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
	                    echo "<a class='nav-link active' href='Inscription.php'>Inscription</a>";
	                echo "</li>";

	                echo " <li class='nav-item'>";
	                    echo "<a class='nav-link active' href='connect_user.php'>Connexion</a>";
	                echo "</li>";
	            } else {
	                echo " <li class='nav-item'>";
	                    echo "<a class='nav-link active' href='disconnect.php'>Déconnexion</a>";
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
<?php  
extract($_POST);
?>
	<h2 align="center">Achat de ticket</h2>
<form method="POST" action="ajoutTicket.php">
<div align="center">Entrez votre numero de carte :<input type="integer" name="numc"></div></br></br>
<table align="center">
    <tr>
        <td>Nombre de tickets<td><td>Ticket<td><td><td><td>Prix unitaire<td>
    <tr>
    <tr>
        <td><input type="number" name="unitaire" value="0"><td><td>Trajet Unitaire<td><td>1,70€<td>
    <tr>
    <tr>
        <td><input type="number" name="zap" value="0"><td><td>Trajet Zap<td><td><td><td>1,10€<td>
    <tr>
    <tr>
        <td><input type="number" name="soiree" value="0"><td><td>Pass Soirée <td><td><td><td>2,40€<td>
    <tr>
    <tr>
        <td><input type="number" name="Jour" value="0"><td><td>Pass 1 jour<td><td><td><td>5,10€<td>
    <tr>
    <tr>
        <td><input type="number" name="2jours" value="0"><td><td>Pass 2jours<td><td><td><td>9,30€<td>
    <tr>
    <tr>
        <td><input type="number" name="3jours" value="0"><td><td>Pass 3 jours<td><td><td><td>12,5€<td>
    <tr>
    <tr>
        <td><input type="number" name="4jours" value="0"><td><td>Pass 4 jours<td><td><td><td>14,40€<td>
    <tr>
    <tr>
        <td><input type="number" name="5jours" value="0"><td><td>Pass 5 jours<td><td><td><td>16,10€<td>
    <tr>
    <tr>
        <td><input type="number" name="6jours" value="0"><td><td>Pass 6 jours<td><td><td><td>17,10€<td>
    <tr>
    <tr>
        <td><input type="number" name="7jours" value="0"><td><td>Pass 7 jours<td><td><td><td>17,70€<td>
    <tr>

    <tr>
        <td><input type="submit" value="Valider"><td><td><td>
        <td><input type="reset" value="Réinitialiser"><td>
    <tr>
</table>
<input type="hidden" name="nums" value='$nums'>
<input type="hidden" name="codebr" value='$codebr'>
</form>
</html>
