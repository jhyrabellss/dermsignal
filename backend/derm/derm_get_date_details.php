<?php
require_once("../config/config.php");
session_start();

if (!isset($_SESSION["derm_id"])) {
    echo json_encode(['status' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../../dermatologist/derm-select.php");
    $date = $_POST['date'];
    
    // Get appointments for this date
    $apt_query = "SELECT 
                    a.*,
                    s.service_name,
                    ad.first_name,
                    ad.last_name,
                    ad.contact,
                    ac.ac_email as email
                  FROM tbl_appointments a
                  JOIN tbl_services s ON a.service_id = s.service_id
                  JOIN tbl_account_details ad ON a.ac_id = ad.ac_id
                  JOIN tbl_account ac ON a.ac_id = ac.ac_id
                  WHERE a.derm_id = ? 
                  AND a.appointment_date = ?
                  AND a.appointment_status != 'Cancelled'
                  ORDER BY a.appointment_time ASC";
    
    $apt_stmt = $conn->prepare($apt_query);
    $apt_stmt->bind_param("is", $derm_id, $date);
    $apt_stmt->execute();
    $apt_result = $apt_stmt->get_result();
    
    $appointments = [];
    while ($row = $apt_result->fetch_assoc()) {
        $appointments[] = $row;
    }
    
    // Get schedule for this date
    $sch_query = "SELECT 
                    ds.schedule_id,
                    ds.time_slot,
                    ds.is_available,
                    CASE 
                        WHEN EXISTS (
                            SELECT 1 FROM tbl_appointments 
                            WHERE derm_id = ds.derm_id 
                            AND appointment_date = ds.schedule_date 
                            AND appointment_time = ds.time_slot 
                            AND appointment_status != 'Cancelled'
                        ) THEN 1 
                        ELSE 0 
                    END as is_booked
                  FROM tbl_derm_schedule ds
                  WHERE ds.derm_id = ? AND ds.schedule_date = ?
                  ORDER BY ds.time_slot ASC";
    
    $sch_stmt = $conn->prepare($sch_query);
    $sch_stmt->bind_param("is", $derm_id, $date);
    $sch_stmt->execute();
    $sch_result = $sch_stmt->get_result();
    
    $schedules = [];
    while ($row = $sch_result->fetch_assoc()) {
        $schedules[] = $row;
    }
    
    echo json_encode([
        'status' => 'success',
        'appointments' => $appointments,
        'schedules' => $schedules
    ]);
}
?>