<?php
session_start();
require_once("../reports/reports.php");

if(isset($_POST["gender"]) && isset($_POST["fname"]) && isset($_POST["mname"]) &&
   isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["contactNo"]) &&
   isset($_POST["address"]) && isset($_POST["username"]) && isset($_POST["password"]) &&
   isset($_POST["role_id"])) {

    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $contactNo = $_POST["contactNo"];
    $address = $_POST["address"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role_id = $_POST["role_id"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $admin_id = $_SESSION["admin_id"];

    $query = "SELECT * FROM tbl_account WHERE ac_username = ? OR ac_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        echo "existed";
    } else {
        $query2 = "INSERT INTO tbl_account (ac_username, ac_email, ac_password, role_id)
                   VALUES(?, ?, ?, ?)";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("sssi", $username, $email, $hashedPassword, $role_id);
        $stmt2->execute();

        $account_id = $stmt2->insert_id;

        $query3 = "INSERT INTO tbl_account_details (account_id, first_name, middle_name, last_name, gender, contact, address)
                   VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt3 = $conn->prepare($query3);
        $stmt3->bind_param("issssss", $account_id, $fname, $mname, $lname, $gender, $contactNo, $address);
        $stmt3->execute();

        $query4 = "SELECT ac_username FROM tbl_account WHERE account_id = ?";
        $stmt4 = $conn->prepare($query4);
        $stmt4->bind_param("i", $admin_id);
        $stmt4->execute();
        $result = $stmt4->get_result();
        if($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $username = $data["ac_username"];
            $act = "Create Account";
            $type = "Admin";
            report($conn, $admin_id, $username, $act, $type);
        }
    }
}
?>
