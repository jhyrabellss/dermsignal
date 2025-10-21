<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

require_once("../../dermatologist/derm-select.php");

// Get appointments count per date
$query = "SELECT 
            appointment_date,
            COUNT(*) as count
          FROM tbl_appointments
          WHERE derm_id = ? 
          AND appointment_status != 'Cancelled'
          GROUP BY appointment_date";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $derm_id);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['count'] . ' appointment' . ($row['count'] > 1 ? 's' : ''),
        'start' => $row['appointment_date'],
        'backgroundColor' => 'rgb(39,153,137)',
        'borderColor' => 'rgb(39,153,137)',
        'display' => 'block'
    ];
}

echo json_encode(['status' => 'success', 'events' => $events]);
?>