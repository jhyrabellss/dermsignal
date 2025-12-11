<?php require_once("../backend/config/config.php") ?>
<?php
    // database query to get the concern_name
    if (isset($_GET['ingredients_id'])) {
        $ingredients_id1 = intval($_GET['ingredients_id']); // Sanitize input
        $sql1 = "SELECT ingredient_name FROM tbl_ingredients WHERE ingredients_id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $ingredients_id1);
        $stmt1->execute();
        $stmt1->bind_result($ingredients_name);
        $stmt1->fetch();
        $stmt1->close();
    } else {
        $concern_name = "No concern provided";
    }
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
    <link rel="stylesheet" href="../jquery/jquery.js">
    <style>
     
    </style>
    <title><?= $ingredients_name?> Products </title>
</head>
<body>
<?php include "header.php" ?>

<div class="individual-prod-main-cont">
    <a href="./index.php">
        <div id="main-title">Home > <?= htmlspecialchars($ingredients_name) ?></div>
    </a>
      <h3 id="ingredient-title"><?= htmlspecialchars($ingredients_name) ?> Products</h3>
      <div class="selection-cont">
        <div class="sort-div">
          <form  method="GET" action="">
            <input type="hidden" name="ingredients_id" value="<?= isset($_GET['ingredients_id']) ? intval($_GET['ingredients_id']) : 1 ?>">
            <select class="sort-by" name="sort" id="sort" onchange="this.form.submit()"> 
              <option value="high" <?= isset($_GET['sort']) && $_GET['sort'] == 'high' ? 'selected' : '' ?>>High to Low</option>
              <option value="low" <?= isset($_GET['sort']) && $_GET['sort'] == 'low' ? 'selected' : '' ?>>Low to High</option>
            </select>
          </form>
        </div>
      </div>

      <div class="product-list-items-cont">
        <?php 
  $sort = isset($_GET['sort']) ? $_GET['sort'] : 'high';
  $order = $sort == 'low' ? 'ASC' : 'DESC';

  if (isset($_GET['ingredients_id'])) {
    $ingredients_id = intval($_GET['ingredients_id']);
  } else {
      die("Error: 'ingredients_id' is not provided in the URL.");
  }

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

  $sql = "SELECT tbl_products.*
  FROM tbl_products
  JOIN tbl_ingredients ON tbl_products.ingredients_id = tbl_ingredients.ingredients_id
  WHERE tbl_ingredients.ingredients_id = ? ORDER BY prod_price $order";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $ingredients_id);
  $stmt->execute();
  $result =  $stmt->get_result();
  
  if($result->num_rows){
    while($data = $result->fetch_assoc()){
      $origprice = $data['prod_price'];
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
                          $discprice = round(($discount_amount / $origprice) * 100, 0);
                      }
                      $voucher_applied = true;
                      break 2; // Exit both loops
                  }
              }
          }
      }
      
      // REMOVED THE PRODUCT-SPECIFIC DISCOUNT CHECK
      // Discounts now ONLY come from vouchers
      
      include "../components/reviews-ratings.php"
?>  
<div class="product-list-items">
    <div class="product-items" data-prod-id="<?= $data['prod_id']?>">
        <div class="img-con-click" data-item-id="<?= $data['prod_id']?>">
          <div class="prod-img-cont">
              <img src="../images/products/<?= $data['prod_img']; ?>" alt="img" >
              <img src="../images/products-hover/<?= $data['prod_hover_img']; ?>" class="hovered-image">
          </div>
        </div>
        <div class="details-cont">
            <div class="prod-name"><?= $data['prod_name']; ?></div>
            <div class="prod-description"><?= $data['prod-short-desc']; ?></div>
            <div class="prod-rating-cont">
                <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                    <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                </svg> 
                <div><?= $average_rating > 0 ? number_format($average_rating, 1) : 'No rating' ?></div>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                <div><?= $total_reviews?> reviews</div>                     
            </div>
            <div class="discount-cont">
                <div id="item-price">₱<?= number_format($prodprice, 2)?> </div>
                <?php if ($voucher_applied && $discprice > 0) { ?>
                    <div id="original-price">₱<?= number_format($origprice, 2)?> </div>
                    <div id="percentage-off"><?= number_format($discprice, 0)?>% off</div>
                <?php } ?>
            </div>
        </div>
        <button class="cart-button submit-cart">Add to Cart</button>
    </div>
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
 


<script src="../jquery/addtocart.js"></script>
<script>
    $(document).ready(function() {
        // Product click handler
        $('.img-con-click').click(function(e) {
            // Prevent the click from triggering when clicking the Add to Cart button
            if (!$(e.target).closest('.submit-cart').length) {
                var itemId = $(this).data("item-id");
                const url = `./components/individual-product.php?item=${itemId}`;
                window.location.href = url;
            }
        });
    });
</script>
</body>
</html>