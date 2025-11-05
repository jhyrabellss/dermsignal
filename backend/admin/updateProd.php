<?php 
session_start();
require_once("../reports/reports.php");

if(isset($_POST["prod_id"]) && isset($_POST["prod_name"]) 
    && isset($_POST["prod_price"]) && isset($_POST["stocks"])) {

    $prod_id = $_POST["prod_id"];
    $prod_name = $_POST["prod_name"];
    $prod_price = $_POST["prod_price"];
    $stocks = $_POST["stocks"];
    $prod_description = $_POST["prod_description"];

    $account_id = $_SESSION["admin_id"];

    // Define upload directories - Use absolute paths
    $base_dir = dirname(__FILE__);
    $products_dir = $base_dir . '/../../images/products/';
    $products_hover_dir = $base_dir . '/../../images/products-hover/';

    // Create directories if they don't exist
    if (!file_exists($products_dir)) {
        mkdir($products_dir, 0777, true);
    }
    if (!file_exists($products_hover_dir)) {
        mkdir($products_hover_dir, 0777, true);
    }

    // Handle image uploads
    $prod_img = null;
    $prod_hover_img = null;

    // Handle main product image
    if(isset($_FILES['prod_image']) && $_FILES['prod_image']['error'] == 0){
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['prod_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)){
            $sanitized_filename = strtolower(str_replace(' ', '_', pathinfo($filename, PATHINFO_FILENAME)));
            $new_filename = $sanitized_filename . '_' . uniqid() . '.' . $ext;
            $upload_path = $products_dir . $new_filename;
            
            if(move_uploaded_file($_FILES['prod_image']['tmp_name'], $upload_path)){
                $prod_img = $new_filename;
                
                // Delete old image if exists
                $query_old = "SELECT prod_img FROM tbl_products WHERE prod_id = ?";
                $stmt_old = $conn->prepare($query_old);
                $stmt_old->bind_param("i", $prod_id);
                $stmt_old->execute();
                $result_old = $stmt_old->get_result();
                if($result_old->num_rows > 0){
                    $old_data = $result_old->fetch_assoc();
                    $old_img_path = $products_dir . $old_data['prod_img'];
                    if(file_exists($old_img_path) && !empty($old_data['prod_img'])){
                        unlink($old_img_path);
                    }
                }
                $stmt_old->close();
            } else {
                error_log("Failed to upload main image to: " . $upload_path);
            }
        }
    }

    // Handle hover image - Store in products-hover directory
    if(isset($_FILES['prod_hover_image']) && $_FILES['prod_hover_image']['error'] == 0){
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['prod_hover_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)){
            $sanitized_filename = strtolower(str_replace(' ', '_', pathinfo($filename, PATHINFO_FILENAME)));
            $new_filename = $sanitized_filename . '_hover_' . uniqid() . '.' . $ext;
            $upload_path = $products_hover_dir . $new_filename;
            
            // Debug: Log the upload path
            error_log("Attempting to upload hover image to: " . $upload_path);
            error_log("Temp file: " . $_FILES['prod_hover_image']['tmp_name']);
            
            if(move_uploaded_file($_FILES['prod_hover_image']['tmp_name'], $upload_path)){
                $prod_hover_img = $new_filename;
                error_log("Hover image uploaded successfully: " . $new_filename);
                
                // Delete old hover image if exists
                $query_old = "SELECT prod_hover_img FROM tbl_products WHERE prod_id = ?";
                $stmt_old = $conn->prepare($query_old);
                $stmt_old->bind_param("i", $prod_id);
                $stmt_old->execute();
                $result_old = $stmt_old->get_result();
                if($result_old->num_rows > 0){
                    $old_data = $result_old->fetch_assoc();
                    $old_hover_img_path = $products_hover_dir . $old_data['prod_hover_img'];
                    if(file_exists($old_hover_img_path) && !empty($old_data['prod_hover_img'])){
                        unlink($old_hover_img_path);
                    }
                }
                $stmt_old->close();
            } else {
                error_log("Failed to upload hover image to: " . $upload_path);
                error_log("Directory exists: " . (file_exists($products_hover_dir) ? 'yes' : 'no'));
                error_log("Directory writable: " . (is_writable($products_hover_dir) ? 'yes' : 'no'));
            }
        }
    }

    // Update query based on whether images were uploaded
    if($prod_img && $prod_hover_img){
        $query = "UPDATE tbl_products SET prod_name=?, prod_price=?, prod_stocks=?, prod_description=?, prod_img=?, prod_hover_img=? WHERE prod_id=?";
        $stmt = $conn->prepare($query);
        if($stmt === false){
            echo "error_preparing_statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("siisssi", $prod_name, $prod_price, $stocks, $prod_description, $prod_img, $prod_hover_img, $prod_id);
    } elseif($prod_img){
        $query = "UPDATE tbl_products SET prod_name=?, prod_price=?, prod_stocks=?, prod_description=?, prod_img=? WHERE prod_id=?";
        $stmt = $conn->prepare($query);
        if($stmt === false){
            echo "error_preparing_statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("siissi", $prod_name, $prod_price, $stocks, $prod_description, $prod_img, $prod_id);
    } elseif($prod_hover_img){
        $query = "UPDATE tbl_products SET prod_name=?, prod_price=?, prod_stocks=?, prod_description=?, prod_hover_img=? WHERE prod_id=?";
        $stmt = $conn->prepare($query);
        if($stmt === false){
            echo "error_preparing_statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("siissi", $prod_name, $prod_price, $stocks, $prod_description, $prod_hover_img, $prod_id);
    } else {
        $query = "UPDATE tbl_products SET prod_name=?, prod_price=?, prod_stocks=?, prod_description=? WHERE prod_id=?";
        $stmt = $conn->prepare($query);
        if($stmt === false){
            echo "error_preparing_statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("siisi", $prod_name, $prod_price, $stocks, $prod_description, $prod_id);
    }

    if($stmt->execute()){
        // Log the activity
        $query2 = "SELECT ac_username FROM tbl_account WHERE ac_id = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $account_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $username = $data["ac_username"];
            $act = "Updated Product ID: $prod_id";
            $type = "Admin";
            report($conn, $account_id, $username, $act, $type);
        }
        $stmt2->close();
        
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "error_invalid_request";
}
?>