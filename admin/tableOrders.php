<?php
session_start();
if (empty($_SESSION["admin_id"])) {
  header('Location: logout.php');
  exit();
}

require_once("../backend/config/config.php");

$status_filter = isset($_GET['status']) ? intval($_GET['status']) : 'all';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Admin Panel - Sales</title>
  <!-- DataTables -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../jquery/updatePending.js"></script>
  <script src="../jquery/cancelOrderAdmin.js"></script>
  <link rel="stylesheet" href="../styles/dataTables.min.css">
  <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/bootsrap5-min.css">
  <link rel="stylesheet" href="../styles/card-general.css">
  <style>
    .filter-buttons {
      margin-bottom: 20px;
    }

    .filter-buttons .btn {
      margin-right: 10px;
      margin-bottom: 10px;
    }

    .status-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .status-process {
      background-color: #fff3cd;
      color: #856404;
      border: 1px solid #ffeaa7;
    }

    .status-delivery {
      background-color: #d1ecf1;
      color: #0c5460;
      border: 1px solid #bee5eb;
    }

    .status-pending {
      background-color: #e2e3e5;
      color: #383d41;
      border: 1px solid #d6d8db;
    }

    .status-delivered {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .status-canceled {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .status-reserve {
      background-color: #e7e3f5;
      color: #4a148c;
      border: 1px solid #d1c4e9;
    }

    td:nth-child(1) {
      width: 90px;
    }

    td:nth-child(2) .status-badge {
      width: 100px;
    }

    td:nth-child(3) {
      width: 180px;
    }
  </style>
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
            <li class="breadcrumb-item active">Sales Management</li>
          </ol>

          <!-- Orders Card -->
          <div class="card mb-5">
            <div class="card-header bg-secondary pt-3">
              <div class="text-center">
                <p class="card-title text-light mb-0">Online Orders Management</p>
              </div>
            </div>
            <div class="card-body">
              <!-- Filter Buttons -->
              <div class="filter-buttons">
                <button class="btn btn-outline-secondary filter-btn <?php echo ($status_filter === 'all' || !isset($_GET['status'])) ? 'active' : ''; ?>" data-status="all">
                  <i class="fas fa-list"></i> All Orders
                </button>
                <button class="btn btn-outline-warning filter-btn <?php echo ($status_filter === 3) ? 'active' : ''; ?>" data-status="3">
                  <i class="fas fa-hourglass-half"></i> Process
                </button>
                <button class="btn btn-outline-info filter-btn <?php echo ($status_filter === 4) ? 'active' : ''; ?>" data-status="4">
                  <i class="fas fa-truck"></i> Out for Delivery
                </button>
                <button class="btn btn-outline-success filter-btn <?php echo ($status_filter === 2) ? 'active' : ''; ?>" data-status="2">
                  <i class="fas fa-check-circle"></i> Delivered
                </button>
                <button class="btn btn-outline-danger filter-btn <?php echo ($status_filter === 5) ? 'active' : ''; ?>" data-status="5">
                  <i class="fas fa-ban"></i> Canceled
                </button>
                <button class="btn btn-outline-purple filter-btn <?php echo ($status_filter === 6) ? 'active' : ''; ?>" data-status="6">
                  <i class="fas fa-bookmark"></i> Reserved
                </button>
              </div>

              <!-- Orders Table -->
              <table id="ordersTable" class="table table-striped wrap" style="width:100%">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Original Price</th>
                    <th>Discount</th>
                    <th>Order Price</th>
                    <th>Quantity</th>
                    <th>Concern</th>
                    <th>Voucher</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Get status filter from URL
                  $status_filter = isset($_GET['status']) ? intval($_GET['status']) : 'all';

                  // Build query based on filter
                  if ($status_filter === 'all' || $status_filter === 0) {
                    $query = "SELECT tc.item_id, tc.account_id, tc.prod_id, tc.prod_qnty, tc.status_id, tc.order_date,
                      tp.prod_name, tp.prod_price, tp.prod_discount, 
                      CONCAT(ta.first_name, ' ', ta.middle_name, ' ', ta.last_name) as full_name,
                      ta.contact, ta.address, tn.concern_name
                      FROM tbl_cart tc 
                      INNER JOIN tbl_products tp ON tp.prod_id = tc.prod_id 
                      INNER JOIN tbl_account_details ta ON ta.ac_id = tc.account_id 
                      LEFT JOIN tbl_concern tn ON tn.concern_id = tp.concern_id
                      WHERE tc.status_id IN (1, 2, 3, 4, 5, 6)
                      ORDER BY tc.order_date DESC";

                                      $stmt = $conn->prepare($query);
                                    } else {
                                      $query = "SELECT tc.item_id, tc.account_id, tc.prod_id, tc.prod_qnty, tc.status_id, tc.order_date,
                      tp.prod_name, tp.prod_price, tp.prod_discount, 
                      CONCAT(ta.first_name, ' ', ta.middle_name, ' ', ta.last_name) as full_name,
                      ta.contact, ta.address, tn.concern_name
                      FROM tbl_cart tc 
                      INNER JOIN tbl_products tp ON tp.prod_id = tc.prod_id 
                      INNER JOIN tbl_account_details ta ON ta.ac_id = tc.account_id 
                      LEFT JOIN tbl_concern tn ON tn.concern_id = tp.concern_id
                      WHERE tc.status_id = ?
                      ORDER BY tc.order_date DESC";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $status_filter);
                  }

                  if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                  }

                  $stmt->execute();
                  $result = $stmt->get_result();

                  while ($data = $result->fetch_assoc()) {
                    $origprice = $data['prod_price'] + 100;
                    $proddiscount = $data['prod_discount'] / 100;
                    $prodprice = $origprice - ($origprice * $proddiscount);
                    $subtotal = $data["prod_qnty"] * $prodprice;

                    // Get status name and badge class
                    $status_names = [
                      1 => ['name' => 'Pending', 'class' => 'status-pending'],
                      2 => ['name' => 'Delivered', 'class' => 'status-delivered'],
                      3 => ['name' => 'Process', 'class' => 'status-process'],
                      4 => ['name' => 'Out for Delivery', 'class' => 'status-delivery'],
                      5 => ['name' => 'Canceled', 'class' => 'status-canceled'],
                      6 => ['name' => 'Reserved', 'class' => 'status-reserve']
                    ];

                    $status_info = $status_names[$data['status_id']] ?? ['name' => 'Unknown', 'class' => 'status-pending'];

                    // Get vouchers applied to this order
                    $voucher_query = "SELECT v.voucher_name, v.voucher_code, v.discount_type, v.discount_value
                      FROM tbl_cart_vouchers cv
                      INNER JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
                      WHERE cv.account_id = ? AND cv.status_id = ?";
                    $stmt_voucher = $conn->prepare($voucher_query);
                    $stmt_voucher->bind_param("ii", $data['account_id'], $data['status_id']);
                    $stmt_voucher->execute();
                    $voucher_result = $stmt_voucher->get_result();

                    $voucher_display = "";
                    if ($voucher_result->num_rows > 0) {
                      $voucher_display = "<div style='font-size: 0.85rem;'>";
                      while ($voucher = $voucher_result->fetch_assoc()) {
                        $discount_text = $voucher['discount_type'] == 'percentage'
                          ? $voucher['discount_value'] . '%'
                          : '₱' . number_format($voucher['discount_value'], 2);
                        $voucher_display .= "<span class='badge bg-success mb-1'>"
                          . htmlspecialchars($voucher['voucher_code'])
                          . " (" . $discount_text . ")</span><br>";
                      }
                      $voucher_display .= "</div>";
                    } else {
                      $voucher_display = "<span class='text-muted'>No voucher</span>";
                    }
                  ?>
                    <tr data-status="<?php echo $data['status_id']; ?>">
                      <td><?php echo htmlspecialchars($data['item_id']); ?></td>
                      <td>
                        <span class="status-badge <?php echo $status_info['class']; ?>">
                          <?php echo $status_info['name']; ?>
                        </span>
                      </td>
                      <td><?php echo htmlspecialchars($data['full_name']); ?></td>
                      <td>₱<?php echo number_format($origprice, 2); ?></td>
                      <td><?php echo number_format($data['prod_discount'], 2); ?>%</td>
                      <td>₱<?php echo number_format($prodprice, 2); ?></td>
                      <td><?php echo htmlspecialchars($data['prod_qnty']); ?></td>
                      <td><?php echo htmlspecialchars($data['concern_name']); ?></td>
                      <td><?php echo $voucher_display; ?></td>
                      <td>
                        <button type="button" class="btn btn-sm btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#productDetails<?php echo htmlspecialchars($data['item_id']); ?>"
                          title="View Details">
                          <i class="fa-solid fa-eye"></i>
                        </button>

                        <?php if ($data['status_id'] == 3 || $data['status_id'] == 4): ?>
                          <button type="button" class="btn btn-sm btn-success updateBtn"
                            id="<?php echo htmlspecialchars($data['item_id']); ?>"
                            data-status-id="<?php echo $data["status_id"]; ?>"
                            data-account-id="<?php echo $data["account_id"]; ?>"
                            title="Complete Order">
                            <i class="fa-solid fa-check"></i>
                          </button>
                        <?php endif; ?>

                        <?php if ($data['status_id'] != 5 && $data['status_id'] != 2): ?>
                          <button type="button" class="btn btn-sm btn-danger delete-js"
                            id="<?php echo htmlspecialchars($data['item_id']); ?>"
                            title="Cancel Order">
                            <i class="fa-solid fa-ban"></i>
                          </button>
                        <?php endif; ?>
                      </td>
                    </tr>

                    <!-- Modal for product details -->
                    <div class="modal fade" id="productDetails<?php echo htmlspecialchars($data['item_id']); ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Order Details - #<?php echo htmlspecialchars($data['item_id']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Order Status</label>
                              <div>
                                <span class="status-badge <?php echo $status_info['class']; ?>">
                                  <?php echo $status_info['name']; ?>
                                </span>
                              </div>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Customer Name</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['full_name']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Customer Address</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['address']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Customer Contact</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['contact']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Product Name</label>
                              <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['prod_name']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Order Price</label>
                              <input type="text" class="form-control" value="₱<?php echo number_format($prodprice, 2); ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Quantity</label>
                              <input type="text" class="form-control" value="<?php echo $data['prod_qnty']; ?>" disabled>
                            </div>
                            <div class="mb-3">
                              <label class="col-form-label fw-bold">Total Amount</label>
                              <input type="text" class="form-control" value="₱<?php echo number_format($subtotal, 2); ?>" disabled>
                            </div>
                            <?php if ($voucher_result->num_rows > 0): ?>
                              <div class="mb-3">
                                <label class="col-form-label fw-bold">Vouchers Applied</label>
                                <div class="form-control" disabled style="background-color: #e9ecef;">
                                  <?php echo $voucher_display; ?>
                                </div>
                              </div>
                            <?php endif; ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  } // end while
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="../scripts/bootstrap.bundle.min.js"></script>
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
    $(document).ready(function() {
      // Initialize DataTable
      var table = $("#ordersTable").DataTable({
        responsive: true,
        order: [
          [0, 'desc']
        ]
      });

      // Remove the custom search function since we're reloading the page

      // Filter functionality - reload page with status parameter
      $('.filter-btn').click(function() {
        var status = $(this).data('status');

        // Reload page with status filter
        if (status === 'all') {
          window.location.href = window.location.pathname;
        } else {
          window.location.href = window.location.pathname + '?status=' + status;
        }
      });

    });
  </script>
</body>

</html>