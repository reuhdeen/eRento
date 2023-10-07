<?php 


include 'db.php';

$userid = 0;
if(isset($_POST['userid'])){
    $userid = mysqli_real_escape_string($db,$_POST['userid']);
}


    ?>


          <form method="post" action="" enctype="multipart/form-data">

          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label class="text-msuiit"><b>WARNING!:</b></label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                <input type="hidden" name="deleteRID" value="<?php echo $userid; ?>">
                    <p>This action cannot be undone. Do you want to continue?</p>
              </div>
          </div>
         
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <input type="submit" value="Confirm" class="btn btn-primary" name="deleteRoom">
         
        </div>
        </form>

