<?php
require_once("../config/config.php");
session_start();

header('Content-Type: application/json');

if (isset($_SESSION["user_id"]) && isset($_POST["review"]) && isset($_POST["prod_id"]) && isset($_POST["rating"])) {
    $account_id = $_SESSION["user_id"];
    $review = trim($_POST["review"]);
    $prod_id = intval($_POST["prod_id"]);
    $rating = intval($_POST["rating"]);

    // Validate rating
    if ($rating < 1 || $rating > 5) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid rating value']);
        exit;
    }

    // Check if user has purchased the product
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
        echo json_encode(['status' => 'error', 'message' => 'You must purchase this product to leave a review']);
        exit;
    }

    // Check if user has already rated this product
    $check_query = "SELECT rv_id FROM tbl_item_reviews WHERE ac_id = ? AND prod_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $account_id, $prod_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_stmt->close();

    if ($check_result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'You have already reviewed this product']);
        exit;
    }

    // Insert the review
    $insert_query = "INSERT INTO tbl_item_reviews (prod_id, rv_comment, rating, ac_id, rv_date) 
                     VALUES (?, ?, ?, ?, CURDATE())";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("isii", $prod_id, $review, $rating, $account_id);

    if ($insert_stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit review: ' . $conn->error]);
    }

    $insert_stmt->close();

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$conn->close();
?>