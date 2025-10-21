<?php 
session_start();
require_once("../reports/trans.php");

if(isset($_POST["item_id"]) && isset($_POST["status_id"])){
    $item_id = $_POST["item_id"];
    $admin_id = $_SESSION["admin_id"];
    $status_id = $_POST["status_id"];
    $account_id = isset($_POST["account_id"]) ? $_POST["account_id"] : null;
    $order_date = date('Y-m-d');
    $prod_name = '';

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update cart status
        $query = "UPDATE tbl_cart SET status_id = ?, order_date = ? WHERE item_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isi", $status_id, $order_date, $item_id);
        $stmt->execute();

        // Update voucher cart status if account_id is provided
        if ($account_id !== null) {
            $status_id_voucher = ($status_id == 2) ? 4 : $status_id; // Set voucher status to 4 if order status is 2

            $voucher_status_query = "UPDATE tbl_cart_vouchers 
                                    SET status_id = ? 
                                    WHERE account_id = ? AND status_id = ?";
            $stmt_voucher = $conn->prepare($voucher_status_query);
            $stmt_voucher->bind_param("iii", $status_id, $account_id, $status_id_voucher);
            $stmt_voucher->execute();
        }

        if($status_id == 2){
            $query1 = "SELECT prod_id, prod_qnty FROM tbl_cart WHERE item_id = ?";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bind_param("i", $item_id);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            $data1 = $result1->fetch_assoc();
            $prod_id = $data1["prod_id"];
            $prod_qnty = $data1["prod_qnty"];
            
            $queryCheck = "SELECT prod_stocks, prod_name FROM tbl_products WHERE prod_id = ?";
            $stmtCheck = $conn->prepare($queryCheck);
            $stmtCheck->bind_param("i", $prod_id);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();
            
            if ($resultCheck->num_rows > 0) {
                $row = $resultCheck->fetch_assoc();
                $current_stock = $row["prod_stocks"];
                $prod_name = $row["prod_name"];
            
                if ($prod_qnty <= $current_stock) {
                    // Proceed with the update
                    $query3 = "UPDATE tbl_products SET prod_stocks = prod_stocks - ? WHERE prod_id = ?";
                    $stmt3 = $conn->prepare($query3);
                    $stmt3->bind_param("di", $prod_qnty, $prod_id);
                    $stmt3->execute();
                    
                    if ($stmt3->affected_rows <= 0) {
                        throw new Exception("Failed to update stock.");
                    }
                } else {
                    $conn->rollback();
                    echo "exceeds";
                    exit();
                }
            } else {
                throw new Exception("Product not found.");
            }
        }

        // Log activity
        $query2 = "SELECT ac.ac_username, ac.role_id, tr.role_name FROM tbl_account ac 
                  INNER JOIN tbl_role tr ON ac.role_id = tr.role_id WHERE ac.ac_id = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $admin_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $user_name = $data["ac_username"];
            $role_id = $data["role_id"];
            $current_date = date('Y-m-d');
            $activity = '';
            
            if($status_id == 2){
                $activity = "Claimed item " . $prod_name;
            } elseif($status_id == 4) {
                $activity = "Set item for delivery";
            }
            
            if(!empty($activity)){
                transaction($conn, $admin_id, $user_name, $role_id, $current_date, $activity, $item_id);
            }
        }

        // Commit transaction
        $conn->commit();
        echo "success";

    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo "error: " . $e->getMessage();
    }
}
?>