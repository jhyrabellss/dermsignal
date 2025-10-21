<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ac_id = $_SESSION["derm_id"];
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    
    if (empty($first_name) || empty($last_name)) {
        echo json_encode(['status' => 'error', 'message' => 'First name and last name are required']);
        exit();
    }
    
    // Update account details
    $update_query = "UPDATE tbl_account_details 
                     SET first_name = ?, middle_name = ?, last_name = ?, gender = ?, contact = ?, address = ? 
                     WHERE ac_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssssi", $first_name, $middle_name, $last_name, $gender, $contact, $address, $ac_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update personal information']);
    }
}
?>