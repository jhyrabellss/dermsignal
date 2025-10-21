<?php
session_start();
require_once("../../backend/config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $promo_type = $_POST['type'];
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];
    $created_by = $_SESSION['admin_id'];

    if ($promo_type === 'low_boost') {
        // Get low-selling products
        $query = "SELECT p.prod_id, p.prod_name, COALESCE(SUM(c.prod_qnty), 0) as total_sold
                  FROM tbl_products p
                  LEFT JOIN tbl_cart c ON p.prod_id = c.prod_id AND c.status_id = 2
                  GROUP BY p.prod_id
                  HAVING total_sold < 5
                  LIMIT 5";
        $result = $conn->query($query);
        
        $target_items = [];
        while ($row = $result->fetch_assoc()) {
            $target_items[] = [
                'type' => 'product',
                'id' => $row['prod_id'],
                'name' => $row['prod_name']
            ];
        }

        $voucher_name = "Boost Low Performers - " . date('M Y');
        $voucher_code = "BOOST" . strtoupper(substr(md5(time()), 0, 6));
        $discount_value = 25; // 25% off
        $promo_category = "Special";

    } elseif ($promo_type === 'bundle') {
        $voucher_name = "Bundle Deal - Buy More Save More";
        $voucher_code = "BUNDLE" . strtoupper(substr(md5(time()), 0, 5));
        $discount_value = 15;
        $promo_category = "Bundle Deal";
        $target_items = null;

    } elseif ($promo_type === 'flash') {
        $voucher_name = "Flash Sale - Limited Time Only!";
        $voucher_code = "FLASH" . strtoupper(substr(md5(time()), 0, 6));
        $discount_value = 30;
        $promo_category = "Flash Sale";
        $target_items = null;
    }

    $target_items_json = $target_items ? json_encode($target_items) : null;

    $stmt = $conn->prepare("INSERT INTO tbl_vouchers (voucher_name, voucher_code, voucher_type, 
                            discount_type, discount_value, min_purchase, start_date, end_date, 
                            target_items, promo_category, auto_apply, created_by, is_active) 
                            VALUES (?, ?, 'both', 'percentage', ?, 0, ?, ?, ?, ?, 1, ?, 1)");
    $stmt->bind_param("ssdssssi", $voucher_name, $voucher_code, $discount_value, 
                     $start_date, $end_date, $target_items_json, $promo_category, $created_by);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true, 
            'message' => "Smart promo '{$voucher_name}' created with code: {$voucher_code}"
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to generate promo']);
    }
    $stmt->close();
}
?>