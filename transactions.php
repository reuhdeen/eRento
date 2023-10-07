<!DOCTYPE html>

<html lang="en">

<?php
session_start();
include 'db.php';
  $id = $_GET['id'];
  $use_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM erento.reservation where user_id = $use_id;";
  $result = $db->query($sql);

  
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Transactions</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.4.0/dist/css/bootstrap.min.css">
    <script src="https://unpkg.com/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.4.0/dist/js/bootstrap.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  });
</script>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <?php 
            include 'csslink.php';
        ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'header.php';?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Rooms
                    </div>
                    <?php 
                            if ($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                            ?>
                            <div class="row">
                            <div class="col-xl-2 col-md-6 mb-4">
                                </div>
                            <div class="col-xl-8 col-md-6 mb-4">
                            
                            <div class="card   col-md-12 mb-4">
                
                                    <div class="d-sm-flex align-items-center justify-content-between card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Unit: <?php echo $row["room_id"];?></h6>
                                    <h6 class="m-0 font-weight-bold text-black-500"><?php
                                    $date = $row["date_created"];
                                    $month_name = date('F', strtotime($date));
                                    $formatted_date = date('m-d-Y H:i:s', strtotime($date));
                                    list($month, $day, $yeartime) = explode('-', $formatted_date);
                                    list($year, $time) = explode(' ', $yeartime);
                                    echo "$month_name $day, $year". " - " . "$time";?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-sm-flex align-items-center justify-content-between">
                                        <p><b>Date of Arrival:</b> <?php echo $row["date_of_arrival"] . ' - ' .$row["time_of_arrival"];?><br>
                                            <b>Length of Stay:</b> <?php echo $row["length_of_stay"];?><br> 
                                            <b>Purpose:</b> <?php echo $row["purpose"];?><br>
                                        </p>
                                        <?php
                                            if($row["status"] == "Pending"){
                                            echo '<button type="button" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Your reservation is still pending, please wait.">
                                            <i class="fas fa-fw fa-info"></i>
                                             Pending
                                           </button>';
                                       }elseif($row["status"] == "Booked"){
                                        echo '<a href="requirements.php?id='.$id. '&reservation='.$row["reservation_id"].'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Your reservation is approved, submit the requirements a day before your arrival.">
                                            <i class="fas fa-fw fa-info"></i>
                                             Approved
                                           </a>';
                                            }elseif($row["status"] == "Confirmed"){
                                        echo '<span class="text-success"><i class="fas fa-check-circle"></i>&nbsp;Reserved</span>'; 
                                            }elseif($row["status"] == "To Be Reviewed"){
                                        echo '<a href="review.php?id='.$id. '&reservation='.$row["reservation_id"].'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Your documents are being checked. Please wait.">
                                            <i class="fas fa-fw fa-info"></i>
                                             To Be Reviewed
                                           </a>';
                                            }elseif($row["status"] == "Rejected"){
                                        echo '<a class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Sorry, your reservation is rejected.">
                                            <i class="fas fa-times-circle"></i>
                                             Rejected
                                           </a>';
                                            }
                                            ?>
                                    </div>
                                </div>
                            </div>
                    
                            
                                </div>
                                 <div class="col-xl-2 col-md-6 mb-4">
                        </div>
                    </div>
                        <?php 

                                }
                            }

                            ?>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>