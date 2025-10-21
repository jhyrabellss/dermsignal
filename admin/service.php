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
    <title>Admin Panel</title>
    <!-- DataTables -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../styles/dataTables.min.css">
    <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../styles/bootsrap5-min.css">
    <link rel="stylesheet" href="../styles/card-general.css">
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
              <li class="breadcrumb-item active">Services</li>
            </ol>

              <div class="card mb-5">
                    <div class="card-header bg-info pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">Services
                        </div>
                    </div>
                    <div class="card-body">
                      <table id="residenceAccounts" class="table table-striped nowrap" style="width:100%">
                        <thead>
                          <tr>
                              <th> Id</th>
                              <th>Service Name</th>
                              <th>Service Price / Session</th>
                              <th>Sessions</th>
                              <th>Procedure & Benifits</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(isset($_GET['service'])){
                                $service_group = $_GET["service"];
                                $query = "SELECT * FROM tbl_services WHERE service_group = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $service_group);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($data = $result->fetch_assoc()) {
                          ?>
                          <tr class="product-row" data-prod-id="<?php echo $data['service_id']; ?>" data-prod-name="<?php echo $data['prod_name']; ?>">
                              <td><?php echo $data['service_id']; ?></td>
                              <td><?php echo $data['service_name']; ?></td>
                              <td>₱<?php echo number_format($data['service_price'], 2); ?></td>
                              <td><?php echo $data['sessions']; ?></td>
                            <td><?php echo $data['procedure_benefits']; ?></td>
                              <td>
                                  <button type="button" class="btn btn-primary" id="<?php echo $data["service_id"] ?>" data-bs-toggle="modal" data-bs-target="#residenceAccountDetails<?php echo $data["service_id"] ?>" data-bs-whatever="@getbootstrap">
                                      <i class="fa-solid fa-pen-to-square" style="color: #fcfcfc;"></i>
                                  </button>

                                  <button type="button" class="btn btn-danger delete-btn" id="<?php echo $data["service_id"] ?>">
                                    <i class="fa-solid fa-trash" style="color: #fcfcfc;"></i>
                                </button>
                              </td>
                          </tr>
                            <div class="modal fade" id="residenceAccountDetails<?php echo $data["service_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Service Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                  <form method="post">
                                    <div class="mb-3">
                                      <label class="col-form-label">Service Name</label>
                                      <input type="text" class="form-control updatedName" value="<?php echo $data["service_name"]; ?>" >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Service Price</label>
                                      <input type="number" class="form-control updatedPrice" value="<?php echo $data["service_price"]; ?>" >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Procedure Benefits</label>
                                      <input type="text" class="form-control updatedBenefits" value="<?php echo $data["procedure_benefits"]; ?>" >
                                    </div>
                                    <div class="mb-3">
                                      <label class="col-form-label">Service Sessions</label>
                                      <input type="number" class="form-control updatedSessions" value="<?php echo $data["sessions"]; ?>" min="1">
                                    </div>

                                    <!-- display image -->
                                    <?php 
                                        if (!empty($data["service_image"])){
                                    ?>
                                    <div class="mb-3">
                                      <label class="col-form-label">Current Service Image</label><br>
                                      <img src="../backend/images/services/<?=  $data["service_image"]; ?>" alt="Service Image" style="max-width: 100%; height: auto;">
                                    </div>
                                    <?php }else{ ?>
                                    <div class="mb-3">
                                      <label class="col-form-label">No Image Available</label>
                                    </div>
                                    <?php } ?>

                                    <!-- image update -->
                                    <div class="mb-3">
                                      <label class="col-form-label">Update Service Image</label>
                                      <input type="file" class="form-control updatedImage" accept="image/*">
                                    </div>
                                  </form>
                                  </div>
                                  <div class="modal-footer">
                                  <button type="button" class="btn btn-primary btn-accept updateResBtn" value="<?php echo $data["service_id"] ?>" >
                                      Save
                                  </button>
                                    <button type="button" class="btn btn-secondary " value="<?php echo $data["service_id"]; ?>" data-bs-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php
                            } }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
      </main>
    </div>
  </div>
    <script>
    $('.delete-btn').on('click', function() {

            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: '../backend/admin/delete_service.php',
                    type: 'POST',
                    data: { service_id: this.id },
                    success: function(response) {
                        if (response.trim() === 'success') {
                        Swal.fire(
                            'Deleted!',
                            'The service has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                        } else {
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the service.',
                            'error'
                        );
                        }
                    },
                    error: function() {
                        Swal.fire(
                        'Error!',
                        'There was an error processing your request.',
                        'error'
                        );
                    }
                })
              }
            });
          });
  </script>
  <script src="../scripts/bootstrap.bundle.min.js"></script>
  <script src="../scripts/jquery.js"></script>
  <script src="../scripts/toggle.js"></script>
  <script src="../jquery/modifyService.js"></script>
  <!-- DataTables Scripts -->
  <script src="../plugins/js/jquery.dataTables.min.js"></script>
  <script src="../plugins/js/dataTables.bootstrap5.min.js"></script>
  <script src="../plugins/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/js/responsive.bootstrap5.min.js"></script>

  <script>
      $(document).ready(function() {
          $('#residenceAccounts').DataTable({
              responsive: true,
              order: [[0, 'desc']],
          });

          
      });
  </script>
  <script src="../jquery/sideBarProd.js"></script>
</body>
</html>
