$(document).ready(() => {
    // Remove any previously attached click handlers
    $(document).off("click", ".submit-cart");
  
    // Add the click handler
    $(document).on("click", ".submit-cart", function() {
        // Try to get userDetails from localStorage
        const userDetails = localStorage.getItem("userDetails");
  
        console.log(userDetails); // Check userDetails in console for debugging
  
        if (userDetails) {
            // Proceed with adding the product to the cart if user is logged in
            const prodId = $(this).closest(".product-list-items").attr("data-prod-id");
            console.log(prodId);  // Log the product ID
  
            $.ajax({
                url: "../backend/user/addCart.php",
                method: "POST",
                data: { prodId },
                success: function(response) {
                    // Handle different server responses
                    if (response === 'exceeds') {
                        Swal.fire({
                            title: "Item already in cart!",
                            text: "This item is already in your cart.",
                        });
                    } else if (response === 'success') {
                        Swal.fire({
                            title: "Success",
                            text: "Item added to cart!",
                        }).then(() => {
                            location.reload();
                        });
                    } else if (response === 'stocks') {
                        Swal.fire({
                            title: "Insufficient Stocks",
                            text: "The quantity you entered exceeds the available stocks.",
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "An error occurred while adding to cart.",
                        });
                    }
                },
                error: function() {
                    alert("Connection Error");
                }
            });
        } else {
            Swal.fire({
                title: "Log in first!",
                text: "You need to log in first before you order!",
            });
        }
    });
  
    // Check the login status on page load (after the page is refreshed)
    const userDetails = localStorage.getItem("userDetails");
    if (!userDetails) {
        // Display a login prompt or make sure UI reflects the user is logged out
        Swal.fire({
            title: "Log in first!",
            text: "You need to log in first before you order!",
        });
    }
  });
  