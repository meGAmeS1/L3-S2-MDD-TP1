<?php include("./includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("./includes/head.php"); ?>
		<title>Starter Template for Bootstrap</title>
	</head>

	<body>
		<?php include("./includes/topbar.php"); ?>
		<?php
		$reqfail = 0;
		 if (! isConnected()) {
			?>
			<div class="container" style="padding-top : 20px;">
				<div class="col-md-offset-4 col-sm-4">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title">Problème</h3>
						</div>
						<div class="panel-body">
							Vous devez être connecté pour utiliser cette page
						</div>
					</div>
				</div>
			</div>
			<div class="container" style="text-align: center;">
				<a href="./" class="btn btn-success btn-lg" role="button">Retour à l'accueil</a>
			</div>
			<?php
		}
		else {
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
			// $niveaureservoire = round (($vehicule['volume_restant'] / $vehicule['volume_reservoir']) * 100);
			if ($reqfail == 0) {
				?>
				<div class="jumbotron">
					<div class="container">
						<h1>Espace personnel</h1>
					</div><!-- /.container -->
				
					<div class="container" style="padding-top : 30px;">
						<div class="col-md-2" style="text-align: center;">
							<?php switch ($vehicule['categorie']) {
								case 'voiture':
									?><img id="imgShadow" src="./assets/img/voiture.png" ><?php
									break;
								case 'camion':
									?><img id="imgShadow" src="./assets/img/camion.png" ><?php
									break;
								default:
									?><img id="imgShadow" src="./assets/img/inconnu.png" ><?php
									break;
							}; ?>
						</div>
						<div class="col-md-4" style="text-align: center;">
							Carburant : <?php echo $vehicule['carburant'] ; ?><br>
							Consommation : <?php echo $vehicule['consommation'] ; ?> l/100km<br>
							Kilométrage : <?php echo $vehicule['kilometrage'] ; ?> km
						</div>
						<div class="col-md-3" style="margin: auto;">
							<div id="gauge1" style="width:200px; height:160px"></div>
						</div>
	
						<div class="col-md-3" style="margin: auto;">
							<div id="gauge2" style="width:200px; height:160px"></div>
						</div>
					</div><!-- /.container -->
				</div>
				<div class="container">
					<div class="col-md-offset-2 col-md-3" style="text-align: center;">
						<div class="well">
							<legend>Acheter du carburant</legend>
							<div class="form-horizontal" role="form">
								<div class="form-group">
									<div class="input-group">
										<input type="number" class="form-control" id="inputCarbu" placeholder="Quantité de carburant" required>
										<span class="input-group-addon">litre</span>
									</div>
								</div>
							</div>
							<button type="button" class="btn btn-success" onclick="buyCarbu()">Valider</button>
						</div>
					</div>

					<div class="col-md-offset-2 col-md-3">
						<div class="well" style="text-align: center;">
							<legend>Rouler</legend>
								<div class="form-horizontal" role="form">
								<div class="form-group">
									<div class="input-group">
										<input type="number" class="form-control" id="inputDrive" placeholder="Distance" required>
										<span class="input-group-addon">km</span>
									</div>
								</div>
							</div>
							<button type="button" class="btn btn-success" onclick="drive()">Valider</button>
						</div>
					</div>
				</div>
				<?php
			}
			else {
				?>
				<div class="container" style="padding-top : 20px;">
					<div class="col-md-offset-4 col-sm-4">
						<div class="panel panel-danger">
							<div class="panel-heading">
								<h3 class="panel-title">Problème</h3>
							</div>
							<div class="panel-body">
								Erreur dans l'éxécution des requêtes ou votre compte n'existe pas.
							</div>
						</div>
					</div>
				<?php
			}

		}?>

		<?php include("./includes/js.php"); ?>
		<?php if (isConnected() && $reqfail == 0) {
			?>
			<script type="text/javascript">
				var g1, g2;
				
				window.onload = function(){
					var g1 = new JustGage({
						id: "gauge1", 
						value: <?php echo $compte ; ?>, 
						min: 0,
						max: 30000,
						title: "Porte monnaie",
						label: "Euro",
						levelColors: ["#ff0000","#f9c802","#a9d70b"]
					});
				
					var g2 = new JustGage({
						id: "gauge2", 
						value: <?php echo $vehicule['volume_restant'] ?>, 
						min: 0,
						max: <?php echo $vehicule['volume_reservoir'] ?>,
						title: "Niveau réservoir",
						label: "litre",
						levelColors: ["#ff0000","#f9c802","#a9d70b"]
					});
				};
			</script>
			<?php
		}
		?>
	</body>
</html>