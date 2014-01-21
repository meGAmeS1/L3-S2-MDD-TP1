<?php
include("./includes/init.php");
include_once("./includes/variables.php"); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("./includes/head.php"); ?>
		<title>Accueil de CarDrive</title>
	</head>
	<body>
		<?php include("./includes/topbar.php"); ?>
		<div class="jumbotron">
			<div class="container">
				<h1>CarDrive</h1>
				<h2><small>La meilleure façon de gérer votre véhicule</small></h2>
				<br>
				<?php if (isConnected())  { ?>
					<p>Vous êtes connecté, vous pouvez accéder à votre espace !</p>
					<a href="./espace.php" class="btn btn-success btn-lg" role="button">Espace personnel</a>
					<?php
				}
				else { ?>
				<p>Connectez-vous à votre compte ou créez-vous votre espace</p>
				<p>
					<button type="button" class="btn btn-primary btn-lg" onclick="create()" >Création de compte</button>
					<button type="button" class="btn btn-success btn-lg" onclick="connect()" >Connexion</button>
				</p>
				<?php
				}
				?>
			</div><!-- /.container -->
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
						<div id="myModalForm"></div>
					</div>
					<div class="modal-footer" id="myModalFooter">
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	
		<!-- Connection form -->
		<div class="hide" id="formConnect">
			<div class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputLogin" class="col-md-4 control-label">Login</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="inputLogin" placeholder="Login" onkeypress="if (event.keyCode == 13) sendConnect();" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword" class="col-md-4 control-label">Mot de passe</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe" onkeypress="if (event.keyCode == 13) sendConnect();" required>
					</div>
				</div>
			</div>
		</div>
		<!-- Connection buttons -->
		<div class="hide" id="buttonsConnect">
			<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			<button type="button" class="btn btn-primary" onclick="sendConnect()">Connexion</button>
		</div>

		<!-- Create account form -->
		<div class="hide" id="formCreate">
			<div class="form-horizontal" role="form">
				<div class="form-group">
					<label for="inputLogin" class="col-md-4 control-label">Login</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="inputLogin" placeholder="Login" onkeypress="if (event.keyCode == 13) sendCreate();" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword" class="col-md-4 control-label">Mot de passe</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe" onkeypress="if (event.keyCode == 13) sendCreate();" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCategorie" class="col-md-4 control-label">Catégorie</label>
					<div class="col-md-6">
						<select name="inputCategorie" id="inputCategorie" class="form-control" onkeypress="if (event.keyCode == 13) sendCreate();">
							<option value="voiture">Voiture</option>
							<option value="camion">Camion</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPrice" class="col-md-4 control-label">Prix</label>
					<div class="col-md-6">
						<div class="input-group">
							<input type="number" class="form-control" id="inputPrice" placeholder="Prix" onkeypress="if (event.keyCode == 13) sendCreate();" required>
							<span class="input-group-addon">€</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputFuel" class="col-md-4 control-label">Carburant</label>
					<div class="col-md-6">
						<select name="inputFuel" id="inputFuel" class="form-control" onkeypress="if (event.keyCode == 13) sendCreate();">
							<option value="essence">Essence</option>
							<option value="diesel">Diesel</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputVolume" class="col-md-4 control-label">Volume du réservoire</label>
					<div class="col-md-6">
						<div class="input-group">
							<input type="number" class="form-control" id="inputVolume" placeholder="Volume" onkeypress="if (event.keyCode == 13) sendCreate();" required>
							<span class="input-group-addon">litre</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputConsumption" class="col-md-4 control-label">Consommation</label>
					<div class="col-md-6">
						<div class="input-group">
							<input type="number" class="form-control" id="inputConsumption" placeholder="Consommation" onkeypress="if (event.keyCode == 13) sendCreate();" required>
							<span class="input-group-addon">l/100km</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Create account buttons -->
		<div class="hide" id="buttonsCreate">
			<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
			<button type="button" class="btn btn-primary" onclick="sendCreate()">Valider</button>
		</div>
		
		<!-- Fail modal buttons -->
		<div class="hide" id="buttonsClose">
			<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Fermer</button>
		</div>
		<?php include("./includes/js.php"); ?>
		<script type="text/javascript">
			function create () {
				$('#myModalLabel').html("Création d'un compte");
				$('#myModalAlert').html('');
				$('#myModalForm').html($('#formCreate').html());
				$('#myModalFooter').html($('#buttonsCreate').html());
				$('#myModal').modal('show');

				// Focus sur le premier champ
				$('#myModal').on('shown.bs.modal', function () {$(".modal-body #inputLogin").focus();});
			}

			function connect() {
				$('#myModalLabel').html("Connexion à votre espace personnel");
				$('#myModalAlert').html('');
				$('#myModalForm').html($('#formConnect').html());
				$('#myModalFooter').html($('#buttonsConnect').html());
				$('#myModal').modal('show');

				// Focus sur le premier champ
				$('#myModal').on('shown.bs.modal', function () {$(".modal-body #inputLogin").focus();});
			}

			function sendCreate () {
				var reqform = $.ajax({
					type:"POST", 
					data: {
						"login" : $(".modal-body #inputLogin").val(),
						"password" : $(".modal-body #inputPassword").val(),
						"categorie" : $(".modal-body #inputCategorie").val(),
						"price" : $(".modal-body #inputPrice").val(),
						"fuel" : $(".modal-body #inputFuel").val(),
						"volume" : $(".modal-body #inputVolume").val(),
						"consumption" : $(".modal-body #inputConsumption").val()
					}, 
					url:"./ajax/createaccount.php"	
				});

				reqform.done(function(data, textStatus, jqXHR){
					var result = jQuery.parseJSON(data);

					if (result.errorlist.length > 0) {
						listerreur = "";

						$.each(result.errorlist, function (key, value) {
							listerreur += "<li>" + value + "</li>";
						});

						$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur dans la saisie !</h3></div><div class="panel-body">Vous avez incorrectement saisi les données suivantes :<ul>'+listerreur+'</ul></div></div>');
					}
					else if (result.reqfail == 1) {
						$('#myModalForm').html('');
						$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Il y a eu une problème dans l\'éxécution d\'une requête</div></div>');
						$('#myModalFooter').html($('#buttonsClose').html());
					}
					else {
						$('#myModalForm').html('');
						$('#myModalAlert').html('<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">Saisie réussie</h3></div><div class="panel-body">Votre compte a bien été créé</div></div>');
						$('#myModalFooter').html($('#buttonsClose').html());
						$('#myModal').on('hide.bs.modal', function () {window.location.href = "./espace.php";});
						setTimeout(function() {$('#myModal').modal('hide'); }, 3000);
					}
				});

				reqform.fail(function(jqXHR, textStatus){
					$('#myModalForm').html('');
					$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Impossible d\'envoyer le formulaire</div></div>');
					$('#myModalFooter').html($('#buttonsClose').html());
				});
			}

			function sendConnect () {
				var reqform = $.ajax({
					type:"POST", 
					data: {
						"login" : $(".modal-body #inputLogin").val(),
						"password" : $(".modal-body #inputPassword").val()
					}, 
					url:"./ajax/connect.php"	
				});

				reqform.done(function(data, textStatus, jqXHR){
					var result = jQuery.parseJSON(data);

					if (result.errorlist.length > 0) {
						listerreur = "";

						$.each(result.errorlist, function (key, value) {
							listerreur += "<li>" + value + "</li>";
						});

						$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur dans la saisie !</h3></div><div class="panel-body">Vous avez incorrectement saisi les données suivantes :<ul>'+listerreur+'</ul></div></div>');
					}
					else if (result.reqfail == 1) {
						$('#myModalForm').html('');
						$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Il y a eu une problème dans l\'éxécution d\'une requête</div></div>');
						$('#myModalFooter').html($('#buttonsClose').html());
					}
					else {
						$('#myModalForm').html('');
						$('#myModalAlert').html('<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">Connecté</h3></div><div class="panel-body">Vous êtes désormais connecté à votre espace personnel</div></div>');
						$('#myModalFooter').html($('#buttonsClose').html());
						$('#myModal').on('hide.bs.modal', function () {window.location.href = "./espace.php";});
						setTimeout(function() {$('#myModal').modal('hide'); }, 3000);
					}
				});

				reqform.fail(function(jqXHR, textStatus){
					$('#myModalForm').html('');
					$('#myModalAlert').html('<div class="panel panel-danger"><div class="panel-heading"><h3 class="panel-title">Erreur</h3></div><div class="panel-body">Impossible d\'envoyer le formulaire</div></div>');
					$('#myModalFooter').html($('#buttonsClose').html());
				});
			}
		</script>
	</body>
</html>