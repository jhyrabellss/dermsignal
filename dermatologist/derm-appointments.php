<?php
session_start();
if(empty($_SESSION["derm_id"])){
  header('Location:../index.php');
  exit();
}
require_once("../backend/config/config.php");

require_once("./derm-select.php");

$current_status = $_GET['status'] ?? 'all';

$status_filter = '';
if ($current_status !== 'all') {
    $status_filter = "AND a.appointment_status = '$current_status'";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>My Appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/dataTables.min.css">
    <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../styles/bootsrap5-min.css">
    <link rel="stylesheet" href="../styles/card-general.css">
  </head>
  <body class="sb-nav-fixed">
    <?php require_once("./derm-navbar.php"); ?>
    <div id="layoutSidenav">
      <?php require_once("./derm-sidebar.php"); ?>
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">My Appointments</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">View and manage your appointments</li>
            </ol>

            <!-- Filter Tabs -->
            <ul class="nav nav-tabs mb-4" id="appointmentTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $current_status === 'all' ? 'active' : ''; ?>" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">
                  All
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $current_status === 'pending' ? 'active' : ''; ?>" data-status="pending" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                  Pending
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $current_status === 'confirmed' ? 'active' : ''; ?>" data-status="confirmed" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed" type="button">
                  Confirmed
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $current_status === 'completed' ? 'active' : ''; ?>" data-status="completed" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button">
                  Completed
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $current_status === 'cancelled' ? 'active' : ''; ?>" data-status="cancelled" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button">
                  Cancelled
                </button>
              </li>
            </ul>

            <!-- Appointments Table -->
            <div class="card mb-5">
              <div class="card-header bg-primary pt-3" style="background-color: rgb(39,153,137) !important;">
                <div class="text-center">
                  <p class="card-title text-light">Appointments List</p>
                </div>
              </div>
              <div class="card-body">
                <table id="appointmentsTable" class="table table-striped nowrap" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th>Price</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT 
                                a.appointment_id,
                                a.appointment_date,
                                a.appointment_time,
                                a.appointment_status,
                                a.notes,
                                s.service_name,
                                s.service_price,
                                ad.first_name,
                                ad.last_name,
                                ad.contact,
                                ac.ac_email
                              FROM tbl_appointments a
                              JOIN tbl_services s ON a.service_id = s.service_id
                              JOIN tbl_account_details ad ON a.ac_id = ad.ac_id
                              JOIN tbl_account ac ON a.ac_id = ac.ac_id
                              WHERE a.derm_id = ? $status_filter
                              ORDER BY a.appointment_date DESC, a.appointment_time DESC";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $derm_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    while ($appointment = $result->fetch_assoc()) {
                      $status_class = '';
                      switch($appointment['appointment_status']) {
                        case 'Pending': $status_class = 'warning'; break;
                        case 'Confirmed': $status_class = 'info'; break;
                        case 'Completed': $status_class = 'success'; break;
                        case 'Cancelled': $status_class = 'danger'; break;
                      }
                    ?>
                    <tr>
                      <td><?= $appointment['appointment_id'] ?></td>
                      <td><?= date('M d, Y', strtotime($appointment['appointment_date'])) ?></td>
                      <td><?= date('g:i A', strtotime($appointment['appointment_time'])) ?></td>
                      <td><?= $appointment['first_name'] . ' ' . $appointment['last_name'] ?></td>
                      <td><?= $appointment['service_name'] ?></td>
                      <td>₱<?= number_format($appointment['service_price'], 2) ?></td>
                      <td><span class="badge bg-<?= $status_class ?>"><?= $appointment['appointment_status'] ?></span></td>
                      <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal<?= $appointment['appointment_id'] ?>">
                          <i class="fas fa-eye"></i>
                        </button>
                      </td>
                    </tr>

                    <!-- View/Edit Modal -->
                    <div class="modal fade" id="viewModal<?= $appointment['appointment_id'] ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Appointment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-3">
                              <strong>Patient:</strong>
                              <p class="form-control bg-light"><?= $appointment['first_name'] . ' ' . $appointment['last_name'] ?></p>
                            </div>
                            <div class="mb-3">
                              <strong>Contact:</strong>
                              <p class="form-control bg-light"><?= $appointment['contact'] ?: $appointment['ac_email'] ?></p>
                            </div>
                            <div class="mb-3">
                              <strong>Service:</strong>
                              <p class="form-control bg-light"><?= $appointment['service_name'] ?></p>
                            </div>
                            <div class="mb-3">
                              <strong>Date & Time:</strong>
                              <p class="form-control bg-light"><?= date('F d, Y', strtotime($appointment['appointment_date'])) ?> at <?= date('g:i A', strtotime($appointment['appointment_time'])) ?></p>
                            </div>
                            <?php if ($appointment['notes']): ?>
                            <div class="mb-3">
                              <strong>Patient Notes:</strong>
                              <p class="form-control bg-light"><?= htmlspecialchars($appointment['notes']) ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="mb-3">
                              <strong>Update Status:</strong>
                              <select class="form-control appointment-status" data-appointment-id="<?= $appointment['appointment_id'] ?>">
                                <option value="Pending" <?= $appointment['appointment_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Confirmed" <?= $appointment['appointment_status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="Completed" <?= $appointment['appointment_status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Cancelled" <?= $appointment['appointment_status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-update-status" data-appointment-id="<?= $appointment['appointment_id'] ?>">
                              Update Status
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
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
    <script src="../plugins/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/js/dataTables.bootstrap5.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#appointmentsTable').DataTable({
          responsive: true,
          order: [[1, 'desc']],
        });
        
        $('.nav-item button').click(function() {
          const status = $(this).data('status') || 'all';
          window.location.href = `derm-appointments.php?status=${status}`;
        });

        // Update appointment status
        $('.btn-update-status').click(function() {
          const appointmentId = $(this).data('appointment-id');
          const newStatus = $(`.appointment-status[data-appointment-id="${appointmentId}"]`).val();
          
          $.ajax({
            url: '../backend/derm_update_appointment.php',
            type: 'POST',
            data: {
              appointment_id: appointmentId,
              status: newStatus
            },
            success: function(response) {
              if (response === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Updated!',
                  text: 'Appointment status updated successfully',
                  confirmButtonColor: 'rgb(39,153,137)'
                }).then(() => location.reload());
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to update status',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              }
            }
          });
        });
      });
    </script>
  </body>
</html>