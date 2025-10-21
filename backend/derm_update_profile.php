<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo "unauthorized";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../dermatologist/derm-select.php");
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    
    $query = "UPDATE tbl_dermatologists SET derm_name = ?, derm_specialization = ? WHERE derm_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $name, $specialization, $derm_id);
    
    if ($stmt->execute()) {
        $_SESSION["derm_name"] = $name; // Update session
        echo "success";
    } else {
        echo "error";
    }
}
?>