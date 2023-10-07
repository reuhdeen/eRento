<!DOCTYPE html>

<html lang="en">

<?php
session_start();
  include 'db.php';
  $id = $_GET['id'];

  $sql10 = "SELECT * FROM erento.property WHERE property_id = $id;";
  $result10 = mysqli_query($db, $sql10);
  $data10 = mysqli_fetch_assoc($result10);


  $sql = "SELECT * FROM erento.room where property_id = $id;";
  $result = $db->query($sql);

  
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $data10['property_name']; ?> - Rooms</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $data10['property_name']; ?> - Rooms
                    </div>
                

                    <div class="row">


                        <?php 
                        if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {
                        ?>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card roomimg-border shadow h-100">
                                <?php
                                    $room_images = explode(',',$row['room_images']);
                                    foreach($room_images as $image){
                                        $image;
                                            break;
                                        }
                                ?>
                                <div class="px-3 py-5" style='background: url("img/<?php echo $image;?>") !important;
                                background-size: cover !important;'></div>
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">

                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               <?php echo $row["room_no"];?></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $row["room_name"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <?php echo "<a href='viewroom.php?id={$id}&rid={$row['room_id']}' class='btn btn-primary btn-user btn-block text-s'>View</a>";?>
                                        </div>
                                        <div class="py-1"><?php echo $row["desc"];?>
                                            <h5 class="text-gray-900">Price: <?php echo $row["price"];
                                            ?></h5> 
                                            <p class="text-msuiit">Available Slots: <?php echo ($row["capacity"] - $row["no_of_occupants"]);
                                            ?></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 

                            }
                        }

                        ?>
                        
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

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>