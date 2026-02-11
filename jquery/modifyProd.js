// UPDATED FILE: modifyProd.js
// This handles the product update logic

$(document).ready(()=>{
    // Handle the initial Save button click - open password modal
    $('.modal-footer .updateResBtn').not('#modalPassword .updateResBtn').on('click', function(){
        const prod_id = $(this).val();
        const currentModal = $(this).closest('.modal');
        
        // Open password modal using the global function
        window.openPasswordModal(currentModal.attr('id'), prod_id);
    });

    // Listen for password verification success
    $(document).on('passwordVerified', async function(event, data){
        // Don't process if this is a delete operation
        if (data && data.isDelete) {
            return;
        }
        
        const prodId = data.dataId;
        const sourceModalId = data.sourceModal;
        const sourceModal = $('#' + sourceModalId);
        
        // Get values from the original modal
        const prod_name = sourceModal.find('.updatedName').val();
        const prod_price = sourceModal.find('.updatedPrice').val();
        const prod_description = sourceModal.find('.updatedDescription').val();
        const stocks = sourceModal.find('.updatedStocks').val();
        const prod_image = sourceModal.find('.updatedImage')[0].files[0];
        const prod_hover_image = sourceModal.find('.updatedHoverImage')[0].files[0];

        if(prodId && prod_name && prod_price){
            const formData = new FormData();
            formData.append('prod_id', prodId);
            formData.append('prod_name', prod_name);
            formData.append('prod_price', prod_price);
            formData.append('stocks', stocks);
            formData.append('prod_description', prod_description);
            formData.append('admin_password', data.admin_password);
            if(prod_image){
                formData.append('prod_image', prod_image);
            }
            if(prod_hover_image){
                formData.append('prod_hover_image', prod_hover_image);
            }
            
            $.ajax({
                url: "../backend/admin/updateProd.php",
                method: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response === 'success'){
                        Swal.fire({
                            title: "Product Updated",
                            text: "Product has been updated",
                        }).then((result)=>{
                            if(result.isConfirmed){
                                window.location.reload();
                            }
                        })
                    }else if(response === 'you cannot reduce the stocks'){
                        Swal.fire({
                            title: "Invalid Stocks",
                            text: "You cannot reduce the stocks",
                        })
                    }else if(response === 'error_invalid_password'){
                        Swal.fire({
                            title: "Invalid Password",
                            text: "The password you entered is incorrect.",
                        })
                    }else{
                        Swal.fire({
                            title: "Product Not Updated",
                            text: "Product has not been updated",
                        })
                    }
                },
                error: function(){
                    alert("Connection Error")
                }
            })
        }else{
            Swal.fire({
                title: "Empty Field!",
                text: "You cannot empty the field.",
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
})