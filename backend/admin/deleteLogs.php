<?php 
    require_once("../config/config.php");

    $query = "TRUNCATE tbl_audit_log";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    echo "success";
?>