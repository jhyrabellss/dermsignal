<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ac_id = $_SESSION["derm_id"];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    
    // Get current password hash
    $get_pass_query = "SELECT ac_password FROM tbl_account WHERE ac_id = ?";
    $get_stmt = $conn->prepare($get_pass_query);
    $get_stmt->bind_param("i", $ac_id);
    $get_stmt->execute();
    $get_result = $get_stmt->get_result();
    $account = $get_result->fetch_assoc();
    
    if (!$account) {
        echo json_encode(['status' => 'error', 'message' => 'Account not found']);
        exit();
    }
    
    // Verify current password
    if (!password_verify($current_password, $account['ac_password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
        exit();
    }
    
    // Hash new password
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password
    $update_query = "UPDATE tbl_account SET ac_password = ? WHERE ac_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_password_hash, $ac_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update password']);
    }
}
?>