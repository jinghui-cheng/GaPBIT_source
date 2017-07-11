<!DOCTYPE html>
<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,500,700' rel='stylesheet' type='text/css'>
	<title>GaPBIT</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- Bootstrap -->
	<link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="screen">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="screen" href="css/motion_game.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/signin.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/mypatterns.css">
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="row">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-responsive-collapse" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html">
						<i class="fa fa-home"></i>
					</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="navbar-responsive-collapse">
					<ul class="nav navbar-nav navbar-left">
						<li><a href="eff-patterns.php">Patterns Focused on Therapy Goals</a></li>
						<li><a href="exp-patterns.php">Patterns Focused on Player Experience</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="active"><a href="my-patterns.php">My Saved Patterns</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div><!-- /.container-fluid -->
	</nav>

	<div class="container">
		<?php
	    include('./login/config.php');

			if ($user->isSigned()) {
				include 'mypatterns/my-patterns-content.php';
			} else {
				echo '<div class="row">
								<div class="col-md-4 col-sm-6 col-centered">';
			  include 'login/user-signin-signup.php';
				echo '</div></div>';
			}
		?>
	</div>
	<br/><br/>

	<!-- JavaScript plugins (requires jQuery) -->
	<script src="js/jquery.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>

	<script src="js/pattern-clickable.js"></script>
</body>
</html>
