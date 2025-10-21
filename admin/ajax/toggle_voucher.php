<?php
require_once("../../backend/config/config.php");

if (isset($_POST['voucher_id']) && isset($_POST['current_status'])) {
    $voucher_id = $_POST['voucher_id'];
    $new_status = $_POST['current_status'] == 1 ? 0 : 1;
    
    $stmt = $conn->prepare("UPDATE tbl_vouchers SET is_active = ? WHERE voucher_id = ?");
    $stmt->bind_param("ii", $new_status, $voucher_id);
    
    if ($stmt->execute()) {
        $message = $new_status == 1 ? 'Voucher activated!' : 'Voucher deactivated!';
        echo json_encode(['success' => true, 'message' => $message]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update voucher status']);
    }
    $stmt->close();
}
?>