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
    <title>Order History</title>
    <link rel="stylesheet" href="../styles/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <script src="../jquery/jquery.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        main {
            margin-bottom: 60px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .profile-main-cont {
            padding: 40px 20px;
        }

        .center {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
        }

        .order-status {
            background: #2c3e50;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .order-status:hover {
            background: #34495e;
            transform: translateY(-2px);
        }

        .order-group {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .order-date-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .order-date-header i {
            color: #6c757d;
            font-size: 18px;
        }

        .order-date-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: #495057;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .styled-table thead {
            background: #f8f9fa;
        }

        .styled-table th {
            text-align: left;
            padding: 14px 12px;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 2px solid #dee2e6;
        }

        .styled-table td {
            padding: 16px 12px;
            color: #6c757d;
            font-size: 14px;
            border-bottom: 1px solid #f1f3f5;
            vertical-align: middle;
        }

        .styled-table tbody tr {
            transition: all 0.2s ease;
        }

        .styled-table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Remove hover effect for voucher and summary rows */
        .styled-table tbody tr.voucher-separator:hover,
        .styled-table tbody tr.voucher-row:hover,
        .styled-table tbody tr.summary-separator:hover,
        .styled-table tbody tr.summary-row:hover,
        .styled-table tbody tr.summary-total:hover {
            background: transparent;
        }

        .img-con {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .img-con img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .product-name {
            font-weight: 500;
            color: #2c3e50;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #d1e7dd;
            color: #0f5132;
        }

        /* Voucher styling in table */
        .voucher-separator td {
            padding: 20px 12px 10px 12px !important;
            border-bottom: none !important;
        }

        .voucher-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #1864ab;
            font-size: 14px;
        }

        .voucher-header i {
            font-size: 16px;
        }

        .voucher-row {
            background: #f8f9fa !important;
        }

        .voucher-row td {
            border-bottom: 1px solid #e9ecef !important;
        }

        .voucher-img {
            background: #e7f5ff !important;
        }

        .voucher-img i {
            font-size: 32px;
            color: #339af0;
        }

        .voucher-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .voucher-code-text {
            font-size: 11px;
            color: #6c757d;
            font-family: monospace;
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 4px;
        }

        /* Summary rows styling */
        .summary-separator td {
            padding: 10px 12px !important;
            border-bottom: 2px solid #dee2e6 !important;
        }

        .summary-row td,
        .summary-total td {
            border-bottom: none !important;
            padding: 8px 12px !important;
        }

        .summary-row td:nth-child(5),
        .summary-row td:nth-child(6),
        .summary-total td:nth-child(5),
        .summary-total td:nth-child(6) {
            text-align: right;
            font-size: 15px;
        }

        .summary-total td {
            padding-top: 12px !important;
            font-size: 16px;
        }

        .summary-total td strong {
            font-size: 18px;
        }

        .discount-text {
            color: #f03e3e;
            font-weight: 600;
        }

        .no-products-message {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .no-products-message i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
            display: block;
        }

        .no-products-message p {
            font-size: 18px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .styled-table {
                font-size: 12px;
            }

            .styled-table th,
            .styled-table td {
                padding: 10px 8px;
            }

            .img-con {
                width: 60px;
                height: 60px;
            }

            .styled-table th:first-child,
            .styled-table td:first-child {
                display: none;
            }

            .voucher-img i {
                font-size: 24px;
            }
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

    <div class="page-header">
        <h1><i class="fa-solid fa-clock-rotate-left"></i> Order History</h1>
        <a href="../components/orders.php">
            <div class="order-status">View Current Orders</div>
        </a>
    </div>

    <div class="profile-main-cont">
        <div class="">


            <?php
            // Get current order products
            $query = "SELECT tc.*, tp.*, ts.status_name
        FROM tbl_cart tc
        JOIN tbl_products tp ON tc.prod_id = tp.prod_id
        JOIN tbl_status ts ON tc.status_id = ts.status_id
        WHERE tc.account_id = ? AND tc.status_id IN (2, 3, 4)
        ORDER BY tc.order_date DESC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $acc_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Get current order vouchers
            $queryVouchers = "SELECT cv.*, v.*, ts.status_name, 
            (SELECT MIN(tc.order_date) 
             FROM tbl_cart tc 
             WHERE tc.account_id = cv.account_id 
             AND tc.status_id IN (2, 3, 4)
             AND tc.order_date >= DATE(cv.added_date)) as order_date
        FROM tbl_cart_vouchers cv
        JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
        JOIN tbl_status ts ON cv.status_id = ts.status_id
        WHERE cv.account_id = ? AND cv.status_id IN (2, 3)";
            $stmtVouchers = $conn->prepare($queryVouchers);
            $stmtVouchers->bind_param("i", $acc_id);
            $stmtVouchers->execute();
            $resultVouchers = $stmtVouchers->get_result();

            if ($result->num_rows > 0) {
                // Group products by order date
                $orderGroups = [];
                $vouchersByDate = [];

                mysqli_data_seek($result, 0);
                while ($data = $result->fetch_assoc()) {
                    $orderDate = $data['order_date'];
                    if (!isset($orderGroups[$orderDate])) {
                        $orderGroups[$orderDate] = [];
                    }
                    $orderGroups[$orderDate][] = $data;
                }

                // Group vouchers by order date
                mysqli_data_seek($resultVouchers, 0);
                while ($voucher = $resultVouchers->fetch_assoc()) {
                    $orderDate = $voucher['order_date'];
                    if ($orderDate && !isset($vouchersByDate[$orderDate])) {
                        $vouchersByDate[$orderDate] = [];
                    }
                    if ($orderDate) {
                        $vouchersByDate[$orderDate][] = $voucher;
                    }
                }

                // Display orders grouped by date
                foreach ($orderGroups as $orderDate => $items) {
                    $dateFormatted = date('F d, Y', strtotime($orderDate));
                    $subtotal = 0;
                    $voucherDiscount = 0;

                    // Calculate subtotal for this order date
                    foreach ($items as $item) {
                        $origprice = $item['prod_price'] + 100;
                        $subtotal += round($item["prod_qnty"] * $origprice, 2);
                    }

                    // Calculate voucher discounts for this date (same logic as cart.php)
                    if (isset($vouchersByDate[$orderDate])) {
                        foreach ($vouchersByDate[$orderDate] as $voucher) {
                            $targetItems = json_decode($voucher['target_items'], true);
                            $eligibleProductIds = [];

                            // Check if voucher applies to all products (same logic as cart.php)
                            $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null || count($targetItems) == 0);

                            if ($applyToAll) {
                                // Apply to ALL products in cart
                                foreach ($items as $item) {
                                    $eligibleProductIds[] = $item['prod_id'];
                                }
                            } else {
                                // Extract eligible product IDs from target items
                                if ($targetItems && is_array($targetItems)) {
                                    foreach ($targetItems as $item) {
                                        if (isset($item['type']) && $item['type'] == 'product' && isset($item['id'])) {
                                            $eligibleProductIds[] = intval($item['id']);
                                        }
                                    }
                                }
                            }

                            // Calculate subtotal for eligible items only
                            $voucherSubtotal = 0;
                            foreach ($items as $item) {
                                if (in_array($item['prod_id'], $eligibleProductIds)) {
                                    $origprice = $item['prod_price'] + 100;
                                    $voucherSubtotal += round($item["prod_qnty"] * $origprice, 2);
                                }
                            }

                            // Calculate discount based on eligible items only
                            $currentDiscount = 0;
                            if ($voucher['discount_type'] == 'percentage') {
                                $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                    $currentDiscount = $voucher['max_discount'];
                                }
                            } else {
                                // Fixed amount discount (min of discount value or voucher subtotal)
                                $currentDiscount = min($voucher['discount_value'], $voucherSubtotal);
                            }

                            // Check minimum purchase requirement
                            $meetsMinimum = ($subtotal >= $voucher['min_purchase']);

                            if ($meetsMinimum && $voucherSubtotal > 0) {
                                $voucherDiscount += $currentDiscount;
                            }
                        }
                    }

                    // Calculate shipping fee (same logic as cart.php)
                    $shippingFee = 50; // Default shipping fee

                    // Calculate grand total BEFORE shipping to check if free shipping applies
                    $grandTotalBeforeShipping = $subtotal - $voucherDiscount;
                    if ($grandTotalBeforeShipping < 0) {
                        $grandTotalBeforeShipping = 0;
                    }

                    // Apply free shipping if total before shipping is >= 500 (same logic as cart.php)
                    if ($grandTotalBeforeShipping >= 500) {
                        $shippingFee = 0;
                    }

                    // Calculate final grand total (WITH shipping fee)
                    $grandTotal = $grandTotalBeforeShipping + $shippingFee;
                    if ($grandTotal < 0) $grandTotal = 0;
            ?>
                    <div class="order-group">
                        <div class="order-date-header">
                            <i class="fa-solid fa-calendar"></i>
                            <h2>Ordered on <?php echo $dateFormatted; ?></h2>
                        </div>

                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $data) {
                                    $origprice = $data['prod_price'] + 100;
                                    $itemSubtotal = round($data["prod_qnty"] * $origprice, 2);
                                ?>
                                    <tr>
                                        <td>
                                            <div class="img-con">
                                                <img src="../images/products/<?php echo $data["prod_img"]; ?>" alt="">
                                            </div>
                                        </td>
                                        <td class="product-name"><?php echo $data["prod_name"]; ?></td>
                                        <td>₱<?php echo number_format($origprice, 2); ?></td>
                                        <td><?php echo $data["prod_qnty"]; ?></td>
                                        <td>₱<?php echo number_format($itemSubtotal, 2); ?></td>
                                        <td><span class="status-badge"><?php echo $data["status_name"]; ?></span></td>
                                    </tr>
                                <?php } ?>

                                <?php if (isset($vouchersByDate[$orderDate]) && count($vouchersByDate[$orderDate]) > 0) { ?>
                                    <tr class="voucher-separator">
                                        <td colspan="6">
                                            <div class="voucher-header">
                                                <i class="fa-solid fa-ticket"></i> Applied Vouchers
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    // Create array to track displayed vouchers
                                    $displayedVouchers = [];

                                    foreach ($vouchersByDate[$orderDate] as $voucher) {
                                        // Skip if this voucher was already displayed for this order date
                                        if (in_array($voucher['voucher_id'], $displayedVouchers)) {
                                            continue;
                                        }

                                        // Mark this voucher as displayed
                                        $displayedVouchers[] = $voucher['voucher_id'];

                                        $targetItems = json_decode($voucher['target_items'], true);
                                        $eligibleProductIds = [];

                                        // Check if voucher applies to all products (same logic as cart.php)
                                        $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null || count($targetItems) == 0);

                                        if ($applyToAll) {
                                            // Apply to ALL products in cart
                                            foreach ($items as $item) {
                                                $eligibleProductIds[] = $item['prod_id'];
                                            }
                                        } else {
                                            // Extract eligible product IDs from target items
                                            if ($targetItems && is_array($targetItems)) {
                                                foreach ($targetItems as $item) {
                                                    if (isset($item['type']) && $item['type'] == 'product' && isset($item['id'])) {
                                                        $eligibleProductIds[] = intval($item['id']);
                                                    }
                                                }
                                            }
                                        }

                                        // Calculate subtotal for eligible items only
                                        $voucherSubtotal = 0;
                                        foreach ($items as $item) {
                                            if (in_array($item['prod_id'], $eligibleProductIds)) {
                                                $origprice = $item['prod_price'] + 100;
                                                $voucherSubtotal += round($item["prod_qnty"] * $origprice, 2);
                                            }
                                        }

                                        // Calculate discount based on eligible items only
                                        $currentDiscount = 0;
                                        if ($voucher['discount_type'] == 'percentage') {
                                            $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                            if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                                $currentDiscount = $voucher['max_discount'];
                                            }
                                        } else {
                                            // Fixed amount discount (min of discount value or voucher subtotal)
                                            $currentDiscount = min($voucher['discount_value'], $voucherSubtotal);
                                        }

                                        // Check minimum purchase requirement
                                        $meetsMinimum = ($subtotal >= $voucher['min_purchase']);

                                        // Only show discount if minimum is met AND there are eligible items
                                        $displayDiscount = 0;
                                        if ($meetsMinimum && $voucherSubtotal > 0) {
                                            $displayDiscount = $currentDiscount;
                                        }
                                    ?>
                                        <tr class="voucher-row">
                                            <td>
                                                <div class="img-con voucher-img">
                                                    <i class="fa-solid fa-ticket-simple"></i>
                                                </div>
                                            </td>
                                            <td class="product-name">
                                                <div class="voucher-name"><?php echo htmlspecialchars($voucher['voucher_name']); ?></div>
                                                <div class="voucher-code-text">Code: <?php echo htmlspecialchars($voucher['voucher_code']); ?></div>
                                            </td>
                                            <td>
                                                <?php if ($voucher['discount_type'] == 'percentage') { ?>
                                                    <?php echo intval($voucher['discount_value']); ?>% OFF
                                                    <?php if ($voucher['max_discount'] > 0) { ?>
                                                        <div style="font-size: 11px; color: #6c757d;">(Max: ₱<?php echo number_format($voucher['max_discount'], 2); ?>)</div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    ₱<?php echo number_format($voucher['discount_value'], 2); ?> OFF
                                                <?php } ?>
                                                <?php if ($voucher['min_purchase'] > 0) { ?>
                                                    <div style="font-size: 11px; color: #6c757d;">Min: ₱<?php echo number_format($voucher['min_purchase'], 2); ?></div>
                                                <?php } ?>
                                            </td>
                                            <td>1</td>
                                            <td class="discount-text">
                                                <?php if ($displayDiscount > 0) { ?>
                                                    -₱<?php echo number_format($displayDiscount, 2); ?>
                                                <?php } else { ?>
                                                    ₱0.00
                                                    <?php if (!$meetsMinimum && $voucher['min_purchase'] > 0) { ?>
                                                        <div style="font-size: 11px; color: #856404;">
                                                            <i class="fa-solid fa-exclamation-triangle"></i> Min not met
                                                        </div>
                                                    <?php } elseif ($voucherSubtotal == 0) { ?>
                                                        <div style="font-size: 11px; color: #856404;">
                                                            <i class="fa-solid fa-exclamation-triangle"></i> No eligible items
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td><span class="status-badge"><?php echo $voucher["status_name"]; ?></span></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <tr class="summary-separator">
                                    <td colspan="6"></td>
                                </tr>
                                <tr class="summary-row">
                                    <td colspan="4"></td>
                                    <td><strong>Subtotal:</strong></td>
                                    <td><strong>₱<?php echo number_format($subtotal, 2); ?></strong></td>
                                </tr>
                                <?php
                                // Recalculate voucher discount with unique vouchers only
                                $actualVoucherDiscount = 0;
                                $displayedVoucherIds = [];

                                if (isset($vouchersByDate[$orderDate])) {
                                    foreach ($vouchersByDate[$orderDate] as $voucher) {
                                        // Skip if already processed
                                        if (in_array($voucher['voucher_id'], $displayedVoucherIds)) {
                                            continue;
                                        }
                                        $displayedVoucherIds[] = $voucher['voucher_id'];

                                        $targetItems = json_decode($voucher['target_items'], true);
                                        $eligibleProductIds = [];

                                        // Check if voucher applies to all products
                                        $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null || count($targetItems) == 0);

                                        if ($applyToAll) {
                                            foreach ($items as $item) {
                                                $eligibleProductIds[] = $item['prod_id'];
                                            }
                                        } else {
                                            if ($targetItems && is_array($targetItems)) {
                                                foreach ($targetItems as $item) {
                                                    if (isset($item['type']) && $item['type'] == 'product' && isset($item['id'])) {
                                                        $eligibleProductIds[] = intval($item['id']);
                                                    }
                                                }
                                            }
                                        }

                                        // Calculate subtotal for eligible items only
                                        $voucherSubtotal = 0;
                                        foreach ($items as $item) {
                                            if (in_array($item['prod_id'], $eligibleProductIds)) {
                                                $origprice = $item['prod_price'] + 100;
                                                $voucherSubtotal += round($item["prod_qnty"] * $origprice, 2);
                                            }
                                        }

                                        // Calculate discount based on eligible items only
                                        $currentDiscount = 0;
                                        if ($voucher['discount_type'] == 'percentage') {
                                            $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                            if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                                $currentDiscount = $voucher['max_discount'];
                                            }
                                        } else {
                                            $currentDiscount = min($voucher['discount_value'], $voucherSubtotal);
                                        }

                                        // Check minimum purchase requirement
                                        $meetsMinimum = ($subtotal >= $voucher['min_purchase']);

                                        if ($meetsMinimum && $voucherSubtotal > 0) {
                                            $actualVoucherDiscount += $currentDiscount;
                                        }
                                    }
                                }

                                // Recalculate shipping and total with correct voucher discount
                                $grandTotalBeforeShipping = $subtotal - $actualVoucherDiscount;
                                if ($grandTotalBeforeShipping < 0) {
                                    $grandTotalBeforeShipping = 0;
                                }

                                // Apply free shipping if total before shipping is >= 500
                                $shippingFee = 50;
                                if ($grandTotalBeforeShipping >= 500) {
                                    $shippingFee = 0;
                                }

                                // Calculate final grand total
                                $grandTotal = $grandTotalBeforeShipping + $shippingFee;
                                if ($grandTotal < 0) $grandTotal = 0;
                                ?>

                                <?php if ($actualVoucherDiscount > 0) { ?>
                                    <tr class="summary-row">
                                        <td colspan="4"></td>
                                        <td><strong>Voucher Discount:</strong></td>
                                        <td class="discount-text"><strong>-₱<?php echo number_format($actualVoucherDiscount, 2); ?></strong></td>
                                    </tr>
                                <?php } ?>
                                <tr class="summary-row">
                                    <td colspan="4"></td>
                                    <td><strong>Shipping Fee:</strong></td>
                                    <td>
                                        <?php if ($shippingFee == 0) { ?>
                                            <span style="text-decoration: line-through; color: #6c757d;">₱50</span> Free
                                        <?php } else { ?>
                                            ₱<?php echo number_format($shippingFee, 2); ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr class="summary-total">
                                    <td colspan="4"></td>
                                    <td><strong>Total Paid:</strong></td>
                                    <td><strong>₱<?php echo number_format($grandTotal, 2); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="no-products-message">
                    <i class="fa-solid fa-box-open"></i>
                    <p>No order history found</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php
    if ((!empty($_SESSION["user_id"]))) {
        include "cart.php";
    }
    ?>

    <script src="../jquery/updateProfile.js"></script>
    <script src="../jquery/checkout.js"></script>
</body>

</html>