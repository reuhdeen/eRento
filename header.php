<!-- Sidebar -->

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
<?php     $user = $_SESSION['user_id'];
        $sql = "SELECT * FROM erento.users where user_id = $user;";
        $resultH = mysqli_query($db, $sql);
        $dataH = mysqli_fetch_assoc($resultH);?>
    <!-- Sidebar - Brand -->

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php if($dataH['user_type'] == 2){?>dashboard.php?id=<?php echo $id;}else{
        echo "propertyChoice.php";
    }?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-search"></i>
        </div>
        <div class="sidebar-brand-text mx-3">e-Rento</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <?php
        if($dataH['user_type'] == 2){

    ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="dashboard.php?id=<?php echo $id;?>">
            <i class="fas fa-solid fa-chart-line"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
<?php }?>



    <!-- Nav Item - Pages Collapse Menu -->


    <?php 
    

        if($dataH['user_type'] == 1){
            $sqlP = "SELECT * FROM erento.property;";
            $resultP = $db->query($sqlP);
                if ($resultP->num_rows > 0) {
    ?>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Property</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <?php
                        while($rowP = $resultP->fetch_assoc()) {

                            echo '<div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="property.php">'.$rowP['property_name']. '</a>
                    </div>';

                        }
                     ?>
                </div>
            </li>
    <?php
        }
     }elseif ($dataH['user_type'] == 2) {
        ?>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fas fa-bed"></i>
                    <span>Rooms</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="manageroom.php?id=<?php echo $id;?>">View Rooms</a>
                    </div>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="manageroom.php?id=<?php echo $id;?>&add=true">Add New Room</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reservations.php?id=<?php echo $id;?>">
                    <i class="fas fa-user-check"></i>
                    <span>Reservations</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="occupants.php?id=<?php echo $id;?>">
                    <i class="fas fa-restroom"></i>
                    <span>Occupants</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="rental.php?id=<?php echo $id;?>">
                    <i class="fas fa-coins"></i>
                    <span><?php if ($dataH['user_id'] == 3){ echo "Room Charge";} else {echo "Monthly Rental";}?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="payments.php?id=<?php echo $id;?>">
                    <i class="fas fa-coins"></i>
                    <span>Payments</span>
                </a>
            </li>

        <?php
     }elseif ($dataH['user_type'] == 3 || $dataH['user_type'] == 4){
        ?>
            <li class="nav-item">
                <a class="nav-link" href="rooms.php?id=<?php echo $id;?>">
                    <i class="fas fa-fw fa-bed"></i>
                    <span>Rooms</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transactions.php?id=<?php echo $id;?>">
                    <i class="fas fa-solid fa-file-signature"></i>
                    <span>Transactions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="bills.php?id=<?php echo $id;?>">
                    <i class="fas fa-solid fa-file-invoice-dollar"></i>
                    <span>Bills</span>
                </a>
            </li>

        <?php
     }
 ?>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Nav Item - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <?php 
                                $user = $_SESSION['user_id'];
                                $sql5 = "SELECT * FROM erento.notification WHERE user_id = $user LIMIT 5;";
                                $result5 = $db->query($sql5);
                                $count = mysqli_num_rows($result5);
                                if ($count > 0) {
                                ?>
                        <span class="badge badge-danger badge-counter">!</span>
                    <?php }?>
                    </a>
                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header bg-primary">
                            Notifications
                        </h6>   
                            <?php 

                                if ($count > 0) {
                                  while($row = $result5->fetch_assoc()) {
                            ?>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500"><?php
                                    $date = $row["date_created"];
                                    $month_name = date('F', strtotime($date));
                                    $formatted_date = date('m-d-Y H:i:s', strtotime($date));
                                    list($month, $day, $yeartime) = explode('-', $formatted_date);
                                    list($year, $time) = explode(' ', $yeartime);
                                    echo "$month_name $day, $year". " - " . "$time";?></div>
                                <span class="font-weight-bold"><?php echo $row["notif_name"];?></span>
                            </div>
                        </a>
                            <?php }
                            echo '<a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>';
                        }else{
                            echo '<a class="dropdown-item text-center small text-gray-500" href="#">No notifications</a>';
                            }?>
                        
                    </div>
                </li>

                

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username'];?></span>
                        <img class="img-profile rounded-circle"
                            src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

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
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>