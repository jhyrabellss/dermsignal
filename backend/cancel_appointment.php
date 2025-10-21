<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "no_session";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $user_id = $_SESSION["user_id"];
    
    // Verify appointment belongs to user
    $verify_query = "SELECT ac_id FROM tbl_appointments WHERE appointment_id = ?";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bind_param("i", $appointment_id);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    $verify_row = $verify_result->fetch_assoc();
    
    if ($verify_row && $verify_row['ac_id'] == $user_id) {
        $update_query = "UPDATE tbl_appointments SET appointment_status = 'Cancelled' WHERE appointment_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("i", $appointment_id);
        
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