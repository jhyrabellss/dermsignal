<?php 
    session_start();
    require_once("../reports/trans.php");

    if(isset($_POST["item_id"]) && isset($_POST["status_id"])){
        $item_id = $_POST["item_id"];
        $admin_id =  $_SESSION["admin_id"];
        $status_id = $_POST["status_id"];
        $order_date = date('Y-m-d');
        $prod_name = '';
        

        $query = "UPDATE tbl_cart SET status_id = ?, order_date = ? WHERE item_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isi", $status_id, $order_date, $item_id);
        $stmt->execute();

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
            
                    if ($stmt3->affected_rows > 0) {
                        echo "Stock updated successfully.";
                    } else {
                        echo "Failed to update stock.";
                    }
                } else {
                    echo "exceeds";
                    exit();
                }
            } else {
                echo "Error: Product not found.";
            }
        }

        $query2 = "SELECT ac.ac_username, ac.role_id, tr.role_name FROM tbl_account ac 
        INNER JOIN tbl_role tr ON ac.role_id = tr.role_id Where ac.ac_id = ?;";
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
                $activity = "Claimed item ".$prod_name;
                transaction($conn, $admin_id, $user_name, $role_id, $current_date, $activity, $item_id);
            }
           
        }
        echo "success";
    }

?>