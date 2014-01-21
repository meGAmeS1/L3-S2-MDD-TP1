<?php
include_once("../includes/variables.php");
include("../includes/connect.php");  // Connexion à la base

$requetes ="";
$sql=file("../includes/raz-base.sql"); // on charge le fichier SQL
foreach($sql as $l){ // on le lit
	if (substr(trim($l),0,2)!="--"){ // suppression des commentaires
		$requetes .= $l;
	}
}
 
$reqs = explode(";",$requetes);// on sépare les requêtes
foreach($reqs as $req){	// et on les éxécute
	if (!mysqli_query($linkdb,$req) && trim($req)!=""){
		die("ERROR : ".$req); // stop si erreur 
	}
}
?>