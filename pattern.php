<?php
	$id = $_GET['id'];
	if (!isset($id)) {
		header("Location: index.html");
 		exit;
	}

	if (strpos($id, "effp") !== false) {
		$type = "eff";
	} else if (strpos($id, "expp") !== false) {
		$type = "exp";
	} else {
		header("Location: index.html");
 		exit;
	}
?>

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
	<link rel="stylesheet" type="text/css" media="screen" href="css/pattern.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/mypatterns.css">

	<script src="js/jquery.js"></script>
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
					<button class="btn navbar-brand btn-primary" id="go-back">Go Back</button>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="navbar-responsive-collapse">
					<ul class="nav navbar-nav navbar-left">
						<?php
							if ($type == "eff") {
								echo '<li class="active"><a href="eff-patterns.php">Patterns Focused on Therapy Goals</a></li>';
								echo '<li><a href="exp-patterns.php">Patterns Focused on Player Experience</a></li>';
							} else if ($type == "exp") {
								echo '<li><a href="eff-patterns.php">Patterns Focused on Therapy Goals</a></li>';
								echo '<li class="active"><a href="exp-patterns.php">Patterns Focused on Player Experience</a></li>';
							}
						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="my-patterns.php">My Saved Patterns</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</div><!-- /.container-fluid -->
	</nav>

  <?php
		include 'pattern-util.php';
		readPatternsList('data/'.$type.'-patterns.csv');

		if ($type == "eff") {
			readGoals();
		}

		readComments();

    //Read pattern detialed info
		if (file_exists('data/patterns/'.$id.'.pattern.json')) {
			$jsonData = file_get_contents('data/patterns/'.$id.'.pattern.json');
      $patternInfo = json_decode($jsonData, true);
		}

		//Set placeholder text
		if (!isset($patternInfo['definition'])) {
			$patternInfo['definition'] = 'No data.';
		}

		if (!isset($patternInfo['problem'])) {
			$patternInfo['problem'] = 'No data.';
		}

		if (!isset($patternInfo['solution'])) {
			$patternInfo['solution'] = 'No data.';
		}

		if (!isset($patternInfo['related-patterns'])) {
			$patternInfo['related-patterns'] = 'No data.';
		}

		//Read pattern goals and category info
    $patternGoals = getGoalsAssociatedWithPattern($id);
    $patternCategory = getPatternCategoryByID($id);
		$patternInfo['name'] = getPatternNameByID($id);

		//Read game control info
		$gameControlType = array();
		$gameControlInfo = array();
		$fh = fopen('data/patterns/example-games/game-control.csv', 'r');
		while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
			$gameControlType[$data[0]] = $data[1];
			$gameControlInfo[$data[0]] = $data[2];
		}

		//Read gameplay info
    $exampleGamesInfo = json_decode(file_get_contents('data/patterns/example-games/example-games-info.json'), true);

		function getExampleGameInfo ($gameName) {
			global $exampleGamesInfo;
			foreach ($exampleGamesInfo["example-games"] as $info) {
				if ($info["name"] == $gameName)
					return $info;
			}
		}
  ?>

	<div class="modal fade other-patterns-modal" id="categoryModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><b><?php echo $patternCategory;?> Patterns</b></h4>
					<p class="modal-title-sub">Click on pattern name to see more information.</p>
				</div>
				<div class="modal-body">
					<ul class="patterns-list">
						<?php
							$patternIDs = getPatternIDsByCategory($patternCategory);
							foreach ($patternIDs as $pid) {
								echo '<li class="pattern-clickable" id="'.$pid.'">'."\n";
								echo '	<p class="name">'.$patternNames[$pid].'</p>';
								echo '	<p class="description">'.$patternDescriptions[$pid].'</p>';
								echo '</li>'."\n";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<?php
		if ($type == "eff") {
			foreach($patternGoals as $goalID => $goal) {
				echo '<div class="modal fade other-patterns-modal" id="goal'.$goalID.'" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title"><b>Patterns for '.$goal.'</b></h4>
											<p class="modal-title-sub">Click on pattern name to see more information.</p>
										</div>
										<div class="modal-body">
											<ul class="patterns-list">';

				$patternIDs = getPatternIDsByGoal($goalID);
				foreach ($patternIDs as $pid) {
					echo '				<li class="pattern-clickable" id="'.$pid.'">'."\n";
					echo '					<p class="name">'.$patternNames[$pid].'</p>';
					echo '					<p class="description">'.$patternDescriptions[$pid].'</p>';
					echo '				</li>'."\n";
				}

				echo '			  </ul>
										</div>
									</div>
								</div>
							</div>';
			}
		}
	?>

	<?php
	  include "mypatterns/add-pattern-modal.php";
	  include "mypatterns/remove-pattern-modal.php";

		createAddPatternModal($id, $patternInfo['name']);
		createRemovePatternModal($id, $patternInfo['name']);
	?>

	<div class="pattern-basic-info">
		<div class="pattern-name"><?php echo $patternInfo['name'];?></div>

		<?php
			if ($type == "eff") {
				echo '<div class="pattern-therapy-goals">';
				echo '	<b>Target Therapy Goal(s): </b>';
				foreach($patternGoals as $goalID => $goal) {
					echo '<span class="tagButton" data-toggle="tooltip" data-placement="bottom" title="Click to see all patterns for '.$goal.'">
									<a href="#" data-toggle="modal" data-target="#goal'.$goalID.'">
										'.$goal.'
									</a>
								</span>';
				}
				echo '</div>';
			}
		?>

		<div class="pattern-category">
			<b>Category:</b>
			<span class="tagButton" data-toggle="tooltip" data-placement="bottom" title="Click to see all <?php echo $patternCategory;?> patterns">
				<a href="#" data-toggle="modal" data-target="#categoryModal">
					<?php echo $patternCategory;?>
				</a>
			</span>
		</div>

		<?php include "mypatterns/x-pattern-button.php"; ?>
	</div>

	<div class="container">
    <div class="row pattern-detailed-info <?php if ($type == "eff") echo "eff-pattern"; else echo "exp-pattern";?>">
      <div class="col-sm-7 col-md-8" class="pattern-summary" id="pattern-summary">
				<div class="pattern-section">
						<div class="pattern-section-title">
						Definition
					</div>
	        <div class="pattern-section-content well">
	          <?php echo $patternInfo['definition'];?>
	        </div>
				</div>

				<div class="row">
					<div class="col-md-6 pattern-section pattern-section-problem" id="pattern-section-problem">
						<div class="pattern-section-title">
							Problem
						</div>
						<div class="pattern-section-content well">
							<?php
								echo ($patternInfo['problem']);
							?>
						</div>
			    </div>

					<div class="col-md-6 pattern-section pattern-section-solution" id="pattern-section-solution">
						<div class="pattern-section-title">
							Solution
						</div>
						<div class="pattern-section-content well">
							<?php
								echo ($patternInfo['solution']);
							?>
						</div>
			    </div>
				</div>
      </div>

      <div class="col-sm-5 col-md-4 pattern-section pattern-secton-related-patterns" id="pattern-secton-related-patterns">
				<div class="pattern-section-title">
					Related Patterns
				</div>
				<div class="pattern-section-content well well-sm">
          <ul class="realted-patterns-list">
            <?php
							if (is_array($patternInfo['related-patterns'])) {
								shuffle($patternInfo['related-patterns']);
	              foreach ($patternInfo['related-patterns'] as $rPattern) {
	                echo "<li>";
	                $html = $rPattern["description"];
									$html = str_replace('$thisPattern',
										'<span class="related-pattern-self-ref">'.$patternInfo['name'].'</span>', $html);

									if (isset($rPattern["name1"])) {
										//If there are multiple related patterns in one entry
										$i = 1;
										while (isset($rPattern["name".$i])) {
											$rpName = $rPattern["name".$i];
											$rpID = getPatternIDByName($rPattern["name".$i]);
											$html = str_replace('$rPattern'.$i,
												'<span class="related-pattern-link pattern-clickable" id="'.$rpID.'">'.$rpName.'</span>', $html);
											++$i;
										}
									} else {
		                $rpName = $rPattern["name"];
										$rpID = getPatternIDByName($rPattern["name"]);
		                $html = str_replace('$rPattern',
		                  '<span class="related-pattern-link pattern-clickable" id="'.$rpID.'">'.$rpName.'</span>', $html);
									}

									echo $html;
	                echo "</li>";
	              }
							} else {
								echo $patternInfo['related-patterns'];
							}
            ?>
          </ul>
        </div>
      </div>
    </div>

		<?php
			function createExampleGameSection ($title, $exampleGames) {
				global $gameControlType;
				global $gameControlInfo;
				global $id;
				global $patternInfo;

				$ret = '
					<div class="pattern-section">
						<div class="pattern-section-title">'.
							$title.'
						</div>
						<div class="panel-group game-list example-game-list" role="tablist" aria-multiselectable="true">';

				shuffle($exampleGames);
				foreach($exampleGames as $exampleGame) {
					$ret = $ret.'<div class="panel panel-default panel-game-list">
												<div class="panel-heading" role="tab" id="heading'.$exampleGame["id"].'">
													<a class="accordion-toggle" data-toggle="collapse" href="#example-game-'.$exampleGame["id"].'">
														<i class="fa fa-plus-square-o"></i> &nbsp;'.$exampleGame["name"].'
													</a>
												</div>
												<div id="example-game-'.$exampleGame["id"].'" class="panel-collapse collapse collapse-example-game" role="tabpanel" aria-labelledby="heading'.$exampleGame["id"].'">
  												<div class="panel-body">
  													<div class="row">
															<div class="col-sm-4 example-game-graph">
																<p>';

					$exampleGameImageName = 'img/pattern-example-games/'.$id.'-'.$exampleGame["id"].'.png';
					if (!file_exists($exampleGameImageName)) {
						$exampleGameImageName = 'img/pattern-example-game-placeholder.png';
					}

					$ret = $ret.'						<a href="#" data-toggle="modal" data-target="#exampleGameImage'.$exampleGame["id"].'">
																		<img src="'.$exampleGameImageName.'" width="100%" alt="Example game screenshots">
																	</a>';
					$ret = $ret.'						<div class="modal fade" id="exampleGameImage'.$exampleGame["id"].'">
																		<div class="modal-dialog">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																					<h4 class="modal-title">
																						<span style="font-size: 70%">'.$patternInfo['name'].' '.substr($title, 0, strlen($title)-3).'</span>
																						<br><b>'.$exampleGame["name"].'</b>
																					</h4>
																				</div>
																				<div class="modal-body">
																					<img src="'.$exampleGameImageName.'" alt="Example game screenshots" width="100%">
																				</div>
																			</div>
																		</div>
																	</div>';

					$ret = $ret.'					</p>
															</div>
															<div class="col-sm-8 example-game-detailed-info">';

					$gameInfo = getExampleGameInfo($exampleGame["name"]);

					if (isset($gameInfo["control"])) {
						if (isset($gameControlType[$gameInfo["control"]])) {
							$ret = $ret.'			<p>
																	<b>Control: </b>'.$gameControlType[$gameInfo["control"]].'
																	<a class="controlMoreInfo" role="button" data-toggle="collapse" href="#'.$exampleGame["id"].'Control" aria-expanded="false" aria-controls="'.$exampleGame["id"].'Control">
																	  More Info
																	</a>
																	<div class="collapse" id="'.$exampleGame["id"].'Control">
																	  '.$gameControlInfo[$gameInfo["control"]].'
																	</div>
																</p>';
						} else {
							$ret = $ret.'			<p><b>Control: </b>'.$gameInfo["control"].'</p>';
						}
					}

					if (isset($gameInfo["gameplay"])) {
						$ret = $ret.'				<p><b>Gameplay: </b>'.$gameInfo["gameplay"].'</p>';
					}

					if (strpos($title, "Anti") === false) {
						$ret = $ret.'				<p><b>Pattern realization: </b>'.$exampleGame["pattern-description"].'</p>';
					} else {
						$ret = $ret.'				<p><b>Pattern violation: </b>'.$exampleGame["pattern-description"].'</p>';
					}

					$comments = array();
					$gameIDs = explode("/", $gameInfo["gameID"]);
					foreach ($gameIDs as $value) {
						$temp = getComments($value);
						if (count($temp) > 0) {
							$comments = array_merge($comments, $temp);
						}
					}
					if (count($comments) > 0) {
						$ret = $ret.'				<p><b>Therapist comments</b></p>
																<div class="well therapist-comments-well" style="height: 150px; font-size: 90%;">';

						shuffle($comments);
						foreach ($comments as $value) {
							$therapistType = '';
							switch ($value['TherapistType']) {
								case 'PT':
									$therapistType = 'Physical Therapist';
									break;
								case 'OT':
									$therapistType = 'Occupational Therapist';
									break;
								case 'RT':
									$therapistType = 'Recreational Therapist';
									break;
								case 'SLP':
									$therapistType = 'Speech Language Pathologist';
									break;
								default:
									break;
							}
							$ret = $ret.'				<p><b>'.$therapistType.':</b> '.$value['Comments'].'</p>';
						}

						$ret = $ret.'				</div>';
					}

					$ret = $ret.'				</div> <!--  col-sm-8 -->
														</div> 	<!-- row -->
													</div>		<!-- panel-body -->
												</div>			<!-- example-game-id -->
											</div>				<!-- panel panel-default -->';
				}
				$ret = $ret.'</div></div>';
				return $ret;
			}
		?>

		<?php
			if (is_array($patternInfo['example-games'])) {
				echo createExampleGameSection("Example Game(s)", $patternInfo['example-games']);
			} else if ($patternInfo['example-games'] !== 'none') {
					echo $patternInfo['example-games'];
			}
		?>

		<?php
			if (isset($patternInfo['anti-example-games']) && is_array($patternInfo['anti-example-games'])) {
				echo createExampleGameSection("Anti Example Game(s)", $patternInfo['anti-example-games']);
			}
		?>
	</div>
	<br/><br/>

	<!-- JavaScript plugins (requires jQuery) -->
	<script src="js/jquery.cookie.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/pattern-layout.js"></script>
	<script src="js/pattern-clickable.js"></script>
	<script src="js/goback.js"></script>
</body>
</html>
