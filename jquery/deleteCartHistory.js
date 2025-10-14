$(document).ready(()=>{
    $(".delete-js").on("click", function(){
        const prodId = $(this).attr("id");
        if(prodId){
            $.ajax({
                url:"../backend/user/deleteCartHistory.php",
                metehod: "get",
                data:{
                    prodId,
                },
                success: function(response){
                    if(response === "deleted"){
                        Swal.fire({
                            title: "Order deleted",
                            text: "Product item has been deleted in your cart.",
                            showConfirmButton: false,
                            timer: 2000
                        }).then((result)=>{
                            window.location.reload();;
                        })
                    }
                },
                error: function(){
                    alert("Connection Error!");
                }
            })
        }
    })
})

