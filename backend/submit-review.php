<?php
require_once("./config/config.php");

header('Content-Type: application/json');
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_id = $_SESSION['user_id'];
    $review_title = trim($_POST['review_title']);
    $rating = intval($_POST['rating']);
    $review_text = trim($_POST['review_text']);
    
    // Validate inputs
    if (empty($review_title) || empty($review_text) || $rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
        exit;
    }
    
    // Handle image upload
    $image_name = null;
    if (isset($_FILES['reviewer_image']) && $_FILES['reviewer_image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['reviewer_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $image_name = uniqid() . '.' . $ext;
            $upload_path = '../images/testimonials/' . $image_name;
            move_uploaded_file($_FILES['reviewer_image']['tmp_name'], $upload_path);
        }
    }
    
    // Insert review
    $stmt = $conn->prepare("INSERT INTO tbl_page_reviews (account_id, review_title, rating, review_text, reviewer_image, status, created_at) VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->bind_param("isdss", $account_id, $review_title, $rating, $review_text, $image_name);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit review']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>