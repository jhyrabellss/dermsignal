<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../../dermatologist/derm-select.php");
    $schedule_id = intval($_POST['schedule_id']);
    
    // Verify ownership
    $verify_query = "SELECT derm_id, schedule_date, time_slot FROM tbl_derm_schedule WHERE schedule_id = ?";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bind_param("i", $schedule_id);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    $verify_row = $verify_result->fetch_assoc();
    
    if (!$verify_row || $verify_row['derm_id'] != $derm_id) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized action']);
        exit();
    }
    
    // Check if there's an active booking
    $booking_query = "SELECT COUNT(*) as count FROM tbl_appointments 
                     WHERE derm_id = ? 
                     AND appointment_date = ? 
                     AND appointment_time = ? 
                     AND appointment_status != 'Cancelled'";
    $booking_stmt = $conn->prepare($booking_query);
    $booking_stmt->bind_param("iss", $derm_id, $verify_row['schedule_date'], $verify_row['time_slot']);
    $booking_stmt->execute();
    $booking_result = $booking_stmt->get_result();
    $booking_row = $booking_result->fetch_assoc();
    
    if ($booking_row['count'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Cannot delete time slot with active booking']);
        exit();
    }
    
    // Delete schedule
    $delete_query = "DELETE FROM tbl_derm_schedule WHERE schedule_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $schedule_id);
    
    if ($delete_stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete schedule']);
    }
}
?>