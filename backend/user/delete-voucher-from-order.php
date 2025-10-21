<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

$account_id = intval($_SESSION['user_id']);
$voucher_id = intval($_POST['voucher_id']);

// Delete voucher from cart (only if status is 3 - PROCESS)
$query = "DELETE FROM tbl_cart_vouchers 
          WHERE voucher_id = ? AND account_id = ? AND status_id = 3";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $voucher_id, $account_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Voucher removed successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to remove voucher."]);
}

$stmt->close();
$conn->close();
?>