<?php
session_start();
if(empty($_SESSION["admin_id"])){
  header('Location:logout.php');
  exit();
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
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">Transactions</li>
            </ol>

              <div class="card mb-5">
                    <div class="card-header bg-primary pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">All Transactions
                        </div>
                    </div>
                    <div class="card-body">
                      <table id="userAuditLogs" class="table table-striped nowrap" style="width:100%">
                        <thead>
                          <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>User Activty</th>
                            <th>User Type</th>
                            <th>Claimed Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $query = "SELECT ts.*, tr.role_name, tp.prod_name, tp.prod_price, tc.prod_qnty, CONCAT(td.first_name, ' ', td.middle_name, ' ', td.last_name) as full_name, td.address, td.contact FROM tbl_transactions ts 
                            INNER JOIN tbl_cart tc ON tc.item_id = ts.item_id
                            INNER JOIN tbl_products tp ON tp.prod_id = tc.prod_id
                            INNER JOIN tbl_account_details td ON td.ac_id = tc.account_id
                            INNER JOIN tbl_role tr ON tr.role_id = ts.user_type";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                              while ($data = $result->fetch_assoc()) {
                                $dateObject = new DateTime($data["activity_date"]);
                                $total = $data["prod_qnty"] * $data["prod_price"];
                                $item_id = $data["item_id"];
                          ?>
                          <tr>
                            <td><?php echo $data['user_id'];?></td>
                            <td><?php echo $data['user_name'];?></td>
                            <td><?php echo $data['user_activity'];?></td>
                            <td><?php echo $data['role_name'];?></td>
                            <td><?php echo $dateObject->format('F j, Y'); ?></td>
                            <td>
                              <button type="button" class="btn btn-primary" id="<?php echo $item_id; ?>" data-bs-toggle="modal" data-bs-target="#residenceAccountDetails<?php echo $item_id; ?>" data-bs-whatever="@getbootstrap">
                                <i class="fa-solid fa-eye" style="color: #fcfcfc;"></i>
                              </button>
                            </td>
                          </tr>
                    <div class="modal fade" id="residenceAccountDetails<?php echo $item_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form method="post">
                            <div class="mb-3">
                              <label class="col-form-label">Customer Name</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data["full_name"]); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label">Customer Address</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data["address"]); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label">Customer Contact</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data["contact"]); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label">Order Name</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data["prod_name"]); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label">Order Price</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data["prod_price"]); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label">Order Quantity</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data["prod_qnty"]); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label">Total</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($total); ?>" disabled>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
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
    <script src="../jquery/sideBarProd.js"></script>
    <script>
        function convertToLowercase(input) {
            input.value = input.value.toLowerCase();
        }
    </script>

<script>
      $(document).ready(function() {
          $('#userAuditLogs').DataTable({
              responsive: true,
              order: [[0, 'desc']],
        //       dom: 'Bfrtip',
        //       buttons: [
        //     {
        //         extend: 'csvHtml5',
        //         text: '<i class="fa-solid fa-file-csv fa-2xl" style="color: #1e7b64;"></i>',
        //     },
        //     {
        //         extend: 'pdfHtml5',
        //         text: '<i class="fa-solid fa-file-pdf fa-2xl" style="color: #a01818;"></i> ',
        //     }
        // ]
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
