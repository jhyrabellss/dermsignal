<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

require_once("../../dermatologist/derm-select.php");

// Handle delete
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    // Get current image
    $query = "SELECT derm_image FROM tbl_dermatologists WHERE derm_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $derm_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row && $row['derm_image']) {
        // Delete file from server
        $image_path = "../../images/profile_images/" . $row['derm_image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Update database
    $update_query = "UPDATE tbl_dermatologists SET derm_image = NULL WHERE derm_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $derm_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Profile image deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete image']);
    }
    exit();
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    
    // Validate file
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG, and GIF allowed']);
        exit();
    }
    
    if ($file['size'] > $max_size) {
        echo json_encode(['status' => 'error', 'message' => 'File size exceeds 5MB limit']);
        exit();
    }
    
    // Create upload directory if it doesn't exist
    $upload_dir = "../../images/profile_images/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Get current image to delete old one
    $query = "SELECT derm_image FROM tbl_dermatologists WHERE derm_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $derm_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row && $row['derm_image']) {
        $old_image = $upload_dir . $row['derm_image'];
        if (file_exists($old_image)) {
            unlink($old_image);
        }
    }
    
    // Generate unique filename
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = 'derm_' . $derm_id . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Update database
        $update_query = "UPDATE tbl_dermatologists SET derm_image = ? WHERE derm_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $new_filename, $derm_id);
        
        if ($update_stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Profile image updated successfully',
                'image' => $new_filename
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update database']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
    }
}
?>