<?php require_once("../backend/config/config.php") ?>
<?php
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'low';
$service_group = isset($_GET['service_group']) ? $_GET['service_group'] : 'all';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/slider.css">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/services.css">
    <link rel="stylesheet" href="../styles/prod-ingredients.css">
    <link rel="stylesheet" href="../styles/product-lists.css">
    <link rel="stylesheet" href="../styles/appointment-modal.css">
    <title>Our Services</title>
</head>
<body>
  
<?php include "./header.php" ?>

<?php include "./slideshow.php" ?>

<div class="individual-prod-main-cont">
    <a href="../index.php">
        <div id="main-title">Home/Services</div>
    </a>
    
    <div class="category-cont">
        <?php
        $current_group = isset($_GET['service_group']) ? htmlspecialchars($_GET['service_group']) : 'all';
        $sort = isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'low';

        $service_groups = [
            ['id' => 'all', 'name' => 'All Services'],
            ['id' => 'Consultation', 'name' => 'Consultation'],
            ['id' => 'Facial Services', 'name' => 'Facial Services'],
            ['id' => 'DRIPS', 'name' => 'DRIPS'],
            ['id' => 'PRP Hair Treatment', 'name' => 'PRP Hair'],
            ['id' => 'Q Laser Services', 'name' => 'Q Laser'],
            ['id' => 'Dermatologic Services', 'name' => 'Dermatologic'],
            ['id' => 'HIFU', 'name' => 'HIFU']
        ];

        foreach ($service_groups as $group) {
            $active_class = $group['id'] == $current_group ? 'background-active' : '';
            echo "<a href=\"?service_group={$group['id']}&sort=$sort\">
                    <div class=\"category-button $active_class\">{$group['name']}</div>
                  </a>";
        }
        ?>
        
        <form method="GET" action="">
            <input type="hidden" name="service_group" value="<?= isset($_GET['service_group']) ? htmlspecialchars($_GET['service_group']) : 'all' ?>">
            <select class="sort-by" name="sort" id="sort" onchange="this.form.submit()"> 
                <option value="low" <?= isset($_GET['sort']) && $_GET['sort'] == 'low' ? 'selected' : '' ?>>Low to High</option>
                <option value="high" <?= isset($_GET['sort']) && $_GET['sort'] == 'high' ? 'selected' : '' ?>>High to Low</option>
            </select>
        </form>
    </div>

    <div class="service-list-items-cont">
        <?php 
        $order = $sort == 'low' ? 'ASC' : 'DESC';
        $service_group_filter = isset($_GET['service_group']) ? htmlspecialchars($_GET['service_group']) : 'all';
        
        if ($service_group_filter != 'all') {
            $sql = "SELECT * FROM tbl_services WHERE service_group = ? ORDER BY service_price $order";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $service_group_filter);
        } else {
            $sql = "SELECT * FROM tbl_services ORDER BY service_price $order";
            $stmt = $conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            while($service = $result->fetch_assoc()) {
        ?>  
        <div class="service-item" data-service-id="<?= $service['service_id']?>">
            <div class="service-card">
                <?php 
                    if(!empty($service['service_image']) && file_exists("../backend/images/services/" . $service['service_image'])) {
                ?>
                <div class="service-image">
                    <img src="../backend/images/services/<?= $service['service_image'] ?>" alt="<?= $service['service_name'] ?>">
                </div>
                <?php }else{ ?>
                    <div class="service-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                <?php } ?>
                <div class="service-details">
                    <div class="service-name"><?= $service['service_name']; ?></div>
                    <div class="service-group-badge"><?= $service['service_group']; ?></div>
                    <div class="service-benefits"><?= $service['procedure_benefits']; ?></div>
                    <div class="service-sessions">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <?= $service['sessions']; ?> Sessions
                    </div>
                    <div class="service-price-cont">
                        <div class="service-price">₱<?= number_format($service['service_price'], 2); ?></div>
                        <div class="price-label">per session</div>
                    </div>
                </div>
                <button class="book-button" data-service-id="<?= $service['service_id']?>" data-service-name="<?= $service['service_name']?>" data-service-price="<?= $service['service_price']?>">
                    Book Appointment
                </button>
            </div>
        </div>
        <?php 
            } 
        } else {
            echo "<p style='text-align: center; width: 100%; padding: 40px;'>No services found in this category.</p>";
        }
        ?>
    </div> 
</div>

<!-- Appointment Modal -->
<div id="appointmentModal" class="appointment-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Book Your Appointment</h2>
        
        <form id="appointmentForm">
            <input type="hidden" id="selectedServiceId" name="service_id">
            
            <div class="form-group">
                <label>Selected Service</label>
                <div class="selected-service-display">
                    <span id="selectedServiceName"></span>
                    <span id="selectedServicePrice"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="dermatologist">Select Dermatologist *</label>
                <select id="dermatologist" name="derm_id" required>
                    <option value="">Choose a dermatologist</option>
                    <?php
                    $derm_sql = "SELECT * FROM tbl_dermatologists WHERE derm_status = 'Active'";
                    $derm_result = $conn->query($derm_sql);
                    while($derm = $derm_result->fetch_assoc()) {
                        echo "<option value='{$derm['derm_id']}'>{$derm['derm_name']} - {$derm['derm_specialization']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="appointmentDate">Select Date *</label>
                <input type="date" id="appointmentDate" name="appointment_date" required min="<?= date('Y-m-d') ?>">
            </div>

            <div class="form-group">
                <label>Available Time Slots *</label>
                <div id="timeSlotContainer" class="time-slot-container">
                    <p class="select-date-first">Please select a dermatologist and date first</p>
                </div>
            </div>

            <div class="form-group">
                <label for="appointmentNotes">Additional Notes (Optional)</label>
                <textarea id="appointmentNotes" name="notes" rows="4" placeholder="Any special requests or concerns..."></textarea>
            </div>

            <!-- Payment Section -->
            <div class="form-group payment-section">
                <label>Payment Required (50% Downpayment - Non-Refundable) *</label>
                <div class="payment-info">
                    <p>Downpayment Amount: <strong id="downpaymentAmount">₱0.00</strong></p>
                    <p class="payment-note">⚠️ This downpayment is non-refundable to secure your appointment slot.</p>
                </div>
                
                <div class="gcash-payment">
                    <h4>Pay via GCash</h4>
                    <div class="qr-code-container">
                        <img src="../images/icons/qr-cash.jpg" alt="GCash QR Code" style="max-width: 250px;">
                        <p>Scan this QR code with your GCash app</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="gcashNumber">GCash Reference Number *</label>
                    <input type="text" id="gcashNumber" name="gcash_reference" required placeholder="Enter your GCash reference number">
                </div>

                <div class="form-group">
                    <label for="paymentProof">Upload Payment Proof *</label>
                    <input type="file" id="paymentProof" name="payment_proof" accept="image/*" required>
                    <small>Upload a screenshot of your GCash payment</small>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-confirm">Confirm Appointment & Pay</button>
            </div>
        </form>
    </div>
</div>

<?php
if((!empty($_SESSION["user_id"]))) {
    include "cart.php";
}
include "footer.php"
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
    const modal = $('#appointmentModal');
    let selectedTimeSlot = null;
    let selectedServicePrice = 0;

    // Open modal when book button is clicked
    $('.book-button').click(function() {
        <?php if(empty($_SESSION["user_id"])): ?>
            Swal.fire({
                icon: 'warning',
                title: 'Please Login',
                text: 'You need to be logged in to book an appointment',
                confirmButtonColor: 'rgb(39,153,137)'
            });
            return;
        <?php else: ?>
            const serviceId = $(this).data('service-id');
            const serviceName = $(this).data('service-name');
            const servicePrice = $(this).data('service-price');
            
            selectedServicePrice = parseFloat(servicePrice);
            const downpayment = (selectedServicePrice * 0.5).toFixed(2);
            
            $('#selectedServiceId').val(serviceId);
            $('#selectedServiceName').text(serviceName);
            $('#selectedServicePrice').text('₱' + selectedServicePrice.toFixed(2));
            $('#downpaymentAmount').text('₱' + downpayment);
            
            modal.fadeIn();
        <?php endif; ?>
    });

    // Close modal
    $('.close-modal, .btn-cancel').click(function() {
        modal.fadeOut();
        resetForm();
    });

    // Close modal when clicking outside
    $(window).click(function(event) {
        if (event.target.id === 'appointmentModal') {
            modal.fadeOut();
            resetForm();
        }
    });

    // Load available time slots when dermatologist and date are selected
    $('#dermatologist, #appointmentDate').change(function() {
        const dermId = $('#dermatologist').val();
        const appointmentDate = $('#appointmentDate').val();
        const service_id = $('#selectedServiceId').val();
        
        if (dermId && appointmentDate) {
            loadTimeSlots(dermId, appointmentDate, service_id);
        }
    });

    // Function to load available time slots
    function loadTimeSlots(dermId, date, service_id) {
        $.ajax({
            url: '../backend/get_available_slots.php',
            type: 'POST',
            data: {
                derm_id: dermId,
                appointment_date: date,
                service_id: service_id
            },
            success: function(response) {
                const data = JSON.parse(response);
                const container = $('#timeSlotContainer');
                container.empty();

                if (data.status === 'failed') {
                    container.html(`<p class="select-date-first">${data.error}</p>`);
                    return;
                }
                
                if (data.slots.length === 0) {
                    container.html('<p class="select-date-first">No available slots for this date</p>');
                    return;
                }

                data.slots.forEach(function(slot) {
                    const timeSlot = $('<div>')
                        .addClass('time-slot')
                        .attr('data-time', slot.time)
                        .text(slot.time);
                    
                    if (!slot.available) {
                        timeSlot.addClass('disabled');
                    } else {
                        timeSlot.click(function() {
                            if (!$(this).hasClass('disabled')) {
                                $('.time-slot').removeClass('selected');
                                $(this).addClass('selected');
                                selectedTimeSlot = $(this).data('time');
                            }
                        });
                    }
                    
                    container.append(timeSlot);
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load time slots',
                    confirmButtonColor: 'rgb(39,153,137)'
                });
            }
        });
    }

    // Handle form submission
    $('#appointmentForm').submit(function(e) {
        e.preventDefault();
        
        if (!selectedTimeSlot) {
            Swal.fire({
                icon: 'warning',
                title: 'Select Time Slot',
                text: 'Please select an available time slot',
                confirmButtonColor: 'rgb(39,153,137)'
            });
            return;
        }

        const appointmentDate = new Date($('#appointmentDate').val());
        const currentDateTime = new Date();

        if(appointmentDate < currentDateTime.setHours(0,0,0,0)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date',
                text: 'Appointment date cannot be in the past.',
                confirmButtonColor: 'rgb(39,153,137)'
            });
            return;
        }

        const formData = new FormData();
        formData.append('service_id', $('#selectedServiceId').val());
        formData.append('derm_id', $('#dermatologist').val());
        formData.append('appointment_date', $('#appointmentDate').val());
        formData.append('appointment_time', selectedTimeSlot);
        formData.append('notes', $('#appointmentNotes').val());
        formData.append('gcash_reference', $('#gcashNumber').val());
        formData.append('downpayment_amount', (selectedServicePrice * 0.5).toFixed(2));
        formData.append('payment_proof', $('#paymentProof')[0].files[0]);
        
        $.ajax({
            url: '../backend/book_appointment.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Appointment Booked!',
                        text: 'Your appointment has been successfully booked. Payment is being verified.',
                        confirmButtonColor: 'rgb(39,153,137)'
                    }).then(() => {
                        modal.fadeOut();
                        resetForm();
                    });
                } else if (response === 'slot_taken') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Slot Unavailable',
                        text: 'This time slot has just been booked. Please select another time.',
                        confirmButtonColor: 'rgb(39,153,137)'
                    });
                    loadTimeSlots($('#dermatologist').val(), $('#appointmentDate').val(), $('#selectedServiceId').val());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Booking Failed',
                        text: response || 'Failed to book appointment. Please try again.',
                        confirmButtonColor: 'rgb(39,153,137)'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    confirmButtonColor: 'rgb(39,153,137)'
                });
            }
        });
    });

    // Reset form function
    function resetForm() {
        $('#appointmentForm')[0].reset();
        $('#timeSlotContainer').html('<p class="select-date-first">Please select a dermatologist and date first</p>');
        selectedTimeSlot = null;
        selectedServicePrice = 0;
    }
});
</script>

</body>
</html>