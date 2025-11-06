<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

$appointment_id = intval($_POST['appointment_id']);

$query = "SELECT 
            a.appointment_id,
            a.appointment_date,
            a.appointment_time,
            a.appointment_status,
            a.notes,
            a.payment_status,
            a.gcash_reference,
            a.downpayment_amount,
            a.payment_proof,
            s.service_name,
            CONCAT(ad.first_name, ' ', ad.last_name) as patient_name
          FROM tbl_appointments a
          JOIN tbl_services s ON a.service_id = s.service_id
          JOIN tbl_account_details ad ON a.ac_id = ad.ac_id
          WHERE a.appointment_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $appointment = $result->fetch_assoc();
    
    // Format date and time
    $appointment['appointment_date'] = date('M d, Y', strtotime($appointment['appointment_date']));
    $appointment['appointment_time'] = date('g:i A', strtotime($appointment['appointment_time']));
    
    echo json_encode([
        'status' => 'success',
        'appointment' => $appointment
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Appointment not found']);
}
?>