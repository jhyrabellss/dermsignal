<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo "unauthorized";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id']) && isset($_POST['status'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $status = $_POST['status'];
    $derm_id = $_SESSION["derm_id"];
    
    // Validate status
    $valid_statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];
    if (!in_array($status, $valid_statuses)) {
        echo "invalid_status";
        exit();
    }
    
    // Verify appointment belongs to this dermatologist
    $verify_query = "SELECT derm_id FROM tbl_appointments WHERE appointment_id = ?";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bind_param("i", $appointment_id);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    $verify_row = $verify_result->fetch_assoc();
    
    if ($verify_row && $verify_row['derm_id'] == $derm_id) {
        $update_query = "UPDATE tbl_appointments SET appointment_status = ? WHERE appointment_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $status, $appointment_id);
        
        if ($update_stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "unauthorized";
    }
}
?>