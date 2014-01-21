<?php
include_once("../includes/variables.php");
include("../includes/init.php");

$errorlist = array();
$reqfail = 0;
$kilometrage = 0;
$reservoir = 0;

if(empty($_POST['distance'])) {
	array_push($errorlist, "Vous devez saisir une distance");
}
elseif (!ctype_digit($_POST['distance'])) {
	array_push($errorlist, "La distance doit être un entier");
}
elseif ($_POST['distance']<0) {
	array_push($errorlist, "La distance doit être positive");
}

if(!isConnected()) {
	array_push($errorlist, "Vous devez être connecté");
}

if (empty($errorlist)) {
	include("../includes/connect.php"); // Connexion à la base

	$prixessence = 2.5;
	$prixdiesel = 1.5;

	$distance = mysqli_real_escape_string($linkdb,$_POST['distance']);

	// Récupération du solde
	$requete = "SELECT * FROM internaute WHERE identifiant = '".$_SESSION['user']."';";
	$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

	if (mysqli_num_rows($resultat) == false) {
		array_push($errorlist, "Vous n'êtes plus inscrit");
	}
	else {
		$requete = "SELECT consommation, volume_restant, kilometrage FROM vehicule WHERE proprietaire = '".$_SESSION['user']."';";
		$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;
		$vehicule = mysqli_fetch_array($resultat);

		$quantiteConsommee = round(floatval($vehicule['consommation']) * $distance / 100);
		$reservoir = $vehicule['volume_restant'] - $quantiteConsommee;

		if ($reservoir < 0) {
			array_push($errorlist, "Vous n'avez pas assez de carburant pour parcourir cette distance");
		}

		if (empty($errorlist)) {
			$kilometrage = $distance + $vehicule['kilometrage'];

			$volume = $vehicule['volume_restant'] + $quantite;
			$requete="UPDATE vehicule SET volume_restant = $reservoir, kilometrage=$kilometrage WHERE proprietaire = '".$_SESSION['user']."';";
			$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;
		}

	}
}
?>
{
	"errorlist" : [<?php
		$i=0;
		$nbligne = count($errorlist);
		foreach ($errorlist as $value) {
			echo "\"$value\"";
			if(++$i<$nbligne) echo ",\n";
		}
		?>],
	"reqfail" : <?php echo $reqfail ?>,
	"kilometrage" : <?php echo $kilometrage ?>,
	"reservoir" : <?php echo $reservoir ?>
}