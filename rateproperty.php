<!DOCTYPE html>
<html lang="en">
<head>
   <?php
    session_start();


include 'db.php';

  $sql = "SELECT * FROM erento.property;";
  $result = $db->query($sql);

  

?>
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

            <div class="col-xl-12 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6 consas py-4 px-4">
                            <h2 class="textmaroon">Give feedback to:</h2>
                                             <?php 

                                if ($result->num_rows > 0) {

                                  while($row = $result->fetch_assoc()) {
                                
                                ?>
                                                <div class="row">
                                                    <div class="col-lg-6 d-none d-lg-block" style=" background: url('img/<?php echo $row["property_image"];?>'); background-position: center;background-size: cover;"></div>
                                                    <div class="col-lg-6">
                                                        <div class="p-4">
                                                            <div class="">
                                                                <center><h1 class="h6 mb-4 descicon"><?php echo $row["property_name"];?></h1></center>
                                                            </div>
                                                            <form method="GET">
                                                                <a class="btn btn-primary btn-user btn-block" href="rate.php?rate=<?php echo $row['property_id'];?>">Give Feedback</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                            
                                            <?php 
                                        }}?>

                            
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