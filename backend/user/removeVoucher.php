<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION["user_id"])) {
    echo "not_logged_in";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voucherId'])) {
    $voucherId = intval($_POST['voucherId']);
    $userId = $_SESSION["user_id"];
    
    $deleteQuery = "DELETE FROM tbl_cart_vouchers WHERE voucher_id = ? AND account_id = ? AND status_id = 1";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $voucherId, $userId);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid_request";
}
?>