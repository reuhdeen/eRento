<?php 


include 'db.php';

$userid = 0;
if(isset($_POST['userid'])){
    $userid = mysqli_real_escape_string($db,$_POST['userid']);
}
$sql = "select * from erento.reservation where reservation_id=".$userid;
$result = mysqli_query($db,$sql);


while( $row = mysqli_fetch_array($result) ){

    $room_no = $row['room_id'];
    $user_id = $row['user_id'];
    $purpose = $row['purpose'];

    ?>


          <form method="post" action="" enctype="multipart/form-data">
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="room_no">Room No:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <label for="room_no"><?php echo $room_no; ?></label>
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="room_no">User ID:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <label for="room_no"><?php echo $user_id; ?></label>
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="room_no">Purpose:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <label for="room_no"><?php echo $purpose; ?></label>
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="desc">Message:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <textarea class="form-control form-control-sm" rows="5" name="Message" placeholder="optional"></textarea>
                  <input type="hidden" name="updateRID" value="<?php echo $userid; ?>">
                  <input type="hidden" name="room_noR" value="<?php echo $room_no; ?>">
                  <input type="hidden" name="user_idR" value="<?php echo $user_id; ?>">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <input type="submit" value="Confirm" class="btn btn-primary" name="updateRoom">
         
        </div>
        </form>

<?php

}

?>