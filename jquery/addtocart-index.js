$(document).ready(() => {
    $(document).off("click", ".submit-cart");
  
    $(document).on("click", ".submit-cart", function() {
        const userDetails = localStorage.getItem("userDetails");
  
        if (userDetails) {
            const prodId = $(this).closest(".product-items").attr("data-prod-id");
  
            $.ajax({
                url: "../backend/user/addCart.php",
                method: "POST",
                data: { prodId },
                dataType: "text",
                success: function(response) {
                    response = response.trim();
                    
                    if (response === 'exceeds') {
                        Swal.fire({
                            icon: 'info',
                            title: "Already in Cart",
                            text: "This item is already in your cart.",
                            confirmButtonColor: 'rgb(39,153,137)'
                        });
                    } else if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: "Success",
                            text: "Item added to cart!",
                            confirmButtonColor: 'rgb(39,153,137)'
                        }).then(() => {
                            location.reload();
                        });
                    } else if (response === 'stocks') {
                        Swal.fire({
                            icon: 'warning',
                            title: "Insufficient Stocks",
                            text: "The quantity exceeds the available stocks.",
                            confirmButtonColor: 'rgb(39,153,137)'
                        });
                    } else if (response === 'no_session') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Session Expired',
                            text: 'Please login again',
                            confirmButtonColor: 'rgb(39,153,137)'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: "Error",
                            text: "An error occurred: " + response,
                            confirmButtonColor: 'rgb(39,153,137)'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", {status, error, response: xhr.responseText});
                    Swal.fire({
                        icon: 'error',
                        title: "Connection Error",
                        text: "Failed to connect to server. Please try again.",
                        confirmButtonColor: 'rgb(39,153,137)'
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Please Login',
                text: 'You need to be logged in to add items to your cart',
                confirmButtonColor: 'rgb(39,153,137)'
            });
        }
    });
});