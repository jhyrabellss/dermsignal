<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
      <div class="nav">
        <div class="sb-sidenav-menu-heading">Main</div>
        <!-- Link manipulation -->
        <a class="nav-link" href="index.php">
          <div class="sb-nav-link-icon">
            <i class="fas fa-tachometer-alt"></i>
          </div>
          Dashboard
        </a>
        <div class="sb-sidenav-menu-heading">Modify</div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmployeeProducts" aria-expanded="false" aria-controls="collapseEmployeeProducts">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-utensils"></i>
          </div>
          Products List
          <div class="sb-sidenav-collapse-arrow">
            <i class="fas fa-angle-down"></i>
          </div>
        </a>
        <div class="collapse" id="collapseEmployeeProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <?php
                $query = "SELECT * FROM tbl_concern";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                while($data = $result->fetch_assoc()){
                    $prodId = $data["concern_id"];
                    $prodName = $data["concern_name"];
            ?>
            <nav class="sb-sidenav-menu-nested nav" data-type-id="<?php echo $prodId; ?>">
                <a class="nav-link prod-type" data-type-id="<?php echo $prodId; ?>" href="#"><?php echo $prodName; ?></a>
            </nav>
            <?php } ?>
            <nav class="sb-sidenav-menu-nested nav">
              <a  class="nav-link" href="addprod.php">Add Product</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEmployeeAccounts" aria-expanded="false" aria-controls="collapseEmployeeAccounts">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-user"></i>
          </div>
          Account List
          <div class="sb-sidenav-collapse-arrow">
            <i class="fas fa-angle-down"></i>
          </div>
        </a>
        <div class="collapse" id="collapseEmployeeAccounts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="customers.php">Active</a>
          </nav>
          <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="deactivated.php">Deactivated</a>
          </nav>
        </div>
        <a class="nav-link" href="reports.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-hand-holding-dollar"></i>
          </div>
          Feedbacks
        </a>

        <div class="sb-sidenav-menu-heading">Report </div>
        <a class="nav-link" href="auditLogs.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-person-walking"></i>
          </div>
          Audit Logs
        </a>
        <a class="nav-link" href="auditTrail.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-chart-line"></i>
          </div>
          Audit Trail
        </a>
        <a class="nav-link" href="transHistory.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-clock-rotate-left"></i>
          </div>
          Transaction History
        </a>

        <div class="sb-sidenav-menu-heading">Manage Orders</div>
        <a class="nav-link" href="tableReceipts.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-receipt"></i>
          </div>
          Receipts
        </a>
        <a class="nav-link" href="tableOrders.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-book"></i>
          </div>
          Manage Orders
        </a>
        <a class="nav-link" href="claimedOrders.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-clipboard-check"></i>
          </div>
          Delivered Orders
        </a>

        <a class="nav-link" href="cancelledOrders.php">
          <div class="sb-nav-link-icon">
            <i class="fa-solid fa-ban"></i>
          </div>
          Cancelled Orders
        </a>


      </div>
    </div>
  </nav>
</div>


