$(document).ready(()=>{
    $('.updateBtn').on('click', function(){
        const item_id = $(this).attr('id');
        const current_status = $(this).data('status-id');
        const account_id = $(this).data('account-id');
        let status_id = 0;
        if(current_status == 3){
            status_id = 4;
        }else{
            status_id = 2;
        }

        Swal.fire({
            title: "Are you sure?",
            text: "This item will update the order status.",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../backend/admin/updatePending.php",
                    method: "post",
                    data:{
                        item_id,
                        status_id,
                        account_id
                    },
                    success: function(response){
                        if(response === 'success'){
                            Swal.fire({
                                title: "Success!",
                                text: "Order status updated successfully.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }else if(response === 'exceeds'){
                            Swal.fire({
                                title: "Invalid stocks!",
                                text: "Quantity requested exceeds available stock.",
                                icon: "error",
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response,
                                icon: "error",
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(){
                        Swal.fire({
                            title: "Connection Error!",
                            text: "Failed to connect to server.",
                            icon: "error",
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    });

    $('.acceptBtn').on('click', function(){
        const item_id = $(this).attr('id');
        const status_id = 2;
        const prod_id = $(this).data('prod-id');
        const prod_qnty = $(this).data('prod-qnty');
        const account_id = $(this).data('account-id');
        
        Swal.fire({
            title: "Are you sure?",
            text: "This item will proceed to claim.",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../backend/admin/updatePending.php",
                    method: "post",
                    data:{
                        item_id,
                        status_id,
                        prod_id,
                        prod_qnty,
                        account_id
                    },
                    success: function(response){
                        if(response === 'success'){
                            Swal.fire({
                                title: "Success!",
                                text: "Order claimed successfully.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }else if(response === 'exceeds'){
                            Swal.fire({
                                title: "Invalid stocks!",
                                text: "Quantity requested exceeds available stock.",
                                icon: "error",
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response,
                                icon: "error",
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(){
                        Swal.fire({
                            title: "Connection Error!",
                            text: "Failed to connect to server.",
                            icon: "error",
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    });
});