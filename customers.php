<!-- For  customers you can view custmer name ,allergy concat allergy and dislikes as dislikes, phonenumber ,loyalty points ,likes, so can add new customer or delete existing or update existing-->
<?php 
session_start();
require("actions/config.php");
// include("automatic_message_sending.php");

global $conn;
if (!isset($_SESSION['staff_id'])) {
    header("Location: signup-page.php?You are not logged in");
    echo "You are not logged in";
    exit();
} else {
    $staff_id = $_SESSION['staff_id'];
    $userdata = "SELECT * FROM staff WHERE staff_id = '$staff_id'";
    $result = $conn -> query($userdata);
    $row = $result -> fetch_assoc();
    $position = $row["position_id"];
    $accesslevel = $row["access_level"];
    $Password = $row["password"];
    $user_name = $row['username'];
    $staff_name=$row["Staff_name"];
    list($firstname,$lastname)= explode(" ", $staff_name);
    $age=$row["age"];
    $phone =$row["phone_number"];

  
    if (
        in_array($accesslevel, [3]) || 
        in_array($position, ["AC1-H", "AC1-S"])
    ) {
        // Authorized user
    } else {
        header("Location: index.php?You are not authorized");
        echo "You are not authorized";
        exit();
    }
    // $profile_pic =$row["ru_pic"];
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>WishMe Admin page | <?php echo $user_name ?> </title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <!-- Custom CSS -->
   <link href="css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="dashboard.php">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="plugins/images/logo-icon.png" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="plugins/images/logo-text.png" alt="homepage" />
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse bg-warning" id="navbarSupportedContent" >
                    <ul class="navbar-nav d-none d-md-block d-lg-none">
                        <li class="nav-item">
                            <a class="nav-toggler nav-link waves-effect waves-light text-white"
                                href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class=" in">
                            <form role="search" class="app-search d-none d-md-block me-3">
                                <input type="text" placeholder="Search..." class="form-control mt-0">
                                <a href="" class="active">
                                    <i class="fa fa-search"></i>
                                </a>
                            </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" href="profile.php">
                                <img src="plugins/images/users/varun.jpg" alt="user-img" width="36"
                                    class="img-circle"><span class="text-white font-medium"><?php echo $user_name ?></span></a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profile.php"
                                aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="hide-menu">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="customers.php"
                                aria-expanded="false">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span class="hide-menu">Customers</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="orders.php"
                                aria-expanded="false">
                                <i class="fas fa-hourglass-start" aria-hidden="true"></i>
                                <span class="hide-menu">Orders</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="menu.php"
                                aria-expanded="false">
                                <i class="fas fa-utensils" aria-hidden="true"></i>
                                <span class="hide-menu">Menu</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="inventory.php"
                                aria-expanded="false">
                                <i class="fas fa-box" aria-hidden="true"></i>
                                <span class="hide-menu">Inventory</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="transactions-history.php"
                                aria-expanded="false">
                                <i class="fas fa-money-bill-alt" aria-hidden="true"></i>
                                <span class="hide-menu">Transactions-history</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="requests.php"
                                aria-expanded="false">
                                <i class="fas fa-comment-dots" aria-hidden="true"></i>
                                <span class="hide-menu">Requests</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="review.php"
                                aria-expanded="false">
                                <i class="far fa-comment-alt" aria-hidden="true"></i>
                                <span class="hide-menu">Reviews</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="search.php"
                                aria-expanded="false">
                                <i class="fas fa-search" aria-hidden="true"></i>
                                <span class="hide-menu">Search</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="staff.php"
                                aria-expanded="false">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                <span class="hide-menu">Staff</span>
                            </a>
                        </li>
                        <li class="text-center p-20 upgrade-btn">
                            <a data-bs-toggle="modal" data-bs-target="#logout-modal" role="button" 
                                class="btn d-grid btn-danger text-white" >
                                Logout</a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Customers Table</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="dashboard.php" class="fw-normal">Dashboard</a></li>
                                
                            </ol>
                                <a type="button" class="btn btn-danger  d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white" data-bs-toggle="modal" data-bs-target="#upload-customers-modal" >Upload customers</a>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Customers Table</h3>
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">Full Name</th>
                                            <th class="border-top-0">Phone Number</th>
                                            <th class="border-top-0">Likes</th>
                                            <th class="border-top-0">Dislikes </th>
                                            <th class="border-top-0">Loyalty Points</th>
                                            <th class="border-top-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                require("actions/config.php");
                
                
                $sql = "SELECT * FROM customers";
                $result = $conn->query($sql);
                
                $record = "";
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $customerid = htmlspecialchars($row["customer_id"]);
                        $fullname = htmlspecialchars($row["customer_name"]);
                        $phonenumber = htmlspecialchars($row["phone_number"]);
                        $likes = htmlspecialchars($row["likes"]);
                        $bad_food = htmlspecialchars($row["allergy"] .', '.$row["dislikes"]);
                        $loyaltypoints = htmlspecialchars($row["loyalty_points"]);
                        $customer_gender = htmlspecialchars($row["gender"]);
                        $customer_location = htmlspecialchars($row["location"]);
                        $customer_allergy = htmlspecialchars($row["allergy"]);
                        $customer_likes = htmlspecialchars($row["likes"]);
                        $customer_dislikes = htmlspecialchars($row["dislikes"]);
                        list($customer_fname,$customer_lname) = explode(" ", $fullname);
                    ?>
                       <tr>
                                <td> <?php echo $customerid; ?> </td>
                                <td> <?php echo $fullname; ?> </td>
                                <td> <?php echo $phonenumber; ?> </td>
                                <td> <?php echo $likes; ?> </td>
                                <td> <?php echo $bad_food; ?> </td>
                                <td> <?php echo $loyaltypoints; ?></td>
                                <td>
                                <a class='btn btn-danger' href='actions/customer-operations.php?action=delete_customer&cid=<?php echo urlencode($customerid); ?>' role='button'>Delete</a> |
                                <a class='btn btn-warning'type='button' data-bs-toggle='modal' data-bs-target='#update-customer-modal-<?php echo $customerid; ?>' >Update</a>
                                </td>
                            </tr>
                
                      <!-- this is the Update customers modal -->
            <div class="modal fade" id="update-customer-modal-<?php echo $customerid; ?>" tabindex="-1" aria-labelledby="update-customer-modal-title-<?php echo $customerid; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="update-customer-modal-title-<?php echo $customerid; ?>">Update Customer Details-<?php echo $customerid; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="actions/customer-operations.php" method = 'POST' id="customer" class="needs-validation" novalidate>

                    <!-- Hidden input to store customer ID -->
                    <input type="hidden" name="customer_id" id="customer-id" value="<?php echo $customerid; ?>">

                    <input type="hidden" name="customerlist" value="Update">
                    <div class="row g-3">
                      <div class="col-6">
                        <input type="text" class="form-control" placeholder="<?php if (!empty($customer_fname)){echo $customer_fname; }else {echo 'First name';}?>" aria-label="First name" name="customer-firstname" >
                      </div>
                      <div class="col-6">
                        <input type="text" class="form-control" placeholder="<?php if (!empty($customer_lname)){ echo $customer_lname; }else {echo 'Last name';} ?>" aria-label="Last name" name="customer-lastname">
                      </div>

                      <div class="col-4">
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="gender" disabled>Gender</option>
                            
                            <?php
                               $Genders = ['Male'=>"male","Female"=>"female"];  
                        
                                      foreach ($Genders as $option => $name) {
                                          $selected = ($option == $gender) ? 'selected' : '';
                                          echo "<option value=\"$option\" $selected>$name</option>";
                                      }
                            ?>
                        </select>
                      </div>
                     
                      <div class="col-8">
                          <input type="text" class="form-control"placeholder="<?php if (!empty($phonenumber)){echo $phonenumber; }else {echo 'phone number';} ?>" id="phone" name="customer-phone" required>
                          <div class="invalid-feedback">
                          Please enter person's phone number.
                          </div>
                      </div>
                      <div class="col-12">
                        <div class="input-group ">
                          <span class="input-group-text">Enter Birthdate</span>
                          <input type="date" class="form-control" id="date_of_birth" name="customer-dob" required>
                        </div>
                        <div class="invalid-feedback">
                        input  date of birth.
                        </div>
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="<?php if (!empty($customer_location)){echo $customer_location; }else {echo 'location';}  ?>" id="location" name="location" >
                         
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="<?php if (!empty($customer_allergy)){echo $customer_allergy; }else {echo 'allergy';}  ?>" id="allergy" name="allergy" >
                          
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="<?php if (!empty($customer_likes)){echo $customer_likes; }else {echo 'likes';} ?>" id="likes" name="likes" >
                       
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="<?php if (!empty($customer_dislikes)){echo $customer_dislikes; }else {echo 'dislikes';}  ?>" id="dislikes" name="dislikes" >
                         
                      </div>


                    </div> 
                    <button type="submit" class="btn btn-outline-danger" name="Update_customer"  id="customer">Update</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                
                </div>
              </div>
            </div>
          </div>
  
                <?php
                    }
                } else {
                    $record = "<tr><td colspan='4'>No users available</td></tr>";
                }
                
                $conn->close();
                echo $record;
                ?>
                    
                                    </tbody>
                           
                                </table>
                                         <!-- Add customers button that toggles to the add customers modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-customer-modal"  >
              Add customer
            </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2021 © WishMe brought to you by Group5 
                    <p>Content on this page is reproduced from <a
                    href="https://www.wrappixel.com/">wrappixel.com</a> with permission from the author.</p>

            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>

