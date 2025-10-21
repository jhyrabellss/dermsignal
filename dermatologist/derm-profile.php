<?php
session_start();
if (empty($_SESSION["derm_id"])) {
  header('Location:../index.php');
  exit();
}
require_once("../backend/config/config.php");
require_once("./derm-select.php");

// Get account details
$details_query = "SELECT ad.*, a.ac_username, a.ac_email 
                  FROM tbl_account_details ad
                  JOIN tbl_account a ON ad.ac_id = a.ac_id
                  WHERE ad.ac_id = ?";
$details_stmt = $conn->prepare($details_query);
$details_stmt->bind_param("i", $ac_id);
$details_stmt->execute();
$details_result = $details_stmt->get_result();
$account_details = $details_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>My Profile</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../styles/bootsrap5-min.css">
  <link rel="stylesheet" href="../styles/card-general.css">
  <style>
    .profile-section {
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 15px;
      color: rgb(39, 153, 137);
      border-bottom: 2px solid rgb(39, 153, 137);
      padding-bottom: 8px;
    }

    .info-row {
      display: flex;
      margin-bottom: 10px;
      padding: 8px;
      border-radius: 4px;
      background: #f8f9fa;
    }

    .info-label {
      font-weight: 600;
      min-width: 120px;
      color: #555;
    }

    .info-value {
      color: #333;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      overflow: hidden;
    }

    .modal-content {
      background-color: white;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 0;
      border-radius: 8px;
      width: 90%;
      max-width: 600px;
      max-height: 85vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .modal-header {
      background-color: rgb(39, 153, 137);
      color: white;
      padding: 15px 20px;
      border-radius: 8px 8px 0 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-shrink: 0;
    }

    .modal-body {
      padding: 20px;
      overflow-y: auto;
      flex: 1;
    }

    .modal-footer {
      padding: 15px 20px;
      border-top: 1px solid #ddd;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      flex-shrink: 0;
    }

    .close {
      color: white;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      border: none;
      background: none;
    }

    .close:hover {
      opacity: 0.8;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .password-input-wrapper {
      position: relative;
    }

    .password-input-wrapper input {
      padding-right: 40px;
    }

    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
    }

    .password-toggle:hover {
      color: #333;
    }

    /* Fix SweetAlert z-index to appear above modals */
    .swal2-container {
      z-index: 10000 !important;
    }


    /* Profile Image Styles */
    .profile-image-container {
      position: relative;
      width: 200px;
      height: 200px;
      margin: 0 auto;
      border-radius: 50%;
      overflow: hidden;
      border: 4px solid rgb(39, 153, 137);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-image-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(0, 0, 0, 0.7);
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 10px;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .profile-image-container:hover .profile-image-overlay {
      opacity: 1;
    }

    .profile-image-overlay .btn {
      padding: 5px 10px;
    }

    /* Image Preview Modal Styles */
.preview-image-container {
  width: 300px;
  height: 300px;
  margin: 0 auto;
  border-radius: 50%;
  overflow: hidden;
  border: 4px solid rgb(39, 153, 137);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.preview-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
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
          <h1 class="mt-4">My Profile</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">View and update your profile</li>
          </ol>

          <div class="row">
            <!-- Account Information -->
            <div class="col-md-8">
              <div class="card mb-4">
                <div class="card-header bg-primary" style="background-color: rgb(39,153,137) !important;">
                  <h5 class="text-white mb-0"><i class="fas fa-user"></i> Account Information</h5>
                </div>
                <div class="card-body">
                  <div class="profile-section">
                    <div class="section-title">Login Credentials</div>
                    <div class="info-row">
                      <span class="info-label">Username:</span>
                      <span class="info-value"><?= htmlspecialchars($account_details['ac_username']) ?></span>
                    </div>
                    <div class="info-row">
                      <span class="info-label">Email:</span>
                      <span class="info-value"><?= htmlspecialchars($account_details['ac_email']) ?></span>
                    </div>
                    <button class="btn btn-sm btn-warning mt-2" onclick="openPasswordModal()">
                      <i class="fas fa-key"></i> Change Password
                    </button>
                  </div>

                  <div class="profile-section">
                    <div class="section-title">Personal Information</div>
                    <div class="info-row">
                      <span class="info-label">Full Name:</span>
                      <span class="info-value">
                        <?= htmlspecialchars($account_details['first_name']) ?>
                        <?= htmlspecialchars($account_details['middle_name'] ?? '') ?>
                        <?= htmlspecialchars($account_details['last_name']) ?>
                      </span>
                    </div>
                    <div class="info-row">
                      <span class="info-label">Gender:</span>
                      <span class="info-value"><?= htmlspecialchars($account_details['gender'] ?? 'Not specified') ?></span>
                    </div>
                    <div class="info-row">
                      <span class="info-label">Contact:</span>
                      <span class="info-value"><?= htmlspecialchars($account_details['contact'] ?? 'Not specified') ?></span>
                    </div>
                    <div class="info-row">
                      <span class="info-label">Address:</span>
                      <span class="info-value"><?= htmlspecialchars($account_details['address'] ?? 'Not specified') ?></span>
                    </div>
                    <button class="btn btn-sm btn-primary mt-2" onclick="openPersonalModal()" style="background-color: rgb(39,153,137); border: none;">
                      <i class="fas fa-edit"></i> Edit Personal Info
                    </button>
                  </div>
                </div>
              </div>

              <!-- Professional Information -->
              <div class="card mb-4">
                <div class="card-header bg-primary" style="background-color: rgb(39,153,137) !important;">
                  <h5 class="text-white mb-0"><i class="fas fa-stethoscope"></i> Professional Information</h5>
                </div>
                <div class="card-body">
                  <form id="professionalForm">
                    <div class="mb-3">
                      <label class="form-label">Professional Name</label>
                      <input type="text" class="form-control" id="dermName" value="<?= htmlspecialchars($data['derm_name']) ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Specialization</label>
                      <input type="text" class="form-control" id="dermSpec" value="<?= htmlspecialchars($data['derm_specialization']) ?>">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <input type="text" class="form-control" value="<?= htmlspecialchars($data['derm_status']) ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                    </div>
                    <button type="button" class="btn btn-primary" id="btnUpdateProfessional" style="background-color: rgb(39,153,137); border: none;">
                      <i class="fas fa-save"></i> Update Professional Info
                    </button>
                  </form>
                </div>
              </div>
            </div>



            <div class="col-md-4">
              <div class="card mb-4">
                <div class="card-header bg-primary" style="background-color: rgb(39,153,137) !important;">
                  <h5 class="text-white mb-0"><i class="fas fa-camera"></i> Profile Picture</h5>
                </div>
                <div class="card-body text-center">
                  <div class="profile-image-container mb-3">
                    <?php
                    $profile_image = $data['derm_image'] ?? null;
                    if(file_exists("../images/profile_images/" . $profile_image) && $profile_image){
                    ?>              
                    <img src="../images/profile_images/<?= $profile_image ?>" alt="Profile" class="profile-image" id="profileImagePreview" onerror="this.src='../assets/default-avatar.png'">
                    <?php } else { ?>
                    <div class="no-profile" style="text-align: center; line-height: 200px; color: #ccc; font-size: 18px;">
                      No Image
                    </div>
                    <?php } ?>      
                    <div class="profile-image-overlay">
                      <button class="btn btn-sm btn-light" onclick="document.getElementById('profileImageInput').click()">
                        <i class="fas fa-camera"></i>
                      </button>
                      <?php if ($profile_image): ?>
                        <button class="btn btn-sm btn-danger" onclick="deleteProfileImage()">
                          <i class="fas fa-trash"></i>
                        </button>
                      <?php endif; ?>
                    </div>
                  </div>
                  <input type="file" id="profileImageInput" accept="image/*" style="display: none;" onchange="previewProfileImage(this)">
                  <button class="btn btn-primary btn-sm" onclick="document.getElementById('profileImageInput').click()" style="background-color: rgb(39,153,137); border: none;">
                    <i class="fas fa-upload"></i> Choose Photo
                  </button>
                  <?php if ($profile_image): ?>
                    <button class="btn btn-danger btn-sm" onclick="deleteProfileImage()">
                      <i class="fas fa-trash"></i> Remove
                    </button>
                  <?php endif; ?>
                  <small class="d-block mt-2 text-muted">Max size: 5MB<br>Formats: JPG, PNG, GIF</small>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-header bg-primary" style="background-color: rgb(39,153,137) !important;">
                  <h5 class="text-white mb-0"><i class="fas fa-chart-bar"></i> Statistics</h5>
                </div>


                <div class="card-body">
                  <?php
                  $stats_query = "SELECT 
                                      COUNT(CASE WHEN appointment_status = 'Completed' THEN 1 END) as completed,
                                      COUNT(CASE WHEN appointment_status = 'Pending' THEN 1 END) as pending,
                                      COUNT(CASE WHEN appointment_status = 'Confirmed' THEN 1 END) as confirmed,
                                      COUNT(CASE WHEN appointment_status = 'Cancelled' THEN 1 END) as cancelled,
                                      COUNT(*) as total
                                    FROM tbl_appointments WHERE derm_id = ?";
                  $stats_stmt = $conn->prepare($stats_query);
                  $stats_stmt->bind_param("i", $derm_id);
                  $stats_stmt->execute();
                  $stats_result = $stats_stmt->get_result();
                  $stats = $stats_result->fetch_assoc();
                  ?>
                  <div class="mb-3 text-center">
                    <strong>Total Appointments</strong>
                    <h2 style="color: rgb(39,153,137);"><?= $stats['total'] ?></h2>
                  </div>
                  <hr>
                  <div class="mb-3">
                    <strong>Completed:</strong>
                    <h3 class="text-success"><?= $stats['completed'] ?></h3>
                  </div>
                  <div class="mb-3">
                    <strong>Confirmed:</strong>
                    <h3 class="text-info"><?= $stats['confirmed'] ?></h3>
                  </div>
                  <div class="mb-3">
                    <strong>Pending:</strong>
                    <h3 class="text-warning"><?= $stats['pending'] ?></h3>
                  </div>
                  <div class="mb-3">
                    <strong>Cancelled:</strong>
                    <h3 class="text-danger"><?= $stats['cancelled'] ?></h3>
                  </div>
                </div>
              </div>
            </div>
      </main>
    </div>
  </div>

  <!-- Personal Info Modal -->
  <div id="personalModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Personal Information</h5>
        <button class="close" onclick="closeModal('personalModal')">&times;</button>
      </div>
      <div class="modal-body">
        <form id="personalForm">
          <div class="form-group">
            <label>First Name <span class="text-danger">*</span></label>
            <input type="text" id="firstName" class="form-control" value="<?= htmlspecialchars($account_details['first_name']) ?>" required>
          </div>
          <div class="form-group">
            <label>Middle Name</label>
            <input type="text" id="middleName" class="form-control" value="<?= htmlspecialchars($account_details['middle_name'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Last Name <span class="text-danger">*</span></label>
            <input type="text" id="lastName" class="form-control" value="<?= htmlspecialchars($account_details['last_name']) ?>" required>
          </div>
          <div class="form-group">
            <label>Gender</label>
            <select id="gender" class="form-control">
              <option value="Male" <?= $account_details['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $account_details['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
              <option value="Other" <?= $account_details['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Contact Number</label>
            <input type="text" id="contact" class="form-control" value="<?= htmlspecialchars($account_details['contact'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Address</label>
            <textarea id="address" class="form-control"><?= htmlspecialchars($account_details['address'] ?? '') ?></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('personalModal')">Cancel</button>
        <button class="btn btn-primary" onclick="updatePersonalInfo()" style="background-color: rgb(39,153,137); border: none;">Update</button>
      </div>
    </div>
  </div>

  <!-- Change Password Modal -->
  <div id="passwordModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Change Password</h5>
        <button class="close" onclick="closeModal('passwordModal')">&times;</button>
      </div>
      <div class="modal-body">
        <form id="passwordForm">
          <div class="form-group">
            <label>Current Password <span class="text-danger">*</span></label>
            <div class="password-input-wrapper">
              <input type="password" id="currentPassword" class="form-control" required>
              <i class="fas fa-eye password-toggle" onclick="togglePassword('currentPassword')"></i>
            </div>
          </div>
          <div class="form-group">
            <label>New Password <span class="text-danger">*</span></label>
            <div class="password-input-wrapper">
              <input type="password" id="newPassword" class="form-control" required>
              <i class="fas fa-eye password-toggle" onclick="togglePassword('newPassword')"></i>
            </div>
            <small class="text-muted">Minimum 6 characters</small>
          </div>
          <div class="form-group">
            <label>Confirm New Password <span class="text-danger">*</span></label>
            <div class="password-input-wrapper">
              <input type="password" id="confirmPassword" class="form-control" required>
              <i class="fas fa-eye password-toggle" onclick="togglePassword('confirmPassword')"></i>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeModal('passwordModal')">Cancel</button>
        <button class="btn btn-primary" onclick="changePassword()" style="background-color: rgb(39,153,137); border: none;">Change Password</button>
      </div>
    </div>
  </div>

  <!-- Image Preview Modal -->
<div id="imagePreviewModal" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h5>Preview Profile Picture</h5>
      <button class="close" onclick="closeImagePreview()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="text-center mb-3">
        <div class="preview-image-container">
          <img id="previewImage" src="" alt="Preview" class="preview-image">
        </div>
      </div>
      <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Please review your image before uploading.
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeImagePreview()">Cancel</button>
      <button class="btn btn-primary" onclick="confirmUploadImage()" style="background-color: rgb(39,153,137); border: none;">
        <i class="fas fa-check"></i> Confirm & Upload
      </button>
    </div>
  </div>
</div>

  <script src="../scripts/bootstrap.bundle.min.js"></script>
  <script src="../scripts/jquery.js"></script>
  <script src="../scripts/toggle.js"></script>
  <script>
    // Modal functions
    function openPersonalModal() {
      document.getElementById('personalModal').style.display = 'block';
      document.body.style.overflow = 'hidden';
    }

    function openPasswordModal() {
      document.getElementById('passwordModal').style.display = 'block';
      document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
      document.body.style.overflowY = 'scroll';
      // Clear form fields if it's password modal
      if (modalId === 'passwordModal') {
        document.getElementById('passwordForm').reset();
      }
    }

    // Update Professional Information
    $(document).ready(function() {
      $('#btnUpdateProfessional').click(function() {
        const name = $('#dermName').val().trim();
        const spec = $('#dermSpec').val().trim();

        if (!name || !spec) {
          Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please fill in all fields',
            confirmButtonColor: 'rgb(39,153,137)'
          });
          return;
        }

        Swal.fire({
          title: 'Are you sure?',
          text: "Do you want to update your professional information?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: 'rgb(39,153,137)',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '../backend/derm/derm_update_professional.php',
              type: 'POST',
              data: {
                name: name,
                specialization: spec
              },
              success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: 'Professional information updated successfully',
                    confirmButtonColor: 'rgb(39,153,137)'
                  }).then(() => location.reload());
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update profile',
                    confirmButtonColor: 'rgb(39,153,137)'
                  });
                }
              }
            });
          }
        });
      });
    });

    // Update Personal Information
    function updatePersonalInfo() {
      const firstName = document.getElementById('firstName').value.trim();
      const middleName = document.getElementById('middleName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const gender = document.getElementById('gender').value;
      const contact = document.getElementById('contact').value.trim();
      const address = document.getElementById('address').value.trim();

      if (!firstName || !lastName) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Information',
          text: 'First name and last name are required',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }


      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to update your personal information?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'rgb(39,153,137)',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '../backend/derm/derm_update_personal.php',
            type: 'POST',
            data: {
              first_name: firstName,
              middle_name: middleName,
              last_name: lastName,
              gender: gender,
              contact: contact,
              address: address
            },
            success: function(response) {
              const data = JSON.parse(response);
              if (data.status === 'success') {
                closeModal('personalModal');
                Swal.fire({
                  icon: 'success',
                  title: 'Updated!',
                  text: 'Personal information updated successfully',
                  confirmButtonColor: 'rgb(39,153,137)'
                }).then(() => location.reload());
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message || 'Failed to update information',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              }
            }
          });
        }
      });



    }

    // Change Password
    function changePassword() {
      const current = document.getElementById('currentPassword').value;
      const newPass = document.getElementById('newPassword').value;
      const confirm = document.getElementById('confirmPassword').value;

      if (!current || !newPass || !confirm) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Information',
          text: 'All fields are required',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }

      if (newPass.length < 6) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Password',
          text: 'New password must be at least 6 characters',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }

      if (newPass !== confirm) {
        Swal.fire({
          icon: 'warning',
          title: 'Password Mismatch',
          text: 'Passwords do not match',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }

      // password should have at least one uppercase letter, one lowercase letter, one digit
      const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
      if (!passwordPattern.test(newPass)) {
        Swal.fire({
          icon: 'warning',
          title: 'Weak Password',
          text: 'Password must contain at least one uppercase letter, one lowercase letter, and one digit',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }



      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to change your password?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'rgb(39,153,137)',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '../backend/derm/derm_change_password.php',
            type: 'POST',
            data: {
              current_password: current,
              new_password: newPass
            },
            success: function(response) {
              const data = JSON.parse(response);
              if (data.status === 'success') {
                closeModal('passwordModal');
                Swal.fire({
                  icon: 'success',
                  title: 'Password Changed!',
                  text: 'Your password has been updated successfully',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message || 'Failed to change password',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              }
            }
          });
        }
      });
    }

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



    // Store the selected file temporarily
