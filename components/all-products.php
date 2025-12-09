<?php require_once("../backend/config/config.php") ?>
<?php
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'high'; // Default to 'high' if sort is not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/slider.css">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/prod-ingredients.css">
    <link rel="stylesheet" href="../styles/voucher-banner.css">
    <link rel="stylesheet" href="../styles/product-lists.css">
    <style>
     
    </style>
    <title>All Product</title>
</head>
<body>
  
<?php include "./header.php" ?>

<?php include "./slideshow.php" ?>

<div class="individual-prod-main-cont">
    <a href="../index.php">
        <div id="main-title">Home/Shop</div>
    </a>
      <div class="category-cont">
      <?php
          $current_concern_id = isset($_GET['concern_id']) ? intval($_GET['concern_id']) : 0; // Get current concern_id
          $sort = isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'high'; // Get sort value

          // Category buttons
          $categories = [
              ['id' => 0, 'name' => 'All'],
              ['id' => 1, 'name' => 'Acne'],
              ['id' => 2, 'name' => 'Acne Scars'],
              ['id' => 3, 'name' => 'Open Pores'],
              ['id' => 4, 'name' => 'Pigmentation']
          ];

          foreach ($categories as $category) {
              // Add "background-active" class if this category is active
              $active_class = $category['id'] == $current_concern_id ? 'background-active' : '';
              echo "<a href=\"?concern_id={$category['id']}&sort=$sort\">
                      <div class=\"category-button $active_class\">{$category['name']}</div>
                    </a>";
          }
          ?>
          
            <form  method="GET" action="">
              <input type="hidden" name="concern_id" value="<?= isset($_GET['concern_id']) ? intval($_GET['concern_id']) : 0 ?>">
              <select class="sort-by" name="sort" id="sort" onchange="this.form.submit()"> 
                <option value="high" <?= isset($_GET['sort']) && $_GET['sort'] == 'high' ? 'selected' : '' ?>>High to Low</option>
                <option value="low" <?= isset($_GET['sort']) && $_GET['sort'] == 'low' ? 'selected' : '' ?>>Low to High</option>
              </select>
            </form>
        </div>

      <div class="product-list-items-cont">
        <?php 
         $order = $sort == 'low' ? 'ASC' : 'DESC';
         $category_id = isset($_GET['concern_id']) ? intval($_GET['concern_id']) : 0;
         // Prepare SQL query
         if ($category_id > 0) {
             // Fetch products for the specific category
             $sql = "SELECT tbl_products.*
             FROM tbl_products
             JOIN tbl_concern ON tbl_products.concern_id = tbl_concern.concern_id
             WHERE tbl_concern.concern_id = ? ORDER BY prod_price $order";
             $stmt = $conn->prepare($sql);
             $stmt->bind_param("i", $category_id);
         } else {
             // Fetch all products
             $sql = "SELECT * FROM tbl_products ORDER by prod_price $order";
             $stmt = $conn->prepare($sql);
         }

         $stmt->execute();
          $result = $stmt->get_result();

          // Fetch all active vouchers once
          $voucher_sql = "SELECT * FROM tbl_vouchers 
                          WHERE is_active = 1 
                          AND (voucher_type = 'product' OR voucher_type = 'both')
                          AND CURDATE() BETWEEN start_date AND end_date";
          $voucher_result = mysqli_query($conn, $voucher_sql);

          // Store vouchers in an array for reuse
          $active_vouchers = [];
          if ($voucher_result && mysqli_num_rows($voucher_result) > 0) {
              while ($voucher = mysqli_fetch_assoc($voucher_result)) {
                  $active_vouchers[] = $voucher;
              }
          }

          if($result->num_rows){
              while($data = $result->fetch_assoc()){
                  $origprice = $data['prod_price'] + 100;
                  $prodprice = $origprice; // Default: no discount
                  $discprice = 0;
                  $voucher_applied = false;

                  // Check if product is eligible for any voucher
                  foreach ($active_vouchers as $voucher) {
                      $target_items = json_decode($voucher['target_items'], true);
                      if ($target_items) {
                          foreach ($target_items as $item) {
                              if ($item['type'] == 'product' && $item['id'] == $data['prod_id']) {
                                  // Apply discount
                                  if ($voucher['discount_type'] == 'percentage') {
                                      $discount_amount = $origprice * ($voucher['discount_value'] / 100);
                                      // Check max_discount limit
                                      if ($voucher['max_discount'] > 0 && $discount_amount > $voucher['max_discount']) {
                                          $discount_amount = $voucher['max_discount'];
                                      }
                                      $prodprice = $origprice - $discount_amount;
                                      $discprice = $voucher['discount_value'];
                                  } else {
                                      // Fixed discount
                                      $discount_amount = $voucher['discount_value'];
                                      $prodprice = max(0, $origprice - $discount_amount);
                                      $discprice = ($discount_amount / $origprice) * 100;
                                  }
                                  $voucher_applied = true;
                                  break 2; // Exit both loops
                              }
                          }
                      }
                  }
                  
                  include "../components/reviews-ratings.php"
          ?>
        <div class="product-items" data-prod-id="<?= $data['prod_id']?>">
            <div class="prod-img-cont img-con-click" data-item-id="<?= $data['prod_id']?>">
                <?php
                if (file_exists('../images/products/' . $data["prod_img"]) == false || $data["prod_img"] == NULL) {
                    echo '<div class="no-image-placeholder" style="color: rgb(77, 77, 77);">No Image Available</div>';
                } else {
                    echo '<img src="../images/products/' . $data["prod_img"] . '" >';
                    echo '<img src="../images/products-hover/' . $data["prod_hover_img"] . '" class="hovered-image">';
                }
                ?>
            </div>
            <div class="details-cont">
                <div class="prod-name"><?php echo $data['prod_name']; ?></div>
                <div class="prod-description"><?php echo $data['prod-short-desc']; ?></div>
                <div class="prod-rating-cont">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                    </svg>
                    <div><?= $average_rating > 0 ? number_format($average_rating, 1) : 'No rating' ?></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16">
                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"/>
                    </svg>
                    <div><?= $total_reviews ?> reviews</div>
                </div>
                <div class="discount-cont">
                    <div id="item-price">₱<?php echo number_format($prodprice, 2) ?></div>
                    <?php if ($voucher_applied) { ?>
                        <div id="original-price">₱<?php echo number_format($origprice, 2) ?></div>
                        <div id="percentage-off"><?php echo number_format($discprice, 0) ?>%</div>
                    <?php } ?>
                </div>
            </div>
            <button class="cart-button submit-cart">Add to Cart</button>
        </div>
          <?php } } ?>

        <div class="image-assessment"></div>
      </div> 
      
  </div>

  <?php
  if((!empty($_SESSION["user_id"]))) {
    include "cart.php";
  }
    include "footer.php"
  ?>
  
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<!--<script>
  $(document).ready(function() {
    // Function to load products based on selected category and sort
    function loadProducts(categoryId, sort) {
      $.ajax({
        url: 'yourpage.php', // PHP file that handles the AJAX request
        type: 'GET',
        data: {
          concern_id: categoryId,
          sort: sort
        },
        success: function(response) {
          $('#product-list').html(response); // Update the product list
        }
      });
    }

    // When a category button is clicked
    $('.category-button').click(function() {
      var categoryId = $(this).data('concern-id');
      var sort = $('#sort').val(); // Get the selected sort value
      loadProducts(categoryId, sort); // Load products via AJAX
    });

    // When the sort dropdown is changed
    $('#sort').change(function() {
      var sort = $(this).val();
      var categoryId = $('.category-button.active').data('concern-id') || 0; // Get the active category
      loadProducts(categoryId, sort); // Load products via AJAX
    });

    // Optionally, highlight the active category button
    $('.category-button').click(function() {
      $('.category-button').removeClass('active');
      $(this).addClass('active');
    });
  });
</script>-->

<script src="/scripts/product-lists.js"></script>
<script src="../jquery/addtocart.js"></script>
<script>
    $('.img-con-click').click(function() {
        var itemId = $(this).data("item-id");
        const url = `../components/individual-product.php?item=${itemId}`;
        window.location.href = url;
    });
</script>
</body>
</html>