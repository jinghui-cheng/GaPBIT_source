<!--
  $id                //pattern id
  $name              //pattern name
-->

<?php
  function createAddPatternModal($id, $name) {
    echo '<div class="modal fade other-patterns-modal" id="addPatternModal-'.$id.'" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">';
    include './login/config.php';

    if ($user->isSigned()) {
      echo '    <div class="modal-body">
                  <h4 class="modal-title">
                    <i class="fa fa-info-circle" style="font-size: 120%;"></i>
                    Add '.$name.' to your saved patterns?
                  </h4>
                  <a href="./login/logout.php" style="margin-left: 25px;">[ Not '.$user->Username.'? </span>Logout ]</a>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary btn-ok" href="mypatterns/add-pattern.php?id='.$id.'">Add</a>
                </div>';
    } else {
      echo '    <div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          			</div>';
      echo '    <div class="modal-body">
                  <div class="row">
						        <div class="col-md-10 col-centered">';
      include './login/user-signin-signup.php';
      echo '        </div>
                  </div>
                </div>';
    }
    echo '    </div>
            </div>
          </div>';
  }
?>