let selectedImageFile = null;

// Preview Profile Image
function previewProfileImage(input) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB
    
    // Validate file size
    if (file.size > maxSize) {
      Swal.fire({
        icon: 'error',
        title: 'File Too Large',
        text: 'Please select an image smaller than 5MB',
        confirmButtonColor: 'rgb(39,153,137)'
      });
      input.value = ''; // Clear the input
      return;
    }
    
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid File Type',
        text: 'Please select a JPG, PNG, or GIF image',
        confirmButtonColor: 'rgb(39,153,137)'
      });
      input.value = ''; // Clear the input
      return;
    }
    
    // Store the file for later upload
    selectedImageFile = file;
    
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewImage').src = e.target.result;
      document.getElementById('imagePreviewModal').style.display = 'block';
    };
    reader.readAsDataURL(file);
  }
}

// Close Image Preview Modal
function closeImagePreview() {
  document.getElementById('imagePreviewModal').style.display = 'none';
  document.getElementById('profileImageInput').value = ''; // Clear the file input
  selectedImageFile = null;
}

// Confirm and Upload Image
function confirmUploadImage() {
  if (!selectedImageFile) {
    Swal.fire({
      icon: 'error',
      title: 'No Image Selected',
      text: 'Please select an image first',
      confirmButtonColor: 'rgb(39,153,137)'
    });
    return;
  }
  
  const formData = new FormData();
  formData.append('profile_image', selectedImageFile);
  
  // Close preview modal
  closeImagePreview();
  
  // Show loading
  Swal.fire({
    title: 'Uploading...',
    text: 'Please wait while we upload your image',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
  
  $.ajax({
    url: '../backend/derm/derm_update_profile_image.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      const data = JSON.parse(response);
      if (data.status === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'Profile image updated successfully',
          confirmButtonColor: 'rgb(39,153,137)'
        }).then(() => location.reload());
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.message || 'Failed to upload image',
          confirmButtonColor: 'rgb(39,153,137)'
        });
      }
    },
    error: function() {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Failed to upload image. Please try again.',
        confirmButtonColor: 'rgb(39,153,137)'
      });
    }
  });
}

// Delete Profile Image
function deleteProfileImage() {
  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to remove your profile picture?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: 'rgb(39,153,137)',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, remove it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '../backend/derm/derm_update_profile_image.php',
        type: 'POST',
        data: { action: 'delete' },
        success: function(response) {
          const data = JSON.parse(response);
          if (data.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Removed!',
              text: 'Profile image has been removed',
              confirmButtonColor: 'rgb(39,153,137)'
            }).then(() => location.reload());
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'Failed to remove image',
              confirmButtonColor: 'rgb(39,153,137)'
            });
          }
        }
      });
    }
  });
}

// Close modal when clicking outside
window.onclick = function(event) {
  const imageModal = document.getElementById('imagePreviewModal');
  if (event.target == imageModal) {
    closeImagePreview();
  }
};
  </script>
</body>

</html>