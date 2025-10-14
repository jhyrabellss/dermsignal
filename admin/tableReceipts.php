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
              <li class="breadcrumb-item active">Sales</li>
            </ol>
                  <div class="card mb-5">
                    <div class="card-header bg-info pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">Online Receipt Orders
                        </div>
                    </div>
                    <div class="card-body">
                      <table id="residenceAccounts" class="table table-striped nowrap" style="width:100%">
                        <thead>
                          <tr>
                              <th>Order Id</th>
                              <th>Customer Name</th>
                              <th>Reference No.</th>
                              <th>Uploaded Date</th>
                              <th>Action</th>

                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $query = "SELECT tr.*, CONCAT(td.first_name, ' ', td.middle_name, ' ', td.last_name) as full_name,
                            td.address, td.contact
                            FROM tbl_receipt tr
                            INNER JOIN tbl_account_details td ON td.ac_id = tr.account_id";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                              while ($data = $result->fetch_assoc()) {
                                $dateObject = new DateTime($data["uploaded_date"]);
                                $formattedDate = $dateObject->format('M j, Y');
                          ?>
                          <tr>
                            <td><?php echo $data['receipt_id'];?></td>
                            <td><?php echo $data['full_name'];?></td>
                            <td><?php echo $data["receipt_number"]; ?></td>
                            <td><?php echo $formattedDate; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" id="<?php echo $data["receipt_id"] ?>"  data-bs-toggle="modal" 
                                data-bs-target="#receiptDetails<?php echo $data["receipt_id"] ?>" data-bs-whatever="@getbootstrap">
                                  <i class="fa-solid fa-eye" style="color: #fcfcfc;"></i>
                                </button>
                            </td>
                          </tr>
                            <div class="modal fade" id="receiptDetails<?php echo $data["receipt_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                  <form method="post">
                                    <div class="mb-3">
                                      <label class="col-form-label">Customer Deposited</label>
                                      <input type="text" class="form-control updatedName" value="<?php echo $data["deposit_amount"]; ?>" disabled >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Customer Reference Number</label>
                                      <input type="text" class="form-control updatedName" value="<?php echo $data["receipt_number"]; ?>" disabled >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Customer Name</label>
                                      <input type="text" class="form-control updatedName" value="<?php echo $data["full_name"]; ?>" disabled >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Customer Address</label>
                                      <input type="text" class="form-control updatedName" value="<?php echo $data["address"]; ?>" disabled >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Customer Contact</label>
                                      <input type="text" class="form-control updatedName" value="<?php echo $data["contact"]; ?>" disabled >
                                    </div>
                                    <div>
                                      <label class="col-form-label">Image Receipt:</label>
                                      <div class="img-con" style="width: 250px;">
                                        <img src="../backend/receipts/<?php echo $data["receipt_img"]; ?>" alt=""
                                        style="width: 250px;">
                                      </div>
                                    </div>
                                      
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                  <!-- <button type="button" class="btn btn-primary btn-accept updateResBtn" value="<?php echo $data["receipt_id"] ?>" >
                                      Save
                                  </button> -->
                                    <button type="button" class="btn btn-secondary " value="<?php echo $data["receipt_id"]; ?>" data-bs-dismiss="modal">Close</button>
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
    <script src="../jquery/updatePending.js"></script>
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
          $('#residenceAccounts').DataTable({
              responsive: true,
              order: [[0, 'desc']],
          });
      });
</script>

<script src="../jquery/cancelOrder.js"></script>

<script>
      $(document).ready(function() {
          $('#toClaimOrders').DataTable({
              responsive: true,
              order: [[0, 'desc']],
          });
      });
</script>

<script>
    const full_name = document.getElementById('full_name');
    const acc_data = JSON.parse(localStorage.getItem('cashierDetails'))
    full_name.innerText = 'Cashier, ' + acc_data.full_name;
  </script>  
  </body>
</html>
