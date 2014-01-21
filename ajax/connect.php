<?php
include_once("../includes/variables.php");
session_start();

$errorlist = array();
$reqfail = 0;

if(empty($_POST['login'])) {
	array_push($errorlist, "Vous devez saisir un login");
}

if(empty($_POST['password'])) {
	array_push($errorlist, "Vous devez saisir un mot de passe");
}

if (empty($errorlist)) {
	include("../includes/connect.php"); // Connexion à la base

	$login 			= mysqli_real_escape_string($linkdb,$_POST['login']);
	$pwd 			= mysqli_real_escape_string($linkdb,$_POST['password']);

	// Vérification si le login existe déjà
	$requete = "SELECT identifiant FROM internaute WHERE login = '$login' AND mdp = '$pwd';";
	$resultat = mysqli_query($linkdb,$requete) OR $reqfail = 1;

	if (mysqli_num_rows($resultat) == false) {
		array_push($errorlist, "Vérifiez votre combinaison login/mot de passe");
	}
	else {
		$idinternaute = mysqli_fetch_array($resultat);
		$idinternaute = $idinternaute[0];

		$_SESSION['user']=$idinternaute;
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