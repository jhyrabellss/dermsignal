<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION["derm_id"])) {
    echo "unauthorized";
    exit();
}

$appointment_id = intval($_POST['appointment_id']);
$payment_status = $_POST['payment_status'];

// Validate payment status
if (!in_array($payment_status, ['Verified', 'Rejected'])) {
    echo "invalid_status";
    exit();
}

// Update payment status
$appointment_status = ($payment_status === 'Verified') ? 'Confirmed' : 'Cancelled';

$query = "UPDATE tbl_appointments 
          SET payment_status = ?, 
              appointment_status = ? 
          WHERE appointment_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $payment_status, $appointment_status, $appointment_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>