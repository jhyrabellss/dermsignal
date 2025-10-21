<?php
session_start();
require_once("../../backend/config/config.php");

if (empty($_SESSION["admin_id"])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get voucher usage statistics
$query = "SELECT 
    v.voucher_id,
    v.voucher_name,
    v.voucher_code,
    v.discount_type,
    v.discount_value,
    v.voucher_type,
    v.used_count,
    v.usage_limit,
    v.total_revenue_generated,
    v.total_discount_given,
    v.start_date,
    v.end_date,
    v.is_active,
    COUNT(DISTINCT vu.account_id) as unique_customers,
    COUNT(vu.usage_id) as total_usage,
    COALESCE(SUM(vu.discount_amount), 0) as actual_discount_given,
    COALESCE(AVG(vu.discount_amount), 0) as avg_discount_per_use
FROM tbl_vouchers v
LEFT JOIN tbl_voucher_usage vu ON v.voucher_id = vu.voucher_id
GROUP BY v.voucher_id
ORDER BY v.created_at DESC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Voucher</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Discount</th>
                    <th>Times Used</th>
                    <th>Unique Customers</th>
                    <th>Total Discount Given</th>
                    <th>Revenue Impact</th>
                    <th>Avg Discount/Use</th>
                    <th>Status</th>
                    <th>Period</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
    
    while ($voucher = $result->fetch_assoc()) {
        $discount_text = $voucher['discount_type'] == 'percentage' 
            ? $voucher['discount_value'] . '%' 
            : '₱' . number_format($voucher['discount_value'], 2);
        
        $usage_text = $voucher['usage_limit'] 
            ? $voucher['total_usage'] . ' / ' . $voucher['usage_limit'] 
            : $voucher['total_usage'] . ' / Unlimited';
        
        $usage_percentage = 0;
        if ($voucher['usage_limit'] > 0) {
            $usage_percentage = ($voucher['total_usage'] / $voucher['usage_limit']) * 100;
        }
        
        // Determine status
        $today = date('Y-m-d');
        if (!$voucher['is_active']) {
            $status_badge = '<span class="badge bg-secondary">Inactive</span>';
        } elseif ($today < $voucher['start_date']) {
            $status_badge = '<span class="badge bg-info">Upcoming</span>';
        } elseif ($today > $voucher['end_date']) {
            $status_badge = '<span class="badge bg-warning">Expired</span>';
        } else {
            $status_badge = '<span class="badge bg-success">Active</span>';
        }
        
        // Color code for usage
        $usage_color = 'text-success';
        if ($usage_percentage > 80) {
            $usage_color = 'text-danger';
        } elseif ($usage_percentage > 50) {
            $usage_color = 'text-warning';
        }
        
        echo '<tr>
                <td><strong>' . htmlspecialchars($voucher['voucher_name']) . '</strong></td>
                <td><code>' . htmlspecialchars($voucher['voucher_code']) . '</code></td>
                <td>' . ucfirst($voucher['voucher_type']) . '</td>
                <td>' . $discount_text . '</td>
                <td class="' . $usage_color . '">
                    <strong>' . $usage_text . '</strong>
                    ' . ($voucher['usage_limit'] > 0 ? '<br><small>(' . number_format($usage_percentage, 1) . '%)</small>' : '') . '
                </td>
                <td><i class="fas fa-users"></i> ' . $voucher['unique_customers'] . '</td>
                <td class="text-danger"><strong>-₱' . number_format($voucher['actual_discount_given'], 2) . '</strong></td>
                <td class="text-success"><strong>₱' . number_format($voucher['total_revenue_generated'], 2) . '</strong></td>
                <td>₱' . number_format($voucher['avg_discount_per_use'], 2) . '</td>
                <td>' . $status_badge . '</td>
                <td>
                    <small>' . date('M d, Y', strtotime($voucher['start_date'])) . '<br>to<br>' 
                    . date('M d, Y', strtotime($voucher['end_date'])) . '</small>
                </td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="viewUsageDetails(' . $voucher['voucher_id'] . ')">
                        <i class="fas fa-eye"></i> Details
                    </button>
                </td>
              </tr>';
    }
    
    echo '</tbody></table>';
} else {
    echo '<div class="alert alert-info">No vouchers found.</div>';
}
?>