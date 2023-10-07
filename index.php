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

    // Connect to the database


    // Check for form submission

        // $username = mysqli_real_escape_string($db, $_SESSION["username"]);
        // $password = mysqli_real_escape_string($db, $_SESSION["username"]);

        // Get the user from the database
        if(isset($_SESSION['user_id'])){
            header('Location: propertyChoice.php');
            exit;
        }
        if(isset($_POST['loginbtn'])){

            $username = $_POST['username'];
            $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);

        // Check if the password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Start the session and redirect the user
            if($user['user_type'] == 1){
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header('Location: property.php');
                exit;
            }
            elseif ($user['user_type'] == 2) {
                $user_id = $user['user_id']; 
                $query2 = "SELECT * FROM erento.property WHERE user_id=$user_id";
                $result2 = mysqli_query($db, $query2);
                $user2 = mysqli_fetch_assoc($result2);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header('Location: manageroom.php?id='.$user2['property_id']);
                exit;
            }
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header('Location: propertyChoice.php');
            exit;

        } else {
            ?> 
                <script>
                  alert("Invalid Username and Password");
                                     window.location.href = "index.php";
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

    <title>e-Rento - Login</title>

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

<body class="bg-gradient-primary " background="img/bg.jpg">

    <div class="container ">

        <!-- Outer Row -->
        <div class="row justify-content-center vertical-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-video">
                                <video autoplay muted loop>
                                    <source src="img/msuiit.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                  </video>
                            </div>
                            <div class="col-lg-6 align-middle">
                                <div class="p-5">
                                    <div class="">
                                        <h1 class="h1  icontext">e-Rento</h1>
                                        <h1 class="h4 mb-4 descicon">MSU-IIT Accommodation</h1>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" type="submit" name="loginbtn" value="Login">
                                            
                                    </form>
                                    <hr>
                                    
                                    <div class="text-center">
                                        <a class="small textmaroon" href="reg.php">Register an Account</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small textmaroon" href="rateproperty.php">Give Feedback</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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