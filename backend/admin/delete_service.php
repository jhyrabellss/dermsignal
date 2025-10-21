<?php 
    session_start();
require_once("../reports/reports.php");

if(isset($_POST["service_id"])) {
    $service_id = $_POST["service_id"];
    $account_id = $_SESSION["admin_id"];

    // Delete service from the database
    $query = "DELETE FROM tbl_services WHERE service_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);

    if ($stmt->execute()) {
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