<?php
session_start();
require_once("../../backend/config/config.php");

if(empty($_SESSION["admin_id"])){
    exit('<div class="alert alert-danger">Unauthorized</div>');
}

$threshold = intval($_POST['threshold'] ?? 1000);
$period = $_POST['period'] ?? 'all';
$limit = intval($_POST['limit'] ?? 10);

// Build date filter
$date_condition = "";
if($period === 'month') {
    $date_condition = "AND DATE_FORMAT(tc.order_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
} elseif($period === 'quarter') {
    $date_condition = "AND QUARTER(tc.order_date) = QUARTER(NOW()) AND YEAR(tc.order_date) = YEAR(NOW())";
}

$query = "SELECT 
            tp.prod_id,
            tp.prod_name,
            tp.prod_price,
            tp.prod_stocks,
            COALESCE(SUM(tc.prod_qnty), 0) as total_sold,
            COALESCE(SUM(tp.prod_price * tc.prod_qnty), 0) as total_revenue,
            COUNT(DISTINCT tc.item_id) as order_count
          FROM tbl_products tp
          LEFT JOIN tbl_cart tc ON tp.prod_id = tc.prod_id AND tc.status_id = 2 $date_condition
          GROUP BY tp.prod_id
          HAVING total_revenue < $threshold
          ORDER BY total_revenue ASC, total_sold ASC
          LIMIT $limit";

$result = $conn->query($query);

if($result->num_rows > 0) {
    echo '<table class="table table-sm table-hover">';
    echo '<thead class="table-light">';
    echo '<tr>';
    echo '<th>Product</th>';
    echo '<th>Price</th>';
    echo '<th>Stock</th>';
    echo '<th>Units Sold</th>';
    echo '<th>Revenue</th>';
    echo '<th>Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while($row = $result->fetch_assoc()) {
        $status_class = 'danger';
        $status_text = 'Critical';
        
        if($row['total_revenue'] > $threshold * 0.5) {
            $status_class = 'warning';
            $status_text = 'Low';
        }
        
        echo '<tr>';
        echo '<td>';
        echo '<div class="fw-bold">' . htmlspecialchars($row['prod_name']) . '</div>';
        echo '<small class="text-muted">ID: ' . $row['prod_id'] . '</small>';
        echo '</td>';
        echo '<td>₱' . number_format($row['prod_price'], 2) . '</td>';
        echo '<td>' . $row['prod_stocks'] . ' units</td>';
        echo '<td>' . $row['total_sold'] . ' units</td>';
        echo '<td class="text-' . $status_class . ' fw-bold">₱' . number_format($row['total_revenue'], 2) . '</td>';
        echo '<td><span class="badge bg-' . $status_class . '">' . $status_text . '</span></td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    
    echo '<div class="alert alert-warning mt-3">';
    echo '<i class="fas fa-lightbulb"></i> <strong>Recommendations:</strong> ';
    echo 'Consider promotional campaigns, price adjustments, or bundling these products with bestsellers.';
    echo '</div>';
} else {
    echo '<div class="alert alert-success">All products are performing above the threshold!</div>';
}
?>