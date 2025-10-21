<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION["admin_id"])) {
    echo json_encode(['status' => 'unauthorized', 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_type = $_POST['account_type'] ?? '';
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name'] ?? '');
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'] ?? null;
    $contact = trim($_POST['contact'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields']);
        exit();
    }
    
    if (strlen($username) < 5) {
        echo json_encode(['status' => 'error', 'message' => 'Username must be at least 5 characters']);
        exit();
    }
    
    if (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters']);
        exit();
    }
    
    // Check if username already exists
    $check_username = "SELECT ac_id FROM tbl_account WHERE ac_username = ?";
    $stmt_check_user = $conn->prepare($check_username);
    $stmt_check_user->bind_param("s", $username);
    $stmt_check_user->execute();
    if ($stmt_check_user->get_result()->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
        exit();
    }
    
    // Check if email already exists
    $check_email = "SELECT ac_id FROM tbl_account WHERE ac_email = ?";
    $stmt_check_email = $conn->prepare($check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    if ($stmt_check_email->get_result()->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
        exit();
    }
    
    // Determine role_id
    $role_id = ($account_type === 'admin') ? 2 : 3;
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert into tbl_account
        $insert_account = "INSERT INTO tbl_account (ac_username, ac_email, ac_password, role_id, account_status_id) 
                          VALUES (?, ?, ?, ?, 1)";
        $stmt_account = $conn->prepare($insert_account);
        $stmt_account->bind_param("sssi", $username, $email, $hashed_password, $role_id);
        $stmt_account->execute();
        
        $ac_id = $conn->insert_id;
        
        // Insert into tbl_account_details
        $insert_details = "INSERT INTO tbl_account_details (ac_id, first_name, middle_name, last_name, gender, contact, address) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_details = $conn->prepare($insert_details);
        $stmt_details->bind_param("issssss", $ac_id, $first_name, $middle_name, $last_name, $gender, $contact, $address);
        $stmt_details->execute();
        
        // If dermatologist, insert into tbl_dermatologists
        if ($account_type === 'dermatologist') {
            $derm_name = trim($_POST['derm_name']);
            $derm_specialization = trim($_POST['derm_specialization']);
            
            if (empty($derm_name) || empty($derm_specialization)) {
                throw new Exception('Dermatologist name and specialization are required');
            }
            
            $insert_derm = "INSERT INTO tbl_dermatologists (ac_id, derm_name, derm_specialization, derm_status) 
                           VALUES (?, ?, ?, 'Active')";
            $stmt_derm = $conn->prepare($insert_derm);
            $stmt_derm->bind_param("iss", $ac_id, $derm_name, $derm_specialization);
            $stmt_derm->execute();
        }
        
        // Commit transaction
        $conn->commit();
        
        $account_type_label = ($account_type === 'admin') ? 'Admin' : 'Dermatologist';
        echo json_encode([
            'status' => 'success', 
            'message' => $account_type_label . ' account created successfully'
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>