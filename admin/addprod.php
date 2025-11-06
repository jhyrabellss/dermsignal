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
              <li class="breadcrumb-item active">Add Product</li>
            </ol>

                <div class="card mb-5">
                    <div class="card-header bg-secondary pt-3">
                        <div class="text-center">
                            <p class="card-title text-light">Add Product <i class="fas fa-plus"></i></p>
                        </div>
                    </div>
                    <div class="card-body">
                    <form class="row g-3" method="post" id="addProd">
                        <h5 class="text-center">Product Details</h5>
                        <hr>
                            <div class="col-md-4">
                                <label for="prod_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="prod_name" >
                            </div>

                            <div class="col-md-4">
                                <label for="prod_price" class="form-label">Product Price</label>
                                <input type="text" class="form-control" id="prod_price" oninput="validateNumberInput(this)">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="prod_concern" class="form-label">Product Concern</label>
                                <select id="prod_concern" class="form-select">
                                    <option value="" disabled selected>Select Product</option>
                                    <?php
                                      $query = "SELECT * FROM tbl_concern";
                                      $stmt = $conn->prepare($query);
                                      $stmt->execute();
                                      $result = $stmt->get_result();
                                      while($data = $result->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $data["concern_id"]; ?>">
                                      <?php echo $data["concern_name"];  ?>    
                                    </option>
                                    <?php } ?>
                                </select>      
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="prod_ingredients" class="form-label">Product Ingredients</label>
                                <select id="prod_ingredients" class="form-select">
                                    <option value="" disabled selected>Select Product</option>
                                    <?php
                                      $query = "SELECT * FROM tbl_ingredients";
                                      $stmt = $conn->prepare($query);
                                      $stmt->execute();
                                      $result = $stmt->get_result();
                                      while($data = $result->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $data["ingredients_id"]; ?>">
                                      <?php echo $data["ingredient_name"];  ?>    
                                    </option>
                                    <?php } ?>
                                </select>      
                            </div>
              
                            <div class="col-md-4">
                                <label for="prod_stocks" class="form-label">Product Stocks</label>
                                <input type="text" class="form-control" id="prod_stocks" oninput="validateNumberInput(this)">
                            </div>
                            <div class="col-md-4">
                                <label for="prod_img" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="prod_img">
                            </div>

                            <div class="col-md-4">
                                <label for="prod_hover_img" class="form-label">Product Hover Image</label>
                                <input type="file" class="form-control" id="prod_hover_img">
                            </div>

                            

                            <div class="col-12 text-center mb-4 mt-5">
                                <button type="submit" id="submit" class="btn btn-primary btn-lg">Add Product</button>
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
    <script src="../jquery/addprod.js"></script>
    <!-- DataTables Scripts -->
    <script src="../plugins/js/jquery.dataTables.min.js"></script>
    <script src="../plugins/js/dataTables.bootstrap5.min.js"></script>
    <script src="../plugins/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/js/responsive.bootstrap5.min.js"></script>



<script src="../jquery/sideBarProd.js"></script> 
  </body>
</html>
