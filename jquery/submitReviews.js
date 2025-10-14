$(document).ready(() => {
    let rating = null; // To store the selected rating
    const prod_id = $(".write-comment-button").data("prod-id"); // Assuming you get the product ID from the button
    const ratingBox = $(".rating-box")
    // Check if the user has already rated the product
    $.ajax({
        url: "../backend/user/checkRating.php", // Endpoint to check if user already rated the product
        method: "post",
        data: {
            prod_id,
        },
        success: function (response) {
            const data = JSON.parse(response);

            if (data.status === 'rated') {
                ratingBox.css("opacity", "0");
                rating = data.rating; // Get the fixed rating value from the backend
                //$(".stars i").prop("disabled", true); // Disable the stars if the user has already rated
               // Swal.fire({
                    //title: "You have already rated this product.",
                    //text: "You cannot change your rating.",
                //});
            } else {
                
                $(".stars i").on("click", function () {
                    rating = $(this).data("value");
                    console.log("Rating selected:", rating);
                });
            }
        },
        error: function () {
            Swal.fire({
                title: "Error!",
                text: "Unable to check your rating status.",
            });
        }
    });

    // Handle form submission with AJAX
    $(".write-comment-button").on("click", function (e) {
        e.preventDefault();

        const review = $("#review").val();

        if (!review) {
            Swal.fire({
                title: "Review Missing!",
                text: "Please write your review before submitting.",
            });
            return;
        }

        // If the user has not selected a rating yet, use the fixed rating from backend
        if (!rating) {
            rating = $(".write-comment-button").data("rating"); // Get the fixed rating if already set
            Swal.fire({
                title: "Product not rated!",
                text: "Please rate the product",
            });
            return;
        }

        $.ajax({
            url: "../backend/user/submitReviews.php",
            method: "post",
            data: {
                review,
                prod_id,
                rating, // Send the fixed rating, whether new or existing
            },
            success: function (response) {
                Swal.fire({
                    title: "Review Submitted!",
                    text: "Thank you for your review!",
                    showConfirmButton: false,
                    timer: 1500,
                });

                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            error: function () {
                Swal.fire({
                    title: "Error!",
                    text: "Unable to submit your review. Please try again.",
                });
            },
        });
    });
});
