<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION['user_id'])) {
    echo "unauthorized";
    exit;
}

$ac_id = intval($_SESSION['user_id']);

// Start transaction
$conn->begin_transaction();

try {
    // Validate receipt file
    if (!isset($_FILES['receipt']) || $_FILES['receipt']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Receipt file is required");
    }

    $refNumber = trim($_POST['refNumber']);
    $depositAmount = floatval($_POST['depositAmount']);
    
    if (strlen($refNumber) !== 13) {
        throw new Exception("Invalid reference number");
    }

    // Handle file upload
    $file = $_FILES['receipt'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    $allowed = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
    
    if (!in_array($fileExt, $allowed)) {
        throw new Exception("Invalid file type");
    }
    
    $fileNameNew = uniqid('', true) . "." . $fileExt;
    $fileDestination = '../images/receipts/' . $fileNameNew;
    
    if (!move_uploaded_file($fileTmpName, $fileDestination)) {
        throw new Exception("Failed to upload receipt");
    }
    
    // Check stock availability
    $stockQuery = "SELECT tc.prod_id, tc.prod_qnty, tp.prod_stocks 
                   FROM tbl_cart tc
                   JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                   WHERE tc.account_id = ? AND tc.status_id = 1";
    $stmt = $conn->prepare($stockQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $stockResult = $stmt->get_result();
    
    $stockIssues = false;
    while ($item = $stockResult->fetch_assoc()) {
        if ($item['prod_qnty'] > $item['prod_stocks']) {
            // Delete items with insufficient stock
            $deleteQuery = "DELETE FROM tbl_cart WHERE prod_id = ? AND account_id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("ii", $item['prod_id'], $ac_id);
            $deleteStmt->execute();
            $deleteStmt->close();
            $stockIssues = true;
        }
    }
    $stmt->close();
    
    if ($stockIssues) {
        $conn->rollback();
        echo "stocks";
        exit;
    }
    
    // Insert receipt
    $receiptQuery = "INSERT INTO tbl_receipt (account_id, receipt_img, receipt_number, deposit_amount, uploaded_date) 
                     VALUES (?, ?, ?, ?, CURDATE())";
    $stmt = $conn->prepare($receiptQuery);
    $stmt->bind_param("issi", $ac_id, $fileNameNew, $refNumber, $depositAmount);
    $stmt->execute();
    $receipt_id = $conn->insert_id;
    $stmt->close();
    
    // Get cart items for voucher calculation
    $cartQuery = "SELECT tc.*, tp.prod_price
                  FROM tbl_cart tc
                  JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                  WHERE tc.account_id = ? AND tc.status_id = 1";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $cartResult = $stmt->get_result();
    
    $cartItems = [];
    $cartTotal = 0;
    while ($item = $cartResult->fetch_assoc()) {
        $itemPrice = $item['prod_price'] + 100; // Add your markup
        $subtotal = $item['prod_qnty'] * $itemPrice;
        $cartTotal += $subtotal;
        
        $cartItems[] = [
            'prod_id' => $item['prod_id'],
            'subtotal' => $subtotal
        ];
    }
    $stmt->close();
    
    // Process vouchers
    $voucherQuery = "SELECT cv.voucher_id, v.discount_type, v.discount_value, v.target_items, 
                            v.min_purchase, v.max_discount
                     FROM tbl_cart_vouchers cv
                     JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
                     WHERE cv.account_id = ? AND cv.status_id = 1";
    $stmt = $conn->prepare($voucherQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $voucherResult = $stmt->get_result();
    
    while ($voucher = $voucherResult->fetch_assoc()) {
        // Calculate eligible subtotal
        $targetItems = json_decode($voucher['target_items'], true);
        $eligibleProductIds = [];
        
        if ($targetItems) {
            foreach ($targetItems as $item) {
                if ($item['type'] == 'product') {
                    $eligibleProductIds[] = $item['id'];
                }
            }
        }
        
        $voucherSubtotal = 0;
        foreach ($cartItems as $cartItem) {
            if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                $voucherSubtotal += $cartItem['subtotal'];
            }
        }
        
        // Calculate discount amount
        $discount_amount = 0;
        if ($cartTotal >= $voucher['min_purchase']) {
            if ($voucher['discount_type'] == 'percentage') {
                $discount_amount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                if ($voucher['max_discount'] > 0 && $discount_amount > $voucher['max_discount']) {
                    $discount_amount = $voucher['max_discount'];
                }
            } else {
                $discount_amount = $voucher['discount_value'];
            }
            
            // Insert order voucher record
            $orderVoucherQuery = "INSERT INTO tbl_order_vouchers (receipt_id, voucher_id, discount_amount) 
                                  VALUES (?, ?, ?)";
            $ovStmt = $conn->prepare($orderVoucherQuery);
            $ovStmt->bind_param("iid", $receipt_id, $voucher['voucher_id'], $discount_amount);
            $ovStmt->execute();
            $ovStmt->close();
            
            // Record voucher usage
            $finalAmount = $cartTotal - $discount_amount;
            $usageQuery = "INSERT INTO tbl_voucher_usage 
                          (voucher_id, account_id, order_type, order_id, discount_amount, original_amount, final_amount) 
                          VALUES (?, ?, 'product', ?, ?, ?, ?)";
            $usageStmt = $conn->prepare($usageQuery);
            $usageStmt->bind_param("iiiddd", $voucher['voucher_id'], $ac_id, $receipt_id, 
                                   $discount_amount, $cartTotal, $finalAmount);
            $usageStmt->execute();
            $usageStmt->close();
            
            // Increment voucher usage count
            $updateVoucherQuery = "UPDATE tbl_vouchers 
                                  SET used_count = used_count + 1,
                                      total_discount_given = total_discount_given + ?,
                                      total_revenue_generated = total_revenue_generated + ?
                                  WHERE voucher_id = ?";
            $uvStmt = $conn->prepare($updateVoucherQuery);
            $uvStmt->bind_param("ddi", $discount_amount, $finalAmount, $voucher['voucher_id']);
            $uvStmt->execute();
            $uvStmt->close();
        }
    }
    $stmt->close();
    
    // Update cart status to delivered (status_id = 2)
    $updateCartQuery = "UPDATE tbl_cart SET status_id = 2, order_date = CURDATE() 
                       WHERE account_id = ? AND status_id = 1";
    $stmt = $conn->prepare($updateCartQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $stmt->close();
    
    // Update voucher cart status to used (status_id = 2)
    $updateVoucherCartQuery = "UPDATE tbl_cart_vouchers SET status_id = 2 
                              WHERE account_id = ? AND status_id = 1";
    $stmt = $conn->prepare($updateVoucherCartQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $stmt->close();
    
    // Update product stocks
    $updateStocksQuery = "UPDATE tbl_products tp
                         INNER JOIN tbl_cart tc ON tp.prod_id = tc.prod_id
                         SET tp.prod_stocks = tp.prod_stocks - tc.prod_qnty
                         WHERE tc.account_id = ? AND tc.status_id = 2";
    $stmt = $conn->prepare($updateStocksQuery);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $stmt->close();
    
    // Commit transaction
    $conn->commit();
    echo "success";
    
} catch (Exception $e) {
    $conn->rollback();
    echo "error: " . $e->getMessage();
}

$conn->close();
?>