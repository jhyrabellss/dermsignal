<?php
session_start();
require_once("../config/config.php");

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}


require_once("../../dermatologist/derm-select.php");

$filter = $_POST['filter'] ?? 'today';
$offset = intval($_POST['offset'] ?? 0);
$limit = intval($_POST['limit'] ?? 10);

$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));

// Build query based on filter
$where_clause = "a.derm_id = ?";
$params = [$derm_id];
$types = "i";

switch ($filter) {
    case 'today':
        $where_clause .= " AND a.appointment_date = ? AND a.appointment_status IN ('Pending', 'Confirmed')";
        $params[] = $today;
        $types .= "s";
        $order_by = "a.appointment_time ASC";
        break;
        
    case 'upcoming':
        $where_clause .= " AND a.appointment_date >= ? AND a.appointment_status IN ('Pending', 'Confirmed')";
        $params[] = $tomorrow;
        $types .= "s";
        $order_by = "a.appointment_date ASC, a.appointment_time ASC";
        break;
        
    case 'completed':
        $where_clause .= " AND a.appointment_status = 'Completed'";
        $order_by = "a.appointment_date DESC, a.appointment_time DESC";
        break;
        
    case 'cancelled':
        $where_clause .= " AND a.appointment_status = 'Cancelled'";
        $order_by = "a.appointment_date DESC, a.appointment_time DESC";
        break;
        
    case 'all':
        $order_by = "a.appointment_date DESC, a.appointment_time DESC";
        break;
        
    default:
        $order_by = "a.appointment_date DESC, a.appointment_time DESC";
}

// Main query
$query = "SELECT 
            a.appointment_id,
            a.appointment_date,
            a.appointment_time,
            a.appointment_status,
            a.notes,
            s.service_name,
            ad.first_name,
            ad.last_name,
            ad.contact,
            ac.ac_email
          FROM tbl_appointments a
          JOIN tbl_services s ON a.service_id = s.service_id
          JOIN tbl_account_details ad ON a.ac_id = ad.ac_id
          JOIN tbl_account ac ON a.ac_id = ac.ac_id
          WHERE {$where_clause}
          ORDER BY {$order_by}
          LIMIT ? OFFSET ?";

$params[] = $limit + 1; // Get one extra to check if there are more
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$html = '';
$count = 0;
$has_more = false;

if ($result->num_rows > 0) {
    while ($appointment = $result->fetch_assoc()) {
        $count++;
        
        // Check if we have more records
        if ($count > $limit) {
            $has_more = true;
            break;
        }
        
        // Format date and time
        $date_formatted = date('M d, Y', strtotime($appointment['appointment_date']));
        $time_formatted = date('g:i A', strtotime($appointment['appointment_time']));
        
        // Determine status badge color
        $status_class = '';
        switch ($appointment['appointment_status']) {
            case 'Confirmed':
                $status_class = 'success';
                break;
            case 'Pending':
                $status_class = 'warning';
                break;
            case 'Completed':
                $status_class = 'info';
                break;
            case 'Cancelled':
                $status_class = 'danger';
                break;
        }
        
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($date_formatted) . '</td>';
        $html .= '<td>' . htmlspecialchars($time_formatted) . '</td>';
        $html .= '<td>' . htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($appointment['service_name']) . '</td>';
        $html .= '<td><span class="badge bg-' . $status_class . '">' . htmlspecialchars($appointment['appointment_status']) . '</span></td>';
        $html .= '<td>' . htmlspecialchars($appointment['contact'] ?: $appointment['ac_email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($appointment['notes'] ?: 'N/A') . '</td>';
        $html .= '</tr>';
    }
    
    echo json_encode([
        'status' => 'success',
        'html' => $html,
        'has_more' => $has_more
    ]);
} else {
    echo json_encode([
        'status' => 'empty',
        'html' => '<tr><td colspan="7" class="text-center text-muted">No appointments found</td></tr>',
        'has_more' => false
    ]);
}
?>