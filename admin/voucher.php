<?php
session_start();
if (empty($_SESSION["admin_id"])) {
  header('Location:logout.php');
}
require_once("../backend/config/config.php");

// Get top selling products
$top_products_query = "SELECT p.prod_id, p.prod_name, p.prod_price, 
                       SUM(c.prod_qnty) as total_sold,
                       SUM(p.prod_price * c.prod_qnty) as total_revenue
                       FROM tbl_cart c
                       INNER JOIN tbl_products p ON c.prod_id = p.prod_id
                       WHERE c.status_id = 2
                       GROUP BY p.prod_id
                       ORDER BY total_sold DESC
                       LIMIT 10";
$top_products = $conn->query($top_products_query);

// Get low selling products
$low_products_query = "SELECT p.prod_id, p.prod_name, p.prod_price,
                       COALESCE(SUM(c.prod_qnty), 0) as total_sold,
                       COALESCE(SUM(p.prod_price * c.prod_qnty), 0) as total_revenue
                       FROM tbl_products p
                       LEFT JOIN tbl_cart c ON p.prod_id = c.prod_id AND c.status_id = 2
                       GROUP BY p.prod_id
                       HAVING total_sold < 5
                       ORDER BY total_sold ASC
                       LIMIT 10";
$low_products = $conn->query($low_products_query);

// Get top selling services
$top_services_query = "SELECT s.service_id, s.service_name, s.service_price,
                       COUNT(a.appointment_id) as total_bookings,
                       SUM(s.service_price) as total_revenue
                       FROM tbl_appointments a
                       INNER JOIN tbl_services s ON a.service_id = s.service_id
                       WHERE a.appointment_status = 'Completed'
                       GROUP BY s.service_id
                       ORDER BY total_bookings DESC
                       LIMIT 10";
$top_services = $conn->query($top_services_query);

// Get low selling services
$low_services_query = "SELECT s.service_id, s.service_name, s.service_price,
                       COALESCE(COUNT(a.appointment_id), 0) as total_bookings,
                       COALESCE(SUM(s.service_price), 0) as total_revenue
                       FROM tbl_services s
                       LEFT JOIN tbl_appointments a ON s.service_id = a.service_id AND a.appointment_status = 'Completed'
                       GROUP BY s.service_id
                       HAVING total_bookings < 3
                       ORDER BY total_bookings ASC
                       LIMIT 10";
