<?php 
    session_start();
require_once("../reports/reports.php");

if(isset($_POST["service_id"], $_POST["password"])) {
    $service_id = $_POST["service_id"];
    $account_id = $_SESSION["admin_id"];
    $password = $_POST["password"];
    
    // Verify admin password
    $query_check = "SELECT ac_password FROM tbl_account WHERE ac_id = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("i", $account_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows === 0) {
        echo "error_unauthorized";
        exit;
    }
    
    $row = $result_check->fetch_assoc();
    $hashed_password = $row["ac_password"];
    
    // Verify password
    if (!password_verify($password, $hashed_password)) {
        echo "error_invalid_password";
        exit;
    }

    // Get image filename for the service so we can remove files after deletion
    $selectQ = "SELECT service_image, service_name FROM tbl_services WHERE service_id = ?";
    $selStmt = $conn->prepare($selectQ);
    if ($selStmt === false) {
        echo "error";
        exit;
    }
    $selStmt->bind_param("i", $service_id);
    $selStmt->execute();
    $res = $selStmt->get_result();
    if ($res->num_rows === 0) {
        echo "error";
        $selStmt->close();
        exit;
    }
    $row = $res->fetch_assoc();
    $service_image = $row['service_image'];
    $service_name = $row['service_name'];
    $selStmt->close();

    // Delete service from the database
    $query = "DELETE FROM tbl_services WHERE service_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);

    if ($stmt->execute()) {
        // Remove image file from the filesystem (best-effort)
        $imagesDir = realpath(dirname(__FILE__)) . "/../../images/services/";
        
        if (!empty($service_image)) {
            $imgPath = $imagesDir . $service_image;
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }
        
        echo "success";
    } else {
        echo "error";
    }

    // Log the deletion action
    $query2 = "SELECT ac_username FROM tbl_account WHERE ac_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $account_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $username = $data["ac_username"];
        $act = "Deleted Service ID: $service_id";
        $type = "Admin";
        report($conn, $account_id, $username, $act, $type);
    }
}

?>