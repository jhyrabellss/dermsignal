<?php
require_once("../../backend/config/config.php");

if (isset($_POST['voucher_id'])) {
    $voucher_id = $_POST['voucher_id'];
    
    $stmt = $conn->prepare("DELETE FROM tbl_vouchers WHERE voucher_id = ?");
    $stmt->bind_param("i", $voucher_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Voucher deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete voucher']);
    }
    $stmt->close();
}
?>