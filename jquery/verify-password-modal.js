// NEW FILE: verify-password-modal.js
// This handles the password verification modal

$(document).ready(() => {
    // Store modal data when opening password verification
    window.openPasswordModal = function(sourceModalId, dataId) {
        const currentModal = $('#' + sourceModalId);
        
        // Store the source modal ID and data ID for later use
        $('#modalPassword').data('sourceModal', sourceModalId);
        $('#modalPassword').data('dataId', dataId);
        
        // Clear previous password
        $('.verifyAdminPassword').val('');
        
        // Close current modal and open password modal
        currentModal.modal('hide');
        $('#modalPassword').modal('show');
    };

    // Handle the password verification
    $('#modalPassword .updateResBtn').on('click', async function(){
        const admin_password = $('.verifyAdminPassword').val();
        
        if(!admin_password){
            Swal.fire({
                title: "Empty Field!",
                text: "Please enter your password.",
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        let passwordVerified = await checkValidPassword(admin_password);
        
        if(!passwordVerified){
            Swal.fire({
                title: "Invalid Password",
                text: "The password you entered is incorrect.",
            });
            return;
        }

        // Password is valid - trigger the callback
        $('#modalPassword').modal('hide');
        
        // Trigger custom event that other scripts can listen to
        $(document).trigger('passwordVerified', {
            sourceModal: $('#modalPassword').data('sourceModal'),
            dataId: $('#modalPassword').data('dataId')
        });
    });
});