<?php 
require_once("../backend/config/config.php");
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/admin-schedules.css">
    <title>Manage Schedules</title>
</head>
<body>

<div class="admin-container">
    <h1>Manage Dermatologist Schedules</h1>
    
    <div class="schedule-controls">
        <div class="control-group">
            <label for="selectDerm">Select Dermatologist:</label>
            <select id="selectDerm" class="form-control">
                <option value="">Choose dermatologist</option>
                <?php
                $derm_sql = "SELECT * FROM tbl_dermatologists";
                $derm_result = $conn->query($derm_sql);
                while($derm = $derm_result->fetch_assoc()) {
                    echo "<option value='{$derm['derm_id']}'>{$derm['derm_name']}</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="control-group">
            <label for="selectDate">Select Date:</label>
            <input type="date" id="selectDate" class="form-control" min="<?= date('Y-m-d') ?>">
        </div>
        
        <button id="loadSchedule" class="btn-primary">Load Schedule</button>
        <button id="generateSchedules" class="btn-success">Generate 30 Days Schedule</button>
    </div>
    
    <div id="scheduleDisplay" class="schedule-display">
        <p class="info-text">Select a dermatologist and date to view/edit schedule</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
    // Load schedule
    $('#loadSchedule').click(function() {
        const dermId = $('#selectDerm').val();
        const date = $('#selectDate').val();
        
        if (!dermId || !date) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please select both dermatologist and date',
                confirmButtonColor: 'rgb(39,153,137)'
            });
            return;
        }
        
        $.ajax({
            url: '../backend/admin_schedule_actions.php',
            type: 'POST',
            data: {
                action: 'load_schedule',
                derm_id: dermId,
                date: date
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    displaySchedule(data.slots, date);
                }
            }
        });
    });
    
    // Display schedule
    function displaySchedule(slots, date) {
        let html = `<h3>Schedule for ${date}</h3><div class="time-slots-grid">`;
        
        if (slots.length === 0) {
            html += '<p>No schedule found for this date. Click "Generate 30 Days Schedule" to create one.</p>';
        } else {
            slots.forEach(function(slot) {
                const availableClass = slot.is_available == 1 ? 'available' : 'unavailable';
                const availableText = slot.is_available == 1 ? 'Available' : 'Unavailable';
                const time = new Date('2000-01-01 ' + slot.time_slot).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
                
                html += `
                    <div class="time-slot-admin ${availableClass}">
                        <div class="time">${time}</div>
                        <div class="status">${availableText}</div>
                        <button class="btn-toggle" data-schedule-id="${slot.schedule_id}" data-available="${slot.is_available}">
                            Toggle
                        </button>
                    </div>
                `;
            });
        }
        
        html += '</div>';
        $('#scheduleDisplay').html(html);
        
        // Add toggle event listeners
        $('.btn-toggle').click(function() {
            const scheduleId = $(this).data('schedule-id');
            const currentStatus = $(this).data('available');
            const newStatus = currentStatus == 1 ? 0 : 1;
            
            toggleAvailability(scheduleId, newStatus);
        });
    }
    
    // Toggle availability
    function toggleAvailability(scheduleId, isAvailable) {
        $.ajax({
            url: '../backend/admin_schedule_actions.php',
            type: 'POST',
            data: {
                action: 'toggle_availability',
                schedule_id: scheduleId,
                is_available: isAvailable
            },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#loadSchedule').click(); // Reload schedule
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Schedule updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            }
        });
    }
    
    // Generate 30 days schedule
    $('#generateSchedules').click(function() {
        const dermId = $('#selectDerm').val();
        
        if (!dermId) {
            Swal.fire({
                icon: 'warning',
                title: 'Select Dermatologist',
                text: 'Please select a dermatologist first',
                confirmButtonColor: 'rgb(39,153,137)'
            });
            return;
        }
        
        Swal.fire({
            title: 'Generate Schedules?',
            text: 'This will create schedules for the next 30 days (excluding Sundays)',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'rgb(39,153,137)',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, generate!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../backend/admin_schedule_actions.php',
                    type: 'POST',
                    data: {
                        action: 'generate_schedules',
                        derm_id: dermId
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                confirmButtonColor: 'rgb(39,153,137)'
                            });
                        }
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>