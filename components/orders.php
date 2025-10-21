<?php
session_start();
if (empty($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
} else {
    session_abort();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" href="../styles/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="../styles/processed.css">
    <script src="../jquery/jquery.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .voucher-row {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #4a9f20ff;
        }

        .voucher-row td {
            color: #4a9f20ff;
            font-weight: 600;
        }

        .voucher-code-badge {
            background: #4a9f20ff;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            margin-left: 5px;
        }

        .voucher-icon {
            color: #4a9f20ff;
            font-size: 24px;
        }

        .discount-amount {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php include "./header.php" ?>
    <?php
    $acc_id = $_SESSION["user_id"];
    ?>


    <div class="profile-main-cont">

        <?php
        // Get products in cart
        $query = "SELECT tc.*, tp.*, ts.status_name
    FROM tbl_cart tc
    JOIN tbl_products tp ON tc.prod_id = tp.prod_id
    JOIN tbl_status ts ON tc.status_id = ts.status_id
    WHERE tc.account_id = ? AND tc.status_id IN (3, 4, 6)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",  $acc_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Get vouchers in cart with same status
        $queryVouchers = "SELECT cv.*, v.*, ts.status_name
        FROM tbl_cart_vouchers cv
        JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
        JOIN tbl_status ts ON cv.status_id = ts.status_id
        WHERE cv.account_id = ? AND cv.status_id IN (3, 4, 6)";
        $stmtVouchers = $conn->prepare($queryVouchers);
        $stmtVouchers->bind_param("i", $acc_id);
        $stmtVouchers->execute();
        $resultVouchers = $stmtVouchers->get_result();

        if ($result->num_rows > 0 || $resultVouchers->num_rows > 0) {
            $total = 0;
            $subtotalOnly = 0;
            $voucherDiscount = 0;

            // Store all cart items for voucher calculation
            $cartItems = [];
            mysqli_data_seek($result, 0);
            while ($data = $result->fetch_assoc()) {
                $origprice = $data['prod_price'] + 100;
                $proddiscount = $data['prod_discount'] / 100;
                $prodprice = $origprice - ($origprice * $proddiscount);
                $subtotal = $data["prod_qnty"] * $prodprice;
                $total += $subtotal;
                $subtotalOnly += $prodprice;

                $cartItems[] = [
                    'prod_id' => $data['prod_id'],
                    'subtotal' => $subtotal
                ];
            }

            // Calculate voucher discounts
            if ($resultVouchers->num_rows > 0) {
                mysqli_data_seek($resultVouchers, 0);
                while ($voucher = $resultVouchers->fetch_assoc()) {
                    $targetItems = json_decode($voucher['target_items'], true);
                    $eligibleProductIds = [];

                    if ($targetItems) {
                        foreach ($targetItems as $item) {
                            if ($item['type'] == 'product') {
                                $eligibleProductIds[] = $item['id'];
                            }
                        }
                    }

                    $voucherSubtotal = 0;
                    foreach ($cartItems as $cartItem) {
                        if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                            $voucherSubtotal += $cartItem['subtotal'];
                        }
                    }

                    if ($voucher['discount_type'] == 'percentage') {
                        $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                        if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                            $currentDiscount = $voucher['max_discount'];
                        }
                    } else {
                        $currentDiscount = $voucher['discount_value'];
                    }

                    $meetsMinimum = ($total >= $voucher['min_purchase']);
                    if ($meetsMinimum) {
                        $voucherDiscount += $currentDiscount;
                    }
                }
            }

            // Calculate final total
            $onlineDisc = $total * 0.05;
            $grandTotal = $total - $onlineDisc - $voucherDiscount;
            if ($grandTotal < 0) $grandTotal = 0;
        ?>
            <main>
                <div class="center" style="flex-direction: column; align-items:end;">
                    <a href="../components/history.php">
                        <div class="order-status">Order History</div>
                    </a>

                    <?php if ($result->num_rows > 0 || $resultVouchers->num_rows > 0) {
                        $total = 0;
                        $subtotalOnly = 0;
                        $voucherDiscount = 0;

                        // Store all cart items for voucher calculation
                        $cartItems = [];
                        mysqli_data_seek($result, 0);
                        while ($data = $result->fetch_assoc()) {
                            $origprice = $data['prod_price'] + 100;
                            $proddiscount = $data['prod_discount'] / 100;
                            $prodprice = $origprice - ($origprice * $proddiscount);
                            $subtotal = $data["prod_qnty"] * $prodprice;
                            $total += $subtotal;
                            $subtotalOnly += $prodprice;

                            $cartItems[] = [
                                'prod_id' => $data['prod_id'],
                                'subtotal' => $subtotal
                            ];
                        }

                        // Calculate voucher discounts
                        if ($resultVouchers->num_rows > 0) {
                            mysqli_data_seek($resultVouchers, 0);
                            while ($voucher = $resultVouchers->fetch_assoc()) {
                                $targetItems = json_decode($voucher['target_items'], true);
                                $eligibleProductIds = [];

                                if ($targetItems) {
                                    foreach ($targetItems as $item) {
                                        if ($item['type'] == 'product') {
                                            $eligibleProductIds[] = $item['id'];
                                        }
                                    }
                                }

                                $voucherSubtotal = 0;
                                foreach ($cartItems as $cartItem) {
                                    if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                        $voucherSubtotal += $cartItem['subtotal'];
                                    }
                                }

                                if ($voucher['discount_type'] == 'percentage') {
                                    $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                    if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                        $currentDiscount = $voucher['max_discount'];
                                    }
                                } else {
                                    $currentDiscount = $voucher['discount_value'];
                                }

                                $meetsMinimum = ($total >= $voucher['min_purchase']);
                                if ($meetsMinimum) {
                                    $voucherDiscount += $currentDiscount;
                                }
                            }
                        }

                        // Calculate final total
                        $onlineDisc = $total * 0.05;
                        $grandTotal = $total - $onlineDisc - $voucherDiscount;
                        if ($grandTotal < 0) $grandTotal = 0;
                    ?>

                        <div class="div">
                            <div class="left-con">
                                <div class="cart-con">
                                    <table class="styled-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product / Voucher</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Display products
                                            mysqli_data_seek($result, 0);
                                            while ($data = $result->fetch_assoc()) {
                                                $origprice = $data['prod_price'] + 100;
                                                $proddiscount = $data['prod_discount'] / 100;
                                                $prodprice = $origprice - ($origprice * $proddiscount);
                                                $subtotal = round($data["prod_qnty"] * $prodprice, 2);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="img-con">
                                                            <img src="../images/products/<?php echo $data["prod_img"]; ?>" alt="">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $data["prod_name"]; ?></td>
                                                    <td>₱<?php echo number_format($prodprice, 2); ?></td>
                                                    <td>
                                                        <div class="qnty-td">
                                                            <div class="qnty-js"><?php echo $data["prod_qnty"]; ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="total-price-js">₱<span class="subtotal-js"><?php echo number_format($subtotal, 2); ?></span></td>
                                                    <td><?php echo $data["status_name"]; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php
                                            // Display vouchers
                                            if ($resultVouchers->num_rows > 0) {
                                                mysqli_data_seek($resultVouchers, 0);
                                                while ($voucher = $resultVouchers->fetch_assoc()) {
                                                    // Calculate discount for this voucher
                                                    $targetItems = json_decode($voucher['target_items'], true);
                                                    $eligibleProductIds = [];

                                                    if ($targetItems) {
                                                        foreach ($targetItems as $item) {
                                                            if ($item['type'] == 'product') {
                                                                $eligibleProductIds[] = $item['id'];
                                                            }
                                                        }
                                                    }

                                                    $voucherSubtotal = 0;
                                                    foreach ($cartItems as $cartItem) {
                                                        if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                                            $voucherSubtotal += $cartItem['subtotal'];
                                                        }
                                                    }

                                                    if ($voucher['discount_type'] == 'percentage') {
                                                        $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                                        if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                                            $currentDiscount = $voucher['max_discount'];
                                                        }
                                                    } else {
                                                        $currentDiscount = $voucher['discount_value'];
                                                    }

                                                    $meetsMinimum = ($total >= $voucher['min_purchase']);
                                            ?>
                                                    <tr class="voucher-row">
                                                        <td>
                                                            <div class="img-con" style="background: #4a9f20ff; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fa-solid fa-ticket-simple voucher-icon" style="color: white;"></i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <i class="fa-solid fa-tag"></i> <?php echo htmlspecialchars($voucher['voucher_name']); ?>
                                                            <span class="voucher-code-badge"><?php echo htmlspecialchars($voucher['voucher_code']); ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if ($voucher['discount_type'] == 'percentage') { ?>
                                                                <?php echo intval($voucher['discount_value']); ?>% OFF
                                                            <?php } else { ?>
                                                                ₱<?php echo number_format($voucher['discount_value'], 2); ?> OFF
                                                            <?php } ?>
                                                        </td>
                                                        <td>1</td>
                                                        <td class="discount-amount">
                                                            <?php if ($meetsMinimum) { ?>
                                                                -₱<?php echo number_format($currentDiscount, 2); ?>
                                                            <?php } else { ?>
                                                                ₱0.00
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $voucher["status_name"]; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="right-con">
                                <div class="total-con">
                                    <h1>Order totals</h1>
                                    <div class="price-div">
                                        <div class="text">
                                            <div>Subtotal:</div>
                                            <span class="text-price">₱<?php echo number_format($total, 2); ?></span>
                                        </div>
                                        <div class="text">
                                            <div>5% Online Discount:</div>
                                            <span class="text-price">-₱<?php echo number_format($onlineDisc, 2); ?></span>
                                        </div>
                                        <?php if ($voucherDiscount > 0) { ?>
                                            <div class="text" style="color: #4a9f20ff;">
                                                <div><i class="fa-solid fa-ticket-simple"></i> Voucher Discount:</div>
                                                <span class="text-price">-₱<?php echo number_format($voucherDiscount, 2); ?></span>
                                            </div>
                                        <?php } ?>
                                        <div class="text">
                                            <div><strong>Grand Total:</strong></div>
                                            <div class="text-total"><strong>₱<?php echo number_format($grandTotal, 2); ?></strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="no-products-message" style="width: 100%; text-align: center; padding: 60px 20px; background: #f8f9fa; border-radius: 8px; margin-top: 20px;">
                            <i class="fa-solid fa-box-open" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                            <h2 style="color: #666; margin-bottom: 10px;">No Active Orders</h2>
                            <p style="color: #999; font-size: 16px;">You don't have any orders in process, out for delivery, or reserved status.</p>
                            <p style="color: #999; font-size: 14px; margin-top: 10px;">Check your order history or start shopping!</p>
                        </div>

                    <?php } ?>
                </div>
            </main>
        <?php
        } else {
        ?>
            <div class="no-products-message" style="flex-direction: column;">
                <p>No products or vouchers available at the moment.</p>
                <a href="../components/history.php">
                    <div class="order-status">
                        View your order history</div>
                </a>
            
            </div>
            
        <?php } ?>
    </div>



    <?php
    if ((!empty($_SESSION["user_id"]))) {
        include "cart.php";
    }
    ?>

    <script src="../jquery/updateProfile.js"></script>
    <script src="../jquery/checkout.js"></script>

    <script>
        // Handle voucher deletion
        $(document).on('click', '.delete-voucher-js', function() {
            const voucherId = $(this).attr('id');

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to remove this voucher from your order?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '../backend/user/delete-voucher-from-order.php',
                        method: 'POST',
                        data: {
                            voucher_id: voucherId
                        },
                        success: function(response) {
                            const res = JSON.parse(response);
                            if (res.success) {
                                Swal.fire("Success!", "Voucher removed successfully!", "success")
                                    .then(() => {
                                        location.reload();
                                    });
                            } else {
                                swal("Error!", res.message, "error");
                            }
                        },
                        error: function() {
                            swal("Error!", "Failed to remove voucher.", "error");
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>