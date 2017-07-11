<!-- force reload -->
<input type="hidden" id="refreshed" value="no">
<script type="text/javascript">
  $(document).ready(function(e) {
    var e = document.getElementById("refreshed");
    if (e.value == "no") {
      e.value = "yes";
    } else {
      e.value = "no";
      location.reload();
    }
  });
</script>
<!-- force reload end -->

<?php
  include 'connect.php';

  $sql = "SELECT PatternID FROM UserPatterns WHERE Username='$user->Username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          array_push($myPatternIDs, $row["PatternID"]);
      }
  }

  $conn->close();
?>

<p>
  <span class="heading">
    There are <?php echo sizeof($myPatternIDs); ?> pattern(s) in your collection
  </span>
  <a href="./login/logout.php" style="margin-left: 10px;">[ Not <?php echo $user->Username?>? </span>Logout ]</a>
</p>


<?php
  include 'pattern-util.php';
  include "remove-pattern-modal.php";

  $myPatternNames = array();
  $myPatternDescriptions = array();

  readPatternsList('data/eff-patterns.csv');
  foreach ($myPatternIDs as $id) {
    if (strpos($id, "effp") !== false) {
      $myPatternNames[$id] = getPatternNameByID($id);
      $myPatternDescriptions[$id] = getPatternDescriptionByID($id);
    }
  }

  readPatternsList('data/exp-patterns.csv');
  foreach ($myPatternIDs as $id) {
    if (strpos($id, "expp") !== false) {
      $myPatternNames[$id] = getPatternNameByID($id);
      $myPatternDescriptions[$id] = getPatternDescriptionByID($id);
    }
  }

  function showOnePatten($id, $name, $description) {
		createRemovePatternModal($id, $name);

    echo '<li class="pattern-clickable" id="'.$id.'">'."\n";
    echo '<p class="name">'.$name.'
            <a class="remove-icon pull-right" data-toggle="modal" data-target="#removePatternModal-'.$id.'">
              &times;
            </a>
          </p>';
    echo '<p class="description">'.$description.'</p>';
    echo '</li>'."\n";
  }

  function showPatternsByName()
  {
    global $myPatternNames;
    global $myPatternDescriptions;

    array_multisort($myPatternNames, $myPatternDescriptions);
    $colTwoStartingIndex = ceil(sizeof($myPatternNames)/2);

    echo '<div class="col-md-6">'."\n";
    echo '<ul class="patterns-list">'."\n";
    $patterns = array_slice($myPatternNames, 0,
                            $colTwoStartingIndex);
    foreach ($patterns as $id => $name) {
      showOnePatten($id, $name, $myPatternDescriptions[$id]);
    }
    echo '</ul>'."\n";
    echo '</div>'."\n";

    echo '<div class="col-md-6">'."\n";
    echo '<ul class="patterns-list">'."\n";
    $patterns = array_slice($myPatternNames, $colTwoStartingIndex,
                            sizeof($myPatternNames)-$colTwoStartingIndex);
    foreach ($patterns as $id => $name) {
      showOnePatten($id, $name, $myPatternDescriptions[$id]);
    }
    echo '</ul>'."\n";
    echo '</div>'."\n";
  }
?>

<div class="row">
  <?php showPatternsByName(); ?>
</div>
