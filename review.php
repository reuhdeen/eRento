<!DOCTYPE html>

<html lang="en">
<?php
session_start(); 
  include 'db.php';
  $rid = $_GET['reservation'];
  $id = $_GET['id'];
  $sql = "SELECT * FROM erento.reservation where reservation_id = $rid;";
  $result = mysqli_query($db, $sql);
  $data = mysqli_fetch_assoc($result);

  $user_id = $_SESSION['user_id'];
  date_default_timezone_set('Asia/Manila'); 
  $current_date_time = date('Y-m-d H:i:s');

  if(isset($_POST['reserve'])){
    $length_of_stay = $_POST['length_of_stay'];
    $arr_date = $_POST['arr_date'];
    $arr_time = $_POST['arr_time'];
    $purpose = $_POST['purpose'];

    $sql = "INSERT INTO erento.reservation (property_id, room_id, user_id, date_created, date_of_arrival, time_of_arrival, purpose, status, length_of_stay) VALUES ('$id','$rid', '$user_id', '$current_date_time', '$arr_date', '$arr_time', '$purpose', 'Pending', '$length_of_stay')";

    if (mysqli_query($db, $sql)) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
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
    <style>
        .timeline-steps {
            display: flex;
            justify-content: center;
            flex-wrap: wrap
        }
        .timeline-steps .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }

        @media (min-width:768px) {
            .timeline-steps .timeline-step:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted #858796;
                width: 3.46rem;
                position: absolute;
                left: 7.5rem;
                top: .3125rem
            }
            .timeline-steps .timeline-step:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted #858796;
                width: 3.8125rem;
                position: absolute;
                right: 7.5rem;
                top: .3125rem
            }
        }

        .timeline-steps .timeline-content {
            width: 10rem;
            text-align: center
        }

        .timeline-steps .timeline-content .inner-circle {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #858796
        }

        .timeline-steps .timeline-content .inner-circle:before {
            content: "";
            background-color: #858796;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }


        .timeline-steps .timeline-content .inner-circlealive {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #a52421
        }

        .timeline-steps .timeline-content .inner-circlealive:before {
            content: "";
            background-color: #a52421;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }

        .file-preview {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .file-icon {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .file-info {
            flex: 1;
        }
        
        .file-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .file-size {
            font-size: 12px;
            color: #888;
        }

    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php 
            include 'header.php';
        ?>
    

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h1 mb-0 text-gray-900 textmaroon">Submit Requirements</h1>
                    </div>
                    

                    <div class="container">                      

                        <div class="row">
                            <div class="col">
                                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                                            <div class="inner-circle"></div>
                                            <p class="h6 mt-3 mb-1">Application</p>
                                        </div>
                                    </div>
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                                            <div class="inner-circle"></div>
                                            <p class="h6 mt-3 mb-1">Submit Requirements</p>
                                        </div>
                                    </div>
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005">
                                            <div class="inner-circlealive"></div>
                                            <p class="h6 mt-3 mb-1">Reserve</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-2 col-md-6 mb-4">
                        </div>
                        <!-- Earnings (Annual) Card Example -->
                        <div class="col-xl-8 col-md-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header">
                                    <div class="d-sm-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="m-0 font-weight-bold text-primary">Unit: <?php echo $data["room_id"];?></h6>
                                            <p><b>Date of Arrival:</b> <?php echo $data["date_of_arrival"] . ' - ' .$data["time_of_arrival"];?><br>
                                                <b>Length of Stay:</b> <?php echo $data["length_of_stay"];?><br> 
                                                <b>Purpose:</b> <?php echo $data["purpose"];?><br>
                                            </p></div>
                                            <div>
                                            <div class="btn btn-secondary">To Be Reviewed</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                            <div class="row">
                                                <?php
                                                $dsn = "mysql:host=localhost;dbname=erento";
                                                $username = "root";
                                                $password = "erento";
                                                $db = new PDO($dsn, $username, $password);
                                                $revuser = $data['user_id'];
                                                $stmt = $db->query("SELECT filename, filetype, filesize FROM erento.files WHERE reservation_id = $rid");
                                                $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                              
                                                ?>
                                                <div class="col-2 col-md-2 mb-4">
                                                    <h6><b>Requirements:</b></h6>
                                                </div>
                                                <div class="col-8 col-md-8 mb-4">
                                                    <ul class="">
                                                        <?php foreach ($files as $file): ?>
                                                            <li><a href="download.php?filename=<?php echo urlencode($file['filename']); ?>" class="link-primary"><?php echo $file['filename']; ?></a></li>
                                                          
                                                        <?php endforeach; ?>
                                                        
                                                    </ul>
                                                    
                                                </div>
                                            </div>

                                            
                                </div>


                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 mb-4">
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

</body>

</html>