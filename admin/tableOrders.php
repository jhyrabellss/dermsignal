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

      .pagination-container {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-top: 20px;
          padding: 15px;
          background: white;
          border-radius: 8px;
      }

      .pagination {
          display: flex;
          gap: 5px;
          list-style: none;
          margin: 0;
          padding: 0;
      }

      .pagination li a {
          padding: 8px 12px;
          border: 1px solid #dee2e6;
          border-radius: 4px;
          color: #495057;
          text-decoration: none;
          transition: all 0.2s;
      }

      .pagination li a:hover {
          background: #e9ecef;
          border-color: #adb5bd;
      }

      .pagination li.active a {
          background: #0d6efd;
          color: white;
          border-color: #0d6efd;
      }

      .pagination li.disabled a {
          color: #6c757d;
          pointer-events: none;
          background: #f8f9fa;
      }

      .showing-text {
          color: #6c757d;
          font-size: 14px;
      }

      .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }

      .table-sm td, .table-sm th {
        padding: 0.5rem;
        font-size: 13px;
      }

      .order-table {
        width: 100%;
        min-width: 1200px;
        margin: 0;
        table-layout: auto;
      }

      .voucher-row {
        background-color: #f8f9fa;
      }

      .voucher-header-row {
        background-color: #e7f5ff;
      }

      .voucher-icon {
        text-align: center;
        vertical-align: middle;
      }

      .voucher-code {
        font-size: 10px;
        color: #6c757d;
        font-family: monospace;
        background: #e9ecef;
        padding: 2px 6px;
        border-radius: 3px;
        display: inline-block;
        margin-top: 2px;
      }

      .summary-divider {
        border-top: 2px solid #dee2e6;
        padding: 10px;
      }

      .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: nowrap;
      }

      .order-group-card {
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 0.375rem;
        overflow: hidden;
      }

      .order-group-card .card-header {
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #dee2e6;
      }

      .order-group-card .card-body {
        padding: 20px;
      }

      .main-card-body {
        padding: 20px;
      }

      .no-orders-container {
        text-align: center;
        padding: 60px 20px;
      }

      /* Mobile responsiveness */
      @media (max-width: 768px) {
        .filter-buttons .btn {
          margin-right: 5px;
          margin-bottom: 5px;
          padding: 0.375rem 0.5rem;
          font-size: 0.875rem;
        }
        
        .pagination-container {
          flex-direction: column;
          gap: 10px;
        }
        
        .order-table {
          min-width: 1000px;
        }

        .main-card-body {
          padding: 15px;
        }

        .order-group-card .card-body {
          padding: 15px;
        }
      }

      body {
        overflow-x: hidden;
      }

      #layoutSidenav_content {
        overflow-x: hidden;
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
            <div class="card-body main-card-body">
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

              <?php
                  // Pagination settings
                  $items_per_page = 5;
                  $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                  $offset = ($current_page - 1) * $items_per_page;

                  // First, get total count of order groups
                  $count_query = "SELECT COUNT(DISTINCT CONCAT(DATE(tc.order_date), '_', tc.account_id)) as total
                    FROM tbl_cart tc 
                    WHERE tc.status_id IN (1, 2, 3, 4, 5, 6)";

                  if ($status_filter !== 'all' && $status_filter !== 0) {
                    $count_query .= " AND tc.status_id = " . intval($status_filter);
                  }

                  $count_result = mysqli_query($conn, $count_query);
                  $count_row = mysqli_fetch_assoc($count_result);
                  $total_groups = $count_row['total'];
                  $total_pages = ceil($total_groups / $items_per_page);

                  // Get all orders with product details
                  $query = "SELECT tc.item_id, tc.account_id, tc.prod_id, tc.prod_qnty, tc.status_id, tc.order_date,
                    tp.prod_name, tp.prod_price, tp.prod_discount, tp.prod_img,
                    CONCAT(ta.first_name, ' ', ta.middle_name, ' ', ta.last_name) as full_name,
                    ta.contact, ta.address, tn.concern_name, ts.status_name
                    FROM tbl_cart tc 
                    INNER JOIN tbl_products tp ON tp.prod_id = tc.prod_id 
                    INNER JOIN tbl_account_details ta ON ta.ac_id = tc.account_id 
                    LEFT JOIN tbl_concern tn ON tn.concern_id = tp.concern_id
                    INNER JOIN tbl_status ts ON tc.status_id = ts.status_id
                    WHERE tc.status_id IN (1, 2, 3, 4, 5, 6)";

                  if ($status_filter !== 'all' && $status_filter !== 0) {
                    $query .= " AND tc.status_id = " . intval($status_filter);
                  }

                  $query .= " ORDER BY tc.order_date DESC, tc.account_id, tc.item_id DESC";

                  $result = mysqli_query($conn, $query);

                  // Get all vouchers
                  $queryVouchers = "SELECT cv.*, v.*, ts.status_name,
                    (SELECT MIN(tc.order_date) 
                    FROM tbl_cart tc 
                    WHERE tc.account_id = cv.account_id 
                    AND tc.status_id = cv.status_id
                    AND tc.order_date >= DATE(cv.added_date)) as order_date
                  FROM tbl_cart_vouchers cv
                  JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
                  JOIN tbl_status ts ON cv.status_id = ts.status_id
                  WHERE cv.status_id IN (1, 2, 3, 4, 5, 6)";

                  if ($status_filter !== 'all' && $status_filter !== 0) {
                    $queryVouchers .= " AND cv.status_id = " . intval($status_filter);
                  }

                  $resultVouchers = mysqli_query($conn, $queryVouchers);

                  if ($result && mysqli_num_rows($result) > 0) {
                    // Group orders by date and account
                    $orderGroups = [];
                    $vouchersByDateAccount = [];
                    
                    mysqli_data_seek($result, 0);
                    while ($data = mysqli_fetch_assoc($result)) {
                      $orderDate = $data['order_date'];
                      $accountId = $data['account_id'];
                      $groupKey = $orderDate . '_' . $accountId;
                      
                      if (!isset($orderGroups[$groupKey])) {
                        $orderGroups[$groupKey] = [
                          'date' => $orderDate,
                          'account_id' => $accountId,
                          'customer_name' => $data['full_name'],
                          'items' => []
                        ];
                      }
                      $orderGroups[$groupKey]['items'][] = $data;
                    }

                    // Group vouchers by date and account
                    if ($resultVouchers) {
                      mysqli_data_seek($resultVouchers, 0);
                      while ($voucher = mysqli_fetch_assoc($resultVouchers)) {
                        $orderDate = $voucher['order_date'];
                        $accountId = $voucher['account_id'];
                        if ($orderDate) {
                          $groupKey = $orderDate . '_' . $accountId;
                          if (!isset($vouchersByDateAccount[$groupKey])) {
                            $vouchersByDateAccount[$groupKey] = [];
                          }
                          $vouchersByDateAccount[$groupKey][] = $voucher;
                        }
                      }
                    }

                    // Apply pagination to order groups
                    $orderGroupsArray = array_values($orderGroups);
                    $paginatedGroups = array_slice($orderGroupsArray, $offset, $items_per_page);
                    
                    $showing_from = $offset + 1;
                    $showing_to = min($offset + count($paginatedGroups), $total_groups);

                    // Get status names
                    $status_names = [
                      1 => ['name' => 'Pending', 'class' => 'status-pending'],
                      2 => ['name' => 'Delivered', 'class' => 'status-delivered'],
                      3 => ['name' => 'Process', 'class' => 'status-process'],
                      4 => ['name' => 'Out for Delivery', 'class' => 'status-delivery'],
                      5 => ['name' => 'Canceled', 'class' => 'status-canceled'],
                      6 => ['name' => 'Reserved', 'class' => 'status-reserve']
                    ];

                    // Display orders grouped by date and account
                    foreach ($paginatedGroups as $group) {
                      $orderDate = $group['date'];
                      $accountId = $group['account_id'];
                      $customerName = $group['customer_name'];
                      $items = $group['items'];
                      $groupKey = $orderDate . '_' . $accountId;
                      $dateFormatted = date('F d, Y', strtotime($orderDate));
                      
                      $subtotal = 0;
                      $voucherDiscount = 0;
                      
                      // Calculate subtotal for this order group
                      foreach ($items as $item) {
                        $origprice = $item['prod_price'] + 100;
                        $subtotal += round($item["prod_qnty"] * $origprice, 2);
                      }

                      // Calculate voucher discounts for this group
                      if (isset($vouchersByDateAccount[$groupKey])) {
                        foreach ($vouchersByDateAccount[$groupKey] as $voucher) {
                          $targetItems = json_decode($voucher['target_items'], true);
                          $eligibleProductIds = [];
                          
                          $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null || count($targetItems) == 0);
                          
                          if ($applyToAll) {
                            foreach ($items as $item) {
                              $eligibleProductIds[] = $item['prod_id'];
                            }
                          } else {
                            if ($targetItems && is_array($targetItems)) {
                              foreach ($targetItems as $item) {
                                if (isset($item['type']) && $item['type'] == 'product' && isset($item['id'])) {
                                  $eligibleProductIds[] = intval($item['id']);
                                }
                              }
                            }
                          }
                          
                          $voucherSubtotal = 0;
                          foreach ($items as $item) {
                            if (in_array($item['prod_id'], $eligibleProductIds)) {
                              $origprice = $item['prod_price'] + 100;
                              $voucherSubtotal += round($item["prod_qnty"] * $origprice, 2);
                            }
                          }
                          
                          $currentDiscount = 0;
                          if ($voucher['discount_type'] == 'percentage') {
                            $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                            if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                              $currentDiscount = $voucher['max_discount'];
                            }
                          } else {
                            $currentDiscount = min($voucher['discount_value'], $voucherSubtotal);
                          }

                          $meetsMinimum = ($subtotal >= $voucher['min_purchase']);
                          
                          if ($meetsMinimum && $voucherSubtotal > 0) {
                            $voucherDiscount += $currentDiscount;
                          }
                        }
                      }

                      // Calculate shipping fee
                      $shippingFee = 50;
                      $grandTotalBeforeShipping = $subtotal - $voucherDiscount;
                      if ($grandTotalBeforeShipping < 0) {
                        $grandTotalBeforeShipping = 0;
                      }

                      if ($grandTotalBeforeShipping >= 500) {
                        $shippingFee = 0;
                      }

                      $grandTotal = $grandTotalBeforeShipping + $shippingFee;
                      if ($grandTotal < 0) $grandTotal = 0;
                  ?>
                      <!-- Order Group Card -->
                      <div class="card order-group-card">
                        <div class="card-header">
                          <div class="d-flex justify-content-between align-items-center" style="color: white;">
                            <h5 class="mb-0">
                              <i class="fas fa-calendar"></i> <?php echo $dateFormatted; ?> - <?php echo htmlspecialchars($customerName); ?>
                            </h5>
                            <span class="badge bg-primary">Order Group #<?php echo substr(md5($groupKey), 0, 8); ?></span>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped table-sm order-table">
                              <thead>
                                <tr>
                                  <th>Order ID</th>
                                  <th>Status</th>
                                  <th>Product</th>
                                  <th>Orig. Price</th>
                                  <th>Disc%</th>
                                  <th>Final Price</th>
                                  <th>Qty</th>
                                  <th>Subtotal</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($items as $data) {
                                  $origprice = $data['prod_price'] + 100;
                                  
                                  $item_has_discount = false;
                                  $item_discount_amount = 0;
                                  $item_discount_percentage = 0;
                                  
                                  if (isset($vouchersByDateAccount[$groupKey])) {
                                    foreach ($vouchersByDateAccount[$groupKey] as $voucher) {
                                      $targetItems = json_decode($voucher['target_items'], true);
                                      $is_eligible = false;
                                      
                                      $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null);
                                      
                                      if ($applyToAll) {
                                        $is_eligible = true;
                                      } else if (is_array($targetItems)) {
                                        foreach ($targetItems as $item) {
                                          if (isset($item['type']) && $item['type'] == 'product' && isset($item['id']) && $item['id'] == $data['prod_id']) {
                                            $is_eligible = true;
                                            break;
                                          }
                                        }
                                      }
                                      
                                      if ($is_eligible) {
                                        if ($voucher['discount_type'] == 'percentage') {
                                          $discount = ($origprice * $voucher['discount_value']) / 100;
                                          if ($voucher['max_discount'] > 0 && $discount > $voucher['max_discount']) {
                                            $discount = $voucher['max_discount'];
                                          }
                                          $item_discount_amount += $discount;
                                        } else {
                                          $discount = min($voucher['discount_value'], $origprice);
                                          $item_discount_amount += $discount;
                                        }
                                        $item_has_discount = true;
                                      }
                                    }
                                    
                                    if ($item_has_discount && $item_discount_amount > 0) {
                                      $item_discount_percentage = round(($item_discount_amount / $origprice) * 100, 2);
                                    }
                                  }
                                  
                                  $prodprice = max(0, $origprice - $item_discount_amount);
                                  $itemSubtotal = $data["prod_qnty"] * $prodprice;
                                  
                                  $status_info = $status_names[$data['status_id']] ?? ['name' => 'Unknown', 'class' => 'status-pending'];
                                ?>
                                  <tr>
                                    <td><?php echo htmlspecialchars($data['item_id']); ?></td>
                                    <td>
                                      <span class="status-badge <?php echo $status_info['class']; ?>">
                                        <?php echo $status_info['name']; ?>
                                      </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($data['prod_name']); ?></td>
                                    <td>₱<?php echo number_format($origprice, 2); ?></td>
                                    <td>
                                      <?php if ($item_has_discount && $item_discount_percentage > 0) { ?>
                                        <?php echo number_format($item_discount_percentage, 2); ?>%
                                      <?php } else { ?>
                                        0%
                                      <?php } ?>
                                    </td>
                                    <td>
                                      ₱<?php echo number_format($prodprice, 2); ?>
                                      <?php if ($item_has_discount && $item_discount_amount > 0) { ?>
                                        <div style="font-size: 0.7rem; color: #dc3545;">
                                          <s>₱<?php echo number_format($origprice, 2); ?></s>
                                        </div>
                                      <?php } ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($data['prod_qnty']); ?></td>
                                    <td>₱<?php echo number_format($itemSubtotal, 2); ?></td>
                                    <td>
                                      <div class="action-buttons">
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
                                      </div>
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
                                            <label class="col-form-label fw-bold">Original Price</label>
                                            <input type="text" class="form-control" value="₱<?php echo number_format($origprice, 2); ?>" disabled>
                                          </div>
                                          <div class="mb-3">
                                            <label class="col-form-label fw-bold">Discount</label>
                                            <input type="text" class="form-control" 
                                              value="<?php echo $item_has_discount ? '₱' . number_format($item_discount_amount, 2) . ' (' . number_format($item_discount_percentage, 2) . '%)' : 'None'; ?>" 
                                              disabled>
                                          </div>
                                          <div class="mb-3">
                                            <label class="col-form-label fw-bold">Discounted Price</label>
                                            <input type="text" class="form-control" value="₱<?php echo number_format($prodprice, 2); ?>" disabled>
                                          </div>
                                          <div class="mb-3">
                                            <label class="col-form-label fw-bold">Quantity</label>
                                            <input type="text" class="form-control" value="<?php echo $data['prod_qnty']; ?>" disabled>
                                          </div>
                                          <div class="mb-3">
                                            <label class="col-form-label fw-bold">Item Total</label>
                                            <input type="text" class="form-control" value="₱<?php echo number_format($itemSubtotal, 2); ?>" disabled>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>

                                <?php if (isset($vouchersByDateAccount[$groupKey]) && count($vouchersByDateAccount[$groupKey]) > 0) { ?>
                                  <tr class="voucher-header-row">
                                    <td colspan="9" style="padding: 15px 12px; border-bottom: 2px solid #339af0;">
                                      <strong style="color: #1864ab; font-size: 14px;">
                                        <i class="fas fa-ticket"></i> Applied Vouchers
                                      </strong>
                                    </td>
                                  </tr>
                                  <?php foreach ($vouchersByDateAccount[$groupKey] as $voucher) {
                                    $targetItems = json_decode($voucher['target_items'], true);
                                    $eligibleProductIds = [];
                                    
                                    $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null || count($targetItems) == 0);
                                    
                                    if ($applyToAll) {
                                      foreach ($items as $item) {
                                        $eligibleProductIds[] = $item['prod_id'];
                                      }
                                    } else {
                                      if ($targetItems && is_array($targetItems)) {
                                        foreach ($targetItems as $item) {
                                          if (isset($item['type']) && $item['type'] == 'product' && isset($item['id'])) {
                                            $eligibleProductIds[] = intval($item['id']);
                                          }
                                        }
                                      }
                                    }
                                    
                                    $voucherSubtotal = 0;
                                    foreach ($items as $item) {
                                      if (in_array($item['prod_id'], $eligibleProductIds)) {
                                        $origprice = $item['prod_price'] + 100;
                                        $voucherSubtotal += round($item["prod_qnty"] * $origprice, 2);
                                      }
                                    }
                                    
                                    $currentDiscount = 0;
                                    if ($voucher['discount_type'] == 'percentage') {
                                      $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                      if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                        $currentDiscount = $voucher['max_discount'];
                                      }
                                    } else {
                                      $currentDiscount = min($voucher['discount_value'], $voucherSubtotal);
                                    }
                                    
                                    $meetsMinimum = ($subtotal >= $voucher['min_purchase']);
                                    $displayDiscount = 0;
                                    if ($meetsMinimum && $voucherSubtotal > 0) {
                                      $displayDiscount = $currentDiscount;
                                    }
                                    
                                    $voucher_status_info = $status_names[$voucher['status_id']] ?? ['name' => 'Unknown', 'class' => 'status-pending'];
                                  ?>
                                    <tr class="voucher-row">
                                      <td class="voucher-icon">
                                        <i class="fas fa-ticket-simple" style="color: #339af0; font-size: 18px;"></i>
                                      </td>
                                      <td>
                                        <span class="status-badge <?php echo $voucher_status_info['class']; ?>">
                                          <?php echo $voucher_status_info['name']; ?>
                                        </span>
                                      </td>
                                      <td>
                                        <strong style="color: #2c3e50; font-size: 12px;"><?php echo htmlspecialchars($voucher['voucher_name']); ?></strong>
                                        <div class="voucher-code">
                                          <?php echo htmlspecialchars($voucher['voucher_code']); ?>
                                        </div>
                                      </td>
                                      <td style="font-size: 11px;">
                                        <?php if ($voucher['discount_type'] == 'percentage') { ?>
                                          <strong><?php echo intval($voucher['discount_value']); ?>%</strong>
                                          <?php if ($voucher['max_discount'] > 0) { ?>
                                            <div style="font-size: 10px; color: #6c757d;">(Max: ₱<?php echo number_format($voucher['max_discount'], 2); ?>)</div>
                                          <?php } ?>
                                        <?php } else { ?>
                                          <strong>₱<?php echo number_format($voucher['discount_value'], 2); ?></strong>
                                        <?php } ?>
                                        <?php if ($voucher['min_purchase'] > 0) { ?>
                                          <div style="font-size: 10px; color: #6c757d;">Min: ₱<?php echo number_format($voucher['min_purchase'], 2); ?></div>
                                        <?php } ?>
                                      </td>
                                      <td>-</td>
                                      <td>-</td>
                                      <td style="text-align: center;">1</td>
                                      <td style="color: #f03e3e; font-weight: 600; font-size: 12px;">
                                        <?php if ($displayDiscount > 0) { ?>
                                          -₱<?php echo number_format($displayDiscount, 2); ?>
                                        <?php } else { ?>
                                          ₱0.00
                                          <?php if (!$meetsMinimum && $voucher['min_purchase'] > 0) { ?>
                                            <div style="font-size: 10px; color: #856404;">
                                              <i class="fa-solid fa-exclamation-triangle"></i> Min not met
                                            </div>
                                          <?php } elseif ($voucherSubtotal == 0) { ?>
                                            <div style="font-size: 10px; color: #856404;">
                                              <i class="fa-solid fa-exclamation-triangle"></i> No eligible
                                            </div>
                                          <?php } ?>
                                        <?php } ?>
                                      </td>
                                      <td>-</td>
                                    </tr>
                                  <?php } ?>
                                <?php } ?>

                                <!-- Summary rows -->
                                <tr>
                                  <td colspan="9" class="summary-divider"></td>
                                </tr>
                                <tr>
                                  <td colspan="7"></td>
                                  <td class="text-end"><strong>Subtotal:</strong></td>
                                  <td><strong>₱<?php echo number_format($subtotal, 2); ?></strong></td>
                                </tr>
                                <?php if ($voucherDiscount > 0) { ?>
                                <tr>
                                  <td colspan="7"></td>
                                  <td class="text-end"><strong>Voucher Discount:</strong></td>
                                  <td style="color: #f03e3e;"><strong>-₱<?php echo number_format($voucherDiscount, 2); ?></strong></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <td colspan="7"></td>
                                  <td class="text-end"><strong>Shipping Fee:</strong></td>
                                  <td>
                                    <?php if ($shippingFee == 0) { ?>
                                      <span style="text-decoration: line-through; color: #6c757d;">₱50</span> <span style="color: #28a745; font-weight: 600;">Free</span>
                                    <?php } else { ?>
                                      ₱<?php echo number_format($shippingFee, 2); ?>
                                    <?php } ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="7"></td>
                                  <td class="text-end"><strong style="font-size: 16px;">Grand Total:</strong></td>
                                  <td><strong style="font-size: 16px;">₱<?php echo number_format($grandTotal, 2); ?></strong></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
                    
                    // Pagination controls
                    if ($total_pages > 1) {
                  ?>
                      <div class="pagination-container">
                        <div class="showing-text">
                          Showing <?php echo $showing_from; ?> to <?php echo $showing_to; ?> of <?php echo $total_groups; ?> order groups
                        </div>
                        <ul class="pagination">
                          <?php if ($current_page > 1): ?>
                            <li>
                              <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page - 1])); ?>">
                                <i class="fas fa-chevron-left"></i> Previous
                              </a>
                            </li>
                          <?php else: ?>
                            <li class="disabled">
                              <a href="#"><i class="fas fa-chevron-left"></i> Previous</a>
                            </li>
                          <?php endif; ?>

                          <?php
                          $start_page = max(1, $current_page - 2);
                          $end_page = min($total_pages, $current_page + 2);
                          
                          if ($start_page > 1) {
                            echo '<li><a href="?' . http_build_query(array_merge($_GET, ['page' => 1])) . '">1</a></li>';
                            if ($start_page > 2) {
                              echo '<li class="disabled"><a href="#">...</a></li>';
                            }
                          }
                          
                          for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <li <?php echo ($i == $current_page) ? 'class="active"' : ''; ?>>
                              <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                                <?php echo $i; ?>
                              </a>
                            </li>
                          <?php endfor; ?>
                          
                          <?php
                          if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1) {
                              echo '<li class="disabled"><a href="#">...</a></li>';
                            }
                            echo '<li><a href="?' . http_build_query(array_merge($_GET, ['page' => $total_pages])) . '">' . $total_pages . '</a></li>';
                          }
                          ?>

                          <?php if ($current_page < $total_pages): ?>
                            <li>
                              <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page + 1])); ?>">
                                Next <i class="fas fa-chevron-right"></i>
                              </a>
                            </li>
                          <?php else: ?>
                            <li class="disabled">
                              <a href="#">Next <i class="fas fa-chevron-right"></i></a>
                            </li>
                          <?php endif; ?>
                        </ul>
                      </div>
                  <?php
                    }
                  } else {
                  ?>
                    <div class="no-orders-container">
                      <i class="fa-solid fa-box-open" style="font-size: 64px; color: #dee2e6;"></i>
                      <p class="mt-3" style="font-size: 18px; color: #6c757d;">No orders found</p>
                    </div>
                  <?php } ?>
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