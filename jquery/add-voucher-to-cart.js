$(document).ready(function() {
    $(document).on('click', '.add-voucher-to-cart:not(.login-required)', function() {
        const voucherId = $(this).data('voucher-id');
        const voucherCode = $(this).data('voucher-code');
        const button = $(this);
        
        // Get voucher details from the voucher card
        const voucherCard = button.closest('.voucher-card');
        const voucherName = voucherCard.find('.voucher-name').text();
        const voucherCategory = voucherCard.find('.voucher-category').text();
        const discountText = voucherCard.find('.voucher-discount').text();
        
        // Build details HTML
        let detailsHTML = '<div style="text-align: left; margin: 20px 0;">';
        detailsHTML += '<p style="margin: 10px 0;"><strong>Voucher:</strong> ' + voucherName + '</p>';
        detailsHTML += '<p style="margin: 10px 0;"><strong>Code:</strong> ' + voucherCode + '</p>';
        detailsHTML += '<p style="margin: 10px 0;"><strong>Discount:</strong> ' + discountText + '</p>';
        detailsHTML += '<p style="margin: 10px 0;"><strong>Category:</strong> ' + voucherCategory + '</p>';
        
        // Get voucher details from card
        const detailItems = voucherCard.find('.voucher-detail-item');
        detailItems.each(function() {
            const text = $(this).text().trim();
            if (text) {
                detailsHTML += '<p style="margin: 10px 0;"><strong>•</strong> ' + text + '</p>';
            }
        });
        
        detailsHTML += '</div>';
        
        // Show confirmation modal
        Swal.fire({
            title: 'Add Voucher to Cart?',
            html: detailsHTML,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4a9f20ff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Add to Cart',
            cancelButtonText: 'Cancel',
            width: '500px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable button to prevent multiple clicks
                button.prop('disabled', true);
                button.html('<i class="fa-solid fa-spinner fa-spin"></i> Adding...');
                
                $.ajax({
                    url: './backend/user/addVoucherToCart.php',
                    method: 'POST',
                    data: { 
                        voucherId: voucherId,
                        voucherCode: voucherCode
                    },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Voucher added to your cart!',
                                icon: 'success',
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        } else if (response === 'already_added') {
                            Swal.fire({
                                title: 'Already Added!',
                                text: 'This voucher is already in your cart.',
                                icon: 'info'
                            });
                            button.prop('disabled', false);
                            button.html('<i class="fa-solid fa-plus"></i> Add to Cart');
                        } else if (response === 'expired') {
                            Swal.fire({
                                title: 'Expired!',
                                text: 'This voucher has expired.',
                                icon: 'error'
                            });
                            button.prop('disabled', false);
                            button.html('<i class="fa-solid fa-plus"></i> Add to Cart');
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to add voucher to cart.',
                                icon: 'error'
                            });
                            button.prop('disabled', false);
                            button.html('<i class="fa-solid fa-plus"></i> Add to Cart');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Connection Error!',
                            text: 'Please try again later.',
                            icon: 'error'
                        });
                        button.prop('disabled', false);
                        button.html('<i class="fa-solid fa-plus"></i> Add to Cart');
                    }
                });
            }
        });
    });
    
    // Remove voucher from cart
    $(document).on('click', '.remove-voucher-btn', function() {
        const voucherId = $(this).data('voucher-id');
        
        Swal.fire({
            title: 'Remove Voucher?',
            text: 'Are you sure you want to remove this voucher from your cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // check url first to determine the correct path. If in index.php use ./backend/user/removeVoucherFromCart.php else use ../backend/user/removeVoucherFromCart.php
                const urlPath = window.location.pathname.endsWith('index.php') ? './backend/user/removeVoucher.php' : '../backend/user/removeVoucher.php';
                
                $.ajax({
                    url: urlPath,
                    method: 'POST',
                    data: { voucherId: voucherId },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire({
                                title: 'Removed!',
                                text: 'Voucher has been removed from your cart.',
                                icon: 'success',
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to remove voucher from cart.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Connection Error!',
                            text: 'Please try again later.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});