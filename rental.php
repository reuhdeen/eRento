<!DOCTYPE html>
<html lang="en">
<?php
// connect to the database
include 'db.php';
// get the list of occupants
$sql = "SELECT * FROM erento.occupants 
INNER JOIN room ON occupants.room_id = room.room_id;";
$result = mysqli_query($db, $sql);

// get the current date
$current_date = new DateTime();

// loop through each occupant
while ($row = mysqli_fetch_assoc($result)) {
  $start_date = new DateTime($row['start_date']);
  
  // get the first billing date after the start date
  $billing_date = clone $start_date;
  $billing_date->modify('first day of next month');
  
  $interval = new DateInterval('P1M');
  $period = new DatePeriod($billing_date, $interval, $current_date);
  foreach ($period as $date) {
    $billing_date = $date->format('Y-m-d');
    $day_of_month = $start_date->format('d');
    $created_date = $date->format('Y-m') . '-' . $day_of_month;
    // calculate amount
    $amount = $row['price'];
    // check if the billing date has already passed before creating a new bill
    if($current_date->format('Y-m-d') >= $billing_date && $billing_date != $start_date){
      // check if a bill already exists for this occupant and billing date
      $occupant_id = $row['occupant_id'];
      $sql = "SELECT * FROM bills WHERE occupant_id = $occupant_id AND date_created = '$created_date'";
      $result2 = mysqli_query($db, $sql);
      if (mysqli_num_rows($result2) == 0) {
        // insert a new bill for the occupant
        $sql = "INSERT INTO bills (occupant_id, amount, date_created, bill_for, bill_status) VALUES ($occupant_id, $amount, '$created_date', 'Monthly Rental', 'Unpaid')";
        mysqli_query($db, $sql);
      }
    }
  }
}

?>
<?php
session_start();
include 'db.php';
    $id = $_GET['id'];
    $month_of = isset($_GET['month_of']) ? $_GET['month_of'] : date('Y-m');
    $monthY = $month_of.'%';
  $sql = "SELECT *,o.occupant_id, u.username, u.user_id, r.price, r.unit, o.balance, o.room_id, `status`, start_date, b.amount AS 'aAmount'
        FROM erento.occupants o
        INNER JOIN room r ON o.room_id = r.room_id
        INNER JOIN users u ON o.user_id = u.user_id
        INNER JOIN bills b ON o.occupant_id = b.occupant_id
        LEFT JOIN payment p ON o.occupant_id = p.occupant_id
        WHERE r.property_id = $id AND b.date_created LIKE '$monthY' order by b.date_created DESC;";
  $result = $db->query($sql);

  $sql3 = "SELECT * FROM erento.property WHERE property_id = '$id';";
  $results = mysqli_query($db, $sql3);
  $prop = mysqli_fetch_assoc($results);
  $property_name = $prop['property_name'];


  $userid = 0;
  if(isset($_POST['userid'])){
      $userid = mysqli_real_escape_string($db,$_POST['userid']);
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
                            <form id="filter-report" method="GET" >
                                <div class="row form-group">
                                    <label class="control-label font-weight-bold col-md-1 text-primary">Month of: </label> 
                                    <input type="hidden" name="id" value="<?php echo ($id) ?>">
                                    <input type="month" name="month_of" class='from-control col-md-4' value="<?php echo ($month_of) ?>">
                                    <button class="btn btn-sm btn-block btn-primary col-md-2 ml-1">Filter</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Room No</th>
                                            <th>Occupants's Info</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Room No</th>
                                            <th>Occupants's Info</th>
                                            <th>Amount</th>
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
                                            <td><?php echo '<b>Name: </b>'.$row["lname"].', '.$row["fname"];
                                                      echo '<br><b>Contact: </b>'.$row["contact"];
                                            ?></td>
                                            <td><?php echo '₱'.(double)$row["aAmount"];?></td>
                                            <td><?php if ($row["bill_status"] == "Unpaid") {
                                                echo '<span class="textmaroon"><i class="fas fa-exclamation"></i>&nbsp;Unpaid</span>&nbsp;<span class="text-secondary"><span class="textmaroon"></span>';
                                            }else{
                                                echo '<span class="text-success"><i class="fas fa-check-circle"></i>&nbsp;Paid</span>';
                                            } ?>&nbsp</td>
                                        

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

    
</body>

</html>