<!-- =============================================== -->
  <!-- =================START OF customers UPLOAD MODAL============== -->
  <!-- =============================================== -->
    <div class="modal fade" id="upload-customers-modal" tabindex="-1" aria-labelledby="uploadexampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadexampleModalLabel">Upload customers</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="actions/customer_upload.php"  id="signin" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="input-group mb-3">
            <input type="file" class="form-control" id="inputGroupFile02" name="customer_file" accept=".csv" required>
            <label class="input-group-text" for="inputGroupFile02">Upload customers csv here</label>
          </div>

              <br>
              <button class="w-100 btn btn-primary btn-lg" name="sign_in" >Upload</button>
            </div>    
          </form>
          
          </div>
       
      </div>
    </div>
  </div>



            <!-- this is the Add customers modal -->
            <div class="modal fade" id="add-customer-modal" tabindex="-1" aria-labelledby="customer-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="customer-modal-title">Add Customer Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="actions/customer-operations.php" method = 'POST' id="customer" class="needs-validation" novalidate>
                    <input type="hidden" name="customerlist" value="Add">
                    <div class="row g-3">
                      <div class="col-6">
                        <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="customer-firstname">
                      </div>
                      <div class="col-6">
                        <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="customer-lastname">
                      </div>

                      <div class="col-4">
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="gender" disabled>Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                      </div>
                     
                      <div class="col-8">
                          <input type="text" class="form-control"placeholder="+233 205069504" id="phone" name="customer-phone" required>
                          <div class="invalid-feedback">
                          Please enter person's phone number.
                          </div>
                      </div>
                      <div class="col-12">
                        <div class="input-group ">
                          <span class="input-group-text">Enter Birthdate</span>
                          <input type="date" class="form-control" id="date_of_birth" name="customer-dob" required>
                        </div>
                        <div class="invalid-feedback">
                        input  date of birth.
                        </div>
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="location" id="location" name="location" >
                         
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="Allergy" id="allergy" name="allergy" >
                          
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="likes" id="likes" name="likes" >
                       
                      </div>

                      <div class="col-12">
                          <input type="text" class="form-control"placeholder="dislikes" id="dislikes" name="dislikes" >
                         
                      </div>


                    </div> 
                    <button type="submit" class="btn btn-outline-danger" name="Add_customer"  id="customer">Add</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                
                </div>
              </div>
            </div>
          </div>



            



            <!-- this is the logout modal -->
            <div class="modal fade" id="logout-modal" tabindex="-1" aria-labelledby="logout-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="logout-modal-title">Logout</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>This will log you out. Do you still want to proceed?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  
                  <form action="php/logout.php" method="post">
                  <button type="submit" class="btn btn-outline-danger" name="logout"  id="logout">Logout</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
  <!-- =============================================== -->
  <!-- =================END OF customer UPLOAD MODAL============== -->
  <!-- =============================================== -->

    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>

</body>

</html>