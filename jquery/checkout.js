
$(document).ready(()=>{
    $(".delete-js").on("click", function(){
        const prodId = $(this).attr("id");
        if(prodId){
            $.ajax({
                url:"../backend/user/cancelProd.php",
                method: "get",
                data:{
                    prodId
                },
                success: function(response){
                    if(response === "deleted"){
                        Swal.fire({
                            title: "Item removed",
                            text: "Product item has been deleted in your cart.",
                            
                        }).then((result)=>{
                            if(result.isConfirmed){
                                window.location.href = window.location.href;
                            }
                        })
                    }
                },
                error: function(){
                    alert("Connection Error!");
                }
            })
        }
    })

// Decrease quantity
$('.minus-btn').on('click', function() {
    const item_id = $(this).data("item-id");
    const button = $(this);
    if (item_id) {
        $.ajax({
            url: "../backend/user/minusQnty.php",
            method: "GET",
            data: { item_id },
            success: function(response) {
                window.location.reload();
            },
            error: function() {
                alert("Connection Error!");
            }
        });
    }
});

// Increase quantity
$('.add-btn').on('click', function() {
    const item_id = $(this).data("item-id");
    const button = $(this);
    if (item_id) {
        $.ajax({
            url: "../backend/user/addQnty.php",
            method: "GET",
            data: { item_id },
            success: function(response) {
                window.location.reload();
            },
            error: function() {
                alert("Connection Error!");
            }
        });
    }
});



 $('.proceed-btn').on('click', function() {
    
        const receiptFile = $('#receiptFile')[0].files[0];
        const refNumber = $("#refNumber").val().trim();
        const depositAmnt = $("#depAmount").val().trim();
        const totalAmnt = $("#overAllTotal").val().trim().replace("₱", "").replace(",", "");

        // Check if the receipt file is uploaded
        if (!receiptFile) {
            Swal.fire({
                title: "Please upload your receipt",
                
                showConfirmButton: true,
            });
            return;
        }
        
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
        const fileExtension = receiptFile.name.split('.').pop().toLowerCase();
        
        // Validate file extension
        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire({
                title: "Invalid file type",
                text: "Please upload a file with one of the following extensions: jpg, jpeg, png, svg, webp",
                
                showConfirmButton: true,
            });
            return;
        }
        
        // Validate reference number input
        if (!refNumber) {
            Swal.fire({
                title: "Please enter your reference number.",
                
                showConfirmButton: true,
            });
            return;
        }

        if(refNumber.length < 13){
            Swal.fire({
                title: "Invalid reference number",
                text: "Reference number must be 13 characters long.",
                
                showConfirmButton: true,
            });
            return;
        }
    
        // Validate deposit amount input
        if (!depositAmnt || isNaN(depositAmnt) || parseFloat(depositAmnt) <= 0) {
            Swal.fire({
                title: "Please enter a valid deposit amount.",
                
                showConfirmButton: true,
            });
            return;
        }
        // console.log(parseFloat(totalAmnt) / 2);
        if((parseFloat(totalAmnt) / 2) > depositAmnt){
            Swal.fire({
                title: "Invalid deposit amount",
                text: "Deposit amount must be at least 50% of the total amount.",
                
                showConfirmButton: true,
            });
            return;
        }
        
        // Confirm pickup action
        Swal.fire({
            title: "Want to proceed?",
            text: "Please ensure all details are correct before proceeding.",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, proceed!"
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('receipt', receiptFile);
                formData.append('refNumber', refNumber);
                formData.append('depositAmount', depositAmnt);
    
                $.ajax({ 
                    url: "../backend/user/proceed.php",
                    method: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response === 'success') {
                            window.location.href = '../components/orders.php';
                        } else if(response === "stocks"){
                            Swal.fire({
                                title: "Invalid stocks!",
                                text: "Deleted items due to insufficient stocks.",
                                
                                showConfirmButton: true,
                            }).then((result)=>{
                                if(result.isConfirmed){
                                    window.location.reload();
                                }
                            }
                            )
                        }else {
                            Swal.fire({
                                title: "Update error",
                                text: response,
                                
                                showConfirmButton: true,
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "Connection Error!",
                            text: "Could not connect to the server.",
                            
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });
    });

   
    
    
})
