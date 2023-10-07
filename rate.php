<!DOCTYPE html>
<html lang="en">
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


        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
   <?php 
            include 'csslink.php';
        ?>
        <style type="text/css">



            .star {
                color: #e98300 !important;
            }
            .rate {
                height: 50px !important;
                margin-left: -5px !important;
                padding: 5px !important;
                font-size: 25px !important;
                position: relative !important;
                cursor: pointer !important;
            }
            .rate input[type="radio"] {
                opacity: 0 !important;
                position: absolute !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%,0%) !important;
                pointer-events: none !important;
                            }
            .star-over::after {
                font-family: 'Font Awesome 5 Free' !important;
              font-weight: 900 !important;
                font-size: 16px !important;
                content: "\f005" !important;
                color: #f0ca99 !important;
                position: absolute !important;
                top: 15px !important;
                left: 10px !important;

            }

            .rate:nth-child(1) .face::after {
                content: "\f119"; /* ☹ */
            }
            .rate:nth-child(2) .face::after {
                content: "\f11a"; /* 😐 */
            }
            .rate:nth-child(3) .face::after {
                content: "\f118"; /* 🙂 */
            }
            .rate:nth-child(4) .face::after {
                content: "\f580"; /* 😊 */
            }
            .rate:nth-child(5) .face::after {
                content: "\f59a"; /* 😄 */
            }
            .face {
                opacity: 0;
                position: absolute;
                width: 35px;
                height: 35px;
                background: #a51d22;
                border-radius: 5px;
                top: -50px;
                left: 2px;
                transition: 0.2s;
                pointer-events: none;
            }
            .face::before {
                font-family: 'Font Awesome 5 Free';
              font-weight: 900;
                content: "\f0dd";
                display: inline-block;
                color: #a51d22;
                z-index: 1;
                position: absolute;
                left: 9px;
                bottom: -15px;
            }
            .face::after {
                font-family: 'Font Awesome 5 Free';
              font-weight: 900;
                display: inline-block;
                color: #fff;
                z-index: 1;
                position: absolute;
                left: 5px;
                top: -1px;
            }

            .rate:hover .face {
                opacity: 1;
            }

            /* Not sure if I like this or not. */
            /* Makes the emoji stay displayed */
            /* input[type="radio"]:checked + .face {
                opacity: 1 !important;
            } */
        </style>

<script src="https://kit.fontawesome.com/a344e6cfdc.js" crossorigin="anonymous"></script>

