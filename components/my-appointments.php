<?php 
require_once("../backend/config/config.php");
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/my-appointments.css">
     <link rel="stylesheet" href="../styles/prod-ingredients.css">
    <link rel="stylesheet" href="../styles/product-lists.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <title>My Appointments</title>
</head>
<body>

<?php include "./header.php" ?>

<div class="appointments-container">
    <h1>My Appointments</h1>
    
    <div class="appointments-filter">
        <button class="filter-btn active" data-status="all">All</button>
        <button class="filter-btn" data-status="Pending">Pending</button>
        <button class="filter-btn" data-status="Confirmed">Confirmed</button>
        <button class="filter-btn" data-status="Completed">Completed</button>
        <button class="filter-btn" data-status="Cancelled">Cancelled</button>
    </div>

    <div class="appointments-list">
        <?php
        $query = "SELECT 
                    a.appointment_id,
                    a.appointment_date,
                    a.appointment_time,
                    a.appointment_status,
                    a.notes,
                    a.created_at,
                    s.service_name,
                    s.service_price,
                    s.service_group,
                    d.derm_name,
                    d.derm_specialization,
                    d.derm_image
                  FROM tbl_appointments a
                  JOIN tbl_services s ON a.service_id = s.service_id
                  JOIN tbl_dermatologists d ON a.derm_id = d.derm_id
                  WHERE a.ac_id = ?
                  ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($appointment = $result->fetch_assoc()) {
                $status_class = strtolower($appointment['appointment_status']);
                $date_formatted = date('F d, Y', strtotime($appointment['appointment_date']));
                $time_formatted = date('g:i A', strtotime($appointment['appointment_time']));
                $can_cancel = $appointment['appointment_status'] == 'Pending' || $appointment['appointment_status'] == 'Confirmed';
        ?>
        <div class="appointment-card" data-status="<?= $appointment['appointment_status'] ?>">
            <div class="appointment-header">
                <div class="appointment-status status-<?= $status_class ?>">
                    <?= $appointment['appointment_status'] ?>
                </div>
                <div class="appointment-date-time">
                    <strong><?= $date_formatted ?></strong> at <strong><?= $time_formatted ?></strong>
                </div>
            </div>
            
            <div class="appointment-body">
                <div class="appointment-service">
                    <h3><?= $appointment['service_name'] ?></h3>
                    <span class="service-category"><?= $appointment['service_group'] ?></span>
                </div>
                
                <div class="appointment-doctor">
                    <div class="profile-image">
                        <?php
                        if (is_null($appointment["derm_image"])) {
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <?php
                            } else {
                        ?>
                        <img src="../images/profile_images/<?= $appointment['derm_image'] ?>" alt="Doctor Image" width="80" height="80"
                        style="border-radius: 100%; object-fit: cover;">
                        <?php
                            }
                        ?>
                    </div>
                    <div>
                        <div class="doctor-name"><?= $appointment['derm_name'] ?></div>
                        <div class="doctor-spec"><?= $appointment['derm_specialization'] ?></div>
                    </div>
                </div>
                
                <?php if ($appointment['notes']): ?>
                <div class="appointment-notes">
                    <strong>Notes:</strong> <?= htmlspecialchars($appointment['notes']) ?>
                </div>
                <?php endif; ?>
                
                <div class="appointment-price">
                    <strong>Price:</strong> ₱<?= number_format($appointment['service_price'], 2) ?>
                </div>
            </div>
            
            <div class="appointment-actions">
                <small class="booking-date">Booked on: <?= date('M d, Y', strtotime($appointment['created_at'])) ?></small>
                <?php if ($can_cancel): ?>
                <button class="btn-cancel-appointment" data-appointment-id="<?= $appointment['appointment_id'] ?>">
                    Cancel Appointment
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php
            }
        } else {
            echo '<div class="no-appointments">
                    <p>You have no appointments yet.</p>
                    <a href="services.php" class="btn-book-now">Book Your First Appointment</a>
                  </div>';
        }
        ?>
    </div>
</div>

<?php include "footer.php" ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
    // Filter appointments
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        const status = $(this).data('status');
        
        if (status === 'all') {
            $('.appointment-card').show();
        } else {
            $('.appointment-card').hide();
            $(`.appointment-card[data-status="${status}"]`).show();
        }
    });
    
    // Cancel appointment
    $('.btn-cancel-appointment').click(function() {
        const appointmentId = $(this).data('appointment-id');
        
        Swal.fire({
            title: 'Cancel Appointment?',
            text: "Are you sure you want to cancel this appointment?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../backend/cancel_appointment.php',
                    type: 'POST',
                    data: { appointment_id: appointmentId },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled!',
                                text: 'Your appointment has been cancelled.',
                                confirmButtonColor: 'rgb(39,153,137)'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to cancel appointment.',
                                confirmButtonColor: 'rgb(39,153,137)'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred.',
                            confirmButtonColor: 'rgb(39,153,137)'
                        });
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>