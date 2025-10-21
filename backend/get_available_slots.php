<?php
require_once("config/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $derm_id = intval($_POST['derm_id']);
    $appointment_date = $_POST['appointment_date'];
    $user_id = isset($_SESSION["user_id"]) ? intval($_SESSION["user_id"]) : null;
    $service_id = isset($_POST['service_id']) ? intval($_POST['service_id']) : null;

    // Check if the user already booked the same service on the same day
    $check_query = "SELECT COUNT(*) as count FROM tbl_appointments 
                    WHERE ac_id = ? 
                    AND service_id = ? 
                    AND appointment_date = ?
                    AND appointment_status != 'Cancelled'";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("iis", $user_id, $service_id, $appointment_date);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();

    if ($check_row['count'] > 0) {
        echo json_encode([
            'error' => 'You have already booked this service on the selected date.',
            'slots' => [],
            'status' => 'failed'
        ]);
        exit();
    }

    // Get all time slots the user has already booked on this date (any service)
    $user_booked_slots_query = "SELECT appointment_time 
                                FROM tbl_appointments 
                                WHERE ac_id = ? 
                                AND appointment_date = ? 
                                AND appointment_status != 'Cancelled'";
    $user_slots_stmt = $conn->prepare($user_booked_slots_query);
    $user_slots_stmt->bind_param("is", $user_id, $appointment_date);
    $user_slots_stmt->execute();
    $user_slots_result = $user_slots_stmt->get_result();
    
    $user_booked_times = [];
    while ($user_slot = $user_slots_result->fetch_assoc()) {
        $user_booked_times[] = $user_slot['appointment_time'];
    }
    
    // Get available time slots from database
    $query = "SELECT time_slot, is_available, max_bookings 
              FROM tbl_derm_schedule 
              WHERE derm_id = ? 
              AND schedule_date = ?
              ORDER BY time_slot ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $derm_id, $appointment_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $availableSlots = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $time_slot = $row['time_slot'];
            
            // Check if the user already has an appointment at this time
            $user_has_this_slot = in_array($time_slot, $user_booked_times);
            
            // Check if slot is already fully booked by others
            $booking_query = "SELECT COUNT(*) as booking_count 
                             FROM tbl_appointments 
                             WHERE derm_id = ? 
                             AND appointment_date = ? 
                             AND appointment_time = ? 
                             AND appointment_status != 'Cancelled'";
            
            $booking_stmt = $conn->prepare($booking_query);
            $booking_stmt->bind_param("iss", $derm_id, $appointment_date, $time_slot);
            $booking_stmt->execute();
            $booking_result = $booking_stmt->get_result();
            $booking_row = $booking_result->fetch_assoc();
            
            // Slot is available if:
            // 1. User hasn't booked this time slot already
            // 2. Schedule says available
            // 3. Bookings haven't reached max capacity
            $is_available = !$user_has_this_slot 
                           && $row['is_available'] == 1 
                           && $booking_row['booking_count'] < $row['max_bookings'];
            
            // Only include slots that user hasn't already booked
            if (!$user_has_this_slot) {
                $availableSlots[] = [
                    'time' => date('g:i A', strtotime($time_slot)),
                    'available' => $is_available
                ];
            }
        }
    } else {
        // If no schedule exists for this date, return default time slots
        $defaultSlots = [
            '09:00:00', '10:00:00', '11:00:00', '12:00:00',
            '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00'
        ];
        
        foreach ($defaultSlots as $time) {
            // Skip if user already has this time slot booked
            if (in_array($time, $user_booked_times)) {
                continue;
            }
            
            $availableSlots[] = [
                'time' => date('g:i A', strtotime($time)),
                'available' => false
            ];
        }
    }
    
    echo json_encode(['slots' => $availableSlots]);
}
?>