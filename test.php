<?php 

include("connexion.php");
$con=connect();

//(toujours) verifier que la connexion est etablie
if (!$con){
	echo "Probleme connexion Ã  la base";
	exit;
}

$sql = "SELECT nums from station order by 1;";
$resultat=pg_query($sql);
$i = 1;

foreach (pg_fetch_all($resultat) as $ligne) {
	$max = random_int(1, 6);
	for ($j=0; $j < $max ; $j++) { 
		$sql2 = "INSERT INTO bornerecharge VALUES ('$i', '".$ligne['nums']."');";
		$i=$i+1;
		$resultat=pg_query($sql2);
	}
}



 ?>