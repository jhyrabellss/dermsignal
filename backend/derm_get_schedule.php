<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../dermatologist/derm-select.php");
    $date = $_POST['date'];
    
    // Get schedule with booking status
    $query = "SELECT 
                ds.schedule_id, 
                ds.time_slot, 
                ds.is_available,
                CASE 
                    WHEN EXISTS (
                        SELECT 1 FROM tbl_appointments 
                        WHERE derm_id = ds.derm_id 
                        AND appointment_date = ds.schedule_date 
                        AND appointment_time = ds.time_slot 
                        AND appointment_status != 'Cancelled'
                    ) THEN 1 
                    ELSE 0 
                END as is_booked
              FROM tbl_derm_schedule ds
              WHERE ds.derm_id = ? AND ds.schedule_date = ?
              ORDER BY ds.time_slot ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $derm_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $slots = [];
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'slots' => $slots]);
}
?>