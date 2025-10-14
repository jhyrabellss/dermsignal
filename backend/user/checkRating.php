<?php
require_once("../config/config.php");
session_start();

// Check if user is logged in and required POST variables are set
if (isset($_SESSION["user_id"]) && isset($_POST["prod_id"])) {
    $account_id = $_SESSION["user_id"];
    $prod_id = $_POST["prod_id"];

    // Check if the user has already rated this product
    $query = "SELECT rating FROM tbl_item_reviews WHERE ac_id = ? AND prod_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ii", $account_id, $prod_id);
    $stmt->execute();
    $stmt->bind_result($existing_rating);
    $stmt->fetch();
    $stmt->close();

    // If the user has rated, return the fixed rating
    if ($existing_rating) {
        echo json_encode(['status' => 'rated', 'rating' => $existing_rating]);
    } else {
        echo json_encode(['status' => 'not_rated']);
    }

} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
