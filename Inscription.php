<html>
<?php
include "connexion.php";
$con=connect();
?>
<h1 align="center"> Inscrivez-vous</h1>
<form action="inscrire.php" method=POST>
<table>
    <tr>
        <td>Entrez votre nom :</td><td><input type="text" name="nom" required></td></tr>
    <tr>
        <td>Entrez votre prenom :</td><td><input type="text" name="prenom"></td>
    </tr>
    <tr>
        <td>Date de naissance : </td><td><input type=date name="dn"></td></tr>
    <tr><td>Adresse : </td><td>N° et nom de rue : <input type="text" name="adresserue"></td></tr>
    <tr>
        <td /><td>Code postal : <input type="text" name="codepostal"></td>
    </tr>
    <tr>
        <td>Mot de passe : </td><td><input type="password" name="mdp" required></td>
    </tr>
    <tr>
        <td> Confirmez votre mot de passe : </td><td><input type="password" name="mdp"></td>
    </tr>
</table>
</form>
</html>
