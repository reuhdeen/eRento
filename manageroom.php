<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'db.php';
    $id = $_GET['id'];
  $sql = "SELECT * FROM erento.room WHERE property_id = '$id';";
  $result = $db->query($sql);

  $sql3 = "SELECT * FROM erento.property WHERE property_id = '$id';";
  $results = mysqli_query($db, $sql3);
  $prop = mysqli_fetch_assoc($results);
  $property_name = $prop['property_name'];


  $userid = 0;
  if(isset($_POST['userid'])){
      $userid = mysqli_real_escape_string($db,$_POST['userid']);
  }


  if(isset($_POST['deleteRoom'])){
     $deleteRID = $_POST['deleteRID'];
    $sql = "DELETE FROM `erento`.`room` WHERE `room_id` = '$deleteRID';";
      if ($db->query($sql) === TRUE){

            ?>
            <script>
                         alert("Room Deleted Successfully!");
                       </script>
            <?php 
      }
      else{
            ?>
            <script>
                         alert("Unable to delete room!");
                       </script>
            <?php 

      }
  }

  if(isset($_POST['updateRoom'])){

 $updateRID = $_POST['updateRID'];
 $room_name = $_POST['Uroom_name'];
 $room_no = $_POST['Uroom_no'];
 $desc = $_POST['Udesc'];
 $capacity = $_POST['Ucapacity'];
 $price = $_POST['Uprice'];
 $unit = $_POST['Uunit'];

 $sql = "UPDATE `erento`.`room` SET `room_name` = '$room_name', `room_no` = '$room_no', `desc` = '$desc', `capacity` = '$capacity', `price` = '$price', `unit` = '$unit' WHERE `room_id` = '$updateRID';";
  if ($db->query($sql) === TRUE){
    

          $Uroom_images = array();
          if(isset($_FILES['Uroom_images']['name'])){
              $count = count($_FILES['Uroom_images']['name']);

                   for($i=0;$i<$count;$i++){
                      $folder = "img/";
                      $filename = $_FILES['Uroom_images']['name'][$i];
                      $target_file = $folder . basename($filename);
                      $tempname = $_FILES['Uroom_images']['tmp_name'][$i];
                      

                      move_uploaded_file($tempname,$target_file);
                      $Uroom_images[] = $filename;
                   }

                   $Uimages = implode(',',$Uroom_images);
              $sql = "UPDATE `erento`.`room` SET `room_images` = '$Uimages' WHERE `room_id` = '$updateRID';";
              mysqli_query($db, $sql);

             ?>
             <script>
                          alert("Room Updated Successfully!");
                        </script>
             <?php 

        }

  }
  else{
    ?> 
        <script>
          alert("Failed to update!");
        </script>
    <?php
  }

}




  $room_images = array();
  if(isset($_POST['addp'])){
  // Get the form data
      $room_name = mysqli_real_escape_string($db, $_POST['room_name']);
      $room_no = mysqli_real_escape_string($db, $_POST['room_no']);
      $desc = mysqli_real_escape_string($db, $_POST['desc']);
      $capacity = mysqli_real_escape_string($db, $_POST['capacity']);
      $price = mysqli_real_escape_string($db, $_POST['price']);
      $unit = mysqli_real_escape_string($db, $_POST['unit']);


      $count = count($_FILES['room_images']['name']);

           for($i=0;$i<$count;$i++){
              $folder = "img/";
              $filename = $_FILES['room_images']['name'][$i];
              $target_file = $folder . basename($filename);
              $tempname = $_FILES['room_images']['tmp_name'][$i];
              

              move_uploaded_file($tempname,$target_file);
              $room_images[] = $filename;

           }

      // Insert the property into the database
           $images = implode(',',$room_images);
      $sql2 = "INSERT INTO room (property_id, room_name, room_no, `desc`, capacity, price, unit, room_images) VALUES ('$id','$room_name', '$room_no', '$desc', '$capacity', '$price', '$unit', '$images')";
      mysqli_query($db, $sql2);

     ?>
     <script>
                
                  alert("New Room added");
                </script>
     <?php 

}
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <?php 
            include 'csslink.php';
        ?>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php 
            include 'header.php';
        ?>
    

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $property_name; ?></h1><button id="addnewr" type="button" class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal">
                      <i class="fas fa-plus"></i>    Add New Room
                    </button>
                    </div>
                    <!-- Button trigger modal -->
                    

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Room</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post" action="" enctype="multipart/form-data">
                            <div class="row">
                            
                                <div class="col-4 col-md-4 mb-4">
                              <label for="room_name">Room Name:</label>
                            </div>
                              <div class="col-8 col-md-8 mb-4">
                              <input type="text" class="form-control form-control-sm" name="room_name" required>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="room_no">Room No:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input type="text" class="form-control form-control-sm" name="room_no" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="desc">Description:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <textarea class="form-control form-control-sm" rows="5" name="desc" required></textarea>
                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="capacity">Capacity:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input type="number" class="form-control form-control-sm" name="capacity" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="price">Price:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input type="number" class="form-control form-control-sm" name="price" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="unit">Unit:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input type="text" class="form-control form-control-sm" name="unit" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="formFile">Room Images:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input class="form-control" type="file" id="formFile" name="room_images[]" multiple>
                                </div>
                            </div>

                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <input type="submit" value="Confirm" class="btn btn-primary" name="addp">
                           
                          </div>
                          </form>
                        </div>
                      </div>
       
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of all rooms</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Room No.</th>
                                            <th>Room Name</th>
                                            <th>Description</th>
                                            <th>Capacity</th>
                                            <th>Price</th>
                                            <th>No of Current Occupants</th>
                                            <th data-sortable="false">View</th>
                                             <th data-sortable="false">Update</th>
                                            <th data-sortable="false">Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Room No.</th>
                                            <th>Room Name</th>
                                            <th>Description</th>
                                            <th>Capacity</th>
                                            <th>Price</th>
                                            <th>No of Current Occupants</th>
                                            <th>View</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        if ($result->num_rows > 0) {
                                          while($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row["room_no"];?></td>
                                            <td><?php echo $row["room_name"];?></td>
                                            <td><?php echo $row["desc"];?></td>
                                            <td><?php echo $row["capacity"];?></td>
                                            <td><?php echo $row["price"] . '/' . $row["unit"];?></td>
                                            <?php $roid = $row["room_id"]; 
                                            $sqlup = "SELECT COUNT(*) AS cOccupant FROM occupants WHERE room_id = $roid;";
                                            $resultup = mysqli_query($db, $sqlup);
                                            $data = mysqli_fetch_assoc($resultup);
                                            $newC = $data["cOccupant"];

                                            $sql4 = "UPDATE `erento`.`room` SET `no_of_occupants` = '$newC' WHERE `room_id` = '$roid';";
                                             if ($db->query($sql4) === TRUE){
                                             }

                                            ?>
                                            <td><?php 
                                            if ($newC == $row["capacity"]) {
                                                echo '<span class="text-success"><i class="fas fa-check-circle"></i>&nbsp;Fully Occupied</span>'; 
                                            }else{
                                                echo $data["cOccupant"];
                                            }
                                            ?></td>
                                            <td class="align-middle"><center><?php echo "<a href='viewroom.php?rid={$row['room_id']}&id={$id}' class='btn btn-primary btn-sm'><i class='fas fa-eye'></a>";?></center></td>
                                                <td class="align-middle"><center><button type="button" class="btn btn-primary btn-sm yellow-btn userinfo" data-id="<?php echo $row["room_id"];?>"><i class="fas fa-edit"></button></center></td>        
                                                <td class="align-middle"><center><button type="button" class="btn btn-primary btn-sm btn-dark deleter" data-id="<?php echo $row["room_id"];?>"><i class="fas fa-trash-alt"></button></center></td>

                                        </tr>
                                        <?php 

                                            }
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->


<!-- Modal -->
   <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">
 
     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Room</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body ubody">
 
      </div>
     </div>
    </div>
   </div>


   <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog">
 
     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Room</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <div class="modal-body dbody">
      </div>
     </div>
    </div>
   </div>





            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; e-Rento 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script type="text/javascript">
            $(document).ready(function(){

               $('.deleter').click(function(){
               
                   var userid = $(this).data('id');

                   // AJAX request
                   $.ajax({
                       url: 'deleteroom.php',
                       type: 'post',
                       data: {userid: userid},
                       success: function(response){ 
                           // Add response in Modal body
                           $('.dbody').html(response);

                           // Display Modal
                           $('#deleteModal').modal('show'); 
                       }
                   });
               });
            });

    </script>

    <script>
      window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('add') === 'true') {
          document.getElementById("addnewr").click();
        }
      };
    </script>

    <script type="text/javascript">
            $(document).ready(function(){

               $('.userinfo').click(function(){
               
                   var userid = $(this).data('id');

                   // AJAX request
                   $.ajax({
                       url: 'ajaxfile.php',
                       type: 'post',
                       data: {userid: userid},
                       success: function(response){ 
                           // Add response in Modal body
                           $('.ubody').html(response);

                           // Display Modal
                           $('#empModal').modal('show'); 
                       }
                   });
               });
            });

    </script>
</body>

</html>