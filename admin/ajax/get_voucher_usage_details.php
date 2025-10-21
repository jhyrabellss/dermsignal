<?php
session_start();
require_once("../../backend/config/config.php");

if (empty($_SESSION["admin_id"])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$voucher_id = $_POST['voucher_id'] ?? 0;

// Get voucher details
$voucher_query = "SELECT * FROM tbl_vouchers WHERE voucher_id = ?";
$stmt = $conn->prepare($voucher_query);
$stmt->bind_param("i", $voucher_id);
$stmt->execute();
$voucher = $stmt->get_result()->fetch_assoc();

// Get usage history
$usage_query = "SELECT 
    vu.*,
    CONCAT(ad.first_name, ' ', ad.last_name) as customer_name,
    a.ac_email
FROM tbl_voucher_usage vu
INNER JOIN tbl_account a ON vu.account_id = a.ac_id
INNER JOIN tbl_account_details ad ON a.ac_id = ad.ac_id
WHERE vu.voucher_id = ?
ORDER BY vu.used_date DESC";

$stmt = $conn->prepare($usage_query);
$stmt->bind_param("i", $voucher_id);
$stmt->execute();
$usage_result = $stmt->get_result();

$response = [
    'voucher' => $voucher,
    'usage' => []
];

while ($usage = $usage_result->fetch_assoc()) {
    $response['usage'][] = $usage;
}

echo json_encode($response);
?>