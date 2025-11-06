$(document).ready(function() {
    $('#addProd').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        
        // Get form values
        var productIngredients = $('#prod_ingredients').val();
        var productName = $('#prod_name').val();
        var productPrice = $('#prod_price').val();
        var productConcern = $('#prod_concern').val();
        var productStocks = $('#prod_stocks').val();
        var productImage = $('#prod_img').prop('files')[0];
        var productHoverImage = $('#prod_hover_img').prop('files')[0];

        // Validate form inputs
        if (!productName || !productPrice || !productConcern || !productStocks || !productImage || !productIngredients) {
            Swal.fire({
                title: "Empty Field!",
                text: "Please fill in all required fields.",
                showConfirmButton: true,
            })
            return;
        }

        // Create FormData object
        var formData = new FormData();
        formData.append('prod_name', productName);
        formData.append('prod_price', productPrice);
        formData.append('prod_concern', productConcern);
        formData.append('prod_stocks', productStocks);
        formData.append('prod_img', productImage);
        formData.append('prod_ingredients', productIngredients);
        
        // Add hover image if selected
        if(productHoverImage) {
            formData.append('prod_hover_img', productHoverImage);
        }

        // AJAX request to submit form data
        $.ajax({
            url: '../backend/admin/add_product.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Handle success response
                if (response === 'success') {
                    Swal.fire({
                        title: "Successfully Added",
                        text: "Product Added Successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        if (result) {
                            $('#addProd')[0].reset();
                            location.reload();
                        }
                    })
                    
                } else {
                    Swal.fire({
                        title: "Error",
                        text: response,
                        icon: "error",
                        showConfirmButton: true,
                    });
                }
            },
            error: function() {
                // Handle error response
                alert('Error: Failed to communicate with server.');
            }
        });
    });

    $('#addProdMain').submit(function(e){
        e.preventDefault();
        var prodNameMain = $('#prod_name_main').val();

        if(!prodNameMain){
            Swal.fire({
                title: "Empty Product Name!",
                text: "Please fill in all fields.",
                showConfirmButton: true,
            })
            return;
        }

        $.ajax({
            url: "../backend/admin/addProdMain.php",
            method: "post",
            data: {prodNameMain},
            success: function(response){
                if(response === 'success'){
                    Swal.fire({
                        title: "Successfully Added",
                        text: "Product Added Successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        if(result){
                            location.reload();
                        }
                    })
                } else if(response === 'exist'){
                    Swal.fire({
                        title: "Folder Already Exist!",
                        text: "Please try another name.",
                        icon: "warning",
                        showConfirmButton: true,
                        timer: 2000
                    })
                }
            },
            error: function() {
                // Handle error response
                alert('Error: Failed to communicate with server.');
            }
        })
    })
});