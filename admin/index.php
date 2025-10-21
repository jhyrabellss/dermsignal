<?php
session_start();
if (empty($_SESSION["admin_id"])) {
  header('Location:logout.php');
}
require_once("../backend/config/config.php");

// Fetch dermatologists for filter
$derm_query = "SELECT derm_id, derm_name FROM tbl_dermatologists WHERE derm_status = 'Active'";
$derm_result = $conn->query($derm_query);
$dermatologists = [];
while ($derm = $derm_result->fetch_assoc()) {
  $dermatologists[] = $derm;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Admin Dashboard - Analytics & Reports</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../styles/dataTables.min.css">
  <link rel="stylesheet" href="../plugins/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../styles/bootsrap5-min.css">
  <link rel="stylesheet" href="../styles/card-general.css">
  <style>
    .analytics-card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .filter-section {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
      border: 1px solid #dee2e6;
    }

    .chart-container {
      position: relative;
      height: 400px;
    }

    .table-responsive {
      max-height: 500px;
      overflow-y: auto;
    }

    .trend-up {
      color: #28a745;
    }

    .trend-down {
      color: #dc3545;
    }

    .forecast-badge {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.85rem;
    }

    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #333;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <?php require_once("./navbar.php"); ?>
  <div id="layoutSidenav">
    <?php require_once("./sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Sales Analytics & Reports</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>

          <!-- Summary Cards (No Filter) -->
          <div class="row">
            <?php
            // Total Sales (Products) - Calculate with discounts
            $prod_sales_query = "SELECT 
                SUM((tp.prod_price + 100) * (1 - tp.prod_discount/100) * tc.prod_qnty) AS subtotal
                FROM tbl_cart tc 
                INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                WHERE status_id = 2";
            $prod_sales_result = $conn->query($prod_sales_query);
            $prod_subtotal = $prod_sales_result->fetch_assoc()['subtotal'] ?? 0;

            // Calculate online discount (5%)
            $online_discount = $prod_subtotal * 0.05;

            // Calculate total voucher discounts for products
            $voucher_discount_query = "SELECT IFNULL(SUM(discount_amount), 0) as total_voucher_discount
                                      FROM tbl_voucher_usage
                                      WHERE order_type = 'product'";
            $voucher_result = $conn->query($voucher_discount_query);
            $voucher_discount = $voucher_result->fetch_assoc()['total_voucher_discount'] ?? 0;

            // Final product sales after all discounts
            $prod_sales = $prod_subtotal - $online_discount - $voucher_discount;

            // Total Sales (Services) - with voucher discounts
            $service_subtotal_query = "SELECT SUM(ts.service_price) AS subtotal
                                      FROM tbl_appointments ta 
                                      INNER JOIN tbl_services ts ON ta.service_id = ts.service_id
                                      WHERE appointment_status = 'Completed'";
            $service_subtotal_result = $conn->query($service_subtotal_query);
            $service_subtotal = $service_subtotal_result->fetch_assoc()['subtotal'] ?? 0;

            // Calculate service voucher discounts
            $service_voucher_query = "SELECT IFNULL(SUM(discount_amount), 0) as total_voucher_discount
                                      FROM tbl_voucher_usage
                                      WHERE order_type = 'service'";
            $service_voucher_result = $conn->query($service_voucher_query);
            $service_voucher_discount = $service_voucher_result->fetch_assoc()['total_voucher_discount'] ?? 0;

            // Final service sales after voucher discounts
            $service_sales = $service_subtotal - $service_voucher_discount;

            // Total sales combining products and services
            $total_sales = $prod_sales + $service_sales;

            // Total discounts given
            $total_discounts = $online_discount + $voucher_discount + $service_voucher_discount;

            // Orders Stats
            $completed_orders = $conn->query("SELECT COUNT(*) as cnt FROM tbl_cart WHERE status_id = 2")->fetch_assoc()['cnt'];
            $pending_orders = $conn->query("SELECT COUNT(*) as cnt FROM tbl_cart WHERE status_id = 3")->fetch_assoc()['cnt'];
            ?>

            <div class="col-xl-3 col-md-6">
              <div class="c-dashboardInfo">
                <div class="wrap">
                  <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    Total Revenue
                  </h4>
                  <span class='hind-font caption-12 c-dashboardInfo__count'>₱<?php echo number_format($total_sales, 2); ?></span>
                  <small class="text-muted">Products + Services</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="c-dashboardInfo">
                <div class="wrap">
                  <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    Product Sales
                  </h4>
                  <span class='hind-font caption-12 c-dashboardInfo__count'>₱<?php echo number_format($prod_sales, 2); ?></span>
                  <small class="text-muted"><?php echo $completed_orders; ?> Completed Orders</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="c-dashboardInfo">
                <div class="wrap">
                  <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    Service Sales
                  </h4>
                  <span class='hind-font caption-12 c-dashboardInfo__count'>₱<?php echo number_format($service_sales, 2); ?></span>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="c-dashboardInfo">
                <div class="wrap">
                  <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    Pending Orders
                  </h4>
                  <span class='hind-font caption-12 c-dashboardInfo__count'><?php echo $pending_orders; ?></span>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="c-dashboardInfo">
                <div class="wrap">
                  <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">
                    Total Discounts Given
                  </h4>
                  <span class='hind-font caption-12 c-dashboardInfo__count'>₱<?php echo number_format($total_discounts, 2); ?></span>
                  <small class="text-muted">Vouchers + Online Discount</small>
                </div>
              </div>
            </div>


          </div>

          <!-- Sales Trend Chart Section with Filter -->
          <div class="row mt-4">
            <div class="col-lg-8">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-chart-line"></i> Sales Trend Analysis</h5>

                <!-- Filter for Sales Trend -->
                <div class="filter-section">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="form-label">Period:</label>
                      <select class="form-select form-select-sm" id="trendFilterType">
                        <option value="year" selected>Yearly</option>
                        <option value="month">Monthly</option>
                        <option value="day">Daily</option>
                      </select>
                    </div>
                    <div class="col-md-4" id="trendDateContainer">
                      <label class="form-label">Select Year:</label>
                      <input type="number" class="form-control form-control-sm" id="trendFilterDate"
                        value="<?php echo date('Y'); ?>" min="2020" max="<?php echo date('Y'); ?>">
                      <small class="text-muted d-block">Showing last 5 years trend</small>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">&nbsp;</label>
                      <button class="btn btn-primary btn-sm w-100" onclick="updateSalesTrendChart()">
                        <i class="fas fa-sync"></i> Update
                      </button>
                    </div>
                  </div>
                </div>

                <div class="chart-container">
                  <canvas id="salesTrendChart"></canvas>
                </div>
              </div>
            </div>

            <!-- Top Products Section with Filter -->
            <div class="col-lg-4">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-trophy"></i> Top Products</h5>

                <!-- Filter for Top Products -->
                <div class="filter-section">
                  <div class="row">
                    <div class="col-12">
                      <label class="form-label">Period:</label>
                      <select class="form-select form-select-sm" id="topProductsFilter" onchange="updateTopProducts()">
                        <option value="all" selected>All Time</option>
                        <option value="month">This Month</option>
                        <option value="week">This Week</option>
                        <option value="today">Today</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="table-responsive" id="topProductsTable">
                  <!-- Content will be loaded via AJAX -->
                </div>
              </div>
            </div>
          </div>

          <!-- Service Performance Section with Filter -->
          <div class="row mt-4">
            <div class="col-lg-6">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-stethoscope"></i> Service Performance</h5>

                <!-- Filter for Service Performance -->
                <div class="filter-section">
                  <div class="row">
                    <div class="col-md-6">
                      <label class="form-label">Period:</label>
                      <select class="form-select form-select-sm" id="serviceFilter" onchange="updateServicePerformance()">
                        <option value="all" selected>All Time</option>
                        <option value="month">This Month</option>
                        <option value="week">This Week</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Service Group:</label>
                      <select class="form-select form-select-sm" id="serviceGroupFilter" onchange="updateServicePerformance()">
                        <option value="all" selected>All Groups</option>
                        <?php
                        $group_query = "SELECT DISTINCT service_group FROM tbl_services";
                        $group_result = $conn->query($group_query);
                        while ($group_row = $group_result->fetch_assoc()) {
                          echo '<option value="' . $group_row['service_group'] . '">' . $group_row['service_group'] . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="table-responsive" id="servicePerformanceTable">
                  <!-- Content will be loaded via AJAX -->
                </div>
              </div>
            </div>

            <!-- Dermatologist Performance Section with Filter -->
            <div class="col-lg-6">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-user-md"></i> Dermatologist Performance</h5>

                <!-- Filter for Dermatologist Performance -->
                <div class="filter-section">
                  <div class="row">
                    <div class="col-md-6">
                      <label class="form-label">Period:</label>
                      <select class="form-select form-select-sm" id="dermFilter" onchange="updateDermPerformance()">
                        <option value="all" selected>All Time</option>
                        <option value="month">This Month</option>
                        <option value="week">This Week</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Dermatologist:</label>
                      <select class="form-select form-select-sm" id="dermSelect" onchange="updateDermPerformance()">
                        <option value="all" selected>All</option>
                        <?php foreach ($dermatologists as $derm): ?>
                          <option value="<?php echo $derm['derm_id']; ?>">
                            <?php echo $derm['derm_name']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="chart-container" style="height: 300px;">
                  <canvas id="dermPerformanceChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Forecasting Section (No Filter) -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-crystal-ball"></i> Sales Forecasting & Predictions</h5>
                <div class="row">
                  <div class="col-md-4">
                    <?php
                    // Calculate average monthly sales with discounts
                    $avg_monthly = "SELECT AVG(monthly_sales) as avg_sales FROM (
                                        SELECT DATE_FORMAT(tc.order_date, '%Y-%m') as month,
                                        SUM((tp.prod_price + 100) * (1 - tp.prod_discount/100) * tc.prod_qnty) * 0.95 as monthly_sales
                                        FROM tbl_cart tc
                                        INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                                        WHERE status_id = 2 AND order_date IS NOT NULL
                                        GROUP BY DATE_FORMAT(tc.order_date, '%Y-%m')
                                        ) as monthly_data";
                    $avg_result = $conn->query($avg_monthly);
                    $avg_sales = $avg_result->fetch_assoc()['avg_sales'] ?? 0;

                    // Factor in average voucher discount impact
                    $avg_voucher_discount = $voucher_discount / max($completed_orders, 1);
                    $next_month_forecast = ($avg_sales - $avg_voucher_discount) * 1.1;
                    ?>
                    <div class="alert alert-info">
                      <h6>Next Month Forecast</h6>
                      <h3 class="trend-up">₱<?php echo number_format($next_month_forecast, 2); ?></h3>
                      <small>Based on average monthly trend (+10% growth)</small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <?php
                    $peak_day = "SELECT DAYNAME(order_date) as day_name, 
                                  SUM((tp.prod_price + 100) * (1 - tp.prod_discount/100) * tc.prod_qnty) * 0.95 as day_sales
                                  FROM tbl_cart tc
                                  INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                                  WHERE status_id = 2 AND order_date IS NOT NULL
                                  GROUP BY DAYNAME(order_date)
                                  ORDER BY day_sales DESC LIMIT 1";
                    $peak_result = $conn->query($peak_day);
                    $peak_data = $peak_result->fetch_assoc();
                    ?>
                    <div class="alert alert-success">
                      <h6>Peak Sales Day</h6>
                      <h3><?php echo $peak_data['day_name'] ?? 'N/A'; ?></h3>
                      <small>₱<?php echo number_format($peak_data['day_sales'] ?? 0, 2); ?> average</small>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <?php
                    $peak_month = "SELECT MONTHNAME(order_date) as month_name,
                 SUM((tp.prod_price + 100) * (1 - tp.prod_discount/100) * tc.prod_qnty) * 0.95 as month_sales
                 FROM tbl_cart tc
                 INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                 WHERE status_id = 2 AND order_date IS NOT NULL
                 GROUP BY MONTHNAME(order_date)
                 ORDER BY month_sales DESC LIMIT 1";
                    $peak_month_result = $conn->query($peak_month);
                    $peak_month_data = $peak_month_result->fetch_assoc();
                    ?>
                    <div class="alert alert-warning">
                      <h6>Peak Sales Month</h6>
                      <h3><?php echo $peak_month_data['month_name'] ?? 'N/A'; ?></h3>
                      <small>₱<?php echo number_format($peak_month_data['month_sales'] ?? 0, 2); ?> total</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Low Performers Section with Filter -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="analytics-card">
                <h5 class="section-title"><i class="fas fa-exclamation-triangle text-warning"></i> Low Performing Products</h5>

                <!-- Filter for Low Performers -->
                <div class="filter-section">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="form-label">Threshold:</label>
                      <select class="form-select form-select-sm" id="lowPerfThreshold" onchange="updateLowPerformers()">
                        <option value="1000" selected>Below ₱1,000</option>
                        <option value="5000">Below ₱5,000</option>
                        <option value="10000">Below ₱10,000</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Period:</label>
                      <select class="form-select form-select-sm" id="lowPerfPeriod" onchange="updateLowPerformers()">
                        <option value="all" selected>All Time</option>
                        <option value="month">This Month</option>
                        <option value="quarter">This Quarter</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Limit:</label>
                      <select class="form-select form-select-sm" id="lowPerfLimit" onchange="updateLowPerformers()">
                        <option value="10" selected>Top 10</option>
                        <option value="20">Top 20</option>
                        <option value="50">Top 50</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="table-responsive" id="lowPerformersTable">
                  <!-- Content will be loaded via AJAX -->
                </div>
              </div>
            </div>
          </div>

        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    let salesTrendChart, dermPerformanceChart;

    // Initialize charts and tables on page load
    $(document).ready(function() {
      initializeSalesTrendChart();
      initializeDermPerformanceChart();
      updateTopProducts();
      updateServicePerformance();
      updateLowPerformers();
    });

    // Initialize Sales Trend Chart
    function initializeSalesTrendChart() {
      const ctx = document.getElementById('salesTrendChart').getContext('2d');

      salesTrendChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
              label: 'Actual Sales (₱)',
              data: [],
              borderColor: 'rgba(75, 192, 192, 1)',
              backgroundColor: 'rgba(75, 192, 192, 0.1)',
              borderWidth: 3,
              fill: true,
              tension: 0.4,
              pointRadius: 5,
              pointBackgroundColor: 'rgba(75, 192, 192, 1)',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointHoverRadius: 7
            },
            {
              label: 'Forecasted Sales (₱)',
              data: [],
              borderColor: 'rgba(244, 67, 54, 1)',
              backgroundColor: 'rgba(244, 67, 54, 0.15)',
              borderWidth: 3,
              borderDash: [8, 4],
              fill: true,
              tension: 0.4,
              pointRadius: 6,
              pointBackgroundColor: 'rgba(244, 67, 54, 1)',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointHoverRadius: 8,
              pointStyle: 'rect'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            mode: 'index',
            intersect: false
          },
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                font: {
                  size: 12,
                  weight: 'bold'
                },
                padding: 15,
                usePointStyle: true
              }
            },
            tooltip: {
              backgroundColor: 'rgba(0, 0, 0, 0.8)',
              padding: 12,
              titleFont: {
                size: 13,
                weight: 'bold'
              },
              bodyFont: {
                size: 12
              },
              callbacks: {
                label: function(context) {
                  return context.dataset.label + ': ₱' + context.parsed.y.toLocaleString('en-PH', {
                    maximumFractionDigits: 2
                  });
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: 'rgba(0, 0, 0, 0.05)',
                drawBorder: false
              },
              ticks: {
                callback: function(value) {
                  return '₱' + value.toLocaleString('en-PH');
                },
                font: {
                  size: 11
                }
              }
            },
            x: {
              grid: {
                display: false,
                drawBorder: false
              },
              ticks: {
                font: {
                  size: 11
                }
              }
            }
          }
        }
      });

      // Load initial data
      updateSalesTrendChart();
    }

    function updateSalesTrendChart() {
      const filterType = $('#trendFilterType').val();
      const filterDate = $('#trendFilterDate').val();

      $.ajax({
        url: 'ajax/get_sales_trend.php',
        method: 'POST',
        data: {
          filter_type: filterType,
          filter_date: filterDate
        },
        dataType: 'json',
        success: function(response) {
          if (response.error) {
            console.error('Error:', response.error);
            return;
          }

          salesTrendChart.data.labels = response.labels;
          salesTrendChart.data.datasets[0].data = response.actual;
          salesTrendChart.data.datasets[1].data = response.forecast;
          salesTrendChart.update();
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', status, error);
          console.error('Response:', xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error loading chart',
            text: 'Could not load sales trend data'
          });
        }
      });
    }

    // Update Top Products
    function updateTopProducts() {
      const filter = $('#topProductsFilter').val();

      $.ajax({
        url: 'ajax/get_top_products.php',
        method: 'POST',
        data: {
          filter: filter
        },
        success: function(response) {
          $('#topProductsTable').html(response);
        }
      });
    }

    // Update Service Performance
    function updateServicePerformance() {
      const filter = $('#serviceFilter').val();
      const group = $('#serviceGroupFilter').val();

      $.ajax({
        url: 'ajax/get_service_performance.php',
        method: 'POST',
        data: {
          filter: filter,
          group: group
        },
        success: function(response) {
          $('#servicePerformanceTable').html(response);
        }
      });
    }

    // Initialize Dermatologist Performance Chart
    function initializeDermPerformanceChart() {
      const ctx = document.getElementById('dermPerformanceChart').getContext('2d');
      dermPerformanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [],
          datasets: [{
            label: 'Revenue (₱)',
            data: [],
            backgroundColor: [
              'rgba(255, 99, 132, 0.7)',
              'rgba(54, 162, 235, 0.7)',
              'rgba(255, 206, 86, 0.7)',
              'rgba(75, 192, 192, 0.7)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return '₱' + value.toLocaleString();
                }
              }
            }
          }
        }
      });
      updateDermPerformance();
    }

    // Update Dermatologist Performance
    function updateDermPerformance() {
      const filter = $('#dermFilter').val();
      const dermId = $('#dermSelect').val();

      $.ajax({
        url: 'ajax/get_derm_performance.php',
        method: 'POST',
        data: {
          filter: filter,
          derm_id: dermId
        },
        dataType: 'json',
        success: function(response) {
          dermPerformanceChart.data.labels = response.labels;
          dermPerformanceChart.data.datasets[0].data = response.data;
          dermPerformanceChart.update();
        }
      });
    }

    // Update Low Performers
    function updateLowPerformers() {
      const threshold = $('#lowPerfThreshold').val();
      const period = $('#lowPerfPeriod').val();
      const limit = $('#lowPerfLimit').val();

      $.ajax({
        url: 'ajax/get_low_performers.php',
        method: 'POST',
        data: {
          threshold: threshold,
          period: period,
          limit: limit
        },
        success: function(response) {
          $('#lowPerformersTable').html(response);
        }
      });
    }

    function generateReport() {
      Swal.fire({
        title: 'Generate Report',
        text: 'Report generation will be implemented with export to PDF/Excel functionality',
        icon: 'info'
      });
    }

    // Handle filter type change
    $('#trendFilterType').on('change', function() {
      const filterType = $(this).val();
      const container = $('#trendDateContainer');

      if (filterType === 'day') {
        container.html(`
          <label class="form-label">Select Month:</label>
          <input type="month" class="form-control form-control-sm" id="trendFilterDate" 
                value="<?php echo date('Y-m'); ?>">
          <small class="text-muted d-block">Daily view for selected month</small>
        `);
      } else if (filterType === 'month') {
        container.html(`
          <label class="form-label">Select Year:</label>
          <input type="number" class="form-control form-control-sm" id="trendFilterDate" 
                value="<?php echo date('Y'); ?>" min="2020" max="<?php echo date('Y'); ?>">
          <small class="text-muted d-block">Monthly view for selected year</small>
        `);
      } else if (filterType === 'year') {
        container.html(`
          <label class="form-label">Year Range:</label>
          <input type="number" class="form-control form-control-sm" id="trendFilterDate" 
                value="<?php echo date('Y'); ?>" min="2020" max="<?php echo date('Y'); ?>" disabled>
          <small class="text-muted d-block">Showing last 5 years trend</small>
        `);
      }
    });
  </script>

  <script src="../scripts/bootstrap.bundle.min.js"></script>
  <script src="../scripts/toggle.js"></script>
</body>

</html>