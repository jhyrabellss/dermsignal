$(document).ready(()=>{
    $('.deactivateResBtn').on('click', function(){
        const account_id = $(this).attr('id');

        if(account_id){
            Swal.fire({
                title: "Are you sure?",
                text: "This account will be updated.",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!"
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url:"../backend/admin/deactivate.php",
                    metehod: "get",
                    data:{
                        account_id
                    },
                    success: function(response){
                        if(response === "success"){
                            Swal.fire({
                                title: "Account Updated!",
                                text: "Account has been updated successfully!",
                            }).then((result)=>{
                                if(result.isConfirmed){
                                    window.location.reload();
                                }
                            })
                              
                        }
                    }
                  })
                }
              });
        }
    })
})