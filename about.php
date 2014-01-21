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
				<h1>À propos</h1>
				<h2>TP de Florentin Le Moal</h2>
				<br>
				<p>Propulsé avec amour et tradition par Bootstrap</p>
			</div><!-- /.container -->
		</div>
		<div class="container">
			<div class="col-md-offset-4 col-sm-4">
				<div class="well" style="text-align: center;">
					<legend>Remise à zéro de la base</legend>
					<button type="button" name="sent" class="btn btn-lg btn-danger" onClick='raz()'><span class="fa fa-refresh" id="icn-btn"></span> Restaurer</button>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Restauration</h4>
					</div>
					<div class="modal-body">
						<div id="myModalAlert"></div>
					</div>
					<div class="modal-footer" id="myModalFooter">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="hide" id="success_mod">
			<div class="alert alert-success">
				<h2>Restauration réussie !</h2>
					C'est bon, tout est comme neuf.<br>
			</div>
		</div>
		<div class="hide" id="fail_mod">
			<div class="alert alert-error">
				<h2>Restauration impossible !</h2>
					Il y a eu une erreur lors de la restauration<br>
			</div>
		</div>

		<?php include("./includes/js.php"); ?>
		<script type="text/javascript">
			function raz () {
				$('#icn-btn').addClass('fa-spin');

				var reqpri = $.ajax({
					url:"ajax/raz.php"	
				});

				reqpri.done(function(data, textStatus, jqXHR){

					if (data == "") {
						$('#myModalAlert').html($('#success_mod').html());
						$('#myModal').modal('show');
					}
					else {
						$('#myModalAlert').html($('#fail_mod').html());
						$('#myModal').modal('show');
					}

					$("#icn-btn").removeClass("fa-spin");
				});

				reqpri.fail(function(jqXHR, textStatus){
					$('#myModalAlert').html($('#fail_mod').html());
					$('#myModal').modal('show');
					$("#icn-btn").removeClass("fa-spin");
				});
			}
		</script>
	</body>
</html>