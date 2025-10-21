<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION["user_id"])) {
    echo "not_logged_in";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voucherId']) && isset($_POST['voucherCode'])) {
    $voucherId = intval($_POST['voucherId']);
    $voucherCode = $_POST['voucherCode'];
    $userId = $_SESSION["user_id"];
    
    // Verify voucher exists and is active
    $checkVoucher = "SELECT * FROM tbl_vouchers WHERE voucher_id = ? AND is_active = 1";
    $stmt = $conn->prepare($checkVoucher);
    $stmt->bind_param("i", $voucherId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo "invalid_voucher";
        exit();
    }
    
    $voucher = $result->fetch_assoc();
    
    // Check if voucher is still valid (date check)
    $today = date('Y-m-d');
    if ($today < $voucher['start_date'] || $today > $voucher['end_date']) {
        echo "expired";
        exit();
    }
    
    // Check if voucher already in user's cart
    $checkCart = "SELECT * FROM tbl_cart_vouchers WHERE account_id = ? AND voucher_id = ? AND status_id = 1";
    $stmt = $conn->prepare($checkCart);
    $stmt->bind_param("ii", $userId, $voucherId);
    $stmt->execute();
    $cartResult = $stmt->get_result();
    
    if ($cartResult->num_rows > 0) {
        echo "already_added";
        exit();
    }
    
    // Add voucher to cart
    $insertCart = "INSERT INTO tbl_cart_vouchers (voucher_id, account_id, status_id) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($insertCart);
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