<?php
session_start();
if(empty($_SESSION["derm_id"])){
  header('Location:../index.php');
  exit();
}
require_once("../backend/config/config.php");
require_once("./derm-select.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>My Schedule</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../styles/bootsrap5-min.css">
    <link rel="stylesheet" href="../styles/card-general.css">
    <link rel="stylesheet" href="../styles/admin-schedules.css">
    <style>
      #calendar {
        max-width: 1100px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      .fc-event {
        cursor: pointer;
      }
      .fc-daygrid-day-number {
        cursor: pointer;
      }

      .fc-event-title{
        padding: 4px 10px !important;
        text-align: center;
      }

      .appointment-badge {
        background: #28a745;
        color: white;
        padding: 2px 6px;
        border-radius: 10px;
        font-size: 11px;
        margin-left: 5px;
      }
      .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow: hidden;
      }
      .modal-content {
        background-color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 0;
        border-radius: 8px;
        width: 90%;
        max-width: 650px;
        max-height: 85vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
      }
      .modal-header {
        background-color: rgb(39,153,137);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
      }
      .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
      }
      .close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        border: none;
        background: none;
      }
      .close:hover {
        opacity: 0.8;
      }
      .appointment-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        background: #f8f9fa;
      }
      .appointment-item h5 {
        margin: 0 0 10px 0;
        color: rgb(39,153,137);
      }
      .appointment-info {
        display: grid;
        gap: 5px;
      }
      .time-slot-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 8px;
      }
      .time-slot-item.available {
        background: rgba(40, 167, 69, 0.1);
        border-color: #28a745;
      }
      .time-slot-item.unavailable {
        background: rgba(220, 53, 69, 0.1);
        border-color: #dc3545;
      }
      .time-slot-item.booked {
        background: rgba(255, 193, 7, 0.1);
        border-color: #ffc107;
      }
      .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        margin-left: 5px;
      }
      .btn-danger {
        background: #dc3545;
        color: white;
      }
      .btn-toggle {
        background: rgb(39,153,137);
        color: white;
      }

      .time-slot-actions {
        display: flex;
        align-items: center;
      }
    </style>
  </head>
  <body class="sb-nav-fixed">
    <?php require_once("./derm-navbar.php"); ?>
    <div id="layoutSidenav">
      <?php require_once("./derm-sidebar.php"); ?>
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">My Schedule</h1>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">Manage your availability and appointments</li>
            </ol>

            <div class="card mb-4">
              <div class="card-header bg-primary" style="background-color: rgb(39,153,137) !important;">
                <h5 class="text-white mb-0">Schedule Calendar</h5>
              </div>
              <div class="card-body">
                <div id='calendar'></div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- Appointments Modal -->
    <div id="appointmentsModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="modalTitle">Appointments</h5>
          <button class="close" onclick="closeModal('appointmentsModal')">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
        </div>
      </div>
    </div>

    <!-- Schedule Management Modal -->
    <div id="scheduleModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="scheduleModalTitle">Manage Schedule</h5>
          <button class="close" onclick="closeModal('scheduleModal')">&times;</button>
        </div>
        <div class="modal-body" id="scheduleModalBody">
        </div>
      </div>
    </div>

    <script src="../scripts/bootstrap.bundle.min.js"></script>
    <script src="../scripts/jquery.js"></script>
    <script src="../scripts/toggle.js"></script>
    <script>
      let calendar;
      
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
          },
          events: function(info, successCallback, failureCallback) {
            $.ajax({
              url: '../backend/derm/derm_get_calendar_events.php',
              type: 'GET',
              success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                  successCallback(data.events);
                }
              },
              error: function() {
                failureCallback();
              }
            });
          },
          dateClick: function(info) {
            showDateDetails(info.dateStr);
          },
          eventClick: function(info) {
            showDateDetails(info.event.startStr);
          }
        });
        calendar.render();
      });

      function showDateDetails(date) {
        $.ajax({
          url: '../backend/derm/derm_get_date_details.php',
          type: 'POST',
          data: { date: date },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.status === 'success') {
              displayDateDetails(date, data.appointments, data.schedules);
            }
          }
        });
      }

      function displayDateDetails(date, appointments, schedules) {
        let html = `
          <div style="margin-bottom: 20px;">
            <h6>Date: ${date}</h6>
            <p><strong>Total Appointments: ${appointments.length}</strong></p>
          </div>
        `;

        if (appointments.length > 0) {
          html += '<h6>Appointments:</h6>';
          appointments.forEach(function(apt) {
            const statusColor = apt.appointment_status === 'Confirmed' ? 'success' : 
                               apt.appointment_status === 'Pending' ? 'warning' : 'info';
            html += `
              <div class="appointment-item">
                <h5>${apt.first_name} ${apt.last_name}</h5>
                <div class="appointment-info">
                  <div><strong>Time:</strong> ${formatTime(apt.appointment_time)}</div>
                  <div><strong>Service:</strong> ${apt.service_name}</div>
                  <div><strong>Status:</strong> <span class="badge bg-${statusColor}">${apt.appointment_status}</span></div>
                  <div><strong>Contact:</strong> ${apt.contact || 'N/A'}</div>
                  <div><strong>Email:</strong> ${apt.email}</div>
                  ${apt.notes ? `<div><strong>Notes:</strong> ${apt.notes}</div>` : ''}
                </div>
              </div>
            `;
          });
        }

        html += '<hr><h6>Time Slots:</h6>';
        html += '<button class="btn btn-success btn-sm mb-3" onclick="addTimeSlot(\'' + date + '\')"><i class="fas fa-plus"></i> Add Time Slot</button>';
        
        if (schedules.length > 0) {
          schedules.forEach(function(slot) {
            const slotClass = slot.is_booked ? 'booked' : (slot.is_available == 1 ? 'available' : 'unavailable');
            const statusText = slot.is_booked ? 'Booked' : (slot.is_available == 1 ? 'Available' : 'Unavailable');
            
            html += `
              <div class="time-slot-item ${slotClass}">
                <span>${formatTime(slot.time_slot)} - ${statusText}</span>
                <div class="time-slot-actions">
                  ${!slot.is_booked ? `
                    <button class="btn-sm btn-toggle" onclick="toggleSlot(${slot.schedule_id}, ${slot.is_available})">
                      ${slot.is_available == 1 ? 'Mark Unavailable' : 'Mark Available'}
                    </button>
                    <button class="btn-sm btn-danger" onclick="deleteSlot(${slot.schedule_id})">
                      <i class="fas fa-trash"></i>
                    </button>
                  ` : '<span class="text-muted">Cannot modify</span>'}
                </div>
              </div>
            `;
          });
        } else {
          html += '<p class="text-muted">No time slots scheduled for this date.</p>';
        }

        document.getElementById('modalTitle').textContent = 'Schedule Details - ' + date;
        document.getElementById('modalBody').innerHTML = html;
        document.getElementById('appointmentsModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
      }

      function addTimeSlot(date) {
        Swal.fire({
          title: 'Add Time Slot',
          html: `
            <input type="time" id="timeSlot" class="swal2-input" placeholder="Select time">
            <select id="availability" class="swal2-input">
              <option value="1">Available</option>
              <option value="0">Unavailable</option>
            </select>
          `,
          showCancelButton: true,
          confirmButtonText: 'Add',
          confirmButtonColor: 'rgb(39,153,137)',
          preConfirm: () => {
            const time = document.getElementById('timeSlot').value;
            const available = document.getElementById('availability').value;
            
            if (!time) {
              Swal.showValidationMessage('Please select a time');
              return false;
            }
            
            return { time: time, available: available, date: date };
          }
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '../backend/derm/derm_add_schedule.php',
              type: 'POST',
              data: result.value,
              success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Added!',
                    text: 'Time slot added successfully',
                    timer: 1500,
                    showConfirmButton: false
                  });
                  calendar.refetchEvents();
                  showDateDetails(date);
                } else {
                  Swal.fire('Error', data.message, 'error');
                }
              }
            });
          }
        });
      }

      function toggleSlot(scheduleId, currentStatus) {
        const newStatus = currentStatus == 1 ? 0 : 1;
        $.ajax({
          url: '../backend/derm_toggle_schedule.php',
          type: 'POST',
          data: {
            schedule_id: scheduleId,
            is_available: newStatus
          },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Updated!',
                timer: 1500,
                showConfirmButton: false
              });
              calendar.refetchEvents();
              const currentDate = $('.time-slot-item').first().closest('.modal-body').prev().find('h6').text().split(': ')[1];
              setTimeout(() => showDateDetails(currentDate), 500);
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          }
        });
      }

      function deleteSlot(scheduleId) {
        Swal.fire({
          title: 'Are you sure?',
          text: "This time slot will be permanently deleted",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '../backend/derm/derm_delete_schedule.php',
              type: 'POST',
              data: { schedule_id: scheduleId },
              success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    timer: 1500,
                    showConfirmButton: false
                  });
                  calendar.refetchEvents();
                  closeModal('appointmentsModal');
                } else {
                  Swal.fire('Error', data.message, 'error');
                }
              }
            });
          }
        });
      }

      function formatTime(timeStr) {
        const time = new Date('2000-01-01 ' + timeStr);
        return time.toLocaleTimeString('en-US', {
          hour: 'numeric',
          minute: '2-digit',
          hour12: true
        });
      }

      function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'scroll';
      }

      window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
          event.target.style.display = 'none';
        }
      }
    </script>
  </body>
</html>