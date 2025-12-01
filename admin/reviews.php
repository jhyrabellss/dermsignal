<?php
session_start();
if(empty($_SESSION["admin_id"])){
  header('Location:logout.php');
}
require_once("../backend/config/config.php");

// Handle Update Status
if(isset($_POST['update_status'])){
    $review_id = $_POST['review_id'];
    $status = $_POST['status'];
    
    $query = "UPDATE tbl_page_reviews SET status = ? WHERE review_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $review_id);
    
    if($stmt->execute()){
        echo json_encode(['success' => true, 'message' => 'Review status updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update review status.']);
    }
    exit;
}

// Handle Delete Review
if(isset($_POST['delete_review'])){
    $review_id = $_POST['review_id'];
    
    $query = "DELETE FROM tbl_page_reviews WHERE review_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $review_id);
    
    if($stmt->execute()){
        echo json_encode(['success' => true, 'message' => 'Review deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete review.']);
    }
    exit;
}
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
              <li class="breadcrumb-item active">Reports</li>
            </ol>

              <div class="card mb-5">
                    <div class="card-header bg-primary pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">Report List
                        </div>
                    </div>
                    <div class="card-body">
                      <table id="residenceAccounts" class="table table-striped nowrap" style="width:100%">
                        <thead>
                          <tr>
                              <th>ID</th>
                              <th>Customer Name</th>
                              <th>Title</th>
                              <th>Rating</th>
                              <th>Status</th>
                              <th>Created Date</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $query = "SELECT tf.*, CONCAT(td.first_name, ' ', td.last_name) AS full_name FROM tbl_page_reviews tf
                            INNER JOIN tbl_account_details td ON tf.account_id = td.ac_id";                            
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                              while ($data = $result->fetch_assoc()) {
                          ?>
                          <tr>
                            <td><?php echo $data['review_id'];?></td>
                            <td><?php echo $data['full_name'];?></td>
                            <td><?php echo $data['review_title'];?></td>
                            <td><?php echo $data['rating'];?></td>
                            <td>
                              <span class="badge bg-<?php 
                                echo $data['status'] == 'approved' ? 'success' : ($data['status'] == 'rejected' ? 'danger' : 'warning'); 
                              ?>">
                                <?php echo ucfirst($data['status']);?>
                              </span>
                            </td>
                            <td><?php echo date('F d, Y', strtotime($data['created_at']));?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                data-bs-target="#residenceAccountDetails<?php echo $data["review_id"] ?>">
                                  <i class="fa-solid fa-eye"></i>
                                </button>

                                <!-- Update status button -->
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" 
                                data-bs-target="#updateStatusModal<?php echo $data['review_id']; ?>">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- Delete button -->
                                <button type="button" class="btn btn-danger btn-sm delete-review-btn" 
                                data-review-id="<?php echo $data['review_id']; ?>">
                                  <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                          </tr>

                            <!-- View Details Modal -->
                            <div class="modal fade" id="residenceAccountDetails<?php echo $data["review_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Report Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post">
                                      <div class="mb-3">
                                        <label class="col-form-label">Report Name</label>
                                        <input type="text" class="form-control" disabled value="<?php echo $data["full_name"]; ?>">
                                      </div>
                                      <div class="mb-3">
                                        <label class="col-form-label">Report Message</label>
                                        <textarea class="form-control" rows="5" cols="30"
                                        style="white-space: pre-wrap; overflow-wrap: break-word;"
                                        disabled><?php echo $data["review_text"]; ?></textarea>
                                      </div>

                                      <!-- Display image -->
                                      <div class="mb-3">
                                        <label class="col-form-label">Reviewer Image</label><br>
                                        <?php if(!empty($data["reviewer_image"])): ?>
                                          <img src="../images/testimonials/<?php echo $data["reviewer_image"]; ?>" alt="Reviewer Image" style="max-width: 100%; height: auto;">
                                        <?php else: ?>
                                          <p>No image provided.</p>
                                        <?php endif; ?>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Update Status Modal -->
                            <div class="modal fade" id="updateStatusModal<?php echo $data['review_id']; ?>" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel">Update Review Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form id="updateStatusForm<?php echo $data['review_id']; ?>">
                                      <input type="hidden" name="review_id" value="<?php echo $data['review_id']; ?>">
                                      
                                      <div class="mb-3">
                                        <label class="col-form-label">Review Title</label>
                                        <input type="text" class="form-control" disabled value="<?php echo $data['review_title']; ?>">
                                      </div>

                                      <div class="mb-3">
                                        <label class="col-form-label">Customer Name</label>
                                        <input type="text" class="form-control" disabled value="<?php echo $data['full_name']; ?>">
                                      </div>

                                      <div class="mb-3">
                                        <label class="col-form-label">Current Status</label>
                                        <input type="text" class="form-control" disabled value="<?php echo ucfirst($data['status']); ?>">
                                      </div>

                                      <div class="mb-3">
                                        <label class="col-form-label">New Status <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status" required>
                                          <option value="">Select Status</option>
                                          <option value="pending" <?php echo $data['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                          <option value="approved" <?php echo $data['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                          <option value="rejected" <?php echo $data['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                      </div>
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary update-status-submit" data-review-id="<?php echo $data['review_id']; ?>">Update Status</button>
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

  <?php require_once("./verifyPassword.php"); ?>

  <script src="../scripts/bootstrap.bundle.min.js"></script>
  <script src="../scripts/jquery.js"></script>
  <script src="../jquery/verify-password-modal.js"></script>
  <script src="../jquery/check-valid-password.js"></script>
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

      // Update Status Handler - Open password modal first
      $('.update-status-submit').on('click', function(e) {
          e.preventDefault();
          var reviewId = $(this).data('review-id');
          var currentModal = $(this).closest('.modal');
          
          // Get the selected status value from the select element in THIS modal
          var selectElement = currentModal.find('select[name="status"]');
          var selectedStatus = selectElement.val();
          
          console.log('Review ID:', reviewId); // Debug log
          console.log('Select Element:', selectElement); // Debug log
          console.log('Selected Status:', selectedStatus); // Debug log
          
          if(!selectedStatus || selectedStatus === '') {
              Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Please select a status!',
              });
              return;
          }
          
          // Store ALL the data we need in modalPassword BEFORE closing the modal
          $('#modalPassword').data('actionType', 'update');
          $('#modalPassword').data('reviewId', reviewId);
          $('#modalPassword').data('selectedStatus', selectedStatus); // Store the status value
          
          // Close current modal and open password modal
          currentModal.modal('hide');
          
          // Use setTimeout to ensure modal is fully closed before opening new one
          setTimeout(function() {
              $('#modalPassword').modal('show');
          }, 300);
      });

      // Delete Review Handler - Open password modal first
      $('.delete-review-btn').on('click', function(e) {
          e.preventDefault();
          var reviewId = $(this).data('review-id');
          
          // Store the action type
          $('#modalPassword').data('actionType', 'delete');
          $('#modalPassword').data('reviewId', reviewId);
          
          // Open password modal
          $('#modalPassword').modal('show');
      });

      // Handle password verification from the modal
      $('#modalPassword .updateResBtn').on('click', async function() {
          const admin_password = $('.verifyAdminPassword').val();
          
          if(!admin_password) {
              Swal.fire({
                  title: "Empty Field!",
                  text: "Please enter your password.",
                  showConfirmButton: false,
                  timer: 1500
              });
              return;
          }

          let passwordVerified = await checkValidPassword(admin_password);
          
          if(!passwordVerified) {
              Swal.fire({
                  title: "Invalid Password",
                  text: "The password you entered is incorrect.",
              });
              return;
          }

          // Password verified - proceed with the action
          var actionType = $('#modalPassword').data('actionType');
          var reviewId = $('#modalPassword').data('reviewId');
          
          // Close password modal
          $('#modalPassword').modal('hide');
          $('.verifyAdminPassword').val(''); // Clear password field
          
          if(actionType === 'update') {
              // Get the stored status value
              var selectedStatus = $('#modalPassword').data('selectedStatus');
              
              console.log('Processing update with status:', selectedStatus); // Debug log

              $.ajax({
                  url: '',
                  type: 'POST',
                  data: {
                      update_status: 1,
                      review_id: reviewId,
                      status: selectedStatus
                  },
                  dataType: 'json',
                  success: function(response) {
                      if(response.success) {
                          Swal.fire({
                              icon: 'success',
                              title: 'Success!',
                              text: response.message,
                              showConfirmButton: false,
                              timer: 1500
                          }).then(() => {
                              location.reload();
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: response.message
                          });
                      }
                  },
                  error: function() {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: 'An error occurred while updating the status.'
                      });
                  }
              });
              
          } else if(actionType === 'delete') {
              // Handle delete review
              $.ajax({
                  url: '',
                  type: 'POST',
                  data: {
                      delete_review: 1,
                      review_id: reviewId
                  },
                  dataType: 'json',
                  success: function(response) {
                      if(response.success) {
                          Swal.fire({
                              icon: 'success',
                              title: 'Deleted!',
                              text: response.message,
                              showConfirmButton: false,
                              timer: 1500
                          }).then(() => {
                              location.reload();
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: response.message
                          });
                      }
                  },
                  error: function() {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: 'An error occurred while deleting the review.'
                      });
                  }
              });
          }
          
          // Clear stored data
          $('#modalPassword').removeData('actionType');
          $('#modalPassword').removeData('reviewId');
          $('#modalPassword').removeData('selectedStatus');
      });
  });
</script>

  <script src="../jquery/sideBarProd.js"></script> 
  </body>
</html>