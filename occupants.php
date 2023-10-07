<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'db.php';
    $id = $_GET['id'];
  $sql = "SELECT o.occupant_id, username, lname, fname,email, contact,address, u.user_id,r.price, r.unit,o.balance, o.room_id, `status`, o.start_date
        FROM occupants o
        INNER JOIN room r ON o.room_id = r.room_id
        INNER JOIN users u ON o.user_id = u.user_id
        WHERE r.property_id = '$id' order by o.start_date DESC;";
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

  if(isset($_POST['updateOcc'])){

 $updateRID = $_POST['updateOID'];
 $UStatus = $_POST['actStatus'];


 $sql = "UPDATE `erento`.`occupants` SET `status` = '$UStatus' WHERE `occupant_id` = '$updateRID';";
  if ($db->query($sql) === TRUE){
        if(!empty($_POST['BAmount'])){
            if(!empty($_POST['Bdesc'])){
                $BAmount = $_POST['BAmount'];
                $Bdesc = $_POST['Bdesc'];
                $NewSql = "INSERT INTO `erento`.`other_bills` (occupant_id, `desc`, amount) VALUES ('$updateRID','$Bdesc', $BAmount);";
                if ($db->query($NewSql) === TRUE){

                    ?>
                    <script>
                                 alert("Occupant Updated Successfully!");
                               </script>
                    <?php 

                }

            }
        }
        ?>
             <script>
                          alert("Occupant Updated Successfully!");
                        </script>
             <?php 

             
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
  if(isset($_POST['addc'])){
  // Get the form data
      $room_no = mysqli_real_escape_string($db, $_POST['room_no']);
      $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
      $sql2 = "INSERT INTO erento.occupants (user_id, room_id, status) VALUES ('$user_id','$room_no', 'Checked In')";
      mysqli_query($db, $sql2);

     ?>
     <script>
                
                  alert("New occupant added");
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
                      <i class="fas fa-plus"></i>    Add Existing Occupant
                    </button>
                    </div>
                    <!-- Button trigger modal -->
                    

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Existing Occupant</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post" action="" enctype="multipart/form-data">
                            <div class="row">
                            
                                <div class="col-4 col-md-4 mb-4">
                              <label for="room_name">Room No:</label>
                            </div>
                              <div class="col-8 col-md-8 mb-4">
                              <input type="text" class="form-control form-control-sm" name="room_no" required>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="room_no">User ID:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input type="text" class="form-control form-control-sm" name="user_id" required>
                                </div>
                            </div>
                            
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <input type="submit" value="Confirm" class="btn btn-primary" name="addc">
                           
                          </div>
                          </form>
                        </div>
                      </div>
       
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of all occupants</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Room No</th>
                                            <th>Occupants's Info</th>
                                            <th>Rate</th>
                                            <th>Date Checked In</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Room No</th>
                                            <th>Occupants's Info</th>
                                            <th>Rate</th>
                                            <th>Date Checked In</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        $z = 0;
                                        if ($result->num_rows > 0) {
                                          while($row = $result->fetch_assoc()) {
                                            $z++;
                                        ?>
                                        <tr>
                                            <td><?php echo $z;?></td>
                                            <td><?php echo $row["room_id"];?></td>
                                            <td><?php 
                                                echo '<b>Name:</b> '.$row["lname"].', '.$row["fname"].'<br>';
                                                echo '<b>Email:</b> '.$row["email"].'<br>';
                                                echo '<b>Contact:</b> '.$row["contact"].'<br>';
                                                echo '<b>Address:</b> '.$row["address"].'<br>';
                                                ?>
                                            </td>
                                            <td><?php echo $row["price"].'/'.$row["unit"];?></td>
                                            <td><?php echo $row["start_date"];?></td>
                                            <td><?php 

                                            if ($row["status"] == "Checked In") {
                                                echo '<span class="text-success"><i class="fas fa-check-circle"></i>&nbsp;'. $row["status"].'</span>&nbsp;&nbsp;&nbsp;';
                                            }else{
                                                echo '<span class="text-secondary"><i class="fas fa-times-circle"></i>&nbsp;'. $row["status"].'</span>&nbsp;&nbsp;&nbsp;';
                                            }

                                            ?>
                                            <?php echo "<a href='viewroom.php?rid={$row['room_id']}&id={$id}' class='btn btn-primary btn-sm'><i class='fas fa-eye'></i></a>";?>
                                        <button type="button" class="btn btn-primary btn-sm yellow-btn userinfo" data-id="<?php echo $row["occupant_id"];?>"><i class='fas fa-edit'></i></a></button>
                                                        </td>

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
        <h4 class="modal-title">Update Occupant</h4>
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
                       url: 'updateOccupant.php',
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