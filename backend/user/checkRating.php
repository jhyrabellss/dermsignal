<?php
require_once("../config/config.php");
session_start();

if (isset($_SESSION["user_id"]) && isset($_POST["prod_id"])) {
    $account_id = $_SESSION["user_id"];
    $prod_id = $_POST["prod_id"];

    // Check if user has purchased this product
    $purchase_query = "SELECT COUNT(*) as purchase_count 
                      FROM tbl_cart 
                      WHERE account_id = ? 
                      AND prod_id = ? 
                      AND status_id = 5";
    $purchase_stmt = $conn->prepare($purchase_query);
    $purchase_stmt->bind_param("ii", $account_id, $prod_id);
    $purchase_stmt->execute();
    $purchase_result = $purchase_stmt->get_result();
    $purchase_data = $purchase_result->fetch_assoc();
    $purchase_stmt->close();

    if ($purchase_data['purchase_count'] == 0) {
        echo json_encode(['status' => 'not_purchased']);
        exit;
    }

    // Check if user has already rated this product
    $query = "SELECT rating FROM tbl_item_reviews WHERE ac_id = ? AND prod_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $account_id, $prod_id);
    $stmt->execute();
    $stmt->bind_result($existing_rating);
    $stmt->fetch();
    $stmt->close();

    if ($existing_rating) {
        echo json_encode(['status' => 'rated', 'rating' => $existing_rating]);
    } else {
        echo json_encode(['status' => 'not_rated']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$conn->close();
?>