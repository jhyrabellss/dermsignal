$(document).ready(() => {
    let rating = null;
    const prod_id = $(".write-comment-button").data("prod-id");
    const ratingBox = $(".rating-box");
    let hasPurchased = false;
    let hasRated = false;

    // Check if the user has purchased and rated the product
    $.ajax({
        url: "../backend/user/checkRating.php",
        method: "post",
        data: { prod_id },
        success: function (response) {
            const data = JSON.parse(response);

            if (data.status === 'not_purchased') {
                ratingBox.css("opacity", "0.5");
                $(".stars i").css("cursor", "not-allowed");
                $(".write-comment-button").prop("disabled", true);
                $(".custom-comment").prop("disabled", true).attr("placeholder", "You must purchase this product to leave a review");
            } else if (data.status === 'rated') {
                hasPurchased = true;
                hasRated = true;
                rating = data.rating;
                ratingBox.css("opacity", "0.5");
                $(".stars i").css("cursor", "not-allowed");
                
                // Highlight the rated stars
                $(".stars i").each(function() {
                    if ($(this).data("value") <= rating) {
                        $(this).css("color", "#ffc300");
                    }
                });
            } else {
                hasPurchased = true;
                
                // Enable star rating functionality
                $(".stars i").on("click", function () {
                    rating = $(this).data("value");
                    
                    // Update star colors
                    $(".stars i").each(function() {
                        if ($(this).data("value") <= rating) {
                            $(this).css("color", "#ffc300");
                        } else {
                            $(this).css("color", "#ccc");
                        }
                    });
                });

                // Hover effect for stars
                $(".stars i").hover(
                    function() {
                        const hoverValue = $(this).data("value");
                        $(".stars i").each(function() {
                            if ($(this).data("value") <= hoverValue) {
                                $(this).css("color", "#ffc300");
                            } else {
                                $(this).css("color", "#ccc");
                            }
                        });
                    },
                    function() {
                        $(".stars i").each(function() {
                            if (rating && $(this).data("value") <= rating) {
                                $(this).css("color", "#ffc300");
                            } else {
                                $(this).css("color", "#ccc");
                            }
                        });
                    }
                );
            }
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Unable to check your rating status.",
            });
        }
    });

    // Handle review submission
    $(".write-comment-button").on("click", function (e) {
        e.preventDefault();

        if (!hasPurchased) {
            Swal.fire({
                icon: "warning",
                title: "Purchase Required",
                text: "You must purchase this product before leaving a review.",
            });
            return;
        }

        if (hasRated) {
            Swal.fire({
                icon: "info",
                title: "Already Reviewed",
                text: "You have already submitted a review for this product.",
            });
            return;
        }

        const review = $("#review").val().trim();

        if (!review) {
            Swal.fire({
                icon: "warning",
                title: "Review Missing!",
                text: "Please write your review before submitting.",
            });
            return;
        }

        if (!rating) {
            Swal.fire({
                icon: "warning",
                title: "Rating Missing!",
                text: "Please rate the product by clicking on the stars.",
            });
            return;
        }

        // Confirmation dialog
        Swal.fire({
            title: "Submit Review?",
            html: `
                <div style="text-align: left;">
                    <p><strong>Rating:</strong> ${rating} star${rating > 1 ? 's' : ''}</p>
                    <p><strong>Review:</strong> ${review}</p>
                </div>
            `,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the review
                $.ajax({
                    url: "../backend/user/submitReviews.php",
                    method: "post",
                    data: {
                        review,
                        prod_id,
                        rating,
                    },
                    success: function (response) {
                        const data = JSON.parse(response);
                        
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: "success",
                                title: "Review Submitted!",
                                text: "Thank you for your review!",
                                showConfirmButton: false,
                                timer: 1500,
                            });

                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: data.message || "Unable to submit your review.",
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Unable to submit your review. Please try again.",
                        });
                    },
                });
            }
        });
    });

    // Cancel button functionality
    $(".cancel-button").on("click", function() {
        $("#review").val("");
        rating = null;
        $(".stars i").css("color", "#ccc");
    });
});