$low_services = $conn->query($low_services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Voucher & Promo Management</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../styles/dataTables.min.css">
  <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/bootsrap5-min.css">
  <link rel="stylesheet" href="../styles/card-general.css">
  <style>
    .analytics-card {
      background: #ffffff;
      border: 1px solid #e8e8e8;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
    }

    .item-badge {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 4px;
      font-size: 0.875rem;
      margin: 4px;
      cursor: pointer;
      transition: all 0.2s;
      border: 1px solid #d0d0d0;
    }

    .item-badge:hover {
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .badge-top {
      background: #f0f9f0;
      color: #2d5016;
      border-color: #c8e6c9;
    }

    .badge-low {
      background: #fafafa;
      color: #555555;
      border-color: #e0e0e0;
    }

    .badge-selected {
      border: 2px solid #5a8c3a;
      background: #e8f5e9;
      box-shadow: 0 0 0 2px rgba(90, 140, 58, 0.15);
    }

    .promo-card {
      border: 1px solid #e8e8e8;
      border-radius: 6px;
      padding: 15px;
      margin-bottom: 15px;
      background: #ffffff;
      transition: all 0.2s;
    }

    .promo-card:hover {
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .promo-active {
      border-left: 4px solid #5a8c3a;
      background: #f9fdf9;
    }

    .promo-inactive {
      border-left: 4px solid #999999;
      background: #f8f8f8;
    }

    .promo-upcoming {
      border-left: 4px solid #7a7a7a;
      background: #fafafa;
    }

    .section-title {
      font-size: 1.05rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: #2d2d2d;
    }

    .suggestion-box {
      background: #f5f9f5;
      border: 1px solid #d4e7d4;
      color: #2d5016;
      padding: 18px;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    .suggestion-box h5 {
      color: #2d5016;
      font-weight: 600;
      margin-bottom: 12px;
    }

    .btn-primary {
      background-color: rgb(59, 156, 157);
      border-color: rgb(59, 156, 157);
      color: white;
    }

    .btn-primary:hover {
      background-color: rgba(47, 131, 132, 1);
      border-color: rgb(47, 131, 132);
    }

    .btn-success {
      background-color: rgb(59, 156, 157);
      border-color: rgb(59, 156, 157);
      color: white;
    }

    .btn-success:hover {
      background-color: rgb(47, 131, 132);
      border-color: rgb(47, 131, 132);
    }

    .modal-header {
      background-color: #f9fdf9;
      border-bottom: 1px solid #e0e0e0;
    }

    .modal-lg {
      max-width: 900px;
    }

    .text-muted {
      color: #757575 !important;
    }

    #selectedItemsDisplay {
      background-color: #fafafa;
      min-height: 60px;
    }

    .badge.bg-primary {
      background-color: #5a8c3a !important;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <?php require_once("./navbar.php"); ?>
  <div id="layoutSidenav">
    <?php require_once("./sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4"><i class="fas fa-ticket"></i> Voucher & Promo Management</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Vouchers</li>
          </ol>

          <!-- AI Suggestions -->
          <div class="row">
            <div class="col-12">
              <div class="suggestion-box">
                <h5><i class="fas fa-lightbulb"></i> Smart Promo Suggestions</h5>
                <p class="mb-2">Based on sales data, we recommend creating promos for:</p>
                <div class="row">
                  <div class="col-md-6">
                    <strong><i class="fas fa-arrow-trend-up"></i> Boost Low Performers:</strong> Create discounts for low-selling items to increase visibility
                  </div>
                  <div class="col-md-6">
                    <strong><i class="fas fa-layer-group"></i> Bundle Top Sellers:</strong> Combine popular items with slower ones for attractive packages
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Create Voucher Button -->
          <div class="row mb-3">
            <div class="col-12">
              <button class="btn btn-primary btn-lg" onclick="openCreateModal()">
                <i class="fas fa-plus"></i> Create New Voucher
              </button>
              <button class="btn btn-success btn-lg" onclick="generateSmartPromo()">
                <i class="fas fa-wand-magic-sparkles"></i> Generate Smart Promo
              </button>
            </div>
          </div>

          <!-- Sales Analytics -->
          <div class="row">
            <!-- Top Selling Products -->
            <div class="col-lg-6">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-chart-line"></i> Top Selling Products</h5>
                <div id="topProductsList">
                  <?php while($product = $top_products->fetch_assoc()): ?>
                    <span class="item-badge badge-top" 
                          data-type="product" 
                          data-id="<?php echo $product['prod_id']; ?>"
                          data-name="<?php echo htmlspecialchars($product['prod_name']); ?>"
                          data-price="<?php echo $product['prod_price']; ?>">
                      <i class="fas fa-box"></i> <?php echo htmlspecialchars($product['prod_name']); ?> 
                      (<?php echo $product['total_sold']; ?> sold)
                    </span>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>

            <!-- Low Selling Products -->
            <div class="col-lg-6">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-chart-line-down"></i> Low Selling Products</h5>
                <div id="lowProductsList">
                  <?php while($product = $low_products->fetch_assoc()): ?>
                    <span class="item-badge badge-low" 
                          data-type="product" 
                          data-id="<?php echo $product['prod_id']; ?>"
                          data-name="<?php echo htmlspecialchars($product['prod_name']); ?>"
                          data-price="<?php echo $product['prod_price']; ?>">
                      <i class="fas fa-box-open"></i> <?php echo htmlspecialchars($product['prod_name']); ?> 
                      (<?php echo $product['total_sold']; ?> sold)
                    </span>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>

            <!-- Top Selling Services -->
            <div class="col-lg-6">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-star"></i> Top Selling Services</h5>
                <div id="topServicesList">
                  <?php while($service = $top_services->fetch_assoc()): ?>
                    <span class="item-badge badge-top" 
                          data-type="service" 
                          data-id="<?php echo $service['service_id']; ?>"
                          data-name="<?php echo htmlspecialchars($service['service_name']); ?>"
                          data-price="<?php echo $service['service_price']; ?>">
                      <i class="fas fa-hands-holding"></i> <?php echo htmlspecialchars($service['service_name']); ?> 
                      (<?php echo $service['total_bookings']; ?> bookings)
                    </span>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>

            <!-- Low Selling Services -->
            <div class="col-lg-6">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-circle-info"></i> Low Selling Services</h5>
                <div id="lowServicesList">
                  <?php while($service = $low_services->fetch_assoc()): ?>
                    <span class="item-badge badge-low" 
                          data-type="service" 
                          data-id="<?php echo $service['service_id']; ?>"
                          data-name="<?php echo htmlspecialchars($service['service_name']); ?>"
                          data-price="<?php echo $service['service_price']; ?>">
                      <i class="fas fa-hand-holding-heart"></i> <?php echo htmlspecialchars($service['service_name']); ?> 
                      (<?php echo $service['total_bookings']; ?> bookings)
                    </span>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Active Vouchers List -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-list"></i> All Vouchers</h5>
                <div class="table-responsive">
                  <div id="vouchersList">
                    <!-- Will be loaded via AJAX -->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Voucher Usage Statistics -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-chart-bar"></i> Voucher Usage Statistics</h5>
                <div class="table-responsive" id="voucherUsageStats">
                  <!-- Will be loaded via AJAX -->
                </div>
              </div>
            </div>
          </div>

        </div>
      </main>
    </div>
  </div>

  <!-- Create/Edit Voucher Modal -->
  <div class="modal fade" id="voucherModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Create New Voucher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="voucherForm">
            <input type="hidden" id="voucherId" name="voucher_id">
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Voucher Name *</label>
                <input type="text" class="form-control" id="voucherName" name="voucher_name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Voucher Code *</label>
                <input type="text" class="form-control" id="voucherCode" name="voucher_code" required 
                       placeholder="e.g., SUMMER2025">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Applies To *</label>
                <select class="form-select" id="voucherType" name="voucher_type" required>
                  <option value="both">Products & Services</option>
                  <option value="product">Products Only</option>
                  <option value="service">Services Only</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Discount Type *</label>
                <select class="form-select" id="discountType" name="discount_type" required>
                  <option value="percentage">Percentage (%)</option>
                  <option value="fixed">Fixed Amount (₱)</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Discount Value *</label>
                <input type="number" class="form-control" id="discountValue" name="discount_value" 
                       required step="0.01" min="0">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Minimum Purchase</label>
                <input type="number" class="form-control" id="minPurchase" name="min_purchase" 
                       step="0.01" value="0">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Maximum Discount</label>
                <input type="number" class="form-control" id="maxDiscount" name="max_discount" 
                       step="0.01" placeholder="Optional">
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Start Date *</label>
                <input type="date" class="form-control" id="startDate" name="start_date" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">End Date *</label>
                <input type="date" class="form-control" id="endDate" name="end_date" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Usage Limit</label>
                <input type="number" class="form-control" id="usageLimit" name="usage_limit" 
                       placeholder="Unlimited">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Promo Category</label>
                <select class="form-select" id="promoCategory" name="promo_category">
                  <option value="">Select Category</option>
                  <option value="Anniversary">Anniversary</option>
                  <option value="Holiday">Holiday</option>
                  <option value="Flash Sale">Flash Sale</option>
                  <option value="Seasonal">Seasonal</option>
                  <option value="Birthday">Birthday</option>
                  <option value="Special">Special Promo</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Auto-Apply on Site</label>
                <div class="form-check form-switch mt-2">
                  <input class="form-check-input" type="checkbox" id="autoApply" name="auto_apply">
                  <label class="form-check-label" for="autoApply">
                    Show on homepage/booking page
                  </label>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Target Items (Optional)</label>
              <p class="text-muted small">Click on items above to select specific products/services for this voucher. Leave empty to apply to all items.</p>
              <div id="selectedItemsDisplay" class="border rounded p-2" style="min-height: 50px;">
                <span class="text-muted">No items selected - applies to all</span>
              </div>
              <input type="hidden" id="targetItems" name="target_items">
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="saveVoucher()">Save Voucher</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../scripts/bootstrap.bundle.min.js"></script>
  <script src="../scripts/toggle.js"></script>
  <script>
    let selectedItems = [];
    let voucherModal;

    $(document).ready(function() {
      voucherModal = new bootstrap.Modal(document.getElementById('voucherModal'));
      loadVouchers();
      loadVoucherUsageStats();
      
      // Item selection handler
      $('.item-badge').on('click', function() {
        const itemData = {
          type: $(this).data('type'),
          id: $(this).data('id'),
          name: $(this).data('name'),
          price: $(this).data('price')
        };
        
        const existingIndex = selectedItems.findIndex(
          item => item.type === itemData.type && item.id === itemData.id
        );
        
        if (existingIndex > -1) {
          selectedItems.splice(existingIndex, 1);
          $(this).removeClass('badge-selected');
        } else {
          selectedItems.push(itemData);
          $(this).addClass('badge-selected');
        }
        
        updateSelectedItemsDisplay();
      });
    });

    function openCreateModal() {
      $('#voucherForm')[0].reset();
      $('#voucherId').val('');
      $('#modalTitle').text('Create New Voucher');
      // Don't clear selectedItems - keep the user's selections
      updateSelectedItemsDisplay();
      voucherModal.show();
    }

    function updateSelectedItemsDisplay() {
      const display = $('#selectedItemsDisplay');
      const input = $('#targetItems');
      
      if (selectedItems.length === 0) {
        display.html('<span class="text-muted">No items selected - applies to all</span>');
        input.val('');
      } else {
        const html = selectedItems.map(item => 
          `<span class="badge bg-primary me-2 mb-2">
            <i class="fas fa-${item.type === 'product' ? 'box' : 'hands-holding'}"></i> ${item.name}
          </span>`
        ).join('');
        display.html(html);
        input.val(JSON.stringify(selectedItems));
      }
    }

    function saveVoucher() {
      const formData = new FormData($('#voucherForm')[0]);

      Swal.fire({
        title: "Are you sure?",
        text: "Please confirm to save the voucher.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#5a8c3a",
        cancelButtonColor: "#999999",
        confirmButtonText: "Yes, save it!"
      }).then((result)=>{
        if (result.isConfirmed) {
          $.ajax({
            url: 'ajax/save_voucher.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: response.message
                });
                voucherModal.hide();
                loadVouchers();
                loadVoucherUsageStats(); // Add this line
                selectedItems = [];
                $('.item-badge').removeClass('badge-selected');
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: response.message
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to save voucher'
              });
            }
          });
        }
      });
    }

    function loadVouchers() {
      $.ajax({
        url: 'ajax/get_vouchers.php',
        method: 'GET',
        success: function(response) {
          $('#vouchersList').html(response);
        }
      });
    }

    function editVoucher(id) {
        

      $.ajax({
        url: 'ajax/get_voucher_details.php',
        method: 'POST',
        data: { voucher_id: id },
        dataType: 'json',
        success: function(data) {
          $('#voucherId').val(data.voucher_id);
          $('#voucherName').val(data.voucher_name);
          $('#voucherCode').val(data.voucher_code);
          $('#voucherType').val(data.voucher_type);
          $('#discountType').val(data.discount_type);
          $('#discountValue').val(data.discount_value);
          $('#minPurchase').val(data.min_purchase);
          $('#maxDiscount').val(data.max_discount);
          $('#startDate').val(data.start_date);
          $('#endDate').val(data.end_date);
          $('#usageLimit').val(data.usage_limit);
          $('#promoCategory').val(data.promo_category);
          $('#autoApply').prop('checked', data.auto_apply == 1);
          
          if (data.target_items) {
            selectedItems = JSON.parse(data.target_items);
            $('.item-badge').each(function() {
              const type = $(this).data('type');
              const id = $(this).data('id');
              if (selectedItems.find(item => item.type === type && item.id === id)) {
                $(this).addClass('badge-selected');
              }
            });
            updateSelectedItemsDisplay();
          }
          
          $('#modalTitle').text('Edit Voucher');
          voucherModal.show();
        }
      });
    }

    function deleteVoucher(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5a8c3a',
        cancelButtonColor: '#999999',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'ajax/delete_voucher.php',
            method: 'POST',
            data: { voucher_id: id },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                Swal.fire('Deleted!', response.message, 'success');
                loadVouchers();
                loadVoucherUsageStats(); // Add this line
              } else {
                Swal.fire('Error!', response.message, 'error');
              }
            }
          });
        }
      });
    }

    function toggleVoucher(id, currentStatus) {
        Swal.fire({
          title: 'Are you sure?',
          text: "This will change the voucher's active status.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#5a8c3a',
          cancelButtonColor: '#999999',
          confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
          if (result.isConfirmed) {
            proceedToggle(id, currentStatus);
          }
        });
    }

    function proceedToggle(id, currentStatus) {
      $.ajax({
        url: 'ajax/toggle_voucher.php',
        method: 'POST',
        data: { voucher_id: id, current_status: currentStatus },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            loadVouchers();
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message,
              timer: 1500,
              showConfirmButton: false
            });
          }
        }
      });
    }

    function generateSmartPromo() {
      Swal.fire({
        title: 'Generate Smart Promo',
        html: `
          <select id="smartPromoType" class="form-select mb-3">
            <option value="low_boost">Boost Low Performers (20-30% off)</option>
            <option value="bundle">Bundle Deal (Buy Top, Get Low)</option>
            <option value="flash">Flash Sale (Limited Time)</option>
          </select>
          <input type="date" id="smartStartDate" class="form-control mb-2" value="${new Date().toISOString().split('T')[0]}">
          <input type="date" id="smartEndDate" class="form-control" value="${new Date(Date.now() + 7*24*60*60*1000).toISOString().split('T')[0]}">
        `,
        showCancelButton: true,
        confirmButtonText: 'Generate',
        confirmButtonColor: '#5a8c3a',
        cancelButtonColor: '#999999',
        preConfirm: () => {
          return {
            type: $('#smartPromoType').val(),
            startDate: $('#smartStartDate').val(),
            endDate: $('#smartEndDate').val()
          };
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'ajax/generate_smart_promo.php',
            method: 'POST',
            data: result.value,
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                Swal.fire('Success!', response.message, 'success');
                loadVouchers();
              } else {
                Swal.fire('Error!', response.message, 'error');
              }
            }
          });
        }
      });
    }

    function loadVoucherUsageStats() {
      $.ajax({
        url: 'ajax/get_voucher_usage_stats.php',
        method: 'GET',
        success: function(response) {
          $('#voucherUsageStats').html(response);
        },
        error: function() {
          $('#voucherUsageStats').html('<div class="alert alert-danger">Failed to load usage statistics</div>');
        }
      });
    }

    function viewUsageDetails(voucherId) {
      $.ajax({
        url: 'ajax/get_voucher_usage_details.php',
        method: 'POST',
        data: { voucher_id: voucherId },
        dataType: 'json',
        success: function(response) {
          const voucher = response.voucher;
          const usage = response.usage;
          
          let usageHtml = '<table class="table table-sm table-striped">';
          usageHtml += '<thead><tr><th>Date</th><th>Customer</th><th>Order Type</th><th>Original Amount</th><th>Discount</th><th>Final Amount</th></tr></thead><tbody>';
          
          if (usage.length > 0) {
            usage.forEach(u => {
              usageHtml += `<tr>
                <td>${new Date(u.used_date).toLocaleDateString()}</td>
                <td>${u.customer_name}<br><small>${u.ac_email}</small></td>
                <td><span class="badge bg-${u.order_type === 'product' ? 'primary' : 'info'}">${u.order_type}</span></td>
                <td>₱${parseFloat(u.original_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                <td class="text-danger">-₱${parseFloat(u.discount_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                <td class="text-success">₱${parseFloat(u.final_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
              </tr>`;
            });
          } else {
            usageHtml += '<tr><td colspan="6" class="text-center text-muted">No usage history yet</td></tr>';
          }
          
          usageHtml += '</tbody></table>';
          
          Swal.fire({
            title: `<strong>${voucher.voucher_name}</strong>`,
            html: `
              <div class="text-start">
                <p><strong>Code:</strong> <code>${voucher.voucher_code}</code></p>
                <p><strong>Total Uses:</strong> ${usage.length}</p>
                <p><strong>Total Discount Given:</strong> <span class="text-danger">₱${parseFloat(voucher.total_discount_given).toLocaleString('en-PH', {minimumFractionDigits: 2})}</span></p>
                <p><strong>Total Revenue Generated:</strong> <span class="text-success">₱${parseFloat(voucher.total_revenue_generated).toLocaleString('en-PH', {minimumFractionDigits: 2})}</span></p>
                <hr>
                <h6>Usage History:</h6>
                ${usageHtml}
              </div>
            `,
            width: '800px',
            confirmButtonColor: '#5a8c3a',
            confirmButtonText: 'Close'
          });
        },
        error: function() {
          Swal.fire('Error', 'Failed to load usage details', 'error');
        }
      });
    }
  </script>

  <script src="../jquery/sideBarProd.js"></script> 
</body>
</html>