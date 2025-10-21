$(document).ready(function(){

    $('.updateResBtn').on('click', function(){
        const service_name = $(this).closest('.modal-content').find('.updatedName').val();
        const service_price = $(this).closest('.modal-content').find('.updatedPrice').val();
        const service_id = $(this).val();
        const procedure_benefits = $(this).closest('.modal-content').find('.updatedBenefits').val();
        const sessions = $(this).closest('.modal-content').find('.updatedSessions').val();

        if(!service_id || !service_name || !service_price || !procedure_benefits || !sessions){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields!',
            });
            return;
        }

        const updatedImage = $(this).closest('.modal-content').find('.updatedImage')[0].files[0];

        // Create FormData object to handle file upload
        const formData = new FormData();
        formData.append('service_id', service_id);
        formData.append('service_name', service_name);
        formData.append('service_price', service_price);
        formData.append('procedure_benefits', procedure_benefits);
        formData.append('sessions', sessions);
        
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
    })
})