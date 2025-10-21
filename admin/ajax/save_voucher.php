<?php
session_start();
require_once("../../backend/config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucher_id = $_POST['voucher_id'] ?? null;
    $voucher_name = $_POST['voucher_name'];
    $voucher_code = strtoupper(trim($_POST['voucher_code']));
    $voucher_type = $_POST['voucher_type'];
    $discount_type = $_POST['discount_type'];
    $discount_value = $_POST['discount_value'];
    $min_purchase = $_POST['min_purchase'] ?? 0;
    $max_discount = $_POST['max_discount'] ?? null;
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $usage_limit = $_POST['usage_limit'] ?? null;
    $promo_category = $_POST['promo_category'] ?? null;
    $auto_apply = isset($_POST['auto_apply']) ? 1 : 0;
    $target_items = $_POST['target_items'] ?? null;
    $created_by = $_SESSION['admin_id'];

    if ($voucher_id) {
        // Update existing voucher
        $stmt = $conn->prepare("UPDATE tbl_vouchers SET voucher_name=?, voucher_code=?, voucher_type=?, 
                                discount_type=?, discount_value=?, min_purchase=?, max_discount=?, 
                                start_date=?, end_date=?, usage_limit=?, target_items=?, promo_category=?, 
                                auto_apply=? WHERE voucher_id=?");
        $stmt->bind_param("ssssdddssissii", $voucher_name, $voucher_code, $voucher_type, $discount_type, 
                         $discount_value, $min_purchase, $max_discount, $start_date, $end_date, 
                         $usage_limit, $target_items, $promo_category, $auto_apply, $voucher_id);
    } else {
        // Insert new voucher
        $stmt = $conn->prepare("INSERT INTO tbl_vouchers (voucher_name, voucher_code, voucher_type, 
                                discount_type, discount_value, min_purchase, max_discount, start_date, 
                                end_date, usage_limit, target_items, promo_category, auto_apply, created_by) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdddssissii", $voucher_name, $voucher_code, $voucher_type, $discount_type, 
                         $discount_value, $min_purchase, $max_discount, $start_date, $end_date, 
                         $usage_limit, $target_items, $promo_category, $auto_apply, $created_by);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Voucher saved successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save voucher: ' . $stmt->error]);
    }
    $stmt->close();
}
?>