<?php 
 function connect()
 {
 $con=pg_connect("host=serveur-etu.polytech-lille.fr user=mtieha port=5432 password=postgres  dbname=projet_billetterie_electronique");
 return $con;
 }
 ?>
