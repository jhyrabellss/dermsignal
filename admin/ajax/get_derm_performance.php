<?php
session_start();
require_once("../../backend/config/config.php");

if(empty($_SESSION["admin_id"])){
    exit(json_encode(['error' => 'Unauthorized']));
}

$filter = $_POST['filter'] ?? 'all';
$derm_id = $_POST['derm_id'] ?? 'all';

// Build date filter
$date_condition = "";
if($filter === 'week') {
    $date_condition = "AND YEARWEEK(ta.appointment_date) = YEARWEEK(NOW())";
} elseif($filter === 'month') {
    $date_condition = "AND DATE_FORMAT(ta.appointment_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
}

// Build dermatologist filter
$derm_condition = "";
if($derm_id !== 'all') {
    $derm_condition = "AND td.derm_id = " . intval($derm_id);
}

$query = "SELECT 
            td.derm_id,
            td.derm_name,
            COUNT(ta.appointment_id) as total_appointments,
            SUM(ts.service_price) as total_revenue,
            AVG(ts.service_price) as avg_revenue
          FROM tbl_appointments ta
          INNER JOIN tbl_dermatologists td ON ta.derm_id = td.derm_id
          INNER JOIN tbl_services ts ON ta.service_id = ts.service_id
          WHERE ta.appointment_status = 'Completed'
          $date_condition
          $derm_condition
          GROUP BY td.derm_id
          ORDER BY total_revenue DESC";

$result = $conn->query($query);

$labels = [];
$data = [];

while($row = $result->fetch_assoc()) {
    $labels[] = $row['derm_name'];
    $data[] = (float)$row['total_revenue'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>