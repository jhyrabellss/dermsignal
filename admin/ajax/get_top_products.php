<?php
session_start();
require_once("../../backend/config/config.php");

if(empty($_SESSION["admin_id"])){
    exit('<div class="alert alert-danger">Unauthorized</div>');
}

$filter = $_POST['filter'] ?? 'all';

// Build date filter
$date_condition = "";
if($filter === 'today') {
    $date_condition = "AND DATE(tc.order_date) = CURDATE()";
} elseif($filter === 'week') {
    $date_condition = "AND YEARWEEK(tc.order_date) = YEARWEEK(NOW())";
} elseif($filter === 'month') {
    $date_condition = "AND DATE_FORMAT(tc.order_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
}

$query = "SELECT 
            tp.prod_id,
            tp.prod_name,
            tp.prod_price,
            SUM(tc.prod_qnty) as total_qty,
            SUM(tp.prod_price * tc.prod_qnty) as total_sales,
            COUNT(DISTINCT tc.item_id) as order_count
          FROM tbl_cart tc
          INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
          WHERE tc.status_id = 2 
          $date_condition
          GROUP BY tp.prod_id
          ORDER BY total_sales DESC
          LIMIT 10";

$result = $conn->query($query);

if($result->num_rows > 0) {
    echo '<table class="table table-sm table-hover">';
    echo '<thead class="table-light">';
    echo '<tr>';
    echo '<th>Rank</th>';
    echo '<th>Product</th>';
    echo '<th>Units Sold</th>';
    echo '<th>Revenue</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $rank = 1;
    while($row = $result->fetch_assoc()) {
        $badge_color = $rank <= 3 ? 'success' : 'secondary';
        echo '<tr>';
        echo '<td><span class="badge bg-' . $badge_color . '">' . $rank . '</span></td>';
        echo '<td>';
        echo '<div class="fw-bold">' . htmlspecialchars($row['prod_name']) . '</div>';
        echo '<small class="text-muted">₱' . number_format($row['prod_price'], 2) . ' each</small>';
        echo '</td>';
        echo '<td>' . $row['total_qty'] . ' units</td>';
        echo '<td class="fw-bold text-success">₱' . number_format($row['total_sales'], 2) . '</td>';
        echo '</tr>';
        $rank++;
    }
    
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<div class="alert alert-info">No sales data available for this period.</div>';
}
?>