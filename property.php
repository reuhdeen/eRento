<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include 'db.php';

  $sql = "SELECT * FROM erento.property;";
  $result0 = $db->query($sql);


  if(isset($_POST['addp'])){
  // Get the form data
  $property_name = mysqli_real_escape_string($db, $_POST['property_name']);
  $property_type = mysqli_real_escape_string($db, $_POST['property_type']);
  $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
   $desc = mysqli_real_escape_string($db, $_POST['desc']);
   $userA = mysqli_real_escape_string($db, $_POST['userA']);


  $image = $_FILES['formFile']['name'];
  if (!empty($image)) {
    $target_dir = "img/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['formFile']['tmp_name'], $target_file);
  }

  // Insert the property into the database

   $sql = "INSERT INTO `erento`.`property` (`property_name`, `property_type`, `user_id`, `property_image`, `desc`, `user_access`) VALUES ('$property_name', '$property_type', '$user_id ', '$image', '$desc', '$userA');";
  mysqli_query($db, $sql);

  // Redirect back to the form
  echo '<script>
                         alert("Added Successfully!");
                       </script>';
  }
  if (isset($_POST['available'])) {
        $prid = $_POST['prid'];

        $sql = "UPDATE erento.property SET status = 'Available' WHERE property_id = '$prid'";
        mysqli_query($db, $sql);
        echo '<script>
                         alert("Property Updated");
                       </script>';
        header("Refresh:0");
  } 
  if (isset($_POST['unavailable'])) {
        $prid = $_POST['prid'];
        $sql = "UPDATE erento.property SET status = 'Unavailable' WHERE property_id = '$prid'";
        mysqli_query($db, $sql);
        echo '<script>
                         alert("Property Updated");
                       </script>';
        header("Refresh:0");
  }
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Property</title>

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
                        <h1 class="h3 mb-0  text-gray-800">Accommodation Property</h1><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      <i class="fas fa-plus"></i>    Add New Property
                    </button>
                    </div>
                    <!-- Button trigger modal -->
                    

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Property</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="post" action="" enctype="multipart/form-data">
                            <div class="row">
                            
                                <div class="col-4 col-md-4 mb-4">
                              <label for="property_name">Property Name:</label>
                            </div>
                              <div class="col-8 col-md-8 mb-4">
                              <input type="text" class="form-control form-control-sm" name="property_name" required>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="property_type">Property Type:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input type="text" class="form-control form-control-sm" name="property_type" required>
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
                                    <label for="desc">User Access:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <select class="form-control form-control-sm" name="userA" required>
                                      <option value="" disabled selected></option>
                                      <option value="Students, Faculty & Guests">Students, Faculty & Guests</option>
                                      <option value="Students">Students Only</option>
                                      <option value="Faculty">Faculty Only</option>
                                      <option value="Students & Faculty">Students & Faculty</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="user_id">Manager ID:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input type="text" class="form-control form-control-sm" name="user_id" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-4 mb-4">
                                    <label for="formFile">Image:</label>
                                </div>
                                <div class="col-8 col-md-8 mb-4">
                                    <input class="form-control" type="file" id="formFile" name="formFile">
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

                    <div class="row">
                        <?php 
                        if ($result0->num_rows > 0) {

                          while($row = $result0->fetch_assoc()) {
   
                        ?>
                    <div class="col-xl-6 col-md-6 mb-4">
                    <!-- Dropdown Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary"><?php echo $row["property_name"];?></h4>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Update Availability:</div>
                                            <form method="post">
                                                <input type="hidden" name="prid" value="<?php echo $row["property_id"];?>">
                                            <input class="dropdown-item" type="submit" name="available" value="Available">

                                            <input class="dropdown-item" type="submit" name="unavailable" value="Unavailable">
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 mx-auto">
                                            <h5 class="text-gray-900">Manager: <?php echo $row["user_id"];
                                            ?></h5> 

                                            <span class="text-msuiit">Property Type: <?php echo $row["property_type"];
                                            ?></span> <br>
                                            <?php
                                                if ($row["status"] == "Available") {
                                                    echo '<span class="badge bg-success text-white">Available</span>';
                                                }else{
                                                    echo '<span class="badge bg-secondary text-white">Unavailable</span>';
                                                }
                                            ?>
                                             

                                             <hr>
                                            <p>
                                            <?php echo $row["desc"];
                                            ?></p>
                                
                                        </div>
                                        <div class="col-xl-6">
                                        <?php

                                            echo "<img src='img/" .$row["property_image"]. "' class='img-fluid' alt='Responsive image'>";
                                        ?>
                                        <center>
                                            <br>
                                       
                                        </center>
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

</body>

</html>