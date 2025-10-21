<?php
header('Content-Type: application/json');
require_once("../../backend/config/config.php");

$filter_type = $_POST['filter_type'] ?? 'year';
$filter_date = $_POST['filter_date'] ?? date('Y');

$labels = [];
$actual = [];
$forecast = [];

try {
    if ($filter_type === 'year') {
        // Yearly trend - last 5 years
        $years = [];
        for ($i = 4; $i >= 0; $i--) {
            $years[] = date('Y') - $i;
        }

        foreach ($years as $year) {
            $labels[] = $year;
            
            // Get actual sales for the year
            $actual_query = "SELECT SUM(tp.prod_price * tc.prod_qnty) AS total 
                            FROM tbl_cart tc 
                            INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                            WHERE tc.status_id = 2 AND YEAR(tc.order_date) = $year";
            
            $actual_result = $conn->query($actual_query);
            $actual_sales = $actual_result->fetch_assoc()['total'] ?? 0;
            $actual[] = (float)$actual_sales;

            // Get service sales
            $service_query = "SELECT SUM(ts.service_price) AS total 
                             FROM tbl_appointments ta 
                             INNER JOIN tbl_services ts ON ta.service_id = ts.service_id
                             WHERE ta.appointment_status = 'Completed' AND YEAR(ta.created_at) = $year";
            
            $service_result = $conn->query($service_query);
            $service_sales = $service_result->fetch_assoc()['total'] ?? 0;
            
            $total_actual = $actual_sales + $service_sales;
            $actual[count($actual) - 1] = (float)$total_actual;
        }

        // Calculate forecast with wave-like pattern (5% growth + seasonal variation)
        $avg_actual = array_sum($actual) / count($actual);
        foreach ($actual as $index => $value) {
            $base_forecast = $value * 1.05; // 5% growth
            $wave_factor = sin($index * pi() / 2.5) * 0.2; // Creates wave effect
            $forecast[] = (float)($base_forecast * (1 + $wave_factor));
        }

    } elseif ($filter_type === 'month') {
        // Monthly trend for selected year
        $year = (int)$filter_date;
        
        for ($month = 1; $month <= 12; $month++) {
            $month_name = date('M', mktime(0, 0, 0, $month, 1));
            $labels[] = $month_name;

            // Get actual sales for the month
            $actual_query = "SELECT SUM(tp.prod_price * tc.prod_qnty) AS total 
                            FROM tbl_cart tc 
                            INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                            WHERE tc.status_id = 2 
                            AND YEAR(tc.order_date) = $year 
                            AND MONTH(tc.order_date) = $month";
            
            $actual_result = $conn->query($actual_query);
            $product_sales = $actual_result->fetch_assoc()['total'] ?? 0;

            // Get service sales
            $service_query = "SELECT SUM(ts.service_price) AS total 
                             FROM tbl_appointments ta 
                             INNER JOIN tbl_services ts ON ta.service_id = ts.service_id
                             WHERE ta.appointment_status = 'Completed' 
                             AND YEAR(ta.created_at) = $year 
                             AND MONTH(ta.created_at) = $month";
            
            $service_result = $conn->query($service_query);
            $service_sales = $service_result->fetch_assoc()['total'] ?? 0;
            
            $total_actual = (float)$product_sales + (float)$service_sales;
            $actual[] = $total_actual;
        }

        // Calculate forecast with wave pattern (5% growth)
        $avg_actual = array_sum($actual) / count($actual);
        foreach ($actual as $index => $value) {
            $base_forecast = $value * 1.05;
            $wave_factor = sin($index * pi() / 6) * 0.2;
            $forecast[] = (float)($base_forecast * (1 + $wave_factor));
        }

    } elseif ($filter_type === 'day') {
        // Daily trend for selected month
        $date_obj = DateTime::createFromFormat('Y-m', $filter_date);
        if (!$date_obj) {
            throw new Exception("Invalid date format");
        }
        
        $year = $date_obj->format('Y');
        $month = $date_obj->format('m');
        $days_in_month = $date_obj->format('t');

        for ($day = 1; $day <= $days_in_month; $day++) {
            $labels[] = $day;

            // Get actual sales for the day
            $actual_query = "SELECT SUM(tp.prod_price * tc.prod_qnty) AS total 
                            FROM tbl_cart tc 
                            INNER JOIN tbl_products tp ON tc.prod_id = tp.prod_id
                            WHERE tc.status_id = 2 
                            AND YEAR(tc.order_date) = $year 
                            AND MONTH(tc.order_date) = $month
                            AND DAY(tc.order_date) = $day";
            
            $actual_result = $conn->query($actual_query);
            $product_sales = $actual_result->fetch_assoc()['total'] ?? 0;

            // Get service sales
            $service_query = "SELECT SUM(ts.service_price) AS total 
                             FROM tbl_appointments ta 
                             INNER JOIN tbl_services ts ON ta.service_id = ts.service_id
                             WHERE ta.appointment_status = 'Completed' 
                             AND YEAR(ta.created_at) = $year 
                             AND MONTH(ta.created_at) = $month
                             AND DAY(ta.created_at) = $day";
            
            $service_result = $conn->query($service_query);
            $service_sales = $service_result->fetch_assoc()['total'] ?? 0;
            
            $total_actual = (float)$product_sales + (float)$service_sales;
            $actual[] = $total_actual;
        }

        // Calculate forecast with wave pattern (5% growth)
        $avg_actual = array_sum($actual) / count($actual);
        foreach ($actual as $index => $value) {
            $base_forecast = $value * 1.05;
            $wave_factor = sin($index * pi() / ($days_in_month / 2)) * 0.2;
            $forecast[] = (float)($base_forecast * (1 + $wave_factor));
        }
    }

    echo json_encode([
        'labels' => $labels,
        'actual' => $actual,
        'forecast' => $forecast,
        'error' => null
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage(),
        'labels' => [],
        'actual' => [],
        'forecast' => []
    ]);
}
?>