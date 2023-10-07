<!DOCTYPE html>
<html lang="en">
<?php

session_start();
  include 'db.php';
  $id = $_GET['id'];
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Charts</title>

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

                <?php 
                    include 'header.php';
                ?>
        

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <div class="row">

                        <!-- Donut Chart -->
                        <div class="col-xl-9">
                            <div class="card roomimg-border shadow h-100">
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-xl-4">
                                            <?php 
                                                $sqlrooms = "SELECT 
                                                                SUM(capacity) AS total_capacity,
                                                              SUM(CASE WHEN capacity = no_of_occupants AND property_id = 1 THEN 1 ELSE 0 END) AS num_capacity_matches,
                                                              SUM(CASE WHEN property_id = '$id' THEN 1 ELSE 0 END) AS num_rooms_with_id
                                                            FROM 
                                                              room
                                                            WHERE 
                                                              property_id = '$id'";
                                                $resultrooms = mysqli_query($db, $sqlrooms);
                                                $datarooms = mysqli_fetch_assoc($resultrooms);
                                            ?>
                                          <div class="chart-pie pt-4 position-absolute " style="z-index: 1;">
                                            <div class="align-middle text-center contenters">
                                              <div class="h2 mb-0 font-weight-bold text-gray-800 textyellow"><?php echo $datarooms['num_rooms_with_id']; ?></div>
                                              <span class="h6 font-weight-bold"><i class="fas fa-solid fa-door-open align-middle"></i> Total Number of Rooms</span>
                                            </div>
                                            <canvas id="numRooms" width="350"  height="250"></canvas>
                                          </div>
                                        </div>

                                        <div class="col-xl-4 position-relative">
                                            <?php
                                                $sqloccupants = "SELECT COUNT(*) AS num_occupants
                                                                FROM occupants
                                                                WHERE room_id IN (
                                                                  SELECT room_id
                                                                  FROM room
                                                                  WHERE property_id = '$id'
                                                                );";
                                                $resultoccupants = mysqli_query($db, $sqloccupants);
                                                $dataroccupants = mysqli_fetch_assoc($resultoccupants);

                                            ?>
                                          <div class="chart-pie pt-4 position-absolute " style="z-index: 1;">
                                            <div class="align-middle text-center contenters">
                                              <div class="h2 mb-0 font-weight-bold text-gray-800 textyellow"><?php echo $dataroccupants['num_occupants']; ?></div>
                                              <span class="h6 font-weight-bold"><i class="fas fa-restroom align-middle"></i> Total Number of Occupants</span>
                                            </div>
                                            <canvas id="myChart" width="350"  height="250"></canvas>
                                          </div>
                                        </div>

                                         <div class="col-xl-4 position-relative">
                                          <div class="chart-pie pt-4 position-absolute " style="z-index: 1;">
                                            <div class="align-middle text-center contenters">
                                              <div class="h2 mb-0 font-weight-bold text-gray-800 textyellow">18</div>
                                              <span class="h6 font-weight-bold"><i class="fas fa-solid fa-credit-card align-middle"></i> Occupants Paid for this Month</span>
                                            </div>
                                            <canvas id="occupants" width="350"  height="250"></canvas>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Donut Chart -->
                        <div class="col-xl-3">
                            <?php 
                                                $sqlsex = "SELECT 
                                                              COUNT(CASE WHEN u.sex = 'Male' THEN 1 ELSE NULL END) AS num_male_users,
                                                              COUNT(CASE WHEN u.sex = 'Female' THEN 1 ELSE NULL END) AS num_female_users
                                                            FROM 
                                                              occupants o
                                                              JOIN users u ON o.user_id = u.user_id
                                                              JOIN room r ON o.room_id = r.room_id
                                                            WHERE 
                                                              r.property_id = '$id';";
                                                $resultsex = mysqli_query($db, $sqlsex);
                                                $datasex = mysqli_fetch_assoc($resultsex);
                                            ?>
                            <div class="card shadow">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Number of Occupants by Sex</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                    

                                        <canvas id="Gender" width="350"  height="250"></canvas>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Occupant's Feedback</h6>
                                </div>
                                <?php 
                                                $sqlrate = "SELECT 
                                                              SUM(rate_clean) AS q,
                                                              SUM(rate_amen) AS w,
                                                              SUM(rate_safe) AS e,
                                                              SUM(rate_comf) AS r,
                                                              SUM(rete_all) AS t,
                                                              COUNT(*) AS total
                                                            FROM 
                                                              rating
                                                            WHERE 
                                                              property_id = '$id';";
                                                $resultrate = mysqli_query($db, $sqlrate);
                                                $datarate = mysqli_fetch_assoc($resultrate);
                                                $all = $datarate['total'] * 5;
                                                $overall = ($datarate['q'] + $datarate['w'] + $datarate['e'] + $datarate['r'] + $datarate['t'])/$all;

                                            ?>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <div class="row mb-3">
                                            <div class="col-xl-5 col-lg-5">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Cleanliness:</div>
                                            </div>
                                            <div class="col-xl-7 col-lg-5">
                                                <div class="progress progress-sm mr-2">
                                                    <?php
                                                        $q1 = ($datarate['q'] / $all) * 100;
                                                    ?>
                                                  <div class="progress-bar" role="progressbar" style="width: <?php echo $q1;?>%;" aria-valuenow="<?php echo $q1;?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($q1, 2);?>%</div>
                                                </div>
                                            </div>
                                        </div>
                  
                                        <div class="row mb-3">
                                            <div class="col-xl-5 col-lg-5">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Amenities:</div>
                                            </div>
                                            <div class="col-xl-7 col-lg-5">
                                                <div class="progress progress-sm mr-2">
                                                  <?php
                                                        $q2 = ($datarate['w'] / $all) * 100;
                                                    ?>
                                                  <div class="progress-bar" role="progressbar" style="width: <?php echo $q2;?>%;" aria-valuenow="<?php echo $q1;?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($q2, 2);?>%</div>
                                                </div>
                                            </div>
                                        </div>
               
                                        <div class="row mb-3">
                                            <div class="col-xl-5 col-lg-5">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Safety:</div>
                                            </div>
                                            <div class="col-xl-7 col-lg-5">
                                                <div class="progress progress-sm mr-2">
                                                  <?php
                                                        $q1 = ($datarate['e'] / $all) * 100;
                                                    ?>
                                                  <div class="progress-bar" role="progressbar" style="width: <?php echo $q1;?>%;" aria-valuenow="<?php echo $q1;?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($q1, 2);?>%</div>
                                                </div>
                                            </div>
                                        </div>
               
                                        <div class="row mb-3">
                                            <div class="col-xl-5 col-lg-5">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Comfort:</div>
                                            </div>
                                            <div class="col-xl-7 col-lg-5">
                                                <div class="progress progress-sm mr-2">
                                                  <?php
                                                        $q1 = ($datarate['r'] / $all) * 100;
                                                    ?>
                                                  <div class="progress-bar" role="progressbar" style="width: <?php echo $q1;?>%;" aria-valuenow="<?php echo $q1;?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($q1, 2);?>%</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-xl-5 col-lg-5">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">Overall Rate:</div>
                                            </div>
                                            <div class="col-xl-7 col-lg-5">
                                                <div class="progress progress-sm mr-2">
                                                  <?php
                                                        $q1 = ($datarate['t'] / $all) * 100;
                                                    ?>
                                                  <div class="progress-bar" role="progressbar" style="width: <?php echo $q1;?>%;" aria-valuenow="<?php echo $q1;?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($q1, 2);?>%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-xl-4 col-lg-5 p-4 mb-3">
                                                <center>
                                                   <i class="fas fa-solid fa-star fa-2x textyellow"></i> <h6 class="mb-0 font-weight-bold text-gray-800"><?php echo number_format($overall, 1);?> Stars</h5>
                                                   <code><?php echo $datarate['total']; ?> ratings</code>
                                                </center>
                                            </div>
                                            <div class="col-xl-8 mb-3 py-2">

                                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="height: 125px !important; !important">
                                                                      <div class="carousel-inner align-middles">
                                                                        <div class="carousel-item active ">
                                                                            <code class=""><center><i class="fas fa-solid fa-quote-left"></i>
                                                                      The bed is cozy. <i class="fas fa-solid fa-quote-right"></i></center></code>
                                                                        </div>
                                                                        <div class="carousel-item">
                                                                        <code>
                                                                            <center><i class="fas fa-solid fa-quote-left"></i>
                                                                      The people are accommodating. <i class="fas fa-solid fa-quote-right"></i></center>
                                                                         </code>
                                                                        </div>

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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Monthly Total Payments</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="earn"></canvas>
                                    </div>
                                </div>
                            </div>
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
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script type="text/javascript">
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            // Pie Chart Example
            var ctx = document.getElementById("Gender");
            var myPieChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: ["Male", "Female"],
                datasets: [{
                  data: [<?php echo $datasex['num_male_users']; ?>, <?php echo $datasex['num_female_users']; ?>],
                  backgroundColor: ['#a51d22', '#f79b23'],
                  hoverBackgroundColor: ['#8a0a0e', '#d97c02'],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: true,
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: true
                },
                cutoutPercentage: 1,
              },
            });
    </script>

    <script type="text/javascript">
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            // Pie Chart Example
            var ctx = document.getElementById("myChart");
            var myPieChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: ["Number of Occupants", "Unoccupied Slot"],
                datasets: [{
                  data: [<?php echo $datarooms['num_capacity_matches']; ?>, <?php echo $datarooms['total_capacity']; ?>],
                  backgroundColor: ['#a51d22', '#dddfeb'],
                  hoverBackgroundColor: ['#8a0a0e', '#dddfeb'],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: true,
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: false
                },
                cutoutPercentage: 80,
              },
            });
    </script>  

     <script type="text/javascript">
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            // Pie Chart Example
            var ctx = document.getElementById("occupants");
            var myPieChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: ["Male", "Female"],
                datasets: [{
                  data: [<?php echo $datasex['num_male_users']; ?>, <?php echo $datasex['num_female_users']; ?>],
                  backgroundColor: ['#a51d22', '#dddfeb'],
                  hoverBackgroundColor: ['#8a0a0e', '#dddfeb'],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: true,
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: false
                },
                cutoutPercentage: 80,
              },
            });
    </script>   
    <script type="text/javascript">
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            // Pie Chart Example
            var ctx = document.getElementById("numRooms");
            var myPieChart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                labels: ["Fully Occupied Rooms", "Unoccupied Rooms"],
                datasets: [{
                  data: [<?php echo $datarooms['num_capacity_matches']; ?>, <?php echo ($datarooms['num_rooms_with_id']-$datarooms['num_capacity_matches']); ?>],
                  backgroundColor: ['#a51d22', '#dddfeb'],
                  hoverBackgroundColor: ['#8a0a0e', '#dddfeb'],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
              },
              options: {
                maintainAspectRatio: true,
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                },
                legend: {
                  display: false
                },
                cutoutPercentage: 80,
              },
            });
    </script> 

    <script type="text/javascript">
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
          // *     example: number_format(1234.56, 2, ',', ' ');
          // *     return: '1 234,56'
          number = (number + '').replace(',', '').replace(' ', '');
          var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
              var k = Math.pow(10, prec);
              return '' + Math.round(n * k) / k;
            };
          // Fix for IE parseFloat(0.55).toFixed(0) = 0;
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
          if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
          }
          if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
          }
          return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("earn");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
              label: "Earnings",
              lineTension: 0.3,
              backgroundColor: "#faedee",
              borderColor: "#a51d22",
              pointRadius: 5,
              pointBackgroundColor: "#a51d22",
              pointBorderColor: "#a51d22",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "#8a0a0e",
              pointHoverBorderColor: "#8a0a0e",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
            }],
          },
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  maxTicksLimit: 5,
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return '₱' + number_format(value);
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }],
            },
            legend: {
              display: false
            },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: true,
              mode: 'index',
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ₱' + number_format(tooltipItem.yLabel);
                }
              }
            }
          }
        });

    </script>

    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>