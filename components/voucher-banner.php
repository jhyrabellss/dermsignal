<?php
// Fetch all active vouchers (no date filtering for display purposes)
$voucher_sql = "SELECT * FROM tbl_vouchers 
                WHERE is_active = 1 
                ORDER BY discount_value DESC";
                
$voucher_result = $conn->query($voucher_sql);

if($voucher_result && $voucher_result->num_rows > 0) {
?>
<div class="voucher-banner-container">
    <div class="voucher-banner-header">
        <i class="fa-solid fa-ticket-simple" style="color: #4a9f20ff; font-size: 28px;"></i>
        <h2>Available Vouchers</h2>
    </div>
    
    <div class="voucher-cards-wrapper">
        <?php while($voucher = $voucher_result->fetch_assoc()) { 
            // Format discount text
            $discount_text = $voucher['discount_type'] == 'percentage' 
                ? "UP TO " . intval($voucher['discount_value']) . '% OFF' 
                : '₱' . number_format($voucher['discount_value'], 2) . ' OFF';
            
            // Format applicable to
            $applicable_to = ucfirst($voucher['voucher_type']);
            if($voucher['voucher_type'] == 'both') {
                $applicable_to = 'Products & Services';
            } elseif($voucher['voucher_type'] == 'product') {
                $applicable_to = 'Products Only';
            } elseif($voucher['voucher_type'] == 'service') {
                $applicable_to = 'Services Only';
            }
            
            // Calculate days remaining until start or end
            $start_date = new DateTime($voucher['start_date']);
            $end_date = new DateTime($voucher['end_date']);
            $today = new DateTime();
            
            $is_upcoming = $today < $start_date;
            $is_active = $today >= $start_date && $today <= $end_date;
            $is_expired = $today > $end_date;
            
            if($is_upcoming) {
                $days_until_start = $today->diff($start_date)->days;
                $status_text = "Starts in " . $days_until_start . " day" . ($days_until_start != 1 ? 's' : '');
                $status_class = 'upcoming';
            } elseif($is_active) {
                $days_left = $today->diff($end_date)->days;
                $status_text = "Expires in " . $days_left . " day" . ($days_left != 1 ? 's' : '');
                $status_class = $days_left <= 3 ? 'expiring-soon' : 'active';
            } else {
                $status_text = "Expired";
                $status_class = 'expired';
            }
        ?>
        <div class="voucher-card <?= $voucher['auto_apply'] ? 'auto-apply' : '' ?> <?= $status_class ?>">
            <div class="store-only-badge">
            <i class="fa-solid fa-store"></i>
                Item Discount
            </div>
            <div class="voucher-left">
                    <div class="voucher-discount"><?= rtrim($discount_text, '.00') ?></div>
                    <div class="voucher-category"><?= htmlspecialchars($voucher['promo_category']) ?></div>
                </div>
            <div class="voucher-card-inner">
                
                <div class="voucher-divider">
                    <div class="circle circle-top"></div>
                    <div class="dashed-line"></div>
                    <div class="circle circle-bottom"></div>
                </div>
                
                <div class="voucher-right">
                    <div class="voucher-name"><?= htmlspecialchars($voucher['voucher_name']) ?></div>
                    <div class="voucher-code-container">
                        <span class="voucher-label">Code:</span>
                        <span class="voucher-code"><?= htmlspecialchars($voucher['voucher_code']) ?></span>
                    </div>
                    
                    <div class="voucher-details-grid">
                        <div class="voucher-detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span><?= $applicable_to ?></span>
                        </div>
                        
                        <?php if($voucher['min_purchase'] > 0) { ?>
                        <div class="voucher-detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"/>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                            <span>Min: ₱<?= number_format($voucher['min_purchase'], 2) ?></span>
                        </div>
                        <?php } ?>
                        
                        <?php if($voucher['usage_limit'] > 0) { ?>
                        <div class="voucher-detail-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="8.5" cy="7" r="4"/>
                                <line x1="20" y1="8" x2="20" y2="14"/>
                                <line x1="23" y1="11" x2="17" y2="11"/>
                            </svg>
                            <span><?= $voucher['used_count'] ?>/<?= $voucher['usage_limit'] ?> used</span>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <div class="voucher-dates">
                        <div class="date-item">
                            <strong>Valid:</strong> <?= date('M d, Y', strtotime($voucher['start_date'])) ?> - <?= date('M d, Y', strtotime($voucher['end_date'])) ?>
                        </div>
                    </div>
                    
                    <div class="voucher-status <?= $status_class ?>">
                        <?php if($is_upcoming) { ?>
                            ⏰ <?= $status_text ?>
                        <?php } elseif($is_active && $days_left <= 3) { ?>
                            ⚠️ <?= $status_text ?>
                        <?php } elseif($is_active) { ?>
                            ✓ Active - <?= $status_text ?>
                        <?php } else { ?>
                            ✕ <?= $status_text ?>
                        <?php } ?>
                    </div>

                    <?php if($is_active && !empty($_SESSION["user_id"])) { ?>
                    <button class="add-voucher-to-cart" data-voucher-id="<?= $voucher['voucher_id'] ?>" data-voucher-code="<?= htmlspecialchars($voucher['voucher_code']) ?>">
                        <i class="fa-solid fa-plus"></i> Add to Cart
                    </button>
                    <?php } elseif($is_active && empty($_SESSION["user_id"])) { ?>
                    <button class="add-voucher-to-cart login-required" onclick="openForm('myFormSignUp')">
                        <i class="fa-solid fa-user-lock"></i> Login to Add
                    </button>
                    <?php } ?>
                    
                    <?php if($voucher['target_items']) { 
                        $target_items = json_decode($voucher['target_items'], true);
                        if($target_items && count($target_items) > 0) {
                    ?>
                    <div class="voucher-applicable-items">
                        <div class="applicable-items-header">Applicable to:</div>
                        <div class="applicable-items-list">
                            <?php 
                            $display_limit = 3;
                            $total_items = count($target_items);
                            foreach(array_slice($target_items, 0, $display_limit) as $item) { 
                            ?>
                                <span class="item-tag">
                                    <?= $item['type'] == 'product' ? '🛍️' : '💆' ?> 
                                    <?= htmlspecialchars($item['name']) ?>
                                </span>
                            <?php } ?>
                            <?php if($total_items > $display_limit) { ?>
                                <span class="item-tag more">+<?= $total_items - $display_limit ?> more</span>
                            <?php } ?>
                        </div>
                    </div>
                    <?php 
                        }
                    } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <div class="voucher-footer-note">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="16" x2="12" y2="12"/>
            <line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>
    </div>
</div>
<?php 
}
?>