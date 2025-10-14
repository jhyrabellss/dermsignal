<?php
session_start();
if(empty($_SESSION["admin_id"])){
  header('Location:logout.php');
}
require_once("../backend/config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Panel</title>
    <!-- DataTables -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../styles/dataTables.min.css">
    <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../styles/bootsrap5-min.css">
    <link rel="stylesheet" href="../styles/card-general.css">
    <script src="../scripts/sweetalert2.js"></script>
    <script
      src="../scripts/font-awesome.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body class="sb-nav-fixed">
    <!-- Navbar -->
    <?php require_once("./navbar.php"); ?>
    <!-- Sidebar -->
    <div id="layoutSidenav">
      <?php require_once("./sidebar.php"); ?>
      <!-- Content -->
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <!-- Page indicator -->
            <h1 class="mt-4" id="full_name">Admin</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">Create Account</li>
            </ol>

                <div class="card mb-5">
                    <div class="card-header bg-primary pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">Create Account <i class="fas fa-user-plus"></i></p>
                        </div>
                    </div>
                    <div class="card-body">
                    <form class="row g-3" method="post" id="createEmpAcc">
                        <h5 class="text-center">Account Details</h5>
                        <hr>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" >
                            </div>

                            <div class="col-md-4">
                                <label for="empUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" id="uname" >
                            </div>

                            <div class="col-md-4">
                                <label for="empPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="selectRole" class="form-label">Role</label>
                                <select id="selectRole" class="form-select">
                                    <option value="" disabled selected>Account Role</option>
                                    <!-- <option value="2">Admin</option> -->
                                    <option value="3">Cashier</option>
                                </select>      
                            </div>

                                <h5 class="text-center">Personal Details</h5>
                            <hr>
                            <div class="col-md-4">
                                <label for="empFname" class="form-label">First name</label>
                                <input type="text" class="form-control" id="fname">
                            </div>
                            <div class="col-md-4">
                                <label for="empLname" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="lname">
                            </div>
                            <div class="col-md-4">
                                <label for="empMname" class="form-label">Middle name</label>
                                <input type="text" class="form-control" id="mname">
                            </div>
            
                            <div class="col-md-4">
                                <label for="empMname" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact" oninput="validateInput(this)" pattern="\d*" maxlength="11">
                            </div>
                            <div class="col-md-6">
                                <label for="empAddress" class="form-label">Address</label>
                                <textarea id="address" class="form-control"></textarea>
                            </div>

                            <div class="col-12 text-center mb-4 mt-5">
                                <button type="submit" id="submit" class="btn btn-primary btn-lg">Sign Up</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
      </main>
    </div>
  </div>
  <script
      src="../scripts/bootstrap.bundle.min.js"
    ></script>
    <script src="../scripts/jquery.js"></script>
    <script src="../scripts/toggle.js"></script>
    <script src="../jquery/createAccount.js"></script>
    <!-- DataTables Scripts -->
    <script src="../plugins/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/js/dataTables.bootstrap5.min.js"></script>
    <script src="../plugins/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/js/responsive.bootstrap5.min.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="../styles/dataTables.min.css">

    <!-- DataTables Buttons JavaScript -->
    <script src="../scripts/dataTables.js"></script>
    <script src="../scripts/ajax.make.min.js"></script>
    <script src="../scripts/ajax.fonts.js"></script>
    <script src="../scripts/dtBtn.html5.js"></script>
    <script>
        function convertToLowercase(input) {
            input.value = input.value.toLowerCase();
        }
    </script>
    <script>
      $(document).ready(function() {
          $('#residenceAccounts').DataTable({
              responsive: true,
              order: [[0, 'desc']],
          });
      });
</script>

<!-- <script>
    const full_name = document.getElementById('full_name');
    const acc_data = JSON.parse(localStorage.getItem('adminDetails'))
    full_name.innerText = 'Admin, ' + acc_data.full_name;
  </script>   -->
<script src="../jquery/sideBarProd.js"></script>
  </body>
</html>
