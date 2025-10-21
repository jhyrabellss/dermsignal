<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../../dermatologist/derm-select.php");
    
    $date = $_POST['date'];
    $time = $_POST['time'] . ':00';
    $available = intval($_POST['available']);
    
    // Check if time slot already exists
    $check_query = "SELECT schedule_id FROM tbl_derm_schedule 
                    WHERE derm_id = ? AND schedule_date = ? AND time_slot = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("iss", $derm_id, $date, $time);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Time slot already exists']);
        exit();
    }
    
    // Insert new schedule
    $insert_query = "INSERT INTO tbl_derm_schedule (derm_id, schedule_date, time_slot, is_available, max_bookings) 
                     VALUES (?, ?, ?, ?, 1)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("issi", $derm_id, $date, $time, $available);
    
    if ($insert_stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add time slot']);
    }
}
?>