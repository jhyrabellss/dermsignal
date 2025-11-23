<?php
session_start();
if(empty($_SESSION["derm_id"])){
  header('Location:../index.php');
  exit();
}
require_once("../backend/config/config.php");
require_once("./derm-select.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dermatologist Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/bootsrap5-min.css">
    <link rel="stylesheet" href="../styles/card-general.css">

    <style>
      .filter-btn {
        transition: all 0.3s;
      }
      
      .filter-btn.active {
        background-color: rgb(28, 127, 114, 1) !important;
        color: white !important;
        border-color: rgba(28, 127, 114, 1) !important;
      }
      
      .filter-btn:hover {
        background-color: rgba(39,153,137, 0.8) !important;
        color: white !important;
      }
      
      .table-hover tbody tr:hover {
        background-color: rgba(39, 153, 137, 0.1);
      }
      
      .badge {
        padding: 0.5em 0.8em;
        font-size: 0.85em;
      }
      
      .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
      }
      
      #appointmentsTableBody tr {
        animation: fadeIn 0.5s;
      }
      
      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }

      .btn-group{
        gap: 5px;
      }

      .btn-group button{
        border-radius: 5px;
        color: rgba(55, 55, 55, 1);
      }
      

      .payment-modal .modal-content {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  }

  .payment-modal .modal-header {
    background: linear-gradient(135deg, rgb(39,153,137) 0%, rgb(28,127,114) 100%);
    border: none;
    padding: 1.5rem 2rem;
  }

  .payment-modal .modal-title {
    font-weight: 600;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .payment-modal .modal-body {
    padding: 2rem;
    background-color: #f8f9fa;
  }

  .info-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s;
  }

  .info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .info-card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: rgb(28,127,114);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
  }

  .info-row:last-child {
    border-bottom: none;
  }

  .info-label {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
  }

  .info-value {
    color: #212529;
    font-weight: 600;
    text-align: right;
  }

  .amount-highlight {
    font-size: 1.5rem;
    color: rgb(39,153,137);
  }

  .payment-proof-container {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    text-align: center;
  }

  .payment-proof-container img {
    border-radius: 8px;
    max-height: 350px;
    width: auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .action-buttons {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
  }

  .action-buttons .btn {
    flex: 1;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
  }

  .btn-verify {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
  }

  .btn-verify:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
  }

  .btn-reject {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    color: white;
  }

  .btn-reject:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
  }

  .modal-footer {
    background-color: white;
    border-top: 1px solid #e9ecef;
    padding: 1rem 2rem;
  }

  .badge-custom {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
  }

  .badge-verified {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .badge-pending {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
  }

  .badge-rejected {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
  }

  .badge-confirmed {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
  }

  .badge-completed {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
  }

  .badge-cancelled {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
  }

  .empty-state {
    text-align: center;
    padding: 2rem;
    color: #9ca3af;
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
  }

  .btn-verify{
    background-color: rgb(16,185,129);
    border: none;
    color: white;
    font-weight: 600;
  }

  .btn-verify:hover{
    background-color: rgb(5,150,105);
    color: white;
  }

  .btn-reject{
    background-color: rgb(239,68,68);
    border: none;
    color: white;
    font-weight: 600;
  }

  .btn-reject:hover{
    background-color: rgb(220,38,38);
    color: white;
  }

  @media (max-width: 576px) {
  .filter-btn {
    font-size: 0.75rem;
    padding: 0.375rem 0.5rem;
  }
  
  .btn-group {
    width: 100%;
  }
  
  .btn-group .btn {
    flex: 1;
  }
}

@media (max-width: 768px) {
  .btn-group {
    gap: 0.25rem;
  }
}

    </style>
  </head>
  <body class="sb-nav-fixed">
    <?php require_once("./derm-navbar.php"); ?>
    <div id="layoutSidenav">
      <?php require_once("./derm-sidebar.php"); ?>
      <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
              <h1 class="mt-4"><?= $data["derm_name"] ?></h1>
              <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>

              <div class="row">
                <!-- Statistics Cards -->
                <div class="c-dashboardInfo-pending col-xl-3 col-md-6">
                  <div class="wrap">
                    <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    <?php
                      $query1 = "SELECT COUNT(*) AS total FROM tbl_appointments 
                                WHERE derm_id = ? AND appointment_status = 'Pending'";
                      $stmt1 = $conn->prepare($query1);
                      $stmt1->bind_param("i", $derm_id);
                      $stmt1->execute();
                      $result1 = $stmt1->get_result();
                      $data1 = $result1->fetch_assoc();
                    ?>
                      Pending Appointments
                    </h4>
                    <span class='hind-font caption-12 c-dashboardInfo__count'><?= $data1["total"] ?></span>
                  </div>
                </div>

                <div class="c-dashboardInfo-confirmed col-xl-3 col-md-6">
                  <div class="wrap">
                    <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    <?php
                      $query2 = "SELECT COUNT(*) AS total FROM tbl_appointments 
                                WHERE derm_id = ? AND appointment_status = 'Confirmed'";
                      $stmt2 = $conn->prepare($query2);
                      $stmt2->bind_param("i", $derm_id);
                      $stmt2->execute();
                      $result2 = $stmt2->get_result();
                      $data2 = $result2->fetch_assoc();
                    ?>
                      Confirmed Appointments
                    </h4>
                    <span class='hind-font caption-12 c-dashboardInfo__count'><?= $data2["total"] ?></span>
                  </div>
                </div>

                <div class="c-dashboardInfo-completed col-xl-3 col-md-6">
                  <div class="wrap">
                    <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    <?php
                      $query3 = "SELECT COUNT(*) AS total FROM tbl_appointments 
                                WHERE derm_id = ? AND appointment_status = 'Completed'";
                      $stmt3 = $conn->prepare($query3);
                      $stmt3->bind_param("i", $derm_id);
                      $stmt3->execute();
                      $result3 = $stmt3->get_result();
                      $data3 = $result3->fetch_assoc();
                    ?>
                      Completed Appointments
                    </h4>
                    <span class='hind-font caption-12 c-dashboardInfo__count'><?= $data3["total"] ?></span>
                  </div>
                </div>

                <div class="c-dashboardInfo-today col-xl-3 col-md-6">
                  <div class="wrap">
                    <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    <?php
                      $today = date('Y-m-d');
                      $query4 = "SELECT COUNT(*) AS total FROM tbl_appointments 
                                WHERE derm_id = ? AND appointment_date = ? 
                                AND appointment_status IN ('Pending', 'Confirmed')";
                      $stmt4 = $conn->prepare($query4);
                      $stmt4->bind_param("is", $derm_id, $today);
                      $stmt4->execute();
                      $result4 = $stmt4->get_result();
                      $data4 = $result4->fetch_assoc();
                    ?>
                      Today's Appointments
                    </h4>
                    <span class='hind-font caption-12 c-dashboardInfo__count'><?= $data4["total"] ?></span>
                  </div>
                </div>
              </div>

              <!-- Filter Tabs -->
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header bg-primary" style="background-color: rgb(39,153,137) !important;">
                      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <h5 class="text-white mb-0">Appointments</h5>
                        <div class="btn-group flex-wrap" role="group">
                          <button type="button" class="btn btn-info btn-sm filter-btn active" data-filter="today">
                            <i class="fas fa-calendar-day"></i> <span class="d-none d-sm-inline">Today</span>
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="upcoming">
                            <i class="fas fa-calendar-alt"></i> <span class="d-none d-sm-inline">Upcoming</span>
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="completed">
                            <i class="fas fa-check-circle"></i> <span class="d-none d-sm-inline">Completed</span>
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="cancelled">
                            <i class="fas fa-times-circle"></i> <span class="d-none d-sm-inline">Cancelled</span>
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="all">
                            <i class="fas fa-list"></i> <span class="d-none d-sm-inline">All</span>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="appointmentsTable">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Patient Name</th>
                              <th>Service</th>
                              <th>Status</th>
                              <th>Contact</th>
                              <th>Payment Status</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody id="appointmentsTableBody">
                            <!-- Data will be loaded here via AJAX -->
                          </tbody>
                        </table>
                      </div>
                      <div class="text-center mt-3">
                        <button class="btn btn-primary" id="loadMoreBtn" style="background-color: rgb(39,153,137); border: none; display: none;">
                          <i class="fas fa-sync-alt"></i> Load More
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Payment Details Modal -->
<!-- Modal HTML -->
<div class="modal fade payment-modal" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel" style="color: white !important;">
          <i class="fas fa-receipt"></i>
          Payment Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Left Column -->
          <div class="col-lg-6">
            <!-- Payment Information Card -->
            <div class="info-card">
              <div class="info-card-title">
                <i class="fas fa-credit-card"></i>
                Payment Information
              </div>
              
              <div class="info-row">
                <span class="info-label">GCash Reference</span>
                <span class="info-value" id="modal_gcash_ref">-</span>
              </div>
              
              <div class="info-row">
                <span class="info-label">Downpayment Amount</span>
                <span class="info-value amount-highlight" id="modal_amount">₱0.00</span>
              </div>
              
              <div class="info-row">
                <span class="info-label">Payment Status</span>
                <span class="info-value" id="modal_payment_status">-</span>
              </div>
              
              <div class="info-row">
                <span class="info-label">Appointment Status</span>
                <span class="info-value" id="modal_appointment_status">-</span>
              </div>
            </div>

            <!-- Patient Information Card -->
            <div class="info-card">
              <div class="info-card-title">
                <i class="fas fa-user"></i>
                Patient Information
              </div>
              
              <div class="info-row">
                <span class="info-label">Patient Name</span>
                <span class="info-value" id="modal_patient_name">-</span>
              </div>
              
              <div class="info-row">
                <span class="info-label">Service</span>
                <span class="info-value" id="modal_service">-</span>
              </div>
              
              <div class="info-row">
                <span class="info-label">Appointment Date & Time</span>
                <span class="info-value" id="modal_datetime">-</span>
              </div>
              
              <div class="info-row">
                <span class="info-label">Additional Notes</span>
                <span class="info-value" id="modal_notes">-</span>
              </div>
            </div>
          </div>

          <!-- Right Column -->
          <div class="col-lg-6">
            <!-- Payment Proof Card -->
            <div class="payment-proof-container">
              <div class="info-card-title">
                <i class="fas fa-image"></i>
                Payment Proof
              </div>
              <img id="modal_payment_proof" src="" alt="Payment Proof" class="img-fluid">
              
              <!-- Action Buttons -->
              <div id="payment_actions"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 0.5rem 1.5rem;">
          <i class="fas fa-times"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

            </div>
        </main>
      </div>
    </div>


    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <script src="../scripts/jquery.js"></script>
    <script src="../scripts/toggle.js"></script>
    
    <script>
  let currentFilter = 'today';
  let currentOffset = 0;
  const limit = 10;

  $(document).ready(function() {
    // Load initial data
    loadAppointments(currentFilter, 0);

    // Filter button click handler
    $('.filter-btn').click(function() {
      $('.filter-btn').removeClass('active');
      $(this).addClass('active');
      currentFilter = $(this).data('filter');
      currentOffset = 0;
      loadAppointments(currentFilter, 0, true);
    });

    // Load more button click handler
    $('#loadMoreBtn').click(function() {
      currentOffset += limit;
      loadAppointments(currentFilter, currentOffset, false);
    });
  });

  function loadAppointments(filter, offset, replace = true) {
    $.ajax({
      url: '../backend/derm/get_appointments.php',
      type: 'POST',
      data: {
        filter: filter,
        offset: offset,
        limit: limit
      },
      beforeSend: function() {
        if (replace) {
          $('#appointmentsTableBody').html('<tr><td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
        }
      },
      success: function(response) {
        const data = JSON.parse(response);
        
        if (data.status === 'success') {
          if (replace) {
            $('#appointmentsTableBody').html(data.html);
          } else {
            $('#appointmentsTableBody').append(data.html);
          }
          
          // Show/hide load more button
          if (data.has_more) {
            $('#loadMoreBtn').show();
          } else {
            $('#loadMoreBtn').hide();
          }
        } else {
          if (replace) {
            $('#appointmentsTableBody').html('<tr><td colspan="8" class="text-center text-muted">No appointments found</td></tr>');
          }
          $('#loadMoreBtn').hide();
        }
      },
      error: function() {
        $('#appointmentsTableBody').html('<tr><td colspan="8" class="text-center text-danger">Error loading appointments</td></tr>');
        $('#loadMoreBtn').hide();
      }
    });
  }

  function viewPayment(appointmentId) {
    $.ajax({
      url: '../backend/derm/get_payment_details.php',
      type: 'POST',
      data: { appointment_id: appointmentId },
      success: function(response) {
        const data = JSON.parse(response);
        
        if (data.status === 'success') {
          const appointment = data.appointment;
          
          // Populate modal with data
          $('#modal_gcash_ref').text(appointment.gcash_reference || 'N/A');
          $('#modal_amount').html('<strong>₱' + parseFloat(appointment.downpayment_amount).toFixed(2) + '</strong>');
          
          // Payment status badge
          let paymentStatusBadge = '';
          switch(appointment.payment_status) {
            case 'Verified':
              paymentStatusBadge = '<span class="badge bg-success">Verified</span>';
              break;
            case 'Pending':
              paymentStatusBadge = '<span class="badge bg-warning">Pending</span>';
              break;
            case 'Rejected':
              paymentStatusBadge = '<span class="badge bg-danger">Rejected</span>';
              break;
          }
          $('#modal_payment_status').html(paymentStatusBadge);
          
          // Appointment status badge
          let appointmentStatusBadge = '';
          switch(appointment.appointment_status) {
            case 'Confirmed':
              appointmentStatusBadge = '<span class="badge bg-success">Confirmed</span>';
              break;
            case 'Pending':
              appointmentStatusBadge = '<span class="badge bg-warning">Pending</span>';
              break;
            case 'Completed':
              appointmentStatusBadge = '<span class="badge bg-info">Completed</span>';
              break;
            case 'Cancelled':
              appointmentStatusBadge = '<span class="badge bg-danger">Cancelled</span>';
              break;
          }
          $('#modal_appointment_status').html(appointmentStatusBadge);
          
          // Patient info
          $('#modal_patient_name').text(appointment.patient_name);
          $('#modal_service').text(appointment.service_name);
          $('#modal_datetime').text(appointment.appointment_date + ' at ' + appointment.appointment_time);
          $('#modal_notes').text(appointment.notes || 'N/A');
          
          // Payment proof image
          if (appointment.payment_proof) {
            $('#modal_payment_proof').attr('src', '../backend/images/payment_proofs/' + appointment.payment_proof);
          }
          
          // Show verification buttons if payment is pending
          if (appointment.payment_status === 'Pending') {
            $('#payment_actions').html(`
              <div class="d-grid gap-2 mt-2">
                <button class="btn btn-verify" onclick="verifyPayment(${appointmentId}, 'Verified')">
                  <i class="fas fa-check"></i> Verify Payment
                </button>
                <button class="btn btn-reject" onclick="verifyPayment(${appointmentId}, 'Rejected')">
                  <i class="fas fa-times"></i> Reject Payment
                </button>
              </div>
            `);
          } else {
            $('#payment_actions').html('');
          }
          
          // Show modal
          $('#paymentModal').modal('show');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load payment details'
          });
        }
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while loading payment details'
        });
      }
    });
  }

  function verifyPayment(appointmentId, status) {
    Swal.fire({
      title: 'Are you sure?',
      text: `You are about to ${status.toLowerCase()} this payment.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: 'rgb(39,153,137)',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, proceed!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '../backend/derm/verify_payment.php',
          type: 'POST',
          data: {
            appointment_id: appointmentId,
            payment_status: status
          },
          success: function(response) {
            if (response === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Payment has been ${status.toLowerCase()}`,
                confirmButtonColor: 'rgb(39,153,137)'
              }).then(() => {
                $('#paymentModal').modal('hide');
                loadAppointments(currentFilter, currentOffset, true);
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update payment status'
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred'
            });
          }
        });
      }
    });
  }
</script>
  </body>
</html>