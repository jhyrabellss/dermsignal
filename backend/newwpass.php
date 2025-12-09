<?php 
require_once "config/config.php";
$PASSWORD = "Jcpogi123c";
$hashedPassword = password_hash($PASSWORD, PASSWORD_DEFAULT);
    $update_query = "UPDATE tbl_account 
    SET ac_password = ?
    WHERE ac_id = 16";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("s", $hashedPassword);
    if($stmt->execute()){
        echo "success";
    }else{
        echo "error";
    }

?>