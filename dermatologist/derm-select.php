<?php
$ac_id = $_SESSION["derm_id"]; 
    $select_query = "SELECT * FROM tbl_dermatologists WHERE ac_id = ?";
    $stmt = $conn->prepare($select_query);
    $stmt->bind_param("i", $ac_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $derm_id = $data["derm_id"];
?>