<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "no_session";
    exit();
}

if (isset($_POST["prodId"])) {
    $account_id = $_SESSION["user_id"];
    $prod_id = $_POST["prodId"];
    $prod_qnty = isset($_POST["quantity"]) ? $_POST["quantity"] : 1;

    // Check if the product is already in the cart
    $query = "SELECT * FROM tbl_cart WHERE prod_id = ? AND account_id = ? AND status_id = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $prod_id, $account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "exceeds";
    } else {
        $query2 = "INSERT INTO tbl_cart (prod_id, prod_qnty, account_id) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("iii", $prod_id, $prod_qnty, $account_id);
        
        if ($stmt2->execute()) {
            echo "success";
        } else {
            echo "stocks";
        }
    }
    exit();
}
?>
