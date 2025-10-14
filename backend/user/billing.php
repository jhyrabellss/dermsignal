<?php
session_start();
require_once("../config/config.php");

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validate session and input data
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

$ac_id = intval($_SESSION['user_id']);
$email = $_POST['email'];
$fname = $_POST['first_name'];
$mname = $_POST['middle_name'] ?? null; // Optional
$lname = $_POST['last_name'];
$unit = $_POST['unit_number'];
$barangay = $_POST['barangay'];
$postal = $_POST['postal_code'];
$city = $_POST['city'];
$region = $_POST['region'];
$phone = $_POST['phone_number'];
$payment_type = intval($_POST['payment_type_id']);
$delivery_type = intval($_POST['delivery_type_id']);

// Check if a record with the same user ID already exists
$checkQuery = "SELECT ac_id FROM tbl_billing_details WHERE ac_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("i", $ac_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Update the existing record
    $updateQuery = "
        UPDATE tbl_billing_details 
        SET email = ?, first_name = ?, middle_name = ?, last_name = ?, 
            unit_number = ?, barangay = ?, postal_code = ?, city = ?, region = ?, 
            phone_number = ?, payment_type_id = ?, delivery_type_id = ?
        WHERE ac_id = ?
    ";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param(
        "ssssssssssiii",
        $email, $fname, $mname, $lname, $unit, 
        $barangay, $postal, $city, $region, 
        $phone, $payment_type, $delivery_type, $ac_id
    );

    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Billing details updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $updateStmt->error]);
    }

    $updateStmt->close();
} else {
    // Insert a new record
    $insertQuery = "
        INSERT INTO tbl_billing_details (
            ac_id, email, first_name, middle_name, last_name, 
            unit_number, barangay, postal_code, city, region, 
            phone_number, payment_type_id, delivery_type_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param(
        "issssssssssii",
        $ac_id, $email, $fname, $mname, $lname, 
        $unit, $barangay, $postal, $city, $region, 
        $phone, $payment_type, $delivery_type
    );

    if ($insertStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Billing details saved successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $insertStmt->error]);
    }

    $insertStmt->close();
}

$stmt->close();
$conn->close();
?>
