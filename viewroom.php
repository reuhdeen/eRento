<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'db.php';
  $id = $_GET['id'];
  $rid = $_GET['rid'];
  $sql = "SELECT * FROM erento.room where room_id = $rid;";
  $result = mysqli_query($db, $sql);
  $data = mysqli_fetch_assoc($result);

  $user = $_SESSION['user_id'];
  $sql2 = "SELECT o.*, u.*, o.user_id AS 'user_ids'
        FROM erento.occupants o
        INNER JOIN users u ON o.user_id = u.user_id
        WHERE o.user_id = $user";
$results = $db->query($sql2);
$results2 = mysqli_query($db, $sql2);
  $data2 = mysqli_fetch_assoc($results2);
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




                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h1 mb-0 text-gray-900 textmaroon"><?php echo $data['room_name']?></h1>
                        
                    </div>
                    <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-8">
                        <div class="card px-3 py-3 roomimg-border shadow h-100">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="height: 600px !important; !important">
                      <div class="carousel-inner">

                        <?php
                        $i = 0;
                        $room_images = explode(',',$data['room_images']);
                        foreach($room_images as $image){
                           
                      ?>
                        <div class="carousel-item<?php if($i == 0){echo " active";}?>">
                            <center>
                          <img class="img-fluid" style="height: 600px!important; width: auto !important;"   src="<?php echo 'img/' .$image;?>" alt="Second slide"></center>
                        </div>

                        <?php $i++;  } 
                        ?> 
                      </div>
                      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                    </div>
                </div>

                    <div class="col-xl-4 col-lg-12 col-md-4">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4"><h4 class="textmaroon"><?php echo $data['room_no']?></h4>

                            <form>
                                <?php 

                                    if ($data['capacity'] == $data["no_of_occupants"]) {
                                        // echo '<span class="text-success"><i class="fas fa-check-circle"></i>&nbsp;Fully Occupied</span>'; 
                                    }elseif($results->num_rows > 0){
                                        if($data2['user_type'] == 4){
                                            echo  '<a href="reserve.php?id='. $id.'&rid='.$rid.'" class="btn btn-primary"><i class="fas fa-solid fa-check"></i> &nbsp;Book Now</a>';
                                        }
                                        
                                    }else{
                                        echo  '<a href="reserve.php?id='. $id.'&rid='.$rid.'" class="btn btn-primary"><i class="fas fa-solid fa-check"></i> &nbsp;Book Now</a>';
                                    }
                                ?>
                           

                        </form>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-4">
                                <h5>Capacity:</h5>
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-8">
                                <h5 class="textyellow"><?php echo $data['capacity'];?></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-4">
                                <h5>No. of current occupants:</h5>
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-8">
                                <p class="textyellow">
                                    <?php 
                                    if ($data['capacity'] == $data["no_of_occupants"]) {
                                        echo '<span class="text-success"><i class="fas fa-check-circle"></i>&nbsp;Fully Occupied</span>'; 
                                    }else{
                                        echo  $data["no_of_occupants"];
                                    }
                                ?>
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-4">
                                <h5>Price:</h5>
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-8">
                                <h5 class="textyellow">₱<?php echo $data['price'] . "/" . $data['unit'];?></h5>
                            </div>
                        </div><br><hr>
                        <h4 class="textmaroon">More Info:</h4>
                        <p><?php echo $data['desc'];?></p>

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