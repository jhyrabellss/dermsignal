<?php
session_start();
if (empty($_SESSION["admin_id"])) {
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
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
    crossorigin="anonymous"></script>
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
            <li class="breadcrumb-item active">Products</li>
          </ol>

          <div class="card mb-5">
            <div class="card-header bg-primary pt-3">
              <div class="text-center">
                <p class="card-title text-light">List Products
              </div>
            </div>
            <div class="card-body">
              <table id="residenceAccounts" class="table table-striped nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>Product Id</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Stocks</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($_GET['type'])) {
                    $prodId = intval($_GET["type"]);
                    $query = "SELECT * FROM tbl_products WHERE concern_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $prodId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($data = $result->fetch_assoc()) {
                  ?>
                      <tr class="product-row" data-prod-id="<?php echo $data['prod_id']; ?>" data-prod-name="<?php echo $data['prod_name']; ?>">
                        <td><?php echo $data['prod_id']; ?></td>
                        <td>
                          <?php
                          if ($data["prod_img"] != null || $data["prod_img"] != "") {
                          ?>
                            <img src="../images/products/<?php echo $data['prod_img']; ?>" alt="Product Image" width="50" height="50">
                          <?php
                          } else {
                          ?>
                            <div>No Image Available</div>
                          <?php
                          }
                          ?>
                        </td>
                        <td><?php echo $data['prod_name']; ?></td>
                        <td>₱<?php echo number_format($data['prod_price'], 2); ?></td>
                        <td><?php echo $data['prod_stocks']; ?></td>
                        <td>
                          <button type="button" class="btn btn-primary" id="<?php echo $data["prod_id"] ?>" data-bs-toggle="modal" data-bs-target="#residenceAccountDetails<?php echo $data["prod_id"] ?>" data-bs-whatever="@getbootstrap">
                            <i class="fa-solid fa-pen-to-square" style="color: #fcfcfc;"></i>
                          </button>
                        </td>
                      </tr>
                      <div class="modal fade" id="residenceAccountDetails<?php echo $data["prod_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                  <label class="col-form-label">Product Image</label>
                                  <div class="mb-2">
                                    <?php if ($data["prod_img"] != null && $data["prod_img"] != "") { ?>
                                      <img src="../images/products/<?php echo $data['prod_img']; ?>" alt="Product Image" width="100" height="100" class="border">
                                    <?php } else { ?>
                                      <div class="text-muted">No Image Available</div>
                                    <?php } ?>
                                  </div>
                                  <input type="file" class="form-control updatedImage" accept="image/*">
                                </div>
                                <div class="mb-3">
                                  <label class="col-form-label">Product Hover Image</label>
                                  <div class="mb-2">
                                    <?php if ($data["prod_hover_img"] != null && $data["prod_hover_img"] != "") { ?>
                                      <img src="../images/products-hover/<?php echo $data['prod_hover_img']; ?>" alt="Hover Image" width="100" height="100" class="border">
                                    <?php } else { ?>
                                      <div class="text-muted">No Hover Image Available</div>
                                    <?php } ?>
                                  </div>
                                  <input type="file" class="form-control updatedHoverImage" accept="image/*">
                                </div>
                                <div class="mb-3">
                                  <label class="col-form-label">Product Name</label>
                                  <input type="text" class="form-control updatedName" value="<?php echo $data["prod_name"]; ?>">
                                </div>
                                <div class="mb-3">
                                  <label class="col-form-label">Product Price</label>
                                  <input type="number" class="form-control updatedPrice" value="<?php echo $data["prod_price"]; ?>">
                                </div>
                                <div class="mb-3">
                                  <label class="col-form-label">Product Description</label>
                                  <input type="text" class="form-control updatedDescription" value="<?php echo $data["prod_description"]; ?>">
                                </div>
                                <div class="mb-3">
                                  <label class="col-form-label">Product Stocks</label>
                                  <input type="number" class="form-control updatedStocks" value="<?php echo $data["prod_stocks"]; ?>" min="1">
                                </div>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary btn-accept updateResBtn" value="<?php echo $data["prod_id"] ?>">
                                Save
                              </button>
                              <button type="button" class="btn btn-secondary " value="<?php echo $data["prod_id"]; ?>" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
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
  <script src="../scripts/bootstrap.bundle.min.js"></script>
  <script src="../scripts/jquery.js"></script>
  <script src="../scripts/toggle.js"></script>
  <script src="../jquery/modifyProd.js"></script>
  <!-- DataTables Scripts -->
  <script src="../plugins/js/jquery.dataTables.min.js"></script>
  <script src="../plugins/js/dataTables.bootstrap5.min.js"></script>
  <script src="../plugins/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/js/responsive.bootstrap5.min.js"></script>
  <!-- DataTables Buttons JavaScript -->
  <script src="../scripts/dataTables.js"></script>
  <script src="../scripts/ajax.make.min.js"></script>
  <script src="../scripts/ajax.fonts.js"></script>
  <script src="../scripts/dtBtn.html5.js"></script>
  <script>
    $(document).ready(function() {
      $('#residenceAccounts').DataTable({
        responsive: true,
        order: [
          [0, 'desc']
        ],
      });
    });
  </script>
  <script src="../jquery/sideBarProd.js"></script>
</body>

</html>