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
                <div class="c-dashboardInfo col-xl-3 col-md-6">
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

                <div class="c-dashboardInfo col-xl-3 col-md-6">
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

                <div class="c-dashboardInfo col-xl-3 col-md-6">
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

                <div class="c-dashboardInfo col-xl-3 col-md-6">
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
                      <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-white mb-0">Appointments</h5>
                        <div class="btn-group" role="group">
                          <button type="button" class="btn btn-info btn-sm filter-btn active" data-filter="today">
                            <i class="fas fa-calendar-day"></i> Today
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="upcoming">
                            <i class="fas fa-calendar-alt"></i> Upcoming
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="completed">
                            <i class="fas fa-check-circle"></i> Completed
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="cancelled">
                            <i class="fas fa-times-circle"></i> Cancelled
                          </button>
                          <button type="button" class="btn btn-info btn-sm filter-btn" data-filter="all">
                            <i class="fas fa-list"></i> All
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
                              <th>Notes</th>
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
              $('#appointmentsTableBody').html('<tr><td colspan="7" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
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
                $('#appointmentsTableBody').html('<tr><td colspan="7" class="text-center text-muted">No appointments found</td></tr>');
              }
              $('#loadMoreBtn').hide();
            }
          },
          error: function() {
            $('#appointmentsTableBody').html('<tr><td colspan="7" class="text-center text-danger">Error loading appointments</td></tr>');
            $('#loadMoreBtn').hide();
          }
        });
      }
    </script>
  </body>
</html>