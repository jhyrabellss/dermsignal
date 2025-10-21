<?php
require_once("config/config.php");
session_start();

// Check if user is admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role_id"] != 2) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

$action = $_POST['action'] ?? '';

// Load schedule for specific date and dermatologist
if ($action === 'load_schedule') {
    $derm_id = intval($_POST['derm_id']);
    $date = $_POST['date'];
    
    $query = "SELECT schedule_id, time_slot, is_available 
              FROM tbl_derm_schedule 
              WHERE derm_id = ? AND schedule_date = ?
              ORDER BY time_slot ASC";
    
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

// Toggle availability of a time slot
if ($action === 'toggle_availability') {
    $schedule_id = intval($_POST['schedule_id']);
    $is_available = intval($_POST['is_available']);
    
    $query = "UPDATE tbl_derm_schedule SET is_available = ? WHERE schedule_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $is_available, $schedule_id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

// Generate schedules for next 30 days
if ($action === 'generate_schedules') {
    $derm_id = intval($_POST['derm_id']);
    
    // Delete existing future schedules for this dermatologist
    $delete_query = "DELETE FROM tbl_derm_schedule WHERE derm_id = ? AND schedule_date >= CURDATE()";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $derm_id);
    $delete_stmt->execute();
    
    // Generate schedules for next 30 days
    $time_slots = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00'];
    
    for ($day = 0; $day < 30; $day++) {
        $current_date = date('Y-m-d', strtotime("+$day days"));
        $day_of_week = date('w', strtotime($current_date));
        
        // Skip Sundays (0)
        if ($day_of_week == 0) continue;
        
        foreach ($time_slots as $time) {
            $insert_query = "INSERT INTO tbl_derm_schedule (derm_id, schedule_date, time_slot, is_available, max_bookings) 
                           VALUES (?, ?, ?, 1, 1)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("iss", $derm_id, $current_date, $time);
            $insert_stmt->execute();
        }
    }
    
    echo json_encode(['status' => 'success', 'message' => '30 days schedule generated successfully']);
}
?>