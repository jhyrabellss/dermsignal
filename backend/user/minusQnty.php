<?php
require_once("../config/config.php");
session_start();
header('Content-Type: application/json');

// Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// Check product id
if (!isset($_GET["prod_id"]) || empty($_GET["prod_id"])) {
    echo json_encode(["status" => "error", "message" => "Invalid product ID."]);
    exit();
}

$account_id = $_SESSION["user_id"];
$prod_id = intval($_GET["prod_id"]);

// Fetch product in the cart
$query = "SELECT * FROM tbl_cart WHERE prod_id = ? AND account_id = ? AND status_id = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $prod_id, $account_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $currentQnty = intval($data["prod_qnty"]);
    
    // If quantity is greater than 1, decrease the quantity
    if ($currentQnty > 1) {
        $updatedQnty = $currentQnty - 1;
        $query2 = "UPDATE tbl_cart SET prod_qnty = ? WHERE prod_id = ? AND account_id = ? AND status_id = 1";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("iii", $updatedQnty, $prod_id, $account_id);
        if ($stmt2->execute()) {
            // Ensure cart stays visible
            $_SESSION['cartVisible'] = true;
            echo json_encode(["status" => "success", "quantity" => $updatedQnty]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update quantity."]);
            exit();
        }
    } else {
        // If quantity is 1, delete the item
        $query3 = "DELETE FROM tbl_cart WHERE prod_id = ? AND account_id = ? AND status_id = 1";
        $stmt3 = $conn->prepare($query3);
        $stmt3->bind_param("ii", $prod_id, $account_id);
        if ($stmt3->execute()) {
            echo json_encode(["status" => "success", "message" => "Product deleted from cart."]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete product."]);
            exit();
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Product not found in cart."]);
    exit();
}
?>
