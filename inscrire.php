<html>
<?php
include "connexion.php";
include "Fonctions.php";
$con=connect();
if (!$con) {
    echo "Probleme de connexion à la base";
    exit;
 }
extract($_POST);
//Boucle d'incrémentation du numero unique(numu) associé à chaque utilisateur
$numu="select max(numu) as max from utilisateur";
$resultat=pg_query($numu);

if (!$resultat) {
    echo " Probleme lors du lancement de la requete 1";
    exit;
    }
$ligne=pg_fetch_array($resultat);


$id = $ligne['max']+1;
//Insertion du nouvel utilisateur dans la base
$sql="insert into utilisateur values ($id,'$nom','$prenom','$dn','$adresserue $codepostal',".codep($dn).",NULL,".datedebutabo().");";

$result=pg_query($sql);

if (!$result) {
    echo " Probleme lors du lancement de la requete 2";
    exit;
    }
else {
    echo "Inscription validée";
    echo "<a><href='Accueil.html'>Retour</a>";
}
?>



</html>
