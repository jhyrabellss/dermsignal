$(document).ready(()=>{
    $('.updateResBtn').on('click', function(){
        const prod_name = $(this).closest('.modal-content').find('.updatedName').val();
        const prod_price = $(this).closest('.modal-content').find('.updatedPrice').val();
        const prod_id = $(this).val();
        const prod_description = $(this).closest('.modal-content').find('.updatedDescription').val();
        const stocks = $(this).closest('.modal-content').find('.updatedStocks').val();
        
        if(prod_id && prod_name && prod_price){
            $.ajax({
                url: "../backend/admin/updateProd.php",
                method: "post",
                data:{
                    prod_id,
                    prod_name,
                    prod_price,
                    stocks,
                    prod_description
                },
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
