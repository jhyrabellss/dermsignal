<?php
session_start();
require_once("../reports/reports.php");

if(isset($_POST["prod_name"]) && isset($_POST["prod_price"]) && 
    isset($_POST["prod_concern"]) && isset($_POST["prod_stocks"]) && 
    isset($_FILES["prod_img"]) && isset($_POST["prod_ingredients"])) {

    // Capture data
    $admin_id = $_SESSION["admin_id"];
    $prod_name = $_POST['prod_name'];
    $prod_price = intval($_POST['prod_price']);
    $prod_concern = intval($_POST['prod_concern']);
    $prod_stocks = intval($_POST['prod_stocks']);
    $prod_ingredients = intval($_POST['prod_ingredients']);
    $prod_short_desc = '';
    $prod_description = '';
    $prod_discount = 0;
    
    // Correct target directory paths
    $targetDir = realpath(dirname(__FILE__)) . "/../../images/products/";
    $targetHoverDir = realpath(dirname(__FILE__)) . "/../../images/products-hover/";
    
    // Prepare to check concern data
    $query = "SELECT * FROM tbl_concern WHERE concern_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prod_concern);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $prod_img_name = null;
    $prod_hover_img_name = '';

    // Handle main product image
    if (isset($_FILES['prod_img']) && $_FILES['prod_img']['error'] == 0) {
        $prod_img = $_FILES['prod_img'];
        $sanitizedFileName = strtolower(str_replace(' ', '_', $prod_img['name']));
        $targetFile = $targetDir . basename($sanitizedFileName);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo "error_image_format";
            exit();
        }

        if (file_exists($targetFile)) {
            echo "error_file_exists";
            exit();
        }

        if (!move_uploaded_file($prod_img["tmp_name"], $targetFile)) {
            echo "error_uploading_image";
            exit();
        }

        $prod_img_name = $sanitizedFileName;
    } else {
        echo "error_no_image_uploaded";
        exit();
    }

    // Handle hover image (optional) - Store in products-hover directory
    if (isset($_FILES['prod_hover_img']) && $_FILES['prod_hover_img']['error'] == 0) {
        $prod_hover_img = $_FILES['prod_hover_img'];
        $sanitizedHoverFileName = strtolower(str_replace(' ', '_', $prod_hover_img['name']));
        $targetHoverFile = $targetHoverDir . basename($sanitizedHoverFileName);
        $hoverImageFileType = strtolower(pathinfo($targetHoverFile, PATHINFO_EXTENSION));

        $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];
        if (!in_array($hoverImageFileType, $allowedTypes)) {
            echo "error_hover_image_format";
            exit();
        }

        if (file_exists($targetHoverFile)) {
            echo "error_hover_file_exists";
            exit();
        }

        if (!move_uploaded_file($prod_hover_img["tmp_name"], $targetHoverFile)) {
            echo "error_uploading_hover_image";
            exit();
        }

        $prod_hover_img_name = $sanitizedHoverFileName;
    }

    // Insert product into the database
    $query = "INSERT INTO tbl_products (prod_name, prod_price, `prod-short-desc`, prod_description, concern_id, ingredients_id, prod_stocks, prod_discount, prod_img, prod_hover_img) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    // Add error checking for prepare statement
    if ($stmt === false) {
        echo "error_preparing_statement: " . $conn->error;
        exit();
    }
    
    $stmt->bind_param("sissiiiiss", $prod_name, $prod_price, $prod_short_desc, $prod_description, $prod_concern, $prod_ingredients, $prod_stocks, $prod_discount, $prod_img_name, $prod_hover_img_name);

    if ($stmt->execute()) {
        // Log the activity
        $query2 = "SELECT ac_username FROM tbl_account WHERE ac_id = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $admin_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if($result2->num_rows > 0){
            $data2 = $result2->fetch_assoc();
            $username = $data2["ac_username"];
            $act = "Added Product: $prod_name";
            $type = "Admin";
            report($conn, $admin_id, $username, $act, $type);
        }
        echo "success";
    } else {
        echo "error_inserting_data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error_invalid_request";
}
?>