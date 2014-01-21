<?php
include_once("../includes/variables.php");
session_start();

$errorlist = array();
$reqfail = 0;

if(empty($_POST['login'])) {
	array_push($errorlist, "Vous devez saisir un login");
}
elseif (strlen($_POST['login'])>20) {
	array_push($errorlist, "Le login est trop long");
}
elseif (!ctype_alnum($_POST['login'])) {
	array_push($errorlist, "Le login doit être alphanumérique");
}

if(empty($_POST['password'])) {
	array_push($errorlist, "Vous devez saisir un mot de passe");
}
elseif (strlen($_POST['password'])>20) {
	array_push($errorlist, "Le mot de passe est trop long");
}

if(empty($_POST['categorie'])) {
	array_push($errorlist, "Vous devez choisir une catégorie");
}

if(empty($_POST['price'])) {
	array_push($errorlist, "Vous devez saisir un prix");
}
elseif (!ctype_digit($_POST['price'])) {
	array_push($errorlist, "Le prix doit être un entier");
}
elseif ($_POST['price']<0) {
	array_push($errorlist, "Le prix doit être positif");
}
elseif ($_POST['price']>=$argentmaxi) {
	array_push($errorlist, "Le prix doit être strictement inférieur à " . $argentmaxi);
}

if(empty($_POST['fuel'])) {
	array_push($errorlist, "Vous devez choisir un type de carburant");
}


if(empty($_POST['volume'])) {
	array_push($errorlist, "Vous devez définir le volume du réservoir");
}
elseif (!ctype_digit($_POST['volume'])) {
	array_push($errorlist, "Le volume du réservoir doit être un entier");
}
elseif ($_POST['volume']<0) {
	array_push($errorlist, "Le volume du réservoir doit être positif");
}

if(empty($_POST['consumption'])) {
	array_push($errorlist, "Vous devez définir la consommation du véhicule");
}
elseif (!is_numeric($_POST['consumption'])) {
	array_push($errorlist, "La consommation du véhicule doit être numérique");
}
elseif ($_POST['consumption']<0) {
	array_push($errorlist, "La consommation du véhicule doit être positive");
}

if (empty($errorlist)) {
	include("../includes/connect.php"); // Connexion à la base

	$login 			= mysqli_real_escape_string($linkdb,$_POST['login']);
	$pwd 			= mysqli_real_escape_string($linkdb,$_POST['password']);
	$categorie 		= mysqli_real_escape_string($linkdb,$_POST['categorie']);
	$price 			= mysqli_real_escape_string($linkdb,$_POST['price']);
	$fuel 			= mysqli_real_escape_string($linkdb,$_POST['fuel']);
	$volume			= mysqli_real_escape_string($linkdb,$_POST['volume']);
	$consumption 	= mysqli_real_escape_string($linkdb,$_POST['consumption']);

	// Vérification si le login existe déjà
	$requete = "SELECT * FROM internaute WHERE login = '$login';";
	$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

	if (mysqli_num_rows($resultat) != false) {
		array_push($errorlist, "Ce login existe déjà");
	}
	else {
		$idinternaute = 0;
		$argent = $argentmaxi - $price;
		// Insertion
		$requete = "INSERT INTO internaute (login,mdp,compte) VALUES ('$login', '$pwd', $argent);";
		$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

		$requete = "SELECT identifiant FROM internaute WHERE login = '$login';";
		$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;
		$idinternaute = mysqli_fetch_array($resultat);
		$idinternaute = $idinternaute[0];

		$requete = "INSERT INTO vehicule (categorie,carburant,consommation,volume_reservoir,volume_restant,kilometrage,proprietaire) VALUES ('$categorie', '$fuel', '$consumption', $volume, 0, 0, '$idinternaute');";
		$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

		if ($reqfail == 0) {
			$_SESSION['user']=$idinternaute;
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
	"reqfail" : <?php echo $reqfail ?>
}