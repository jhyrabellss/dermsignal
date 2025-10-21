<?php
session_start();
require_once("../../backend/config/config.php");

if(empty($_SESSION["admin_id"])){
    exit('<div class="alert alert-danger">Unauthorized</div>');
}

$filter = $_POST['filter'] ?? 'all';
$group = $_POST['group'] ?? 'all';

// Build date filter
$date_condition = "";
if($filter === 'week') {
    $date_condition = "AND YEARWEEK(ta.appointment_date) = YEARWEEK(NOW())";
} elseif($filter === 'month') {
    $date_condition = "AND DATE_FORMAT(ta.appointment_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
}

// Build group filter
$group_condition = "";
if($group !== 'all') {
    $group_condition = "AND ts.service_group = '" . $conn->real_escape_string($group) . "'";
}

$query = "SELECT 
            ts.service_id,
            ts.service_name,
            ts.service_group,
            ts.service_price,
            COUNT(ta.appointment_id) as booking_count,
            SUM(ts.service_price) as total_revenue,
            AVG(ts.service_price) as avg_price
          FROM tbl_appointments ta
          INNER JOIN tbl_services ts ON ta.service_id = ts.service_id
          WHERE ta.appointment_status = 'Completed'
          $date_condition
          $group_condition
          GROUP BY ts.service_id
          ORDER BY total_revenue DESC
          LIMIT 15";

$result = $conn->query($query);

if($result->num_rows > 0) {
    echo '<table class="table table-sm table-hover">';
    echo '<thead class="table-light">';
    echo '<tr>';
    echo '<th>Service</th>';
    echo '<th>Group</th>';
    echo '<th>Bookings</th>';
    echo '<th>Revenue</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>';
        echo '<div class="fw-bold">' . htmlspecialchars($row['service_name']) . '</div>';
        echo '<small class="text-muted">₱' . number_format($row['service_price'], 2) . ' per session</small>';
        echo '</td>';
        echo '<td><span class="badge bg-info">' . htmlspecialchars($row['service_group']) . '</span></td>';
        echo '<td>' . $row['booking_count'] . ' bookings</td>';
        echo '<td class="fw-bold text-success">₱' . number_format($row['total_revenue'], 2) . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<div class="alert alert-info">No service data available for this period.</div>';
}
?>