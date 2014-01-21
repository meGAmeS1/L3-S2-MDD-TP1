<?php
include_once("../includes/variables.php");
include("../includes/init.php");

$errorlist = array();
$reqfail = 0;
$reservoir = 0;
$money = 0;

if(empty($_POST['quantite'])) {
	array_push($errorlist, "Vous devez saisir une quantité");
}
elseif (!ctype_digit($_POST['quantite'])) {
	array_push($errorlist, "La quantité doit être un entier");
}
elseif ($_POST['quantite']<0) {
	array_push($errorlist, "La quantité doit être positive");
}

if(!isConnected()) {
	array_push($errorlist, "Vous devez être connecté");
}

if (empty($errorlist)) {
	include("../includes/connect.php"); // Connexion à la base

	$quantite = mysqli_real_escape_string($linkdb,$_POST['quantite']);

	// Récupération du solde
	$requete = "SELECT compte FROM internaute WHERE identifiant = '".$_SESSION['user']."';";
	$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

	if (mysqli_num_rows($resultat) == false) {
		array_push($errorlist, "Vous n'êtes plus inscrit");
	}
	else {
		$compte = mysqli_fetch_array($resultat);
		$compte = $compte[0];

		$requete = "SELECT carburant, consommation, volume_reservoir, volume_restant FROM vehicule WHERE proprietaire = '".$_SESSION['user']."';";
		$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;
		$vehicule = mysqli_fetch_array($resultat);

		$prixcarbu = 0;
		switch ($vehicule['carburant']) {
			case 'essence':
				$prixcarbu = $prixessence;
				break;
			
			case 'diesel':
				$prixcarbu = $prixdiesel;
				break;
			default:
				array_push($errorlist, "Votre type de carburant est inconnu");
				break;
		}

		$cout = $quantite * $prixcarbu;
		$compterestant = round($compte - $cout);
		if ($compterestant < 0) {
			array_push($errorlist, "Vous n'avez pas assez d'argent");
		}

		if ($quantite > ($vehicule['volume_reservoir'] - $vehicule['volume_restant'])) {
			array_push($errorlist, "Vous dépassez le volume du réservoir");
		}

		if (empty($errorlist)) {
			$requete="UPDATE internaute SET compte = $compterestant WHERE identifiant = '".$_SESSION['user']."';";
			$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

			$volume = $vehicule['volume_restant'] + $quantite;
			$requete="UPDATE vehicule SET volume_restant = $volume WHERE proprietaire = '".$_SESSION['user']."';";
			$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

			$money = $compterestant;
			$reservoir = $volume;
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
	"reservoir" : <?php echo $reservoir ?>,
	"money" : <?php echo $money ?>
}