<?php include("./includes/init.php");
unset($_SESSION['user'])
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include("./includes/head.php"); ?>
		<title>Starter Template for Bootstrap</title>
	</head>

	<body>

		<?php include("./includes/topbar.php"); ?>
		<div class="container" style="padding-top : 20px;">
			<div class="col-md-offset-4 col-sm-4">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Déconnecté</h3>
					</div>
					<div class="panel-body">
						Vous êtes désormais déconnecté !
					</div>
				</div>
			</div>
		</div>
		<div class="container" style="text-align: center;">
			<a href="./" class="btn btn-success btn-lg" role="button">Retour à l'accueil</a>
		</div>
		<?php include("./includes/js.php"); ?>
		<script type="text/javascript">
		</script>
	</body>
</html>