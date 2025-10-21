<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../dermatologist/derm-select.php");
    $schedule_id = intval($_POST['schedule_id']);
    $is_available = intval($_POST['is_available']);
    
    // Check if schedule belongs to this dermatologist
    $verify_query = "SELECT derm_id FROM tbl_derm_schedule WHERE schedule_id = ?";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bind_param("i", $schedule_id);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    $verify_row = $verify_result->fetch_assoc();
    
    if (!$verify_row || $verify_row['derm_id'] != $derm_id) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized action']);
        exit();
    }
    
    // Check if time slot is already booked
    $check_query = "SELECT ds.schedule_date, ds.time_slot 
                    FROM tbl_derm_schedule ds
                    WHERE ds.schedule_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("i", $schedule_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    
    if ($check_row) {
        $booking_query = "SELECT COUNT(*) as count FROM tbl_appointments 
                         WHERE derm_id = ? 
                         AND appointment_date = ? 
                         AND appointment_time = ? 
                         AND appointment_status != 'Cancelled'";
        $booking_stmt = $conn->prepare($booking_query);
        $booking_stmt->bind_param("iss", $derm_id, $check_row['schedule_date'], $check_row['time_slot']);
        $booking_stmt->execute();
        $booking_result = $booking_stmt->get_result();
        $booking_row = $booking_result->fetch_assoc();
        
        if ($booking_row['count'] > 0) {
            echo json_encode(['status' => 'error', 'message' => 'This time slot has an active booking and cannot be modified']);
            exit();
        }
    }
    
    // Update availability
    $update_query = "UPDATE tbl_derm_schedule SET is_available = ? WHERE schedule_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $is_available, $schedule_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update schedule']);
    }
}
?>