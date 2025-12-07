<?php
require_once("../backend/config/config.php");
?>
<link rel="stylesheet" href="../styles/cart.css">
<script src="../jquery/jquery.js"></script>

<?php
if (!empty($_SESSION["user_id"])) {
    

$current_user = $_SESSION['user_id'];
?>

<?php
// Get products in cart
$query = "SELECT tc.*, tp.*
    FROM tbl_cart tc
    JOIN tbl_products tp ON tc.prod_id = tp.prod_id
    WHERE tc.account_id = ? AND tc.status_id = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $current_user);
$stmt->execute();
$result = $stmt->get_result();

// Get vouchers in cart
$queryVouchers = "SELECT cv.*, v.*
    FROM tbl_cart_vouchers cv
    JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
    WHERE cv.account_id = ? AND cv.status_id = 1";
$stmtVouchers = $conn->prepare($queryVouchers);
$stmtVouchers->bind_param("i", $current_user);
$stmtVouchers->execute();
$resultVouchers = $stmtVouchers->get_result();

// Check if cart has items
$hasItems = ($result->num_rows > 0 || $resultVouchers->num_rows > 0);
?>

<div class="main-cart-cont" id="main-cart-cont">
    <div class="cart-cont" id="cart-cont">
        <div class="my-cart-title" id="my-cart-title">
            <div class="exit">
                <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.7071 4.29289C12.0976 4.68342 12.0976 5.31658 11.7071 5.70711L6.41421 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H6.41421L11.7071 18.2929C12.0976 18.6834 12.0976 19.3166 11.7071 19.7071C11.3166 20.0976 10.6834 20.0976 10.2929 19.7071L3.29289 12.7071C3.10536 12.5196 3 12.2652 3 12C3 11.7348 3.10536 11.4804 3.29289 11.2929L10.2929 4.29289C10.6834 3.90237 11.3166 3.90237 11.7071 4.29289Z"
                        fill="#000000" />
                </svg>
            </div>
            <h1>My Cart</h1>
        </div>
        <div class="whole-cont-display">
            <?php if ($hasItems) { ?>
                <div class="whole-item-cont" id="whole-item-cont">
                    <div class="order-summary-header">Order Summary</div>
                    <div class="item-cont" id="item-cont">
                        <?php
                        $total = 0;
                        $voucherDiscount = 0;
                        
                        // Store all cart items for voucher calculation
                        $cartItems = [];
                        mysqli_data_seek($result, 0);
                        while ($data = $result->fetch_assoc()) {
                            $origprice = $data['prod_price'] + 100;
                            $prodprice = $origprice;
                            $subtotal = $data["prod_qnty"] * $prodprice;
                            $total += $subtotal;
                            
                            $cartItems[] = [
                                'prod_id' => $data['prod_id'],
                                'subtotal' => $subtotal
                            ];
                        }
                        
                        // Calculate voucher discounts (only for eligible items)
                        $voucherEligibleTotal = 0;
                        if ($resultVouchers->num_rows > 0) {
                            mysqli_data_seek($resultVouchers, 0);
                            while ($voucher = $resultVouchers->fetch_assoc()) {
                                // Parse target items
                                $targetItems = json_decode($voucher['target_items'], true);
                                $eligibleProductIds = [];
                                
                                if ($targetItems) {
                                    foreach ($targetItems as $item) {
                                        if ($item['type'] == 'product') {
                                            $eligibleProductIds[] = $item['id'];
                                        }
                                    }
                                }
                                
                                // Calculate subtotal for eligible items only
                                $voucherSubtotal = 0;
                                foreach ($cartItems as $cartItem) {
                                    if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                        $voucherSubtotal += $cartItem['subtotal'];
                                    }
                                }
                                
                                // Calculate discount based on eligible items only
                                if ($voucher['discount_type'] == 'percentage') {
                                    $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                    if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                        $currentDiscount = $voucher['max_discount'];
                                    }
                                } else {
                                    $currentDiscount = $voucher['discount_value'];
                                }
                                
                                // Check minimum purchase requirement
                                $meetsMinimum = ($total >= $voucher['min_purchase']);
                                if ($meetsMinimum) {
                                    $voucherDiscount += $currentDiscount;
                                    $voucherEligibleTotal += $voucherSubtotal;
                                }
                            }
                        }
                        
                        // Display products
                        mysqli_data_seek($result, 0);
                        while ($data = $result->fetch_assoc()) {
                            $origprice = $data['prod_price'] + 100;
                            $prodprice = $origprice;
                            $subtotal = $data["prod_qnty"] * $prodprice;
                        ?>
                            <div class="item-cont-flex">
                                <div class="item-img-cont">
                                    <img src="../images/products/<?= $data['prod_img']; ?>" alt="img">
                                </div>
                                <div class="item-details">
                                    <p class="item-name"> <?= $data['prod_name'] ?> </p>
                                    <div class="item-classification"><?= $data['prod-short-desc'] ?> </div>
                                    <div class="item-prices">
                                        <div class="prices-cont">
                                            <div class="main-price"> <?= number_format($prodprice, 2) ?> </div>
                                        </div>
                                        <div class="quantity-buttons">
                                            <button class="minus-btn" data-item-id="<?= $data["prod_id"] ?>"> - </button>
                                            <div class="quantity-display"><?= $data["prod_qnty"] ?> </div>
                                            <button class="add-btn" data-item-id="<?= $data["prod_id"] ?>"> + </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        // Display vouchers in cart
                        if ($resultVouchers->num_rows > 0) {
                            mysqli_data_seek($resultVouchers, 0);

                            while ($voucher = $resultVouchers->fetch_assoc()) {
                                // Parse target items
                                $targetItems = json_decode($voucher['target_items'], true);
                                $eligibleProductIds = [];
                                
                                if ($targetItems) {
                                    foreach ($targetItems as $item) {
                                        if ($item['type'] == 'product') {
                                            $eligibleProductIds[] = $item['id'];
                                        }
                                    }
                                }
                                
                                // Calculate subtotal for eligible items only
                                $voucherSubtotal = 0;
                                foreach ($cartItems as $cartItem) {
                                    if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                        $voucherSubtotal += $cartItem['subtotal'];
                                    }
                                }
                                
                                // Calculate voucher discount
                                if ($voucher['discount_type'] == 'percentage') {
                                    $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                    if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                        $currentDiscount = $voucher['max_discount'];
                                    }
                                } else {
                                    $currentDiscount = $voucher['discount_value'];
                                }

                                // Check minimum purchase requirement
                                $meetsMinimum = ($total >= $voucher['min_purchase']);
                        ?>
                                <div class="item-cont-flex voucher-item" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-left: 4px solid #4a9f20ff; margin-bottom: 15px;">
                                    <div class="item-img-cont" style="background: #4a9f20ff; display: flex; align-items: center; justify-content: center; min-width: 70px;">
                                        <i class="fa-solid fa-ticket-simple" style="color: white; font-size: 40px;"></i>
                                    </div>
                                    <div class="item-details" style="flex: 1;">
                                        <p class="item-name" style="color: #4a9f20ff; font-weight: bold; font-size: 16px;">
                                            <i class="fa-solid fa-tag"></i> <?= htmlspecialchars($voucher['voucher_name']) ?>
                                        </p>
                                        <div class="item-classification" style="font-weight: 600; margin: 5px 0;">
                                            Code: <span style="background: #4a9f20ff; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px;"><?= htmlspecialchars($voucher['voucher_code']) ?></span>
                                        </div>
                                        <div class="voucher-details" style="font-size: 12px; color: #6c757d; margin-top: 5px;">
                                            <?php if ($voucher['discount_type'] == 'percentage') { ?>
                                                <span><i class="fa-solid fa-percent"></i> <?= intval($voucher['discount_value']) ?>% OFF</span>
                                                <?php if ($voucher['max_discount'] > 0) { ?>
                                                    <span style="margin-left: 10px;">(Max: ₱<?= number_format($voucher['max_discount'], 2) ?>)</span>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <span><i class="fa-solid fa-peso-sign"></i> ₱<?= number_format($voucher['discount_value'], 2) ?> OFF</span>
                                            <?php } ?>
                                            <?php if ($voucher['min_purchase'] > 0) { ?>
                                                <span style="margin-left: 10px;"><i class="fa-solid fa-cart-shopping"></i> Min: ₱<?= number_format($voucher['min_purchase'], 2) ?></span>
                                            <?php } ?>
                                        </div>
                                        <div class="voucher-eligible-items" style="font-size: 11px; color: #6c757d; margin-top: 5px;">
                                            <i class="fa-solid fa-box"></i> Eligible items subtotal: ₱<?= number_format($voucherSubtotal, 2) ?>
                                        </div>
                                        <?php if (!$meetsMinimum) { ?>
                                            <div class="voucher-warning" style="background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px; margin-top: 8px; font-size: 11px;">
                                                <i class="fa-solid fa-exclamation-triangle"></i> Add ₱<?= number_format($voucher['min_purchase'] - $total, 2) ?> more to use this voucher
                                            </div>
                                        <?php } else { ?>
                                            <div class="voucher-applied" style="background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 5px; margin-top: 8px; font-size: 11px;">
                                                <i class="fa-solid fa-check-circle"></i> Discount applied: -₱<?= number_format($currentDiscount, 2) ?>
                                            </div>
                                        <?php } ?>
                                        <div class="item-prices" style="margin-top: 10px;">
                                            <button class="remove-voucher-btn" data-voucher-id="<?= $voucher['voucher_id'] ?>"
                                                style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 12px;">
                                                <i class="fa-solid fa-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        
                        // Recalculate totals with voucher discounts
                        $grandTotal = $total - $voucherDiscount;
                        if ($grandTotal < 0) $grandTotal = 0;
                        $savedAmount = $voucherDiscount;
                        ?>
                    </div>
                </div>

                <div>
                    <div class="cart-details" id="cart-details">
                        <div class="saved-amount-cont">
                            <div class="saved-amount">
                                <div>
                                    You saved <span>₱ <?= number_format($savedAmount, 2) ?></span> on this order
                                </div>
                            </div>
                        </div>
                        <div class="price-summary-cont">
                            <div>
                                <div class="price-summary">
                                    Price Summary
                                </div>
                                <div class="order-total">
                                    <div>Order Total</div>
                                    <div>₱<?= number_format($total, 2) ?></div>
                                </div>
                                <div class="shipping-discount">
                                    <div>Shipping</div>
                                    <div>
                                        <?php 
                                        $shippingFee = ($grandTotal >= 500) ? 0 : 50;
                                        if ($shippingFee == 0) {
                                            echo '<span style="text-decoration: line-through; color: black;">₱50</span> Free';
                                        } else {
                                            echo '₱' . number_format($shippingFee, 2);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php if ($voucherDiscount > 0) { ?>
                                    <div class="voucher-discount" style="color: white; font-weight: 500; padding: 10px 20px;
                                    font-size: 18px; border-top: 1px dashed #dee2e6;">
                                        <div><i class="fa-solid fa-ticket-simple"></i> Voucher Discount</div>
                                        <div>-₱<?= number_format($voucherDiscount, 2) ?></div>
                                    </div>
                                <?php } ?>
                                <div class="grand-total">
                                    <div>Grand Total</div>
                                    <div>₱<?= number_format($grandTotal, 2) ?></div>
                                </div>
                                <div class="secure-payment">
                                    <img src="../images/icons/icon-cart-safe-pay.png" alt="">
                                    <div>Safe and Secure Payment, Easy Return</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-button-cont" id="checkout-button-cont">
                        <div class="item-details-price">
                            <div>₱<?= number_format($grandTotal, 2) ?></div>
                        </div>
                        <div>
                            <a href="./checkout.php">
                                <button>Checkout</button>
                            </a>
                        </div>
                    </div>
                </div>
        </div>
    <?php } else { ?>

        <div class="empty-cont" id="empty-cont">
            <div class="empty-cont-img">
                <img src="../images/icons/cart-empty.png" alt="">
            </div>
            <div class="empty-cart-text">
                Your Cart is empty !
            </div>
            <div>
                It's a good day to buy the items you saved for later
            </div>
            <div class="shop-now-cont">
                <a href="../components/all-products.php">
                    <button class="shop-now">Shop Now</button>
                </a>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php } ?>

<script src="../scripts/cart.js"></script>
<script src="../jquery/addtocart.js"></script>
<script src="../jquery/add-voucher-to-cart.js"></script>