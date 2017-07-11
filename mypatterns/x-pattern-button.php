<!--
  $id                       //pattern id
-->

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

<div class="x-to-mypatterns">
  <?php
    $addButton = '<a href="#" class="btn btn-primary btn-sm visible-lg visible-sm" data-toggle="modal" data-target="#addPatternModal-'.$id.'">
                    <i class="fa fa-plus"></i> &nbsp;Add to saved patterns
                  </a>
                  <div class="hidden-lg hidden-sm" data-toggle="tooltip" data-placement="bottom" title="Add to saved patterns">
            				<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPatternModal-'.$id.'">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>';
    $removeButton = ' <a href="#" class="btn btn-default btn-sm visible-lg visible-sm" data-toggle="modal" data-target="#removePatternModal-'.$id.'">
                        <i class="fa fa-minus"></i> &nbsp;Remove from saved patterns
                      </a>
                      <div class="hidden-lg hidden-sm" data-toggle="tooltip" data-placement="bottom" title="Remove from saved patterns">
                				<a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#removePatternModal-'.$id.'">
                          <i class="fa fa-minus"></i>
                        </a>
                      </div>';
    $accessButton = ' <a href="#" class="btn btn-nofunction btn-sm visible-lg visible-sm">
                        <i class="fa fa-bookmark"></i> &nbsp;In my saved patterns
                      </a>
                      <div class="hidden-lg hidden-sm" data-toggle="tooltip" data-placement="bottom" title="In my saved patterns">
                				<a href="#" class="btn btn-nofunction btn-sm">
                          <i class="fa fa-bookmark"></i>
                        </a>
                      </div>';

    include './login/config.php';

    if ($user->isSigned()) {
      include 'connect.php';

      $sql = "SELECT PatternID FROM UserPatterns WHERE Username='$user->Username' AND PatternID='$id'";
      $result = $conn->query($sql);

      if ($result->num_rows == 0) {
        echo $addButton;
      } else {
        echo $accessButton;
      }

      $conn->close();
    } else {
      echo $addButton;
    }
  ?>
</div>
