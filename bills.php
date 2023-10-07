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
    $uid = $_SESSION['user_id'];
    $month_of = isset($_GET['month_of']) ? $_GET['month_of'] : date('Y-m');
    $monthY = $month_of.'%';
  $sql = "SELECT *,b.amount AS 'aAmount', b.date_created AS 'bDate', b.bill_id AS 'billid' FROM erento.occupants o
        INNER JOIN room r ON o.room_id = r.room_id
        INNER JOIN users u ON o.user_id = u.user_id
        INNER JOIN bills b ON o.occupant_id = b.occupant_id
        LEFT JOIN payment p ON o.occupant_id = p.occupant_id
        WHERE o.user_id = $uid AND b.date_created LIKE '$monthY';";
  $result = $db->query($sql);
  $results2 = mysqli_query($db, $sql);
  $proper = mysqli_fetch_assoc($results2);

    $sql6 = "SELECT * FROM erento.other_bills 
            INNER JOIN occupants ON other_bills.occupant_id = occupants.occupant_id WHERE user_id = $uid;";
  $result6 = $db->query($sql6);


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
                    
                    
                    <!-- DataTales Example -->
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <form id="filter-report" method="GET" >
                                <div class="row form-group">
                                    <label class="control-label font-weight-bold col-md-1 text-primary">Month of: </label> 
                                    <input type="hidden" name="id" value="<?php echo ($id) ?>">
                                    <input type="month" name="month_of" class='from-control col-md-4' value="<?php echo ($month_of) ?>">&nbsp;
                                    <button class="btn btn-sm col-md-1 btn-primary">Filter</button>
                    
                                </div>
                            </form>
                        </div>
                        
                        <div class="card-body">
                            <?php 
                            $z = 0 ;


                                        if ($result->num_rows > 0) {
                                          while($row = $result->fetch_assoc()) {
                                            $bill_id = $row["billid"];
                                        ?>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo $z;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <script>
                                                        function previewFiles() {
                                                            var files = document.getElementById("file-upload").files;
                                                            var preview = document.getElementById("file-preview");
                                                            
                                                            for (var i = 0; i < files.length; i++) {
                                                                var file = files[i];
                                                                var file_name = file.name;
                                                                var file_size = formatBytes(file.size);
                                                                
                                                                var preview_item = document.createElement("div");
                                                                preview_item.className = "file-preview";
                                                                preview_item.innerHTML = '<div class="file-icon"><i class="fa fa-file"></i></div>' +
                                                                    '<div class="file-info">' +
                                                                    '<div class="file-name">' + file_name + '</div>' +
                                                                    '<div class="file-size">' + file_size + '</div>' +
                                                                    '</div>';
                                                                preview.appendChild(preview_item);
                                                            }
                                                        }
                                                        
                                                        function formatBytes(bytes, decimals = 2) {
                                                            if (bytes === 0) return '0 Bytes';
                                                            const k = 1024;
                                                            const dm = decimals < 0 ? 0 : decimals;
                                                            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                                                            const i = Math.floor(Math.log(bytes) / Math.log(k));
                                                            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
                                                        }
                                                    </script>
                                                    <div class="row">
                                                        <div class="col-4 col-md-4 mb-4">
                                                            <label for="formFile">Receipt/s:</label>
                                                        </div>
                                                        <div class="col-8 col-md-8 mb-4">
                                                    
                                                                <input type="file" class="form-control" name="files[]" id="file-upload" multiple onchange="previewFiles()"><br>
                                                                <div id="file-preview"></div>
                                                            
                                                        </div>
                                                    </div>

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <input type="hidden" name="bid" value="<?php echo $bill_id;?>">
                                    <input type="submit" value="Confirm" class="btn btn-primary" name="addc">
                                  </div>
                                  </form>
                                </div>
                              </div>
                            </div>


                              <div class="container mt-5" id="printable-div<?php echo $z;?>">
                                <div class="row">
                                  <div class="col-6">
                                    <span><b>Payor:</b>  <u><?php echo $row["lname"].', '. $row["fname"];?></u></span><br>
                                    <span><b>Status:</b>  <?php if($row["bill_status"] == "Paid"){
                                        echo '<span class="badge bg-success text-white">'.$row["bill_status"].'</span></span><br>';
                                    }elseif($row["bill_status"] == "Unpaid"){
                                        echo '<span class="badge yellow-btn text-white disabled">'.$row["bill_status"].'</span></span><br>';
                                    }else{
                                        echo '<span class="badge btn-secondary text-white disabled">'.$row["bill_status"].'</span></span><br>';
                                    }
                                        ?>

                                        
                                  </div>
                                  <div class="col-6 text-right">
                                     <span><b>Date Issued:</b>  <u><?php echo $row["bDate"];?></u></span><br>
                                     <span><b>Due Date:</b>  <u><?php echo (date("Y-m-d", strtotime($row["bDate"] . "+15 days")));?></u></span><br>
                                  </div>
                                </div>
                                <div class="row mt-4">
                                  <div class="col-12">
                                    <table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th>Description</th>
                                          <th>Amount</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td><?php echo $row["bill_for"];?></td>
                                          <td><?php echo '₱'.$row["price"];?></td>
                                        </tr>
                                        <?php 
                                            $total = $row["aAmount"];
                                        if ($result6->num_rows > 0) {
                                          while($row6 = $result6->fetch_assoc()) {

                                        ?>
                                        <tr>
                                            <td><?php echo $row6["desc"];?></td>
                                            <td><?php echo '₱'.$row6["amount"];?></td>
                                        </tr>
                                        <?php 
                                        $total = $total + $row6["amount"];
                                            }
                                        }
                                        ?>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <th class="text-right">Total</th>
                                          <td><b class="textmaroon"><?php echo '₱'.$total;?></b></td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <script>
                                <?php
                                                              
                                    ?> 
                            function printDiv<?php echo $z;?>(){
                              var printableElement = document.getElementById("printable-div<?php echo $z;?>");
                              var printContents = printableElement.innerHTML;
                              var originalContents = document.body.innerHTML;

                              document.body.innerHTML = printContents;
                              window.print();

                              document.body.innerHTML = originalContents;
                            }
                            </script>
                            <center> <button class = "btn btn-secondary" onclick="printDiv<?php echo $z;?>()">&nbsp;&nbsp;<i class="fas fa-solid fa-print"></i>&nbsp; &nbsp; Print&nbsp;&nbsp;</button> <button class = "btn btn-secondary yellow-btn" data-toggle="modal" data-target="#exampleModal<?php echo $z;?>">&nbsp;&nbsp;<i class="fas fa-solid fa-upload"></i>&nbsp; &nbsp; Upload Receipt&nbsp;&nbsp;</button></center> 
                            <?php 
                              $z++;

                                            }
                                        }else{
                                            echo "<td colspan='5'><center><b>No bill for this month yet.</b></center></td>";
                                        }

                                        ?>

                                      
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

     <?php

                                                        $dsn = "mysql:host=localhost;dbname=erento";
                                                        $username = "root";
                                                        $password = "erento";

                                                        $pdo = new PDO($dsn, $username, $password);
                                                        $upload_user = $uid;

                                                        if(isset($_POST['addc'])){
                                                            $bill_id = $_POST['bid'];

                                                            foreach($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                                                              $filename = $_FILES['files']['name'][$key];
                                                              $filetype = $_FILES['files']['type'][$key];
                                                              $filesize = $_FILES['files']['size'][$key];
                                                              $filedata = file_get_contents($tmp_name);  
                                                              date_default_timezone_set('Asia/Manila'); 
                                                              $current_date_time = date('Y-m-d H:i:s');

                                                              $stmt = $pdo->prepare("INSERT INTO erento.receipt (filename, filetype, filesize, filedata, bill_id, date_uploaded) VALUES (?, ?, ?, ?, ?, ?)");
                                                              $stmt->execute([$filename, $filetype, $filesize, $filedata, $bill_id, $current_date_time]);
                                                            }

                                                            $sql10 = "UPDATE `erento`.`bills` SET `bill_status` = 'Receipt To Be Reviewed' WHERE `bill_id` = '$bill_id';";
                                                            mysqli_query($db, $sql10);  
                                                            ?>
                                                                <script>
                                                                  alert("Receipt Submitted!");
                                                                </script>
                                                            <?php
                                                        }                                                    
                                                        ?>
</body>

</html>