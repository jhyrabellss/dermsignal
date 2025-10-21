<?php
require_once("../../backend/config/config.php");

$query = "SELECT * FROM tbl_vouchers ORDER BY created_at DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($voucher = $result->fetch_assoc()) {
        $today = date('Y-m-d');
        $status_class = '';
        $status_text = '';
        $status_badge_class = '';
        
        if ($voucher['is_active'] == 0) {
            $status_class = 'promo-inactive';
            $status_text = 'Inactive';
            $status_badge_class = 'status-inactive';
        } elseif ($today < $voucher['start_date']) {
            $status_class = 'promo-upcoming';
            $status_text = 'Upcoming';
            $status_badge_class = 'status-upcoming';
        } elseif ($today > $voucher['end_date']) {
            $status_class = 'promo-inactive';
            $status_text = 'Expired';
            $status_badge_class = 'status-expired';
        } else {
            $status_class = 'promo-active';
            $status_text = 'Active';
            $status_badge_class = 'status-active';
        }

        $discount_display = $voucher['discount_type'] == 'percentage' 
            ? $voucher['discount_value'] . '%' 
            : '₱' . number_format($voucher['discount_value'], 2);

        $target_items_display = 'All Items';
        if ($voucher['target_items']) {
            $items = json_decode($voucher['target_items'], true);
            $target_items_display = count($items) . ' specific items';
        }

        $usage_display = $voucher['usage_limit'] 
            ? $voucher['used_count'] . ' / ' . $voucher['usage_limit'] 
            : $voucher['used_count'] . ' / Unlimited';

        echo "
        <div class='voucher-card {$status_class}'>
            <div class='row align-items-center'>
                <div class='col-md-9'>
                    <div class='voucher-header'>
                        <h5 class='voucher-title'>
                            <i class='fas fa-ticket'></i> {$voucher['voucher_name']}
                        </h5>
                        <span class='voucher-status {$status_badge_class}'>{$status_text}</span>
                    </div>
                    
                    <div class='voucher-details'>
                        <div class='detail-row'>
                            <span class='detail-label'><i class='fas fa-barcode'></i> Code:</span>
                            <span class='voucher-code'>{$voucher['voucher_code']}</span>
                        </div>
                        
                        <div class='detail-row'>
                            <span class='detail-label'><i class='fas fa-percent'></i> Discount:</span>
                            <span class='voucher-discount'>{$discount_display} off</span>
                        </div>
                        
                        <div class='detail-row'>
                            <span class='detail-label'><i class='fas fa-calendar-alt'></i> Valid:</span>
                            <span>" . date('M d, Y', strtotime($voucher['start_date'])) . " - " . date('M d, Y', strtotime($voucher['end_date'])) . "</span>
                        </div>
                        
                        <div class='detail-row'>
                            <span class='detail-label'><i class='fas fa-users'></i> Usage:</span>
                            <span class='usage-count'>{$usage_display}</span>
                        </div>
                        
                        <div class='detail-row'>
                            <span class='detail-label'><i class='fas fa-tag'></i> Applies To:</span>
                            <span>" . ucfirst($voucher['voucher_type']) . " <span class='text-muted'>({$target_items_display})</span></span>
                        </div>
                        
                        " . ($voucher['promo_category'] ? "<div class='detail-row'><span class='promo-category-badge'><i class='fas fa-folder'></i> {$voucher['promo_category']}</span></div>" : "") . "
                    </div>
                </div>
                
                <div class='col-md-3'>
                    <div class='voucher-actions'>
                        <button class='btn btn-action btn-action-edit' onclick='editVoucher({$voucher['voucher_id']})' title='Edit Voucher'>
                            <i class='fas fa-edit'></i> Edit
                        </button>
                        <button class='btn btn-action btn-action-toggle' onclick='toggleVoucher({$voucher['voucher_id']}, {$voucher['is_active']})' title='" . ($voucher['is_active'] ? 'Deactivate' : 'Activate') . " Voucher'>
                            <i class='fas fa-power-off'></i> " . ($voucher['is_active'] ? 'Deactivate' : 'Activate') . "
                        </button>
                        <button class='btn btn-action btn-action-delete' onclick='deleteVoucher({$voucher['voucher_id']})' title='Delete Voucher'>
                            <i class='fas fa-trash-alt'></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .voucher-card {
                background: #ffffff;
                border: 1px solid #e8e8e8;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 16px;
                transition: all 0.3s ease;
            }
            
            .voucher-card:hover {
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            }
            
            .promo-active {
                border-left: 4px solid #5a8c3a;
                background: #f9fdf9;
            }
            
            .promo-inactive {
                border-left: 4px solid #999999;
                background: #f8f8f8;
            }
            
            .promo-upcoming {
                border-left: 4px solid #7a7a7a;
                background: #fafafa;
            }
            
            .voucher-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 16px;
                padding-bottom: 12px;
                border-bottom: 1px solid #e8e8e8;
            }
            
            .voucher-title {
                margin: 0;
                font-size: 1.2rem;
                font-weight: 600;
                color: #2d2d2d;
            }
            
            .voucher-title i {
                color: #5a8c3a;
                margin-right: 8px;
            }
            
            .voucher-status {
                padding: 4px 12px;
                border-radius: 4px;
                font-size: 0.85rem;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .status-active {
                background: #e8f5e9;
                color: #2d5016;
                border: 1px solid #c8e6c9;
            }
            
            .status-inactive {
                background: #f5f5f5;
                color: #666666;
                border: 1px solid #d0d0d0;
            }
            
            .status-upcoming {
                background: #fafafa;
                color: #555555;
                border: 1px solid #e0e0e0;
            }
            
            .status-expired {
                background: #f5f5f5;
                color: #999999;
                border: 1px solid #d0d0d0;
            }
            
            .voucher-details {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            
            .detail-row {
                display: flex;
                align-items: center;
                font-size: 0.95rem;
                color: #333333;
            }
            
            .detail-label {
                font-weight: 500;
                color: #666666;
                margin-right: 8px;
                min-width: 100px;
            }
            
            .detail-label i {
                width: 18px;
                text-align: center;
                margin-right: 6px;
                color: #999999;
            }
            
            .voucher-code {
                background: #2d2d2d;
                color: #ffffff;
                padding: 4px 12px;
                border-radius: 4px;
                font-family: 'Courier New', monospace;
                font-weight: 600;
                letter-spacing: 1px;
            }
            
            .voucher-discount {
                color: #5a8c3a;
                font-weight: 600;
                font-size: 1.05rem;
            }
            
            .usage-count {
                color: #555555;
                font-weight: 500;
            }
            
            .promo-category-badge {
                background: #f0f9f0;
                color: #2d5016;
                padding: 4px 12px;
                border-radius: 4px;
                font-size: 0.85rem;
                border: 1px solid #d4e7d4;
            }
            
            .promo-category-badge i {
                margin-right: 6px;
            }
            
            .voucher-actions {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
            
            .btn-action {
                width: 100%;
                padding: 8px 16px;
                border: 1px solid #e0e0e0;
                border-radius: 4px;
                font-size: 0.9rem;
                font-weight: 500;
                transition: all 0.2s ease;
                cursor: pointer;
                text-align: left;
            }
            
            .btn-action i {
                margin-right: 6px;
                width: 16px;
                text-align: center;
            }
            
            .btn-action-edit {
                background: #ffffff;
                color: #5a8c3a;
                border-color: #5a8c3a;
            }
            
            .btn-action-edit:hover {
                background: #5a8c3a;
                color: #ffffff;
            }
            
            .btn-action-toggle {
                background: #ffffff;
                color: #7a7a7a;
                border-color: #d0d0d0;
            }
            
            .btn-action-toggle:hover {
                background: #f5f5f5;
                color: #555555;
            }
            
            .btn-action-delete {
                background: #ffffff;
                color: #999999;
                border-color: #e0e0e0;
            }
            
            .btn-action-delete:hover {
                background: #f5f5f5;
                color: #666666;
            }
            
            @media (max-width: 768px) {
                .voucher-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 10px;
                }
                
                .voucher-actions {
                    margin-top: 16px;
                }
            }
        </style>
        ";
    }
} else {
    echo "<div class='alert alert-info' style='background: #f0f9f0; border: 1px solid #d4e7d4; color: #2d5016; border-radius: 6px; padding: 16px;'>
            <i class='fas fa-info-circle'></i> No vouchers created yet. Click 'Create New Voucher' to get started!
          </div>";
}
?>