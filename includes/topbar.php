<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./">CarDrive</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li <?php if ($file=="index.php") echo 'class="active"'; ?>><a href="./">Home</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if (isConnected()) {
					?>
					<li><a href="./exit.php">Déconnexion</a></li>
					<?php
				} ?>
				<li <?php if ($file=="about.php") echo 'class="active"'; ?>><a href="./about.php">À propos</a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>