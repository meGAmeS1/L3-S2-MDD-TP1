<?php
include("./includes/init.php");
include_once("./includes/variables.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("./includes/head.php"); ?>
		<title>Espace personnel</title>
	</head>

	<body>
		<?php include("./includes/topbar.php");
		
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

			// Récupération des données
			include("./includes/process/espace.php");

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
							Carburant : <span class="label label-primary" ><?php echo $vehicule['carburant'] ; ?></span><br>
							Consommation : <span class="label label-primary" ><?php echo $vehicule['consommation'] ; ?> l/100km</span><br>
							Kilométrage : <span class="label label-primary" ><span id="fieldKilometrage"><?php echo $vehicule['kilometrage'] ; ?></span> km</span>
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
										<input type="number" class="form-control" id="inputCarbu" placeholder="Quantité de carburant" onkeypress="if (event.keyCode == 13) buyCarbu();" autocomplete=off required>
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
										<input type="number" class="form-control" id="inputDrive" placeholder="Distance" onkeypress="if (event.keyCode == 13) drive();" autocomplete=off required>
										<span class="input-group-addon">km</span>
									</div>
								</div>
							</div>
							<button type="button" class="btn btn-success" onclick="drive()">Valider</button>
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"></h4>
							</div>
							<div class="modal-body">
								<div id="myModalAlert"></div>
							</div>
							<div class="modal-footer" id="myModalFooter">
								<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Fermer</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
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

				var g1 = new JustGage({
					id: "gauge1", 
					value: <?php echo $compte ; ?>, 
					min: 0,
					max: <?php echo $argentmaxi; ?>,
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

				function buyCarbu () {
					var reqform = $.ajax({
						type:"POST", 
						data: {
							"quantite" : $("#inputCarbu").val()
						}, 
						url:"./ajax/buycarbu.php"	
					});

					reqform.done(function(data, textStatus, jqXHR){
						var result = jQuery.parseJSON(data);

						if (result.errorlist.length > 0) {
							listerreur = "";

							$.each(result.errorlist, function (key, value) {
								listerreur += "<li>" + value + "</li>";
							});

							$('#myModalLabel').html("Erreur");
							$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur dans la saisie !</h3></div><div class="panel-body">Vous avez incorrectement saisi les données suivantes :<ul>'+listerreur+'</ul></div></div>');
							$('#myModal').modal('show');
						}
						else if (result.reqfail == 1) {
							$('#myModalLabel').html("Erreur");
							$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Il y a eu une problème dans l\'éxécution d\'une requête</div></div>');
							$('#myModal').modal('show');
						}
						else {
							$('#myModalAlert').html('');
							$("#inputCarbu").val('');
							g1.refresh(result.money);
							g2.refresh(result.reservoir);
						}
					});

					reqform.fail(function(jqXHR, textStatus){
						$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Impossible d\'envoyer le formulaire</div></div>');
					});
				}

				function drive () {
					var reqform = $.ajax({
						type:"POST", 
						data: {
							"distance" : $("#inputDrive").val()
						}, 
						url:"./ajax/drive.php"	
					});

					reqform.done(function(data, textStatus, jqXHR){
						var result = jQuery.parseJSON(data);

						if (result.errorlist.length > 0) {
							listerreur = "";

							$.each(result.errorlist, function (key, value) {
								listerreur += "<li>" + value + "</li>";
							});

							$('#myModalLabel').html("Erreur");
							$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur dans la saisie !</h3></div><div class="panel-body">Vous avez incorrectement saisi les données suivantes :<ul>'+listerreur+'</ul></div></div>');
							$('#myModal').modal('show');
						}
						else if (result.reqfail == 1) {
							$('#myModalLabel').html("Erreur");
							$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Il y a eu une problème dans l\'éxécution d\'une requête</div></div>');
							$('#myModal').modal('show');
						}
						else {
							$('#myModalAlert').html('');
							$("#inputDrive").val('');
							g2.refresh(result.reservoir);
							$('#fieldKilometrage').html(result.kilometrage)
						}
					});

					reqform.fail(function(jqXHR, textStatus){
						$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Impossible d\'envoyer le formulaire</div></div>');
					});
				}
			</script>
			<?php
		}
		?>
	</body>
</html>