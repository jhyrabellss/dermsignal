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
              <li class="breadcrumb-item active">Add Services</li>
            </ol>

                <div class="card mb-5">
                    <div class="card-header bg-secondary pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">Add Services <i class="fas fa-plus"></i></p>
                        </div>
                    </div>
                    <div class="card-body">
                    <form class="row g-3" method="post" id="addService">
                        <h5 class="text-center">Service Details</h5>
                        <hr>
                            <div class="col-md-4">
                                <label for="service_name" class="form-label">Service Name</label>
                                <input type="text" class="form-control" id="service_name" >
                            </div>

                            <div class="col-md-4">
                                <label for="service_price" class="form-label">Service Price</label>
                                <input type="text" class="form-control" id="service_price" oninput="validateNumberInput(this)">
                            </div>

                            <!-- number of sessions -->
                            <div class="col-md-4">
                                <label for="sessions" class="form-label">Number of Sessions</label>
                                <input type="number" class="form-control" id="sessions" min="1">
                            </div>

                            <div class="col-md-4">
                                <label for="procedure_benefits" class="form-label">
                                    Procedure Benefits
                                </label>
                                <input type="text" class="form-control" id="procedure_benefits">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="service_group" class="form-label">Service Group</label>
                                <select id="service_group" class="form-select">
                                    <option value="" disabled selected>Select Service Group</option>
                                    <?php
                                      $query = "SELECT service_group FROM tbl_services GROUP BY service_group";
                                      $stmt = $conn->prepare($query);
                                      $stmt->execute();
                                      $result = $stmt->get_result();
                                      while($data = $result->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $data["service_group"]; ?>">
                                      <?php echo $data["service_group"];  ?>    
                                    </option>
                                    <?php } ?>
                                </select>      
                            </div>


                            <div class="col-md-4">
                                <label for="service_image" class="form-label">
                                    Service Image
                                </label>
                                <input type="file" class="form-control" id="service_image" accept="image/*">
                            </div>

                            

                            <div class="col-12 text-center mb-4 mt-5">
                                <button type="submit" id="submit" class="btn btn-primary btn-lg">Add Service</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
      </main>
    </div>
  </div>

<script>
function validateNumberInput(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}
</script>
  <script
      src="../scripts/bootstrap.bundle.min.js"
    ></script>
    <script src="../scripts/jquery.js"></script>
    <script src="../scripts/toggle.js"></script>
    <script src="../jquery/addService.js"></script>
    <!-- DataTables Scripts -->
    <script src="../plugins/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/js/dataTables.bootstrap5.min.js"></script>
    <script src="../plugins/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/js/responsive.bootstrap5.min.js"></script>



<script src="../jquery/sideBarProd.js"></script> 
  </body>
</html>
