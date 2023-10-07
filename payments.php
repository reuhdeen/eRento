<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'db.php';
    $id = $_GET['id'];
  $sql = "SELECT *, receipt.bill_id AS 'resbill', bills.date_created AS 'BDATE' FROM erento.receipt 
INNER JOIN bills ON receipt.bill_id = bills.bill_id
INNER JOIN occupants ON bills.occupant_id = occupants.occupant_id
INNER JOIN users ON occupants.user_id = users.user_id
INNER JOIN room ON occupants.room_id = room.room_id
        WHERE room.property_id = '$id' AND bills.bill_status = 'Receipt To Be Reviewed' order by bills.date_created DESC;";
  $result = $db->query($sql);
  $resultse = mysqli_query($db, $sql);
  $props = mysqli_fetch_assoc($resultse);

  $sql3 = "SELECT * FROM erento.property WHERE property_id = '$id';";
  $results = mysqli_query($db, $sql3);
  $prop = mysqli_fetch_assoc($results);
  $property_name = $prop['property_name'];


  $userid = 0;
  if(isset($_POST['userid'])){
      $userid = mysqli_real_escape_string($db,$_POST['userid']);
  }


  if(isset($_POST['confirmP'])){
     $confirmPi = $_POST['confRID'];
    $sql = "UPDATE `erento`.`bills` SET `bill_status` = 'Paid' WHERE `bill_id` = '$confirmPi';";
      if ($db->query($sql) === TRUE){

            ?>
            <script>
                         alert("Payment confirmed Successfully!");
                       </script>
            <?php 
      }
      else{
            ?>
            <script>
                         alert("Unable to update payment!");
                       </script>
            <?php 

      }
  }

  if(isset($_POST['updateOcc'])){

 $updateRID = $_POST['updateOID'];
 $UStatus = $_POST['actStatus'];


 $sql = "UPDATE `erento`.`occupants` SET `status` = '$UStatus' WHERE `occupant_id` = '$updateRID';";
  if ($db->query($sql) === TRUE){
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
                            <h6 class="m-0 font-weight-bold text-primary">List of payments</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Room No</th>
                                            <th>Occupants's Info</th>
                                            <th>Receipt</th>
                                            <th>Bill Date</th>
                                            <th data-sortable="false">Confirm</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Room No</th>
                                            <th>Occupants's Info</th>
                                            <th>Receipt</th>
                                            <th>Bill Date</th>
                                            <th data-sortable="false">Confirm</th>
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
                                            <td>
                                                <?php
                                                $dsn = "mysql:host=localhost;dbname=erento";
                                                $username = "root";
                                                $password = "erento";
                                                $db = new PDO($dsn, $username, $password);
                                                $resID = $row['resbill'];
                                                $stmt = $db->query("SELECT filename, filetype, filesize FROM erento.receipt WHERE bill_id = $resID");
                                                $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                              
                                                ?>

                                                <?php foreach ($files as $file): ?>
                                                            <li><a href="modal/receiptdownload.php?filename=<?php echo urlencode($file['filename']); ?>" class="link-primary"><?php echo $file['filename']; ?></a></li>
                                                        <?php endforeach; ?>
                                            </td>
                                            <td><?php echo $row["BDATE"];?></td>
                                            <td>
                                        <button type="button" class="btn btn-primary btn-sm yellow-btn deleter" data-id="<?php echo $row['resbill'];?>"><i class="fas fa-solid fa-check-double"></i></button>
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
        <h4 class="modal-title">Update Occupant Status</h4>
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
        <h4 class="modal-title">Confirm Payment</h4>
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
                       url: 'modal/confirmpayment.php',
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