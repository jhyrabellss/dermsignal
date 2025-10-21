<?php
session_start();
require_once("../reports/reports.php");
if(isset($_POST["service_name"]) && isset($_POST["service_price"]) && 
    isset($_POST["procedure_benefits"]) && isset($_POST["service_group"])) {

    // Capture data
    $admin_id = $_SESSION["admin_id"];
    $service_name = $_POST['service_name'];
    $service_price = floatval($_POST['service_price']);
    $procedure_benefits = $_POST['procedure_benefits'];
    $service_group = $_POST['service_group'];
    $targetDir = "../images/services/";
    $targetDir = realpath(dirname(__FILE__)) . "/../images/services/";
    $service_image_name = '';
    $sessions = $_POST['sessions'];


    // Check if the file is uploaded correctly
    if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] == 0) {
        $service_image = $_FILES['service_image'];

        // Sanitize file name (remove spaces, and convert to lowercase for uniformity)
        $sanitizedFileName = strtolower(str_replace(' ', '_', $service_image['name']));
        
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
        if (!move_uploaded_file($service_image["tmp_name"], $targetFile)) {
            echo "error_uploading_image";
            exit(); // Exit if there is an error while uploading
        }

        // If everything is successful, return the sanitized file name for saving into the database
        $service_image_name = $sanitizedFileName;
    } else {
        echo "error_no_image_uploaded";  // If no image is uploaded
        exit();
    }

    // Insert service into the database
    $query = "INSERT INTO tbl_services (service_name, service_price, procedure_benefits, service_group, service_image, sessions) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdsssi", $service_name, $service_price, $procedure_benefits, $service_group, $service_image_name, $sessions);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error_inserting_data";
    }
} else {
    echo "error_invalid_request";
}
?>
