<?php
require_once("../config/config.php");
session_start();

date_default_timezone_set('UTC');  // Ensure timezone is set

// Debugging: check if date() is working
$current_date = date("Y-m-d");
echo "Current Date: " . $current_date . "<br>";  // Should print something like 2024-12-10

// Check if user is logged in and required POST variables are set
if (isset($_SESSION["user_id"]) && isset($_POST["review"]) && isset($_POST["prod_id"]) && isset($_POST["rating"])) {
    $review = $_POST["review"];
    $account_id = $_SESSION["user_id"];
    $prod_id = $_POST["prod_id"];
    $rating = intval($_POST["rating"]);

    // Debugging: print all variables
    echo "Review: " . htmlspecialchars($review) . "<br>";
    var_dump($prod_id, $review, $rating, $account_id, $current_date);

    // Validate rating value
    if ($rating < 0) {
        echo "Please rate the product.";
        exit;
    }

    // Raw SQL for debugging
    $query = "INSERT INTO tbl_item_reviews (prod_id, rv_comment, rating, ac_id, rv_date) 
              VALUES ('$prod_id', '$review', '$rating', '$account_id', '$current_date')";
    
    echo "Executing Query: " . $query . "<br>";  // Debugging: Output the query to check it
    
    if ($conn->query($query)) {
        echo "Review submitted!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request. Please ensure all required fields are provided.";
}

// Close the database connection
$conn->close();

?>
