

<?php
    session_start();
    if(empty($_SESSION["user_id"])){
        header("Location: ../index.php");
        exit();
    }
    else{
        session_abort();
    }
?>  
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>History</title>
    <link rel="stylesheet" href="../styles/profile.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="../styles/processed.css">
    <script src="../jquery/jquery.js"></script>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
   </head>
<body>

<?php include "./header.php" ?>
<?php
    $acc_id = $_SESSION["user_id"];
?>
    

<div class="profile-main-cont">

  <?php
    // Get products in cart with delivered status
    $query = "SELECT tc.*, tp.*, ts.status_name
    FROM tbl_cart tc
    JOIN tbl_products tp ON tc.prod_id = tp.prod_id
    JOIN tbl_status ts ON tc.status_id = ts.status_id
    WHERE tc.account_id = ? AND tc.status_id = 2";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",  $acc_id);
    $stmt->execute();   
    $result = $stmt->get_result();

    // Get vouchers in cart with delivered status
    $queryVouchers = "SELECT cv.*, v.*, ts.status_name
        FROM tbl_cart_vouchers cv
        JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
        JOIN tbl_status ts ON cv.status_id = ts.status_id
        WHERE cv.account_id = ? AND cv.status_id = 2";
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
            $subtotal = round($data["prod_qnty"] * $data["prod_price"], 2);
            $total += $subtotal;
            $subtotalOnly += round($data["prod_price"], 2);

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
        $grandTotal = $total - $voucherDiscount;
        if ($grandTotal < 0) $grandTotal = 0;
    ?>
    <main>
        <div class="center" style="flex-direction: column;  align-items:end">
        <a href="../components/orders.php"><div style="display: flex;" class="order-status">Orders</div></a>
            <div class="div">
                <div class="left-con">
                    <div class="cart-con">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Display products
                                mysqli_data_seek($result, 0);
                                while ($data = $result->fetch_assoc()) {
                                    $subtotal = round($data["prod_qnty"] * $data["prod_price"], 2);
                                ?>
                                <tr>
                                    <td>
                                        <div class="img-con">
                                        <img src="../images/products/<?php echo $data["prod_img"]; ?>" alt="">
                                        </div>
                                    </td>
                                    <td><?php echo $data["prod_name"]; ?></td>
                                    <td>₱<?php echo number_format($data["prod_price"], 2); ?></td>
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
        </div>
    </main>
    <?php
    } else {
    ?>
        <div class="no-products-message">
            <p>No products or vouchers in delivery history.</p>
        </div>
    <?php } ?>
</div>



  <?php
  if((!empty($_SESSION["user_id"]))) {
    include "cart.php";
  }
  ?>

  <script src="../jquery/updateProfile.js"></script>
  <script src="../jquery/checkout.js"></script>
</body>
</html>