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
						<li class="active"><a href="exp-patterns.php">Patterns Focused on Player Experience</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="my-patterns.php">My Saved Patterns</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div><!-- /.container-fluid -->
	</nav>

	<div class="container">
		<form id="view-select-form" class="form-horizontal">
			<div class="form-group">
				<div class="row">
					<label for="sel-view-by" class="col-lg-1 col-md-2 col-sm-2 col-xs-3 control-label">View By</label>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-5" style="padding-left:0;">
						<select id="sel-view-by" class="form-control">
							<option selected="selected" value="category">Category</option>
							<option value="name">Pattern Name</option>
							<option value="relation">Relationship</option>
						</select>
					</div>
					<div class="col-lg-8 col-md-7 col-sm-4 col-xs-4" style="padding-left:0;">
						<button type="button" class="btn btn-expand-all btn-primary">Collapse All</button>
					</div>
				</div>
			</div>
		</form>
		<hr>

		<?php
			include 'pattern-util.php';
			readPatternsList('data/exp-patterns.csv');
		?>

		<div class="row hide" id="view-by-name">
			<?php
				function showPatternsByName()
				{
					global $patternNames;
					global $patternCategories;
					global $patternDescriptions;

					array_multisort($patternNames, $patternCategories, $patternDescriptions);
					$colTwoStartingIndex = ceil(sizeof($patternNames)/2);

					echo '<div class="col-md-6">'."\n";
					echo '<ul class="patterns-list">'."\n";
					$patterns = array_slice($patternNames, 0,
																	$colTwoStartingIndex);
					foreach ($patterns as $id => $name) {
						echo '<li class="pattern-clickable" id="'.$id.'">'."\n";
						//echo '<div class="category exp-category pull-right"><b>Category: </b>'.$patternCategories[$id].'</div>';
						echo '<p class="name">'.$name.'</p>';
						echo '<p class="description">'.$patternDescriptions[$id].'</p>';
						echo '</li>'."\n";
					}
					echo '</ul>'."\n";
					echo '</div>'."\n";

					echo '<div class="col-md-6">'."\n";
					echo '<ul class="patterns-list">'."\n";
					$patterns = array_slice($patternNames, $colTwoStartingIndex,
																	sizeof($patternNames)-$colTwoStartingIndex);
					foreach ($patterns as $id => $name) {
						echo '<li class="pattern-clickable" id="'.$id.'">'."\n";
						//echo '<div class="category exp-category pull-right"><b>Category: </b>'.$patternCategories[$id].'</div>';
						echo '<p class="name">'.$name.'</p>';
						echo '<p class="description">'.$patternDescriptions[$id].'</p>';
						echo '</li>'."\n";
					}
					echo '</ul>'."\n";
					echo '</div>'."\n";
				}

				showPatternsByName();
 			?>
		</div>

		<div class="row" id="view-by-category">
			<?php
				function showCollapsedPatternsByCategory()
				{
					global $patternNames;
					global $patternCategories;
					global $patternDescriptions;

					$categories = array_unique($patternCategories);
					sort($categories);

					foreach ($categories as $category) {
						$categoryID = preg_replace('/\s+/', '-', $category);
						$patternIDs = array_keys($patternCategories, $category);

						echo '<div class="col-sm-6 col-md-3 category text-center">'."\n";
						echo '<a href="#" class="btn btn-category" data-toggle="modal" data-target="#'.$categoryID.'-modal">'.$category.'</a>'."\n";
						echo '</div>'."\n";

						//modal that include all patterns in the category
						echo '<div class="modal fade" id="'.$categoryID.'-modal" tabindex="-1" role="dialog">';
	  				echo '	<div class="modal-dialog" role="document">';
	    			echo '		<div class="modal-content">';
						echo '			<div class="modal-header">';
	        	echo '				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	        	echo '				<h4 class="modal-title"><b>'.$category.' Patterns</b></h4>';
						echo '				<p class="modal-title-sub">Click on pattern name to see more information.</p>';
	      		echo '			</div>';
	    			echo '			<div class="modal-body">';

						echo '<ul class="patterns-list">'."\n";
						foreach ($patternIDs as $id) {
							echo '<li class="pattern-clickable" id="'.$id.'">'."\n";
							echo '<p class="name">'.$patternNames[$id].'</p>';
							echo '<p class="description">'.$patternDescriptions[$id].'</p>';
							echo '</li>'."\n";
						}
						echo '</ul>'."\n";

	      		echo '			</div>';	//modal-body
	      		echo '		</div>';		//modal-content
	      		echo '	</div>';			//modal-dialog
	      		echo '</div>';				//modal-body
					}
				}

				function showExpandedPatternsByCategory()
				{
					global $patternNames;
					global $patternCategories;
					global $patternDescriptions;

					$categories = array_unique($patternCategories);
					sort($categories);
					$colTwoStartingIndex = ceil(sizeof($categories)/2);

					echo '<div class="col-md-6">'."\n";
					echo '<ul class="list-expanded">';
					$cats = array_slice($categories, 0, $colTwoStartingIndex);
					foreach ($cats as $category) {
						$categoryID = preg_replace('/\s+/', '-', $category);
						$patternIDs = array_keys($patternCategories, $category);

						echo '<li>'."\n";
						echo '<div class="list-name-expanded">'.$category.'</div>'."\n";
						echo '<ul class="patterns-list patterns-list-grouped">'."\n";
						foreach ($patternIDs as $id) {
							echo '<li class="pattern-clickable" id="'.$id.'">'."\n";
							echo '<p class="name">'.$patternNames[$id].'</p>';
							echo '<p class="description">'.$patternDescriptions[$id].'</p>';
							echo '</li>'."\n";
						}
						echo '</ul>'."\n";
						echo '</li>'."\n";
					}
					echo '</ul>'."\n";
					echo '</div>'."\n";

					echo '<div class="col-md-6">'."\n";
					echo '<ul class="list-expanded">';
					$cats = array_slice($categories, $colTwoStartingIndex,
																	sizeof($categories)-$colTwoStartingIndex);
					foreach ($cats as $category) {
						$categoryID = preg_replace('/\s+/', '-', $category);
						$patternIDs = array_keys($patternCategories, $category);

						echo '<li>'."\n";
						echo '<div class="list-name-expanded">'.$category.'</div>'."\n";
						echo '<ul class="patterns-list patterns-list-grouped">'."\n";
						foreach ($patternIDs as $id) {
							echo '<li class="pattern-clickable" id="'.$id.'">'."\n";
							echo '<p class="name">'.$patternNames[$id].'</p>';
							echo '<p class="description">'.$patternDescriptions[$id].'</p>';
							echo '</li>'."\n";
						}
						echo '</ul>'."\n";
						echo '</li>'."\n";
					}
					echo '</ul>'."\n";
					echo '</div>'."\n";
				}
			?>

			<div class="hide" id="view-by-category-collapsed">
				<?php showCollapsedPatternsByCategory(); ?>
			</div>
			<div id="view-by-category-expanded">
				<?php showExpandedPatternsByCategory(); ?>
			</div>
		</div>

		<div class="hide text-center" id="view-by-relation">
			<img src="img/expp-rel.png" width="1140" height="449" alt="relationship graph for experience-centered patterns" usemap="#patternmap">
			<map name="patternmap" id="patternmap">
				<area shape="rect" coords="312,18,448,78" href="pattern.php?id=expp1" alt="Multiplayer Competition" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="502,18,638,78" href="pattern.php?id=expp9" alt="Age Appropriate Theme" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="692,18,828,78" href="pattern.php?id=expp7" alt="Advancing" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="882,18,1018,78" href="pattern.php?id=expp8" alt="Optimistic Performance Evaluation" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="122,123,258,184" href="pattern.php?id=expp11" alt="Familiar Theme" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="312,123,448,184" href="pattern.php?id=expp6" alt="Pick up and Play" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="502,123,638,184" href="pattern.php?id=expp4" alt="Gentle Challenge Ramp" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="312,228,448,289" href="pattern.php?id=expp5" alt="Minimized Distraction" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="502,228,638,289" href="pattern.php?id=expp3" alt="Adjustable Speed" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="692,228,828,289" href="pattern.php?id=expp2" alt="Optional High-Level Challenge" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
				<area shape="rect" coords="312,334,448,394" href="pattern.php?id=expp10" alt="Enabling Theme" data-maphilight='{"shadow":true,"fill":false,"strokeWidth":4, "strokeColor":"555555"}'>
			</map>
		</div>

	</div>
	<br/><br/>

	<!-- JavaScript plugins (requires jQuery) -->
	<script src="js/jquery.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.rwdImageMaps.min.js"></script>
	<script src="js/jquery.maphilight.mod.js"></script>

	<script src="js/pattern-change-view.js"></script>
	<script src="js/pattern-clickable.js"></script>
</body>
</html>
