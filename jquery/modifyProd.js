$(document).ready(()=>{
    $('.updateResBtn').on('click', function(){
        const prod_name = $(this).closest('.modal-content').find('.updatedName').val();
        const prod_price = $(this).closest('.modal-content').find('.updatedPrice').val();
        const prod_id = $(this).val();
        const prod_description = $(this).closest('.modal-content').find('.updatedDescription').val();
        const stocks = $(this).closest('.modal-content').find('.updatedStocks').val();
        const prod_image = $(this).closest('.modal-content').find('.updatedImage')[0].files[0];
        const prod_hover_image = $(this).closest('.modal-content').find('.updatedHoverImage')[0].files[0];
        
        if(prod_id && prod_name && prod_price){
            const formData = new FormData();
            formData.append('prod_id', prod_id);
            formData.append('prod_name', prod_name);
            formData.append('prod_price', prod_price);
            formData.append('stocks', stocks);
            formData.append('prod_description', prod_description);
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
    })
})