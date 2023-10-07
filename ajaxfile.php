<?php 


include 'db.php';

$userid = 0;
if(isset($_POST['userid'])){
    $userid = mysqli_real_escape_string($db,$_POST['userid']);
}
$sql = "select * from erento.room where room_id=".$userid;
$result = mysqli_query($db,$sql);


while( $row = mysqli_fetch_array($result) ){

    $room_id = $row['room_id'];
    $room_name = $row['room_name'];
    $room_no = $row['room_no'];
    $desc = $row['desc'];
    $capacity = $row['capacity'];
    $price = $row['price'];
    $unit = $row['unit'];
    ?>


          <form method="post" action="" enctype="multipart/form-data">
          <div class="row">
          
              <div class="col-4 col-md-4 mb-4">
            <label for="room_name">Room Name:</label>
          </div>
            <div class="col-8 col-md-8 mb-4">
            <input type="text" class="form-control form-control-sm" name="Uroom_name" value="<?php echo $room_name; ?>">
            </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="room_no">Room No:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <input type="text" class="form-control form-control-sm" name="Uroom_no" value="<?php echo $room_no; ?>">
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="desc">Description:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <textarea class="form-control form-control-sm" rows="5" name="Udesc"><?php echo $desc; ?></textarea>
              
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="capacity">Capacity:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <input type="number" class="form-control form-control-sm" name="Ucapacity" value= "<?php echo $capacity;?>">
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="price">Price:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <input type="number" class="form-control form-control-sm" name="Uprice" value="<?php echo $price; ?>">
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="unit">Unit:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <input type="text" class="form-control form-control-sm" name="Uunit" value="<?php echo $unit; ?>">
                   <input type="hidden" name="updateRID" value="<?php echo $room_id; ?>">
              </div>
          </div>
          <div class="row">
              <div class="col-4 col-md-4 mb-4">
                  <label for="formFile">Room Images:</label>
              </div>
              <div class="col-8 col-md-8 mb-4">
                  <input class="form-control" type="file" id="formFile" name="Uroom_images[]" multiple>
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