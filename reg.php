
    <!DOCTYPE html>
<html lang="en">
<?php
        // Connect to the database
        include 'db.php';

        // Check for form submission
        if (isset($_POST['regbtn'])) {
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $password = mysqli_real_escape_string($db, $_POST['password']);

            // Hash the password
            $password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user into the database
            $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
            if ($db->query($query) === TRUE){
                echo '<script>
                  alert("Registered Successfully!");
                                     window.location.href = "index.php";
                </script>';
            }else {
                echo '<script>
                  alert("Email is already used!");
                                     window.location.href = "reg.php";
                </script>';
            }
        }
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
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="">
                                        <h1 class="h1  icontext">e-Rento</h1>
                                        <h1 class="h4 mb-4 descicon">MSU-IIT Accommodation</h1>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email" name="email">
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
                                        <input class="btn btn-primary btn-user btn-block" type="submit" name="regbtn" value="Register">
                                            
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small textmaroon" href="reg.php">Already have an account!</a>
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

</head>
</html>