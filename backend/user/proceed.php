<?php 
require_once("../config/config.php");
session_start();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $date = date('Y-m-d');

    // Check if a file was uploaded
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../receipts/';
        $originalFileName = basename($_FILES['receipt']['name']);
        $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

        // Validate file type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "invalid_file_type";
            exit();
        }

        // Generate a unique file name
        $uniqueFileName = uniqid() . '.' . $fileExtension;
        $uploadFile = $uploadDir . $uniqueFileName;

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $uploadFile)) {
            $ref_number = $_POST["refNumber"];
            $depositAmount = $_POST["depositAmount"];
            $status_id = 3;

            // Start transaction
            $conn->begin_transaction();

            try {
                // Insert receipt
                $receiptQuery = "INSERT INTO tbl_receipt (account_id, receipt_img, receipt_number, deposit_amount, uploaded_date) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($receiptQuery);
                $stmt->bind_param("issis", $user_id, $uniqueFileName, $ref_number, $depositAmount, $date);
                
                if (!$stmt->execute()) {
                    throw new Exception("error_inserting_receipt");
                }
                
                $receipt_id = $conn->insert_id;

                // Update cart status
                $cartQuery = "UPDATE tbl_cart SET status_id = ?, order_date = ? WHERE account_id = ? AND status_id = 1";
                $stmt = $conn->prepare($cartQuery);
                $stmt->bind_param("isi", $status_id, $date, $user_id);
                
                if (!$stmt->execute()) {
                    throw new Exception("error_updating_cart");
                }

                // Check if there are vouchers in cart
                $checkVoucherQuery = "SELECT COUNT(*) as voucher_count 
                                     FROM tbl_cart_vouchers 
                                     WHERE account_id = ? AND status_id = 1";
                $stmtCheck = $conn->prepare($checkVoucherQuery);
                $stmtCheck->bind_param("i", $user_id);
                $stmtCheck->execute();
                $checkResult = $stmtCheck->get_result();
                $voucherCount = $checkResult->fetch_assoc()['voucher_count'];

                // Only process vouchers if they exist
                if ($voucherCount > 0) {
                    // Process vouchers from cart
                    $voucherQuery = "SELECT cv.voucher_id, v.* 
                                    FROM tbl_cart_vouchers cv
                                    JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
                                    WHERE cv.account_id = ? AND cv.status_id = 1";
                    $stmtVoucher = $conn->prepare($voucherQuery);
                    $stmtVoucher->bind_param("i", $user_id);
                    $stmtVoucher->execute();
                    $voucherResult = $stmtVoucher->get_result();

                    // Get cart items for voucher calculation
                    $cartItemsQuery = "SELECT tc.prod_id, tc.prod_qnty, tp.prod_price, tp.prod_discount
                                      FROM tbl_cart tc
                                      JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                                      WHERE tc.account_id = ? AND tc.status_id = ?";
                    $stmtCart = $conn->prepare($cartItemsQuery);
                    $stmtCart->bind_param("ii", $user_id, $status_id);
                    $stmtCart->execute();
                    $cartResult = $stmtCart->get_result();

                    $cartItems = [];
                    $total = 0;
                    while ($item = $cartResult->fetch_assoc()) {
                        $origprice = $item['prod_price'] + 100;
                        $proddiscount = $item['prod_discount'] / 100;
                        $prodprice = $origprice - ($origprice * $proddiscount);
                        $subtotal = $item["prod_qnty"] * $prodprice;
                        $total += $subtotal;
                        
                        $cartItems[] = [
                            'prod_id' => $item['prod_id'],
                            'subtotal' => $subtotal
                        ];
                    }

                    // Calculate and insert voucher usage
                    while ($voucher = $voucherResult->fetch_assoc()) {
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
                        if ($voucher['discount_type'] == 'percentage') {
                            $discountAmount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                            if ($voucher['max_discount'] > 0 && $discountAmount > $voucher['max_discount']) {
                                $discountAmount = $voucher['max_discount'];
                            }
                        } else {
                            $discountAmount = $voucher['discount_value'];
                        }
                        
                        // Check minimum purchase requirement
                        $meetsMinimum = ($total >= $voucher['min_purchase']);
                        
                        if ($meetsMinimum && $discountAmount > 0) {
                            // Calculate amounts for voucher usage
                            $onlineDisc = $total * 0.05;
                            $originalAmount = $total;
                            $finalAmount = $total - $onlineDisc - $discountAmount;
                            if ($finalAmount < 0) $finalAmount = 0;
                            
                            // Insert into tbl_voucher_usage
                            $usageQuery = "INSERT INTO tbl_voucher_usage 
                                          (voucher_id, account_id, order_type, order_id, discount_amount, original_amount, final_amount) 
                                          VALUES (?, ?, 'product', ?, ?, ?, ?)";
                            $stmtUsage = $conn->prepare($usageQuery);
                            $stmtUsage->bind_param("iiiddd", 
                                $voucher['voucher_id'], 
                                $user_id, 
                                $receipt_id, 
                                $discountAmount, 
                                $originalAmount, 
                                $finalAmount
                            );
                            
                            if (!$stmtUsage->execute()) {
                                throw new Exception("error_inserting_voucher_usage");
                            }
                            
                            // Update voucher statistics
                            $updateVoucherQuery = "UPDATE tbl_vouchers 
                                                 SET used_count = used_count + 1,
                                                     total_revenue_generated = total_revenue_generated + ?,
                                                     total_discount_given = total_discount_given + ?
                                                 WHERE voucher_id = ?";
                            $stmtUpdateVoucher = $conn->prepare($updateVoucherQuery);
                            $stmtUpdateVoucher->bind_param("ddi", $finalAmount, $discountAmount, $voucher['voucher_id']);
                            
                            if (!$stmtUpdateVoucher->execute()) {
                                throw new Exception("error_updating_voucher_stats");
                            }
                        }
                    }

                    // Update cart vouchers status to 3 (PROCESS) after checkout
                    $updateCartVouchersQuery = "UPDATE tbl_cart_vouchers SET status_id = 3 WHERE account_id = ? AND status_id = 1";
                    $stmtUpdateCartVouchers = $conn->prepare($updateCartVouchersQuery);
                    $stmtUpdateCartVouchers->bind_param("i", $user_id);
                    
                    if (!$stmtUpdateCartVouchers->execute()) {
                        throw new Exception("error_updating_cart_vouchers");
                    }
                }

                // Commit transaction
                $conn->commit();
                echo "success";
                
            } catch (Exception $e) {
                // Rollback transaction on error
                $conn->rollback();
                echo $e->getMessage();
            }
        } else {
            echo "file_upload_error";
            exit();
        }
    } else {
        echo "no_file_or_upload_error";
        exit();
    }
} else {
    echo "user_not_logged_in";
}
?>