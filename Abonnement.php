<html>
<?php
include "connexion.php";
$con=connect();
if (!$con) {
    echo "Probleme de connexion à la base";
    exit;
 }
?>
<h1 align="center">Abonnements</h1>
<ul>
    <li><a href="Abonnement.php"/>Tous les abonnements</li>
    <li><a href="Tpublic.php"/>Tout Public</li>
    <li><a href="Social.php"/>Tarification Sociale</li>
    <li><a href="basique.php"/>4-25 ANS</li>
    <li><a href="Mature.php"/>65 ANS et +</li>
    <li><a href="ticket.php"/>Titres Occasionnels</li>
</ul>

</html>
