<!DOCTYPE html>
<html lang="en">
<?php
session_start();
  include 'db.php';
    $id = $_GET['id'];
  $sql = "SELECT * FROM erento.reservation INNER JOIN users ON reservation.user_id = users.user_id WHERE reservation.property_id = '$id' order by date_created DESC;";
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
    $Message = $_POST['Message'];
    $updateRID = $_POST['updateRID'];
    $room_noR = $_POST['room_noR'];
    $user_idR = $_POST['user_idR'];

    date_default_timezone_set('Asia/Manila'); 
    $current_date_time = date('Y-m-d H:i:s');

    $sql = "UPDATE `erento`.`reservation` SET `status` = 'Booked' WHERE `reservation_id` = '$updateRID';";
    $msg = "Your booking on <b>".$property_name."'s</b> room no. <b>".$room_noR."</b> has been approved. Please submit the required documents and pay the reservation fees.<br><br><b>Message:</b> ".$Message;
    $msgs = strval($msg);
    
    if ($db->query($sql) === TRUE){
        $sql2 = "INSERT INTO `erento`.`notification` (`notif_name`, `notif_body`, `date_created`, `user_id`) VALUES ('Booking Approved!', \"$msgs\", '$current_date_time', '$user_idR');";
        if ($db->query($sql2) === TRUE){
             
                echo '<script>
                  alert("Booking Approved!");
                </script>';
           
        }else{
        ?> 
            <script>
              alert("Failed to update!");
            </script>
        <?php
      }
    }else{
        ?> 
            <script>
              alert("Failed to update!");
            </script>
        <?php
      }

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
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $property_name; ?></h1>
                    </div>
                    <!-- Button trigger modal -->
                    


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of reservations</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Room No.</th>
                                            <th>Name</th>
                                            <th>Purpose</th>
                                            <th>Duration</th>
                                            <th>Date Created</th>
                                            <th>Date of Arrival</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Room No.</th>
                                            <th>Name</th>
                                            <th>Purpose</th>
                                            <th>Duration</th>
                                            <th>Date Created</th>
                                            <th>Date of Arrival</th>
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
                                            <td><?php echo $row["purpose"];?></td>
                                            <td><?php echo $row["length_of_stay"];?></td>
                                            <td><?php echo $row["date_created"];?></td>
                                            <td><?php echo $row["date_of_arrival"]."<br>".$row["time_of_arrival"];?></td>
                                            <td><?php if($row["status"] == "Pending"){ 
                                                echo '<span class="text-secondary"><i class="fas fa-clock"></i>&nbsp;Pending</span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-sm userinfo" data-id="'.$row["reservation_id"].'"><i class="fas fa-edit"></i></button>';
                                            }elseif ($row["status"] == "Booked") {
                                                echo '<span class="text-secondary"><i class="fas fa-clock"></i>&nbsp;Pending Requirements&nbsp;&nbsp;&nbsp;<a href="reservation.php?id='.$id.'&reservation='.$row["reservation_id"].'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>';
                                            }elseif ($row["status"] == "Approved") {
                                                echo '<p class="textyellow"></p><a href="reservation.php?id='.$id.'&reservation='.$row["reservation_id"].'" class="btn btn-primary btn-sm">Pending Requirements</a>';
                                            }elseif ($row["status"] == "To Be Reviewed") {
                                                 echo '<span class="textyellow"><i class="fas fa-folder"></i>&nbsp;Requirements Submitted&nbsp;&nbsp;&nbsp;<a href="reservation.php?id='.$id.'&reservation='.$row["reservation_id"].'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>';
                                            }elseif($row["status"] == "Rejected"){
                                                echo '<span class="text-secondary"><i class="fas fa-times-circle"></i>&nbsp;Rejected</span>'; 
                                            }else{
                                                echo '<span class="text-success"><i class="fas fa-check-circle"></i>&nbsp;Reserved</span>'; 
                                            } ?>
                                                                            
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
        <h4 class="modal-title">Approve Transaction</h4>
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

    <script type="text/javascript">
            $(document).ready(function(){

               $('.userinfo').click(function(){
               
                   var userid = $(this).data('id');

                   // AJAX request
                   $.ajax({
                       url: 'confirmbook.php',
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