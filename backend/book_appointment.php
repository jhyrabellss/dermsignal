<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "no_session";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ac_id = $_SESSION["user_id"];
    $service_id = intval($_POST['service_id']);
    $derm_id = intval($_POST['derm_id']);
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = date('H:i:s', strtotime($_POST['appointment_time']));
    $notes = isset($_POST['notes']) ? $_POST['notes'] : null;
    $gcash_reference = $_POST['gcash_reference'];
    $downpayment_amount = floatval($_POST['downpayment_amount']);
    
    // Handle file upload for payment proof
    $payment_proof = '';
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
        $target_dir = "images/payment_proofs/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            echo "invalid_file_type";
            exit();
        }
        
        $payment_proof = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $payment_proof;
        
        if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $target_file)) {
            echo "upload_failed";
            exit();
        }
    } else {
        echo "no_payment_proof";
        exit();
    }
    
    // Check if slot is still available (prevent double booking)
    $check_query = "SELECT COUNT(*) as count FROM tbl_appointments 
                    WHERE derm_id = ? 
                    AND appointment_date = ? 
                    AND appointment_time = ? 
                    AND appointment_status != 'Cancelled'";
    
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("iss", $derm_id, $appointment_date, $appointment_time);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    
    if ($check_row['count'] > 0) {
        // Delete uploaded file if slot is taken
        if (file_exists($target_dir . $payment_proof)) {
            unlink($target_dir . $payment_proof);
        }
        echo "slot_taken";
        exit();
    }
    
    // Insert appointment with payment information
    $insert_query = "INSERT INTO tbl_appointments 
                     (ac_id, service_id, derm_id, appointment_date, appointment_time, notes, 
                      gcash_reference, downpayment_amount, payment_proof, payment_status, appointment_status) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Pending')";
    
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("iiissssds", 
        $ac_id, 
        $service_id, 
        $derm_id, 
        $appointment_date, 
        $appointment_time, 
        $notes,
        $gcash_reference,
        $downpayment_amount,
        $payment_proof
    );

    if ($insert_stmt->execute()) {
        echo "success";
    } else {
        // Delete uploaded file if database insert fails
        if (file_exists($target_dir . $payment_proof)) {
            unlink($target_dir . $payment_proof);
        }
        echo "error";
    }
    
    $insert_stmt->close();
    $check_stmt->close();
    $conn->close();
}
?>