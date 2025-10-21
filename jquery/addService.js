$(document).ready(function() {
    $('#addService').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        
        // Get form values
        var serviceName = $('#service_name').val();
        var servicePrice = $('#service_price').val();
        var procedureBenefits = $('#procedure_benefits').val();
        var serviceGroup = $('#service_group').val();
        var serviceImage = $('#service_image').prop('files')[0];
        var sessions = $('#sessions').val();

        // Validate form inputs
        if (!serviceName || !servicePrice || !procedureBenefits || !serviceGroup || !serviceImage || !sessions) {
            Swal.fire({
                title: "Empty Field!",
                text: "Please fill in all fields.",
                showConfirmButton: true,
            })
            return;
        }

        // Validate form inputs
        if (!serviceName || !servicePrice || !procedureBenefits || !serviceGroup || !serviceImage) {
            Swal.fire({
                title: "Empty Field!",
                text: "Please fill in all fields.",
                showConfirmButton: true,
            })
            return;
        }

        // Create FormData object
        var formData = new FormData();
        formData.append('service_name', serviceName);
        formData.append('service_price', servicePrice);
        formData.append('procedure_benefits', procedureBenefits);
        formData.append('service_group', serviceGroup);
        formData.append('service_image', serviceImage);
        formData.append('sessions', sessions);

        // AJAX request to submit form data
        $.ajax({
            url: '../backend/admin/add_service.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Handle success response
                if (response === 'success') {
                    Swal.fire({
                        title: "Successfully Added",
                        text: "Service Added Successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        if (result) {
                            $('#addService')[0].reset();
                            location.reload();
                        }
                    })
                    
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response,
                        icon: "error",
                        showConfirmButton: true,
                    });
                }
            },
            error: function() {
                // Handle error response
                alert('Error: Failed to communicate with server.');
            }
        });
    });

    $('#addProdMain').submit(function(e){
        e.preventDefault();
        var prodNameMain = $('#prod_name_main').val();

        if(!prodNameMain){
            Swal.fire({
                title: "Empty Product Name!",
                text: "Please fill in all fields.",
                showConfirmButton: true,
            })
            return;
        }

        $.ajax({
            url: "../backend/admin/addProdMain.php",
            method: "post",
            data: {prodNameMain},
            success: function(response){
                if(response === 'success'){
                    Swal.fire({
                        title: "Successfully Added",
                        text: "Product Added Successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        if(result){
                            location.reload();
                        }
                    })
                } else if(response === 'exist'){
                    Swal.fire({
                        title: "Folder Already Exist!",
                        text: "Please try another name.",
                        icon: "warning",
                        showConfirmButton: true,
                        timer: 2000
                    })
                }
            },
            error: function() {
                // Handle error response
                alert('Error: Failed to communicate with server.');
            }
        })
    })
});
