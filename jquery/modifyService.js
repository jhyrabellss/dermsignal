// UPDATED FILE: modifyService.js (or whatever this file is named)

$(document).ready(function(){
    // Handle the initial Save button click - open password modal
    $('.modal-footer .updateResBtn').not('#modalPassword .updateResBtn').on('click', function(){
        const service_id = $(this).val();
        const currentModal = $(this).closest('.modal');
        
        // Validate fields before opening password modal
        const service_name = currentModal.find('.updatedName').val();
        const service_price = currentModal.find('.updatedPrice').val();
        const procedure_benefits = currentModal.find('.updatedBenefits').val();
        const sessions = currentModal.find('.updatedSessions').val();

        if(!service_id || !service_name || !service_price || !procedure_benefits || !sessions){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields!',
            });
            return;
        }
        
        // Open password modal using the global function
        window.openPasswordModal(currentModal.attr('id'), service_id);
    });

    // Listen for password verification success
    $(document).on('passwordVerified', async function(event, data){
        // Don't process if this is a delete operation
        if (data && data.isDelete) {
            return;
        }
        
        const service_id = data.dataId;
        const sourceModalId = data.sourceModal;
        const sourceModal = $('#' + sourceModalId);
        
        // Get values from the original modal
        const service_name = sourceModal.find('.updatedName').val();
        const service_price = sourceModal.find('.updatedPrice').val();
        const procedure_benefits = sourceModal.find('.updatedBenefits').val();
        const sessions = sourceModal.find('.updatedSessions').val();
        const updatedImage = sourceModal.find('.updatedImage')[0].files[0];

        // Create FormData object to handle file upload
        const formData = new FormData();
        formData.append('service_id', service_id);
        formData.append('service_name', service_name);
        formData.append('service_price', service_price);
        formData.append('procedure_benefits', procedure_benefits);
        formData.append('sessions', sessions);
        formData.append('admin_password', data.admin_password);
        
        // Only append image if one was selected
        if(updatedImage){
            formData.append('updatedImage', updatedImage);
        }

        $.ajax({
            url: "../backend/admin/updateService.php",
            method: "POST",
            data: formData,
            processData: false,  // CRITICAL: Don't process the data
            contentType: false,  // CRITICAL: Don't set content type (let browser set it with boundary)
            success: function(response){
                if(response === 'success'){
                    Swal.fire({
                        title: "Service Updated",
                        text: "Service has been updated",
                        icon: "success"
                    }).then((result)=>{
                        if(result.isConfirmed){
                            window.location.reload();
                        }
                    })
                }else if(response === 'you cannot reduce the sessions'){
                    Swal.fire({
                        title: "Invalid Sessions",
                        text: "You cannot reduce the sessions",
                        icon: "warning"
                    })
                }else if(response === 'error_invalid_password'){
                    Swal.fire({
                        title: "Invalid Password",
                        text: "The password you entered is incorrect.",
                        icon: "error"
                    })
                }else{
                    Swal.fire({
                        title: "Service Not Updated",
                        text: "Service has not been updated",
                        icon: "error"
                    })
                }
            },
            error: function(){
                Swal.fire({
                    title: "Connection Error",
                    text: "There was a problem connecting to the server",
                    icon: "error"
                })
            }
        })
    });
})