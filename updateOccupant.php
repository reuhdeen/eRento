<?php 


include 'db.php';

$userid = 0;
if(isset($_POST['userid'])){
    $userid = mysqli_real_escape_string($db,$_POST['userid']);
}
$sql = "select * from erento.occupants where occupant_id=".$userid;
$result = mysqli_query($db,$sql);


while( $row = mysqli_fetch_array($result) ){

    $status = $row['status'];

    ?>


          <form method="post" action="" enctype="multipart/form-data">
          <div class="row px-2">
          

              <a class="btn btn-primary yellow-btn btn-sm btn-block" data-toggle="collapse" href="#AddBill" role="button" aria-expanded="false" aria-controls="collapseExample">Add Bill</a>

            </div>

            <div class="collapse" id="AddBill">
              <div class="card card-body">

                <label for="property_name">Amount:</label>
                <input type="number" name="BAmount" >
                <label for="property_name">Description:</label>
                <input type="text" name="Bdesc" >
              
              </div>
            </div>


            <br>

          <div class="row">
          
              <div class="col-4 col-md-4 mb-4">
            <label for="room_name">Status:</label>
          </div>
            <div class="col-8 col-md-8 mb-4">
              <input type="hidden" name="updateOID" value="<?php echo $row['occupant_id']; ?>">


            <select class="form-select form-control form-control-sm" aria-label="Default select example"   name="actStatus">
              <option selected><?php echo $status; ?></option>
              <?php if($status == "Checked In"){
                echo ' <option value="Checked Out">Checked Out</option>';
              }else {
                echo ' <option value="Checked In">Checked In</option>';
              }?>
             
            </select>

            </div>
          </div>
        
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <input type="submit" value="Confirm" class="btn btn-primary" name="updateOcc">
         
        </div>
        </form>

<?php

}

?>