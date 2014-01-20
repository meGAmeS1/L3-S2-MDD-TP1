<?php include("./includes/init.php");?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("./includes/head.php"); ?>
		<title>Starter Template for Bootstrap</title>
	</head>

	<body>

		<?php include("./includes/topbar.php"); ?>

		<div class="jumbotron">

			<div class="container">
				<h1>CarDrive</h1>
				<h2><small>La meilleure façon de gérer votre véhicule</small></h2>
				<br>
				<p>Connectez-vous à votre compte ou créez-vous votre espace</p>
				<p>
					<button type="button" class="btn btn-primary btn-lg" onclick="create()" >Création de compte</button>
					<button type="button" class="btn btn-success btn-lg" onclick="connect()" >Connexion</button>
				</p>
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
						<input type="text" class="form-control" id="inputLogin" placeholder="Login" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword" class="col-md-4 control-label">Mot de passe</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe" required>
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
						<input type="text" class="form-control" id="inputLogin" placeholder="Login" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword" class="col-md-4 control-label">Mot de passe</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe" required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCategorie" class="col-md-4 control-label">Catégorie</label>
					<div class="col-md-6">
						<select name="inputCategorie" id="inputCategorie" class="form-control">
							<option value="voiture">Voiture</option>
							<option value="camion">Camion</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPrice" class="col-md-4 control-label">Prix</label>
					<div class="col-md-6">
						<div class="input-group">
							<input type="number" class="form-control" id="inputPrice" placeholder="Prix" required>
							<span class="input-group-addon">€</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputFuel" class="col-md-4 control-label">Carburant</label>
					<div class="col-md-6">
						<select name="inputFuel" id="inputFuel" class="form-control">
							<option value="voiture">Essence</option>
							<option value="camion">Diesel</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputVolume" class="col-md-4 control-label">Volume du réservoire</label>
					<div class="col-md-6">
						<div class="input-group">
							<input type="number" class="form-control" id="inputVolume" placeholder="Volume" required>
							<span class="input-group-addon">litre</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputConsumption" class="col-md-4 control-label">Consommation</label>
					<div class="col-md-6">
						<div class="input-group">
							<input type="number" class="form-control" id="inputConsumption" placeholder="Consommation" required>
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

		<?php include("./includes/js.php"); ?>
		<script type="text/javascript">
			function create () {
				$('#myModalLabel').html("Création d'un compte");
				$('#myModalForm').html($('#formCreate').html());
				$('#myModalFooter').html($('#buttonsCreate').html());
				$('#myModal').modal('show');

			}

			function connect() {
				$('#myModalLabel').html("Connexion à votre espace personnel");
				$('#myModalForm').html($('#formConnect').html());
				$('#myModalFooter').html($('#buttonsConnect').html());
				$('#myModal').modal('show');
			}

			function sendCreate () {
				// body...
			}

			function sendConnect () {
				// body...
			}
		</script>
	</body>
</html>