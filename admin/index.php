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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/dataTables.min.css">
    <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../styles/bootsrap5-min.css">
    <link rel="stylesheet" href="../styles/card-general.css">
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
              <h1 class="mt-4" id='full_name'>Admin</h1>
              <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>

              <div class="row">
            
            <div class="c-dashboardInfo col-xl-3 col-md-6">
              <div class="wrap">
                <h4
                  class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title"
                >
                <?php
                  $query5 = "SELECT SUM(tp.prod_price * tc.prod_qnty) AS total_sales FROM tbl_cart tc 
                  INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                  WHERE status_id = 2;";
                  $stmt5 = $conn->prepare($query5);
                  $stmt5->execute();
                  $result5 = $stmt5->get_result();
                  $data5 = $result5->fetch_assoc();
                ?>
                  Total Sales
                </h4>
                <span class='hind-font caption-12 c-dashboardInfo__count'>₱<?php echo $data5["total_sales"] != 0 ? number_format($data5["total_sales"], 2) : "0.00"; ?></span>
              </div>
            </div>

            <div class="c-dashboardInfo col-xl-3 col-md-6">
              <div class="wrap">
                <h4
                  class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title"
                >
                <?php
                  $query6 = "SELECT COUNT(prod_id) AS total_claimed FROM tbl_cart WHERE status_id = 2";
                  $stmt6 = $conn->prepare($query6);
                  $stmt6->execute();
                  $result6 = $stmt6->get_result();
                  $data6 = $result6->fetch_assoc();
                ?>
                  Order Claimed
                </h4>
                <span class='hind-font caption-12 c-dashboardInfo__count'><?php echo $data6["total_claimed"] ?></span>
              </div>
            </div>

            <div class="c-dashboardInfo col-xl-3 col-md-6">
              <div class="wrap">
                <h4
                  class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title"
                >
                <?php
                  $query7 = "SELECT COUNT(prod_id) AS total_pending FROM tbl_cart WHERE status_id = 3";
                  $stmt7 = $conn->prepare($query7);
                  $stmt7->execute();
                  $result7 = $stmt7->get_result();
                  $data7 = $result7->fetch_assoc();
                ?>
                  Pending Orders
                </h4>
                <span class='hind-font caption-12 c-dashboardInfo__count'><?php echo $data7["total_pending"] != 0 ? $data7["total_pending"] : "0"; ?></span>
              </div>
            </div>

            <div class="c-dashboardInfo col-xl-3 col-md-6">
              <div class="wrap">
                <h4
                  class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title"
                >
                <?php
                  $query8 = "SELECT COUNT(prod_id) AS total_claim FROM tbl_cart WHERE status_id = 4";
                  $stmt8 = $conn->prepare($query8);
                  $stmt8->execute();
                  $result8 = $stmt8->get_result();
                  $data8 = $result8->fetch_assoc();
                ?>
                  Out for delivery
                </h4>
                <span class='hind-font caption-12 c-dashboardInfo__count'><?php echo $data8["total_claim"] ?></span>
              </div>
            </div>

            <div class="row">
                <!-- Barangay Clearance Start of graph -->
                <!-- Barangay Clearance Start of graph -->
<div class="col-md m-1">
    <div class="card">
          <div class="card-header bg-primary pt-3 "  style="background-color:  rgb(39,153,137) !important;">
              <div class="text-center">
                  <p class="card-title text-light">Sales Graph</p>
              </div>
          </div>
          <div class="card-header text-center d-flex justify-content-center flex-wrap indiv-card" style="gap: 10px;  ">
              <div class="d-flex flex-column">
                  <p>Start date</p>
                  <input onchange="filterData(reqbcstartdate, reqbcenddate, chartBcRequest, serviceRequestBcCount, monthlyBcHold, configRequestBc, dataBcReq)" type="month" id="reqbcstartdate">
              </div>
              <div class="d-flex flex-column">
                  <p>End date</p>
                  <input onchange="filterData(reqbcstartdate, reqbcenddate, chartBcRequest, serviceRequestBcCount, monthlyBcHold, configRequestBc, dataBcReq)" type="month" id="reqbcenddate">
              </div>
          </div>
          <div class="card-body">
              <?php
              date_default_timezone_set('Asia/Manila');
              $monthlyBc = [];
              $serviceRequestBcCount = [];
              $monthlyBcRequest = mysqli_query($conn, "SELECT SUM(tc.prod_qnty * tp.prod_price) AS serviceRequestBcCount, DATE_FORMAT(tc.order_date, '%M %Y') AS Dates FROM tbl_cart tc INNER JOIN tbl_products tp ON tp.prod_id = tc.prod_id WHERE status_id = 2 AND (tc.order_date IS NOT NULL AND tc.order_date != '0000-00-00') GROUP BY DATE_FORMAT(tc.order_date, '%Y-%m')");
              foreach ($monthlyBcRequest as $data) {
                  $monthlyBc[] = $data['Dates'];
                  $serviceRequestBcCount[] = $data['serviceRequestBcCount'];
              }
              ?>
              <div>
                  <canvas id="chartBcRequest"></canvas>
              </div>
          </div>
  </div>
