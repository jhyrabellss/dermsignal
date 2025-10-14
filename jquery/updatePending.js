$(document).ready(()=>{
    $('.updateBtn').on('click', function(){
        const item_id = $(this).attr('id');
        const current_status = $(this).data('status-id');
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
                    status_id
                },
                success: function(response){
                  if(response === 'success'){
                      window.location.reload();
                  }else if(response === 'exceeds'){
                    Swal.fire({
                      title: "Invalid stocks!",
                      text: "Quantity requested exceeds available stock.",
                      
                      showConfirmButton: false,
                      timer: 2000
                    })
                  }

                  window.location.reload();
              },
                error: function(){
                    alert("Connection Error")
                }
              })
            }
          });
    })

    $('.acceptBtn').on('click', function(){
        const item_id = $(this).attr('id');
        const status_id = 2;
        const prod_id = $(this).data('prod-id');
        const prod_qnty = $(this).data('prod-qnty');
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
                url: "../admin/updatePending.php",
                method: "post",
                data:{
                    item_id,
                    status_id,
                    prod_id,
                    prod_qnty
                },
                success: function(response){
                    if(response === 'success'){
                        window.location.reload();
                    }else if(response === 'exceeds'){
                      Swal.fire({
                        title: "Invalid stocks!",
                        text: "Quantity requested exceeds available stock.",
                        
                        showConfirmButton: false,
                        timer: 2000
                      })
                    }

                    window.location.reload();
                },
                error: function(){
                    alert("Connection Error")
                }
              })
            }
          });
    })
})