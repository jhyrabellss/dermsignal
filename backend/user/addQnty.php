<?php
require_once("../config/config.php");
session_start();
header('Content-Type: application/json');

// Check user session
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// Validate product ID
if (!isset($_GET["prod_id"]) || empty($_GET["prod_id"])) {
    echo json_encode(["status" => "error", "message" => "Invalid product ID."]);
    exit();
}

$account_id = $_SESSION["user_id"];
$prod_id = intval($_GET["prod_id"]);

// Fetch product in the cart
$query = "SELECT * FROM tbl_cart WHERE prod_id = ? AND account_id = ? AND status_id = 1" ;
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $prod_id, $account_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $currentQnty = intval($data["prod_qnty"]);
    $updatedQnty = $currentQnty + 1;
    //$prodStocks = $data['prod_stocks']
    // Update quantity in the database
    $query2 = "UPDATE tbl_cart SET prod_qnty = ? WHERE prod_id = ? AND account_id = ? AND status_id = 1";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("iii", $updatedQnty, $prod_id, $account_id);
    if ($stmt2->execute()) {
        echo json_encode(["status" => "success", "quantity" => $updatedQnty]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update quantity."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Product not found in cart."]);
}
?>
