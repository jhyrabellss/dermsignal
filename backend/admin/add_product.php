<?php
session_start();
require_once("../reports/reports.php");
if(isset($_POST["prod_name"]) && isset($_POST["prod_price"]) && 
    isset($_POST["prod_concern"]) && isset($_POST["prod_stocks"]) && isset($_FILES["prod_img"]) && isset($_POST["prod_ingredients"])) {

    // Capture data
    $admin_id = $_SESSION["admin_id"];
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $prod_concern = $_POST['prod_concern'];
    $prod_stocks = $_POST['prod_stocks'];
    $prod_ingredients = $_POST['prod_ingredients'];
    $targetDir = "../images/products/";
    $targetDir = realpath(dirname(__FILE__)) . "/../images/products/";
    // Prepare to check concern data
    $query = "SELECT * FROM tbl_concern WHERE concern_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prod_concern);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Check if the file is uploaded correctly
    if (isset($_FILES['prod_img']) && $_FILES['prod_img']['error'] == 0) {
        $prod_img = $_FILES['prod_img'];

        // Sanitize file name (remove spaces, and convert to lowercase for uniformity)
        $sanitizedFileName = strtolower(str_replace(' ', '_', $prod_img['name']));
        
        // Set the full path for the target file (including the directory and sanitized file name)
        $targetFile = $targetDir . basename($sanitizedFileName);

        // Get the file extension to check for validity
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate image file type (allow jpg, jpeg, png, gif, webp)
        $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "error_image_format";
            exit(); // Exit if the image format is not allowed
        }

        // Check if the file already exists in the target directory
        if (file_exists($targetFile)) {
            echo "error_file_exists";
            exit(); // Exit if the file already exists
        }

        // Try moving the uploaded file to the target directory
        if (!move_uploaded_file($prod_img["tmp_name"], $targetFile)) {
            echo "error_uploading_image";
            exit(); // Exit if there is an error while uploading
        }

        // If everything is successful, return the sanitized file name for saving into the database
        $prod_img_name = $sanitizedFileName;
    } else {
        echo "error_no_image_uploaded";  // If no image is uploaded
        exit();
    }

    // Insert product into the database
    $query = "INSERT INTO tbl_products (prod_name, prod_price, concern_id, prod_stocks, ingredients_id, prod_img) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siidis", $prod_name, $prod_price, $prod_concern, $prod_stocks, $prod_ingredients, $prod_img_name);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error_inserting_data";
    }
} else {
    echo "error_invalid_request";
}
?>
