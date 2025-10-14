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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
              <li class="breadcrumb-item active">Accounts</li>
            </ol>

              <div class="card mb-5">
                    <div class="card-header bg-danger pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">Account Deactivated Details
                        </div>
                    </div>
                    <div class="card-body">
                      <table id="residenceAccounts" class="table table-striped nowrap" style="width:100%">
                        <thead>
                          <tr>
                              <th>Account ID</th>
                              <th>Name</th>
                              <th>Contact</th>
                              <th>Address</th>
                              <th>Action</th>

                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $query = "SELECT ta.ac_id, CONCAT(tc.first_name, ' ', tc.middle_name, ' ', tc.last_name) AS full_name, tc.contact, tc.address FROM tbl_account ta INNER JOIN tbl_account_details tc ON tc.ac_id = ta.ac_id WHERE ta.role_id = 1 AND ta.account_status_id = 2;";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                              while ($data = $result->fetch_assoc()) {
                          ?>
                          <tr>
                            <td><?php echo $data['ac_id'];?></td>
                            <td><?php echo $data['full_name'];?></td>
                            <td><?php echo $data['contact'];?></td>
                            <td><?php echo $data['address'];?></td>
                            <td>
                                <!-- <button type="button" class="btn btn-primary" id="<?php echo $data["ac_id"] ?>"  data-bs-toggle="modal" data-bs-target="#residenceAccountDetails<?php echo $data["prod_id"] ?>" data-bs-whatever="@getbootstrap">
                                  <i class="fa-solid fa-pen-to-square" style="color: #fcfcfc;"></i>
                                </button> -->
                                <button type="button" class="btn btn-primary deactivateResBtn" id="<?php echo $data["ac_id"] ?>" >
                                  <i class="fa-solid fa-clock-rotate-left"  style="color: #fcfcfc;"></i>
                                </button>
                            </td>
                          </tr>
                            <!-- <div class="modal fade" id="residenceAccountDetails<?php echo $data["account_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                  <form method="post">
                                    <div class="mb-3">
                                      <label class="col-form-label">Product Name</label>
                                      <input type="text" class="form-control updatedName" value="<?php echo $data["prod_name"]; ?>" >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Product Price</label>
                                      <input type="text" class="form-control updatedPrice" value="<?php echo $data["prod_price"]; ?>" >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Product Stocks</label>
                                      <input type="number" min="0" class="form-control updatedStocks" value="<?php echo $data["prod_stocks"]; ?>" >
                                    </div>
                                      
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                  <button type="button" class="btn btn-primary btn-accept updateResBtn" value="<?php echo $data["prod_id"] ?>" >
                                      Save
                                  </button>
                                    <button type="button" class="btn btn-secondary " value="<?php echo $data["prod_id"]; ?>" data-bs-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div> -->
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
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
    <script src="../jquery/activate.js"></script>
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