</head>
<body class="bg-gradient-primary">

    <div class="container ">

        <!-- Outer Row -->
        <div class="row justify-content-center vertical-center">
            <?php 
            include 'db.php';
            $rate = $_GET['rate'];
            $sql3 = "SELECT * FROM erento.property WHERE property_id = '$rate';";
            $results = mysqli_query($db, $sql3);
            $prop = mysqli_fetch_assoc($results);
            $property_name = $prop['property_name'];
            ?>
            <div class="col-xl-12 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6 consas py-4 px-4">
                            <h2 class="textmaroon"><?php 
                                
                                echo 'Give us your feedback to the ' . $property_name;?></h2>
                            <br>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-6 col-lg-6">
                                    <span><i class="fas fa-solid fa-pump-medical textmaroon"></i> <b>Cleanliness:</b></span>
                                 </div>

                                <div class="col-xl-6 col-lg-6 ">
                                    <div class="stars ">
                                        <form method="POST">                                        
                                        <label class="rate">
                                            <input type="radio" name="radio1" id="star1" value="1">
                                            <div class="face"></div>
                                            <i class="far fa-star star one-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio1" id="star2" value="2">
                                            <div class="face"></div>
                                            <i class="far fa-star star two-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio1" id="star3" value="3">
                                            <div class="face"></div>
                                            <i class="far fa-star star three-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio1" id="star4" value="4">
                                            <div class="face"></div>
                                            <i class="far fa-star star four-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio1" id="star5" value="5">
                                            <div class="face"></div>
                                            <i class="far fa-star star five-star"></i>
                                        </label>
          
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-6 col-lg-6">
                                    <span><i class="fas fa-solid fa-person-booth textmaroon"></i> <b>Amenities:</b></span>
                                 </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div class="stars">
                                        <form method="POST">                                        
                                        <label class="rate">
                                            <input type="radio" name="radio2" id="star1" value="1">
                                            <div class="face"></div>
                                            <i class="far fa-star star one-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio2" id="star2" value="2">
                                            <div class="face"></div>
                                            <i class="far fa-star star two-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio2" id="star3" value="3">
                                            <div class="face"></div>
                                            <i class="far fa-star star three-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio2" id="star4" value="4">
                                            <div class="face"></div>
                                            <i class="far fa-star star four-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio2" id="star5" value="5">
                                            <div class="face"></div>
                                            <i class="far fa-star star five-star"></i>
                                        </label>
          
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-6 col-lg-6">
                                    <span><i class="fas fa-solid fa-lock textmaroon"></i> <b>Safety:</b></span>
                                 </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div class="stars">
                                        <form method="POST">                                        
                                        <label class="rate">
                                            <input type="radio" name="radio3" id="star1" value="1">
                                            <div class="face"></div>
                                            <i class="far fa-star star one-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio3" id="star2" value="2">
                                            <div class="face"></div>
                                            <i class="far fa-star star two-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio3" id="star3" value="3">
                                            <div class="face"></div>
                                            <i class="far fa-star star three-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio3" id="star4" value="4">
                                            <div class="face"></div>
                                            <i class="far fa-star star four-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio3" id="star5" value="5">
                                            <div class="face"></div>
                                            <i class="far fa-star star five-star"></i>
                                        </label>
          
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-6 col-lg-6 ">
                                    <span><i class="fas fa-solid fa-bed textmaroon"></i> <b>Comfort:</b></span>
                                 </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div class="stars">
                                        <form method="POST">                                        
                                        <label class="rate">
                                            <input type="radio" name="radio4" id="star1" value="1">
                                            <div class="face"></div>
                                            <i class="far fa-star star one-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio4" id="star2" value="2">
                                            <div class="face"></div>
                                            <i class="far fa-star star two-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio4" id="star3" value="3">
                                            <div class="face"></div>
                                            <i class="far fa-star star three-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio4" id="star4" value="4">
                                            <div class="face"></div>
                                            <i class="far fa-star star four-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio4" id="star5" value="5">
                                            <div class="face"></div>
                                            <i class="far fa-star star five-star"></i>
                                        </label>
          
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-6 col-lg-6">
                                    <span><b>Overall Rate:</b></span>
                                 </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div class="stars">
                                        <form method="POST">                                        
                                        <label class="rate">
                                            <input type="radio" name="radio5" id="star1" value="1">
                                            <div class="face"></div>
                                            <i class="far fa-star star one-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio5" id="star2" value="2">
                                            <div class="face"></div>
                                            <i class="far fa-star star two-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio5" id="star3" value="3">
                                            <div class="face"></div>
                                            <i class="far fa-star star three-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio5" id="star4" value="4">
                                            <div class="face"></div>
                                            <i class="far fa-star star four-star"></i>
                                        </label>
                                        <label class="rate">
                                            <input type="radio" name="radio5" id="star5" value="5">
                                            <div class="face"></div>
                                            <i class="far fa-star star five-star"></i>
                                        </label>
          
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-4 col-lg-4">
                                    <span><b>Comments & Suggestions:</b></span>
                                 </div>

                                <div class="col-xl-8 col-lg-8">
                                    <textarea class="form-control" rows="5" name="purpose"></textarea>
                                </div>
                            </div>
                            <br>
                            <center>
                            <button type="submit" name="buttonsaas" class="btn btn-md btn-primary"><i class="fas fa-solid fa-paper-plane"></i>  Send Feedback</button>
                            </center>
                            </form>
                                <?php
                                date_default_timezone_set('Asia/Manila'); 
                                $current_date_time = date('Y-m-d H:i:s');
                                    if (isset($_POST['buttonsaas'])) {
                                            $clean = $_POST['radio1'];
                                            $amen = $_POST['radio2'];
                                            $safe = $_POST['radio3'];
                                            $comf = $_POST['radio4'];
                                            $all = $_POST['radio5'];
                                            $comm = $_POST['purpose'];

                                              $sql2 = "INSERT INTO erento.rating (rate_clean, rate_amen, rate_safe, rate_comf, rete_all, comment, date_created, property_id) VALUES ('$clean','$amen', '$safe', '$comf', '$all', '$comm', '$current_date_time', '$rate')";
                                                   if ($db->query($sql2) === TRUE){
                                                     echo '<script>
                                                       alert("Feedback Sent!");
                                                       window.location.href = "index.php";
                                                     </script>';
                                                   }else{
                                              ?> 
                                                  <script>
                                                    alert("Failed to send feedback!");
                                                  </script>
                                              <?php
                                            }
                                        }
                                ?>


                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function() {
            
            $(document).on({
                mouseover: function(event) {
                    $(this).find('.far').addClass('star-over');
                    $(this).prevAll().find('.far').addClass('star-over');
                },
                mouseleave: function(event) {
                    $(this).find('.far').removeClass('star-over');
                    $(this).prevAll().find('.far').removeClass('star-over');
                }
            }, '.rate');


            $(document).on('click', '.rate', function() {
                if ( !$(this).find('.star').hasClass('rate-active') ) {
                    $(this).siblings().find('.star').addClass('far').removeClass('fas rate-active');
                    $(this).find('.star').addClass('rate-active fas').removeClass('far star-over');
                    $(this).prevAll().find('.star').addClass('fas').removeClass('far star-over');
                } else {
                    console.log('has');
                }
            });
            
        });


    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    
</body>

</html>