<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ac_id = $_SESSION["derm_id"];
    $name = trim($_POST['name']);
    $specialization = trim($_POST['specialization']);
    
    if (empty($name) || empty($specialization)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit();
    }
    
    // Get derm_id
    $get_derm_query = "SELECT derm_id FROM tbl_dermatologists WHERE ac_id = ?";
    $get_stmt = $conn->prepare($get_derm_query);
    $get_stmt->bind_param("i", $ac_id);
    $get_stmt->execute();
    $get_result = $get_stmt->get_result();
    $derm_data = $get_result->fetch_assoc();
    
    if (!$derm_data) {
        echo json_encode(['status' => 'error', 'message' => 'Dermatologist not found']);
        exit();
    }
    
    $derm_id = $derm_data['derm_id'];
    
    // Update dermatologist information
    $update_query = "UPDATE tbl_dermatologists SET derm_name = ?, derm_specialization = ? WHERE derm_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $name, $specialization, $derm_id);
    
    if ($update_stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update professional information']);
    }
}
?>