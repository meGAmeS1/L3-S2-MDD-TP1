<?php 
include("./includes/connect.php");

$requete = "SELECT compte FROM internaute WHERE identifiant = '" . $_SESSION['user'] . "';";
$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;
if (mysqli_num_rows($resultat) == false) $reqfail = 1;
$compte = mysqli_fetch_array($resultat);
$compte = $compte[0];

$requete = "SELECT categorie, carburant, consommation, volume_reservoir, volume_restant, kilometrage FROM vehicule WHERE proprietaire = '" . $_SESSION['user'] . "';";
$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;
if (mysqli_num_rows($resultat) == false) $reqfail = 1;
$vehicule = mysqli_fetch_array($resultat);

?>