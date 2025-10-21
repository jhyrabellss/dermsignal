<?php 
session_start();
require_once("../reports/reports.php");

if(isset($_POST["service_id"]) && isset($_POST["service_name"]) 
    && isset($_POST["service_price"]) && isset($_POST["sessions"]) && isset($_POST["procedure_benefits"])) {

    $service_id = $_POST["service_id"];
    $service_name = $_POST["service_name"];
    $service_price = $_POST["service_price"];
    $sessions = $_POST["sessions"];
    $procedure_benefits = $_POST["procedure_benefits"];


    if($sessions < 1){
       echo "you cannot reduce the sessions";
        exit();
    }

    if(isset($_FILES['updatedImage']) && $_FILES['updatedImage']['error'] == 0) {
        $service_image = $_FILES['updatedImage'];
        $targetDir = realpath(dirname(__FILE__)) . "/../images/services/";
        $sanitizedFileName = strtolower(str_replace(' ', '_', $service_image['name']));
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
        if (!move_uploaded_file($service_image["tmp_name"], $targetFile)) {
            echo "error_uploading_image";
            exit();
        }

        $queryImage = "UPDATE tbl_services SET service_image=? WHERE service_id=?";
        $stmtImage = $conn->prepare($queryImage);
        $stmtImage->bind_param("si", $sanitizedFileName, $service_id);
        $stmtImage->execute();
    }

    $account_id = $_SESSION["admin_id"];

    $query = "UPDATE tbl_services SET service_name=?, service_price=?, sessions = ?, procedure_benefits = ? WHERE service_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdisi", $service_name, $service_price, $sessions, $procedure_benefits, $service_id);

    if($stmt->execute()){
        echo "success";
    } else {
        echo "error";
    }

    $query2 = "SELECT ac_username FROM tbl_account WHERE ac_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $account_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $username = $data["ac_username"];
        $act = "Updated Service ID: $service_id";
        $type = "Admin";
        report($conn, $account_id, $username, $act, $type);
    }
}
?>
