<?php 
    require_once("../config/config.php");
    
    function report($conn, $trail_id, $trail_username, $trail_activity, $trail_user_type)
    {
        $query = "INSERT INTO tbl_audit_trail 
        (trail_user_id, trail_username, trail_activity, trail_user_type) VALUES(?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $trail_id, $trail_username, $trail_activity, $trail_user_type);
        $stmt->execute();
    }
    
?>