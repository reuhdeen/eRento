<!DOCTYPE html>
<html lang="en">
<?php
    session_start();


include 'db.php';

  $sql = "SELECT * FROM erento.property;";
  $result = $db->query($sql);
    $user = $_SESSION['user_id'];
    $sql2 = "SELECT * FROM erento.users where user_id = $user;";
    $resultH = mysqli_query($db, $sql2);
    $dataH = mysqli_fetch_assoc($resultH);
?>

<head>
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <?php 
            include 'csslink.php';
        ?>

        <style type="text/css">
            
            .overlay {
  position: relative;
}

.overlay:before {
  content: "Unavailable";
  font-weight: bold;
  color: white;
  position: absolute;
  z-index: 1;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7); /* Adjust the color and opacity as needed */
  display: flex;
  justify-content: center;
  align-items: center;
}

.card {
  position: relative;
  z-index: 0;
}
        </style>

</head>

<body class="bg-gradient-primary " background="img/bg.jpg">

    <div class="container ">

        <!-- Outer Row -->
    <div class="row justify-content-center">

            <?php 
            if ($result->num_rows > 0) {
ob_start(); 

    while ($row = $result->fetch_assoc()) {
     
            
            ?>
            <div class="col-xl-6 ">
                <div class="card o-hidden border-0 shadow-lg my-5 <?php if ($row["status"] == "Unavailable") {
                    echo "overlay";                }?>">
                    <div class="card-body p-0 ">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block " style=" background: url('img/<?php echo $row["property_image"];?>'); background-position: center;background-size: cover;"></div>
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <div class="">
                                        <h2 class="h5  icontext"><?php echo $row["property_name"];?></h2>
                                       
                                        <p><?php echo $row["desc"];?></p>
                                    </div>
                                    <form method="POST">
                                        <input type="submit" name="choose<?php echo $row['property_id'];?>" class="btn btn-primary btn-user btn-block" value="Get Started">
                                    </form>
                                    <?php
                                            if(isset($_POST['choose'.$row['property_id']])){
                                                if($dataH['user_type'] == 3){
                                                    if(strpos($row["user_access"], "Students") !== false){
                                                        header("Location: rooms.php?id={$row['property_id']}&name={$row['property_name']}");
                                                        exit;
                                                    }else{
                                                        echo '<script>
                                                                  alert("User type of this account is restricted.");
                                                                                     window.location.href = "propertyChoice.php";
                                                                </script>';
                                                                exit;
                                                    }
                                                }else{
                                                    header("Location: rooms.php?id={$row['property_id']}&name={$row['property_name']}");
                                                    exit;
                                                }
                                            }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                }
                ob_end_flush();
            }
                ?>


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