</div>
<!-- Barangay Clearance End of graph -->
<!-- Certificate of Indigency Start of graph -->
                
                <div class="col-md m-1">
                  <div class="card" style="height:500px; overflow: auto;">
                    <div class="text-center mt-3">
                            <p class="card-title">Products List & Price</p>
                    </div>
                    <div class="card-body">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                              <th>Product Id</th>
                              <th>Product Name</th>
                              <th>Product Price</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            $query = "SELECT * FROM tbl_products"; 
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($data = $result->fetch_assoc()) {
                        ?>
                          <tr>
                            <td><?php echo $data['prod_id'];?></td>
                            <td><?php echo $data['prod_name'];?></td>
                            <td>₱<?php echo number_format($data['prod_price'], 2);?></td>
                          </tr>
                        <?php 
                            }
                        ?>
                        </tbody>
                      </table>
                  </div>
                </div>
                </div>
              </div>



<script src="../scripts/bootstrap.bundle.min.js"></script>
<script src="../scripts/jquery.js"></script>
<script src="../scripts/toggle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- 
<script>
    const full_name = document.getElementById('full_name');
    const acc_data = JSON.parse(localStorage.getItem('adminDetails'));
    full_name.innerText = 'Admin, ' + acc_data.full_name;
</script> -->

<script>
    // Note: Barangay Clearance Request Variables
    const monthlyBc = <?php echo json_encode($monthlyBc); ?>;
    const serviceRequestBcCount = <?php echo json_encode($serviceRequestBcCount); ?>;
    const monthlyBcHold = [...monthlyBc];
    const serviceRequestBcCountHold = [...serviceRequestBcCount];

    // Note: Request Maps
    const dateMaps = new Map([
        [1, 'January'], [2, 'February'], [3, 'March'], [4, 'April'], [5, 'May'],
        [6, 'June'], [7, 'July'], [8, 'August'], [9, 'September'], [10, 'October'],
        [11, 'November'], [12, 'December']
    ]);

    // Note: Barangay Clearance Request Data
    const dataBcReq = {
        labels: monthlyBc,
        datasets: [{
            label: 'Sales Count Monthly',
            data: serviceRequestBcCount,
            backgroundColor: [
                'rgba(255, 26, 104, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
                'rgba(0, 0, 0, 0.2)'
            ],
            borderColor: [
                'rgba(255, 26, 104, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
                'rgba(0, 0, 0, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Note: Barangay Clearance Request Config
    const configRequestBc = {
        type: 'bar',
        data: dataBcReq,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMin: 0,
                    suggestedMax: 30
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    };

    // Note: Barangay Clearance Request Chart
    const chartBcRequest = new Chart(
        document.getElementById('chartBcRequest'),
        configRequestBc
    );


    // Note: Request Filtering
    function filterData(start, end, chart, datapoint2, month2, config, dataConfig) {
    const startDateArr = start.value.split('-');
    const endDateArr = end.value.split('-');

    // Parse start and end dates into year and month parts
    const startYear = Number(startDateArr[0]);
    const startMonth = Number(startDateArr[1]);

    const endYear = Number(endDateArr[0]);
    const endMonth = Number(endDateArr[1]);

    const filteredLabels = [];
    const filteredData = [];

    // Loop through years and months
    for (let year = startYear; year <= endYear; year++) {
        let monthStart = year === startYear ? startMonth : 1; // Start from the starting month for the start year
        let monthEnd = year === endYear ? endMonth : 12; // End at the ending month for the end year

        for (let month = monthStart; month <= monthEnd; month++) {
            const label = `${dateMaps.get(month)} ${year}`;
            
            // Only add the label if it exists in the dataset (month2 array)
            if (month2.includes(label)) {
                filteredLabels.push(label);

                // Find the index of the label and push the corresponding data point
                const index = month2.indexOf(label);
                if (index !== -1) {
                    filteredData.push(datapoint2[index]);
                }
            }
        }
    }

    // Update the chart with filtered labels and data
    chart.config.data.labels = filteredLabels;
    chart.config.data.datasets[0].data = filteredData;
    chart.update();
}

</script>

<!-- Employee per role counter -->
<script>
    $(function() {
        const pieChartCanvas = $('#employeePerRoleCount').get(0).getContext('2d');
        const donutData = {
            labels: ['User', 'Admin', 'Cashier'],
            datasets: [{
                data: [<?php echo $countOfSecretary; ?>, <?php echo $countOfBrgyCapt; ?>, <?php echo $countOfCashier; ?>],
                backgroundColor: ['#00d4ff', '#fd1d1d', '#eeaeca']
            }]
        };
        const pieOptions = {
            maintainAspectRatio: false,
            responsive: true
        };
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: donutData,
            options: pieOptions
        });
    });
</script>

<script src="../jquery/sideBarProd.js"></script>

  </body>
</html>
