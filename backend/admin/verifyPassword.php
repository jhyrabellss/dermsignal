<?php 
    session_start();
    require_once("../reports/reports.php");

    if(isset($_POST["admin_password"])) {
        $admin_id = $_SESSION["admin_id"];
        $admin_password = $_POST["admin_password"];

        $query = "SELECT ac_password FROM tbl_account WHERE ac_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['ac_password'];

            if (password_verify($admin_password, $hashed_password)) {
                echo "valid";
            } else {
                echo "invalid";
            }
        } else {
            echo "invalid";
        }
    } else {
        echo "invalid_request";
    }

?>