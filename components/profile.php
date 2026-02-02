<?php
session_start();
if (empty($_SESSION["user_id"])) {
  header('Location:../index.php');
  exit();
}
require_once("../backend/config/config.php");

$acc_id = $_SESSION["user_id"];

// Get account details
$details_query = "SELECT ta.ac_id, ta.ac_username, ta.ac_email,
                  td.first_name, td.middle_name, td.last_name, 
                  td.contact, td.gender, td.address
                  FROM tbl_account ta
                  INNER JOIN tbl_account_details td ON ta.ac_id = td.ac_id
                  WHERE ta.ac_id = ?";
$details_stmt = $conn->prepare($details_query);
$details_stmt->bind_param("i", $acc_id);
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
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }

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
      text-decoration: none; 
    }

    .info-value {
      color: #333;
      text-decoration: none;
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

    .swal2-container {
      z-index: 10000 !important;
    }

    .container-fluid {
      padding: 20px;
      max-width: 1400px;
      margin: 0 auto;
    }

    .card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .card-header {
      padding: 15px 20px;
      border-radius: 8px 8px 0 0;
    }

    .card-body {
      padding: 20px;
    }

    .btn {
      padding: 8px 16px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-primary {
      background-color: rgb(39, 153, 137);
      color: white;
    }

    .btn-primary:hover {
      background-color: rgb(30, 120, 110);
    }

    .btn-warning {
      background-color: #ffc107;
      color: #000;
    }

    .btn-warning:hover {
      background-color: #e0a800;
    }

    .btn-danger {
      background-color: #dc3545;
      color: white;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .btn-sm {
      padding: 5px 10px;
      font-size: 14px;
    }

    .text-danger {
      color: #dc3545;
    }

    .text-muted {
      color: #6c757d;
    }

    .mt-2 {
      margin-top: 8px;
    }

    .mt-4 {
      margin-top: 24px;
      font-size: 32px;
      margin-bottom: 50px;
    }

    .mb-3 {
      margin-bottom: 16px;
    }

    .mb-4 {
      margin-bottom: 24px;
    }

    .text-center {
      text-align: center;
    }

    .d-block {
      display: block;
    }

    .row {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -12px;
    }

    .col-md-8 {
      flex: 0 0 100%;
      max-width: 100%;
      padding: 0 12px;
    }

    .col-md-4 {
      flex: 0 0 100%;
      max-width: 100%;
      padding: 0 12px;
    }

    @media (max-width: 768px) {
      .col-md-8,
      .col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
      }
    }

    h1 {
      color: #333;
      font-size: 32px;
      margin-bottom: 8px;
    }

    .breadcrumb {
      background-color: transparent;
      padding: 0;
      margin-bottom: 20px;
      list-style: none;
    }

    .breadcrumb-item {
      display: inline-block;
      color: white !important;
      padding: 6px 12px;
      border-radius: 4px;
    }

    .breadcrumb-item.active {
      color: #495057;
    }
    
  </style>
</head>

<body>
  <?php include "./header-profile.php" ?>

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
              <?php if (!empty($account_details['ac_email'])): ?>
                <div class="info-row">
                  <span class="info-label">Email:</span>
                  <span class="info-value"><?= htmlspecialchars($account_details['ac_email']) ?></span>
                </div>
              <?php endif; ?>
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
      </div>


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
            <input type="text" id="contact" class="form-control" value="<?= htmlspecialchars($account_details['contact'] ?? '') ?>" maxlength="11">
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

  <?php
  if ((!empty($_SESSION["user_id"]))) {
    include "cart.php";
  }
  ?>

  <script src="../scripts/bootstrap.bundle.min.js"></script>
  <script src="../jquery/jquery.js"></script>
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
      if (modalId === 'passwordModal') {
        document.getElementById('passwordForm').reset();
      }
    }

    // Validation functions
    function validateContactNo(contactNo) {
      const contactPattern = /^09\d{9}$/;
      return contactPattern.test(contactNo);
    }

    function validatePassword(password) {
      const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
      return passwordPattern.test(password);
    }

    // Update Personal Information
    function updatePersonalInfo() {
      const firstName = document.getElementById('firstName').value.trim();
      const middleName = document.getElementById('middleName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const gender = document.getElementById('gender').value;
      const contact = document.getElementById('contact').value.trim();
      const address = document.getElementById('address').value.trim();
      const username = '<?= $account_details['ac_username'] ?>';

      if (!firstName || !lastName || !username || !address || !contact) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Information',
          text: 'Please make sure all required fields are filled',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }

      if (!validateContactNo(contact)) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Contact Number',
          text: 'Contact number must be 11 digits long and start with 09',
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
            url: "../backend/user/updateProfile.php",
            method: "POST",
            data: {
              fName: firstName,
              mName: middleName,
              lName: lastName,
              username: username,
              address: address,
              contact: contact,
              password: '',
              confirmPass: ''
            },
            success: function(response) {
              if(response === "empty1") {
                Swal.fire({
                  icon: 'warning',
                  title: 'Empty Fields',
                  text: 'Please make sure all fields are filled',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              } else if(response === "updated") {
                closeModal('personalModal');
                Swal.fire({
                  icon: 'success',
                  title: 'Updated!',
                  text: 'Profile has been updated successfully',
                  confirmButtonColor: 'rgb(39,153,137)'
                }).then(() => location.reload());
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to update information',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Failed to connect to server',
                confirmButtonColor: 'rgb(39,153,137)'
              });
            }
          });
        }
      });
    }

    // Change Password
    function changePassword() {
      const firstName = '<?= $account_details['first_name'] ?>';
      const middleName = '<?= $account_details['middle_name'] ?? '' ?>';
      const lastName = '<?= $account_details['last_name'] ?>';
      const username = '<?= $account_details['ac_username'] ?>';
      const address = '<?= $account_details['address'] ?? '' ?>';
      const contact = '<?= $account_details['contact'] ?? '' ?>';
      const current = document.getElementById('currentPassword').value;
      const newPass = document.getElementById('newPassword').value;
      const confirm = document.getElementById('confirmPassword').value;

      if (!current || !newPass || !confirm) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Information',
          text: 'All password fields are required',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }

      if (!validatePassword(newPass)) {
        Swal.fire({
          icon: 'warning',
          title: 'Weak Password',
          text: 'Password must be at least 8 characters long and include at least one uppercase letter and one lowercase letter',
          confirmButtonColor: 'rgb(39,153,137)'
        });
        return;
      }

      if (newPass !== confirm) {
        Swal.fire({
          icon: 'warning',
          title: 'Password Mismatch',
          text: 'Make sure that your passwords are the same',
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
            url: "../backend/user/updateProfile.php",
            method: "POST",
            data: {
              fName: firstName,
              mName: middleName,
              lName: lastName,
              username: username,
              address: address,
              contact: contact,
              password: current,
              confirmPass: newPass
            },
            success: function(response) {
              if(response === "empty") {
                Swal.fire({
                  icon: 'warning',
                  title: 'Empty Fields',
                  text: 'Current Password or New Password are empty',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              } else if(response === "invalid") {
                Swal.fire({
                  icon: 'error',
                  title: 'Invalid Password',
                  text: 'Invalid current password',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              } else if(response === "updated") {
                closeModal('passwordModal');
                Swal.fire({
                  icon: 'success',
                  title: 'Password Changed!',
                  text: 'Your password has been updated successfully',
                  confirmButtonColor: 'rgb(39,153,137)'
                }).then(() => location.reload());
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to change password',
                  confirmButtonColor: 'rgb(39,153,137)'
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Failed to connect to server',
                confirmButtonColor: 'rgb(39,153,137)'
              });
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

    let selectedImageFile = null;

    function previewProfileImage(input) {
      if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 5 * 1024 * 1024;

        if (file.size > maxSize) {
          Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: 'Please select an image smaller than 5MB',
            confirmButtonColor: 'rgb(39,153,137)'
          });
          input.value = '';
          return;
        }

        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
          Swal.fire({
            icon: 'error',
            title: 'Invalid File Type',
            text: 'Please select a JPG, PNG, or GIF image',
            confirmButtonColor: 'rgb(39,153,137)'
          });
          input.value = '';
          return;
        }

        selectedImageFile = file;

        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('previewImage').src = e.target.result;
          document.getElementById('imagePreviewModal').style.display = 'block';
        };
        reader.readAsDataURL(file);
      }
    }

    function closeImagePreview() {
      document.getElementById('imagePreviewModal').style.display = 'none';
      document.getElementById('profileImageInput').value = '';
      selectedImageFile = null;
    }

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

      closeImagePreview();

      Swal.fire({
        title: 'Uploading...',
        text: 'Please wait while we upload your image',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        url: '../backend/user/user_update_profile_image.php',
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

    // Close modal when clicking outside
    window.onclick = function(event) {
      const personalModal = document.getElementById('personalModal');
      const passwordModal = document.getElementById('passwordModal');
      
      if (event.target == personalModal) {
        closeModal('personalModal');
      }
      if (event.target == passwordModal) {
        closeModal('passwordModal');
      }
    };

    // Restrict contact input to numbers only and max 11 digits
    document.getElementById('contact').addEventListener('input', function(e) {
      this.value = this.value.replace(/\D/g, '').slice(0, 11);
    });
  </script>
</body>

</html>