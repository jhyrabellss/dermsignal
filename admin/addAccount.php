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
    <title>Create Account - Admin Panel</title>
    <!-- DataTables -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/dataTables.min.css">
    <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../styles/bootsrap5-min.css">
    <link rel="stylesheet" href="../styles/card-general.css">
    <style>
      .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        z-index: 10;
      }
      
      .password-toggle:hover {
        color: #333;
      }
      
      .password-wrapper {
        position: relative;
      }
      
      .password-wrapper input {
        padding-right: 40px;
      }

      .account-type-card {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid #dee2e6;
      }

      .account-type-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      }

      .account-type-card.selected {
        border-color: #0d6efd;
        background-color: #f0f8ff;
      }

      .account-type-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
      }

      #dermatologistFields {
        display: none;
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
            <h1 class="mt-4" id="full_name">Create Account</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">Create new admin or dermatologist account</li>
            </ol>

            <!-- Account Type Selection -->
            <div class="card mb-4">
              <div class="card-header bg-primary pt-3">
                <div class="text-center">
                  <p class="card-title text-light">Select Account Type</p>
                </div>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="card account-type-card text-center p-4" data-type="admin">
                      <div class="card-body">
                        <i class="fas fa-user-shield account-type-icon text-primary"></i>
                        <h4>Admin Account</h4>
                        <p class="text-muted">Full system access and management</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card account-type-card text-center p-4" data-type="dermatologist">
                      <div class="card-body">
                        <i class="fas fa-user-md account-type-icon text-success"></i>
                        <h4>Dermatologist Account</h4>
                        <p class="text-muted">Appointment and patient management</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Account Creation Form -->
            <div class="card mb-5" id="accountFormCard" style="display: none;">
              <div class="card-header bg-secondary pt-3">
                <div class="text-center">
                  <p class="card-title text-light">
                    <span id="accountTypeTitle">Account</span> Details 
                    <i class="fas fa-user-plus"></i>
                  </p>
                </div>
              </div>
              <div class="card-body">
                <form class="row g-3" method="post" id="createAccountForm">
                  <input type="hidden" id="account_type" name="account_type" value="">
                  
                  <h5 class="text-center">Login Credentials</h5>
                  <hr>
                  
                  <div class="col-md-4">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" required>
                    <small class="text-muted">Minimum 5 characters</small>
                  </div>

                  <div class="col-md-4">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" required>
                  </div>

                  <div class="col-md-4">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="password-wrapper">
                      <input type="password" class="form-control" id="password" required>
                      <i class="fas fa-eye password-toggle" onclick="togglePassword('password')"></i>
                    </div>
                    <small class="text-muted">Min 6 chars, 1 uppercase, 1 lowercase, 1 digit</small>
                  </div>

                  <h5 class="text-center mt-4">Personal Information</h5>
                  <hr>

                  <div class="col-md-4">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="first_name" required>
                  </div>

                  <div class="col-md-4">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middle_name">
                  </div>

                  <div class="col-md-4">
                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="last_name" required>
                  </div>

                  <div class="col-md-4">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" class="form-select">
                      <option value="">Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="contact" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="contact" placeholder="+63 XXX XXX XXXX">
                  </div>

                  <div class="col-md-4">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address">
                  </div>

                  <!-- Dermatologist Specific Fields -->
                  <div id="dermatologistFields">
                    <h5 class="text-center mt-4">Professional Information</h5>
                    <hr>

                    <div class="col-md-6">
                      <label for="derm_name" class="form-label">Professional Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="derm_name" placeholder="e.g., Dr. Juan dela Cruz">
                      <small class="text-muted">Name to be displayed to patients</small>
                    </div>

                    <div class="col-md-6">
                      <label for="derm_specialization" class="form-label">Specialization <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="derm_specialization" placeholder="e.g., Cosmetic Dermatology">
                    </div>
                  </div>

                  <div class="col-12 text-center mb-4 mt-5">
                    <button type="button" class="btn btn-secondary btn-lg me-2" onclick="resetForm()">
                      <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" id="submit" class="btn btn-primary btn-lg">
                      <i class="fas fa-check"></i> Create Account
                    </button>
                  </div>

                </form>
              </div>
            </div>

            <!-- Existing Accounts Table -->
            <div class="card mb-5">
              <div class="card-header bg-info pt-3">
                <div class="text-center">
                  <p class="card-title text-light">Existing Accounts <i class="fas fa-users"></i></p>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="accountsTable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = "SELECT 
                                  a.ac_id,
                                  a.ac_username,
                                  a.ac_email,
                                  a.role_id,
                                  ad.first_name,
                                  ad.middle_name,
                                  ad.last_name,
                                  st.ac_status
                                FROM tbl_account a
                                LEFT JOIN tbl_account_details ad ON a.ac_id = ad.ac_id
                                LEFT JOIN tbl_ac_status st ON a.account_status_id = st.ac_status_id
                                WHERE a.role_id IN (2, 3)
                                ORDER BY a.ac_id DESC";
                      
                      $stmt = $conn->prepare($query);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      
                      while($account = $result->fetch_assoc()) {
                        $role_name = $account['role_id'] == 2 ? 'Admin' : 'Dermatologist';
                        $role_badge = $account['role_id'] == 2 ? 'primary' : 'success';
                        $status_badge = $account['ac_status'] == 'Active' ? 'success' : 'danger';
                        $full_name = trim($account['first_name'] . ' ' . ($account['middle_name'] ?? '') . ' ' . $account['last_name']);
                      ?>
                      <tr>
                        <td><?= $account['ac_id'] ?></td>
                        <td><?= htmlspecialchars($account['ac_username']) ?></td>
                        <td><?= htmlspecialchars($account['ac_email']) ?></td>
                        <td><?= htmlspecialchars($full_name) ?></td>
                        <td><span class="badge bg-<?= $role_badge ?>"><?= $role_name ?></span></td>
                        <td><span class="badge bg-<?= $status_badge ?>"><?= $account['ac_status'] ?></span></td>
                        <td><?= date('M d, Y') ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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
    <!-- DataTables Scripts -->
    <script src="../plugins/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/js/dataTables.bootstrap5.min.js"></script>
    <script src="../plugins/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/js/responsive.bootstrap5.min.js"></script>

    <script>
      $(document).ready(function() {
        // Initialize DataTable
        $('#accountsTable').DataTable({
          responsive: true,
          order: [[0, 'desc']]
        });

        // Account type selection
        $('.account-type-card').click(function() {
          $('.account-type-card').removeClass('selected');
          $(this).addClass('selected');
          
          const accountType = $(this).data('type');
          $('#account_type').val(accountType);
          
          // Update form title
          if (accountType === 'admin') {
            $('#accountTypeTitle').text('Admin');
            $('#dermatologistFields').hide();
            $('#derm_name, #derm_specialization').removeAttr('required');
          } else {
            $('#accountTypeTitle').text('Dermatologist');
            $('#dermatologistFields').show();
            $('#derm_name, #derm_specialization').attr('required', 'required');
          }
          
          $('#accountFormCard').slideDown();
        });

        // Form submission
        $('#createAccountForm').submit(function(e) {
          e.preventDefault();
          
          const accountType = $('#account_type').val();
          
          if (!accountType) {
            Swal.fire({
              icon: 'warning',
              title: 'Account Type Required',
              text: 'Please select an account type first',
              confirmButtonColor: '#0d6efd'
            });
            return;
          }

          // Validation
          const username = $('#username').val().trim();
          const email = $('#email').val().trim();
          const password = $('#password').val();
          const firstName = $('#first_name').val().trim();
          const lastName = $('#last_name').val().trim();

          if (username.length < 5) {
            Swal.fire({
              icon: 'error',
              title: 'Invalid Username',
              text: 'Username must be at least 5 characters',
              confirmButtonColor: '#0d6efd'
            });
            return;
          }

          if (password.length < 6) {
            Swal.fire({
              icon: 'error',
              title: 'Invalid Password',
              text: 'Password must be at least 6 characters',
              confirmButtonColor: '#0d6efd'
            });
            return;
          }

          // Password strength check
          const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
          if (!passwordPattern.test(password)) {
            Swal.fire({
              icon: 'error',
              title: 'Weak Password',
              text: 'Password must contain at least one uppercase letter, one lowercase letter, and one digit',
              confirmButtonColor: '#0d6efd'
            });
            return;
          }

          // Dermatologist specific validation
          if (accountType === 'dermatologist') {
            const dermName = $('#derm_name').val().trim();
            const dermSpec = $('#derm_specialization').val().trim();
            
            if (!dermName || !dermSpec) {
              Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please fill in all required dermatologist fields',
                confirmButtonColor: '#0d6efd'
              });
              return;
            }
          }

          // Collect form data
          const formData = {
            account_type: accountType,
            username: username,
            email: email,
            password: password,
            first_name: firstName,
            middle_name: $('#middle_name').val().trim(),
            last_name: lastName,
            gender: $('#gender').val(),
            contact: $('#contact').val().trim(),
            address: $('#address').val().trim()
          };

          if (accountType === 'dermatologist') {
            formData.derm_name = $('#derm_name').val().trim();
            formData.derm_specialization = $('#derm_specialization').val().trim();
          }

          // Show loading
          Swal.fire({
            title: 'Creating Account...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          // Submit via AJAX
          $.ajax({
            url: '../backend/admin/create_account.php',
            type: 'POST',
            data: formData,
            success: function(response) {
              const data = JSON.parse(response);
              
              if (data.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: data.message,
                  confirmButtonColor: '#0d6efd'
                }).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message || 'Failed to create account',
                  confirmButtonColor: '#0d6efd'
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to create account. Please try again.',
                confirmButtonColor: '#0d6efd'
              });
            }
          });
        });
      });

      // Toggle password visibility
      function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = event.currentTarget;
        
        if (field.type === 'password') {
          field.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          field.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      }

      // Reset form
      function resetForm() {
        $('#createAccountForm')[0].reset();
        $('#accountFormCard').slideUp();
        $('.account-type-card').removeClass('selected');
        $('#account_type').val('');
        $('#dermatologistFields').hide();
      }
    </script>
  </body>
</html>