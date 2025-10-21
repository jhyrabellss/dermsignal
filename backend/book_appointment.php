<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "no_session";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ac_id = $_SESSION["user_id"];
    $service_id = intval($_POST['service_id']);
    $derm_id = intval($_POST['derm_id']);
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = date('H:i:s', strtotime($_POST['appointment_time']));
    $notes = isset($_POST['notes']) ? $_POST['notes'] : null;
    
    // Check if slot is still available (prevent double booking)
    $check_query = "SELECT COUNT(*) as count FROM tbl_appointments 
                    WHERE derm_id = ? 
                    AND appointment_date = ? 
                    AND appointment_time = ? 
                    AND appointment_status != 'Cancelled'";
    
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("iss", $derm_id, $appointment_date, $appointment_time);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    
    if ($check_row['count'] > 0) {
        echo "slot_taken";
        exit();
    }
    
    // Insert appointment
    $insert_query = "INSERT INTO tbl_appointments (ac_id, service_id, derm_id, appointment_date, appointment_time, notes) 
                     VALUES (?, ?, ?, ?, ?, ?)";
    
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("iiisss", $ac_id, $service_id, $derm_id, $appointment_date, $appointment_time, $notes);

    if ($insert_stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>