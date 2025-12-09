<?php
session_start();
require_once("../config/config.php");

// Set header to prevent any output issues
header('Content-Type: text/plain; charset=utf-8');

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo "no_session";
    exit();
}

// Check if prodId is set
if (!isset($_POST["prodId"])) {
    echo "missing_data";
    exit();
}

$account_id = $_SESSION["user_id"];
$prod_id = intval($_POST["prodId"]);
$prod_qnty = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 1;

// Validate quantity
if ($prod_qnty < 1) {
    echo "invalid_quantity";
    exit();
}

// Check product stock
$stockQuery = "SELECT prod_stocks FROM tbl_products WHERE prod_id = ?";
$stockStmt = $conn->prepare($stockQuery);

if (!$stockStmt) {
    error_log("Stock query prepare failed: " . $conn->error);
    echo "database_error";
    exit();
}

$stockStmt->bind_param("i", $prod_id);
$stockStmt->execute();
$stockResult = $stockStmt->get_result();

if ($stockResult->num_rows == 0) {
    echo "invalid_product";
    exit();
}

$stockData = $stockResult->fetch_assoc();
$available_stock = intval($stockData['prod_stocks']);

// Check if the product is already in the cart
$query = "SELECT item_id, prod_qnty FROM tbl_cart WHERE prod_id = ? AND account_id = ? AND status_id = 1";
$stmt = $conn->prepare($query);

if (!$stmt) {
    error_log("Cart check query prepare failed: " . $conn->error);
    echo "database_error";
    exit();
}

$stmt->bind_param("ii", $prod_id, $account_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Product already in cart - update quantity
    $cartData = $result->fetch_assoc();
    $current_qnty = intval($cartData['prod_qnty']);
    $new_qnty = $current_qnty + $prod_qnty;
    
    // Check if new quantity exceeds stock
    if ($new_qnty > $available_stock) {
        echo "stocks";
        exit();
    }
    
    // Update cart quantity
    $updateQuery = "UPDATE tbl_cart SET prod_qnty = ? WHERE item_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    
    if (!$updateStmt) {
        error_log("Update query prepare failed: " . $conn->error);
        echo "database_error";
        exit();
    }
    
    $updateStmt->bind_param("ii", $new_qnty, $cartData['item_id']);
    
    if ($updateStmt->execute()) {
        echo "success";
    } else {
        error_log("Update execution failed: " . $updateStmt->error);
        echo "update_failed";
    }
} else {
    // Check if quantity exceeds stock
    if ($prod_qnty > $available_stock) {
        echo "stocks";
        exit();
    }
    
    // Add new item to cart - note the status_id is set to 1
    $insertQuery = "INSERT INTO tbl_cart (prod_id, prod_qnty, account_id, status_id) VALUES (?, ?, ?, 1)";
    $insertStmt = $conn->prepare($insertQuery);
    
    if (!$insertStmt) {
        error_log("Insert query prepare failed: " . $conn->error);
        echo "database_error";
        exit();
    }
    
    $insertStmt->bind_param("iii", $prod_id, $prod_qnty, $account_id);
    
    if ($insertStmt->execute()) {
        echo "success";
    } else {
        error_log("Insert execution failed: " . $insertStmt->error);
        echo "insert_failed";
    }
}

$conn->close();
exit();
?>