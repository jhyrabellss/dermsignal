<?php
    session_start();
    require_once("../config/config.php");

    if(isset($_GET["prodId"])){
        $user_id = $_SESSION["admin_id"];
        $status_id = 5;
        $item_id = $_GET["prodId"];

        $query = "UPDATE tbl_cart SET status_id = ? WHERE prod_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $status_id, $item_id);
        $stmt->execute();
        echo "deleted";
    }
?>