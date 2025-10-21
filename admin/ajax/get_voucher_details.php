<?php
require_once("../../backend/config/config.php");

if (isset($_POST['voucher_id'])) {
    $voucher_id = $_POST['voucher_id'];
    
    $stmt = $conn->prepare("SELECT * FROM tbl_vouchers WHERE voucher_id = ?");
    $stmt->bind_param("i", $voucher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $voucher = $result->fetch_assoc();
        echo json_encode($voucher);
    } else {
        echo json_encode(['error' => 'Voucher not found']);
    }
    $stmt->close();
}
?>