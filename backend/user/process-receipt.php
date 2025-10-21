<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

$ac_id = intval($_SESSION['user_id']);

// Start transaction
$conn->begin_transaction();

try {
    // Handle receipt upload (your existing code)
    $receipt_number = $_POST['receipt_number'];
    $deposit_amount = $_POST['deposit_amount'];
    
    // File upload logic here...
    $receipt_img = ''; // Set after upload
    
    // Insert receipt
    $receiptQuery = "INSERT INTO tbl_receipt (account_id, receipt_img, receipt_number, deposit_amount, uploaded_date) 
                     VALUES (?, ?, ?, ?, CURDATE())";
    $stmt = $conn->prepare($receiptQuery);
    $stmt->bind_param("issi", $ac_id, $receipt_img, $receipt_number, $deposit_amount);
    $stmt->execute();
    $receipt_id = $conn->insert_id;
    $stmt->close();
    
    // Update cart items to delivered
    $updateCartQuery = "UPDATE tbl_cart SET status_id = 2, order_date = CURDATE() WHERE account_id = ? AND status_id = 1";
    $stmt = $conn->prepare($updateCartQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $stmt->close();
    
    // Get vouchers from cart and record their usage
    $voucherQuery = "SELECT cv.voucher_id, v.discount_type, v.discount_value, v.target_items
                     FROM tbl_cart_vouchers cv
                     JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
                     WHERE cv.account_id = ? AND cv.status_id = 1";
    $stmt = $conn->prepare($voucherQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($voucher = $result->fetch_assoc()) {
        // Calculate discount amount (you'll need to implement this based on your checkout calculation)
        $discount_amount = 0; // Calculate based on voucher rules
        
        // Insert order voucher record
        $orderVoucherQuery = "INSERT INTO tbl_order_vouchers (receipt_id, voucher_id, discount_amount) 
                              VALUES (?, ?, ?)";
        $ovStmt = $conn->prepare($orderVoucherQuery);
        $ovStmt->bind_param("iid", $receipt_id, $voucher['voucher_id'], $discount_amount);
        $ovStmt->execute();
        $ovStmt->close();
        
        // Increment voucher usage count
        $updateVoucherQuery = "UPDATE tbl_vouchers SET used_count = used_count + 1 WHERE voucher_id = ?";
        $uvStmt = $conn->prepare($updateVoucherQuery);
        $uvStmt->bind_param("i", $voucher['voucher_id']);
        $uvStmt->execute();
        $uvStmt->close();
    }
    $stmt->close();
    
    // Update voucher cart status to used (status_id = 2)
    $updateVoucherCartQuery = "UPDATE tbl_cart_vouchers SET status_id = 2 WHERE account_id = ? AND status_id = 1";
    $stmt = $conn->prepare($updateVoucherCartQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $stmt->close();
    
    // Commit transaction
    $conn->commit();
    
    echo json_encode(["success" => true, "message" => "Order processed successfully!"]);
    
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$conn->close();
?>