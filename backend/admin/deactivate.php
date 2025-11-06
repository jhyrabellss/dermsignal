<?php

    session_start();
    require_once("../reports/reports.php");

    if(isset($_GET["account_id"])){
        $account_id = $_GET["account_id"];
        $admin_id = $_SESSION["admin_id"];

        $current_status = null;

        $check_current_status = "SELECT account_status_id FROM tbl_account WHERE ac_id = ?";
        $stmt_check = $conn->prepare($check_current_status);
        $stmt_check->bind_param("i", $account_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if($result_check->num_rows > 0){
            // if the status = 1 (active), change to 2 (deactivated)
            $data_check = $result_check->fetch_assoc();
            $current_status = $data_check["account_status_id"];
        }
        $stmt_check->close();

        if($current_status == 1){
            $current_status = 2;
        } else{
            $current_status = 1;
        }

        $query = "UPDATE tbl_account SET account_status_id = ? WHERE ac_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $current_status, $account_id);
        $stmt->execute();
        echo "success";

        $query2 = "SELECT ac_username FROM tbl_account WHERE ac_id = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $admin_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $username = $data["ac_username"];
            $act = "Deactivated Account ID: $account_id";
            $type = "Admin";
            report($conn, $admin_id, $username, $act, $type);
        }

    }

?>