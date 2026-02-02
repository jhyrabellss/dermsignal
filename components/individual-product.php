<?php require_once("../backend/config/config.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <title>Document</title>
  <link rel="stylesheet" href="../styles/footer.css">
  <link rel="stylesheet" href="../styles/cart.css">
  <link rel="stylesheet" href="../styles/individual-products.css">
  <link rel="stylesheet" href="../styles/slider.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <style>
    html {
      height: 100vh;
    }


    hr {
      margin-bottom: 10px;
      opacity: 0.2;
    }
  </style>
</head>

<body>

  <?php include "./header.php" ?>

  <?php
  // Get the product ID from the GET request
  $product_id = isset($_GET['item']) ? intval($_GET['item']) : 0;

  if ($product_id > 0) {
    // Get total reviews and average rating
    $query = "
        SELECT 
            COUNT(*) AS total_reviews, 
            COUNT(DISTINCT ac_id) AS total_rated_accounts,
            AVG(rating) AS average_rating,
            SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) AS rating_5,
            SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS rating_4,
            SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS rating_3,
            SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS rating_2,
            SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS rating_1
        FROM tbl_item_reviews
        WHERE prod_id = $product_id
    ";

    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
      // Use the values
      $total_reviews = $row['total_reviews'];
      $total_rated_accounts = $row['total_rated_accounts'];
      $average_rating = $row['average_rating'] ? round($row['average_rating'], 1) : 0;
      $rating_5 = $row['rating_5'];
      $rating_4 = $row['rating_4'];
      $rating_3 = $row['rating_3'];
      $rating_2 = $row['rating_2'];
      $rating_1 = $row['rating_1'];

      // Calculate percentages for the rating bars
      $total_ratings = $total_reviews > 0 ? $total_reviews : 1; // Prevent division by zero
      $rating_5_percent = $total_ratings > 0 ? ($rating_5 / $total_ratings) * 100 : 0;
      $rating_4_percent = $total_ratings > 0 ? ($rating_4 / $total_ratings) * 100 : 0;
      $rating_3_percent = $total_ratings > 0 ? ($rating_3 / $total_ratings) * 100 : 0;
      $rating_2_percent = $total_ratings > 0 ? ($rating_2 / $total_ratings) * 100 : 0;
      $rating_1_percent = $total_ratings > 0 ? ($rating_1 / $total_ratings) * 100 : 0;
    } else {
      // Default values if no reviews
      $total_reviews = 0;
      $total_rated_accounts = 0;
      $average_rating = 0;
      $rating_5 = $rating_4 = $rating_3 = $rating_2 = $rating_1 = 0;
      $rating_5_percent = $rating_4_percent = $rating_3_percent = $rating_2_percent = $rating_1_percent = 0;
    }
  } else {
    echo "Invalid Product ID.";
  }
  ?>



  <?php
$sql = "SELECT * FROM tbl_products WHERE prod_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["item"]);
$stmt->execute();
$result = $stmt->get_result();

$products = [];

while ($data = $result->fetch_assoc()) {
  $products[] = $data;
}

$product = $products[0];

// Calculate base price
$origprice = $product['prod_price'] + 100;
$prodprice = $origprice; // Default: no discount
$proddiscount = 0;
$discprice = 0;
$voucher_name = '';

// Check for active vouchers that include this product
$voucher_sql = "SELECT * FROM tbl_vouchers 
                WHERE is_active = 1 
                AND (voucher_type = 'product' OR voucher_type = 'both')
                AND CURDATE() BETWEEN start_date AND end_date
                ";
$voucher_result = mysqli_query($conn, $voucher_sql);

if ($voucher_result && mysqli_num_rows($voucher_result) > 0) {
    while ($voucher = mysqli_fetch_assoc($voucher_result)) {
        // Check if this product is in the target_items
        $target_items = json_decode($voucher['target_items'], true);
        if ($target_items) {
            foreach ($target_items as $item) {
                if ($item['type'] == 'product' && $item['id'] == $product['prod_id']) {
                    // Apply discount
                    $voucher_name = $voucher['voucher_name'];
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
                    break 2; // Exit both loops once discount is applied
                }
            }
        }
    }
}
?>
  <div class="individual-prod-main-cont">
    <div class="prod-details-main-cont">
      <div class="swiper-cont">
        <div class="image-cont swiper mySwiper2">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="../images/products/<?= $product['prod_img'] ?>" alt="">
            </div>
            <div class="swiper-slide">
              <img src="../images/products/<?= $product['prod_hover_img'] ?>" alt="">
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
        <div thumbsSlider="" class="swiper mySwiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <img src="../images/products/<?= $product['prod_img'] ?>" alt="">
            </div>
            <div class="swiper-slide">
              <img src="../images/products/<?= $product['prod_img'] ?>" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="info-cont">
      <div><?= $product['prod_name'] ?></div>
      <div><?= $product['prod-short-desc'] ?></div>
      <div><?= $product['prod_description'] ?></div>
      <div class="prod-rating-cont">
        <i class="fas fa-star" style="color: gold;"></i>
        <div><?= $average_rating > 0 ? $average_rating : 'No rating yet' ?></div>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16">
          <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
        </svg>
        <div><?= $total_reviews ?> reviews</div>
      </div>
      <div>Special Price</div>
      <div class="discount-cont">
        <div id="item-price">₱<?= number_format($prodprice, 2) ?></div>
        <?php if ($discprice > 0) { ?>
          <div id="original-price">₱<?= number_format($origprice, 2) ?></div>
          <div id="percentage-off"><?= number_format($discprice, 0) ?>% off</div>
          <?php if ($voucher_name) { ?>
            <div style="color: green; font-size: 12px;">🎉 <?= htmlspecialchars($voucher_name) ?></div>
          <?php } ?>
        <?php } ?>
      </div>
      <hr>
      <div class="prod-buttons">
        <div class="quantity-buttons" style="padding: 8px;">
          <button class="decrement-button"> - </button>
          <div class="count"> 1 </div>
          <button class="increment-button"> + </button>
        </div>
        <button class="cart-button submit-cart " data-prod-id="<?= $product['prod_id'] ?>">Add to Cart</button>
      </div>
      <!--<div class="product-info">
        <img src="../images/icons/icon-indiv-prod.png" alt="">
      </div>-->
    </div>
  </div>

  <div class="reviews-container">

    <div class="rating-title">
      <p>Ratings and Reviews ( <?= $total_rated_accounts + $total_reviews ?> ) </p>
      <div>
        <div><img src="https://images.thedermaco.com/static/verified.svg" alt=""></div>
        <p>Only Verified User</p>
      </div>
    </div>

    <div class="rating-main-cont">
      <div class="rating-cont">
        <div>
          <div class="star-rating">
            <div><?= $average_rating > 0 ? $average_rating : '0' ?></div>
            <div><svg class="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path>
              </svg>
            </div>
          </div>

          <div> <?= $total_rated_accounts ?> Ratings & <?= $total_reviews ?> Reviews</div>
        </div>
      </div>

      <div class="bar-rating-cont">
  <div class="bar-rating" id="5">
    <div>5</div>
    <div class="rating-bar">
      <div class="rating-bar-div" style="width: <?= $rating_5_percent ?>%; background-color: #4CAF50;"></div>
    </div>
    <div><svg class="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path>
      </svg></div>
  </div>
  <div class="bar-rating" id="4">
    <div>4</div>
    <div class="rating-bar">
      <div class="rating-bar-div" style="width: <?= $rating_4_percent ?>%; background-color: #8BC34A;"></div>
    </div>
    <div><svg class="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path>
      </svg></div>
  </div>
  <div class="bar-rating" id="3">
    <div>3</div>
    <div class="rating-bar">
      <div class="rating-bar-div" style="width: <?= $rating_3_percent ?>%; background-color: #FFC107;"></div>
    </div>
    <div><svg class="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path>
      </svg></div>
  </div>
  <div class="bar-rating" id="2">
    <div>2</div>
    <div class="rating-bar">
      <div class="rating-bar-div" style="width: <?= $rating_2_percent ?>%; background-color: #FF9800;"></div>
    </div>
    <div><svg class="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path>
      </svg></div>
  </div>
  <div class="bar-rating" id="1">
    <div>1</div>
    <div class="rating-bar">
      <div class="rating-bar-div" style="width: <?= $rating_1_percent ?>%; background-color: #F44336;"></div>
    </div>
    <div><svg class="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path>
      </svg></div>
  </div>
</div>

    </div>

    <hr>

    <div class="comments-main-cont">

      <?php
      $queryFd = "SELECT tf.*, 
        td.first_name, 
        td.last_name, 
        CONCAT(td.first_name, ' ', td.last_name) AS full_name 
        FROM tbl_item_reviews tf
        INNER JOIN tbl_account_details td ON tf.ac_id = td.ac_id
        WHERE tf.prod_id = ?";
      $stmtFd = $conn->prepare($queryFd);
      $stmtFd->bind_param("i", $_GET["item"]);
      $stmtFd->execute();
      $resultFd = $stmtFd->get_result();
      if ($resultFd->num_rows == 0) {
      }
      while ($row = $resultFd->fetch_assoc()) {
        $date = new DateTime($row["rv_date"]);
        $current_date =  $date->format(' d Y ');
        $month = $date->format(' F ')
      ?>
        <div class="comments-cont">
          <div class="name-initial"><?= strtoupper(substr($row['first_name'], 0, 1)) ?></div>
          <div>
            <div>
              <?= $row['first_name'] ?> | <?= $month, $current_date ?> </div>
            <div class="rated">
              <div> <svg class="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                  <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path>
                </svg></div>
              <div><?= $row['rating'] ?>.0</div>
            </div>
            <div class="commented"><?= $row['rv_comment'] ?></div>
          </div>
        </div>
      <?php } ?>
    </div>

    <?php
    if (!empty($_SESSION["user_id"])) {
      $current_user = $_SESSION['user_id'];

      // Prepare the SQL query
      $sql = "SELECT first_name FROM tbl_account_details WHERE ac_id = ?";
      $stmtCm = $conn->prepare($sql);

      // Bind the parameter to prevent SQL injection
      $stmtCm->bind_param("i", $current_user);

      // Execute the query
      $stmtCm->execute();
      $resultCm = $stmtCm->get_result();

      // Fetch the result
      if ($data = $resultCm->fetch_assoc()) {
        $name = $data['first_name'];
      }
      $stmtCm->close();
    ?>
      <div class="new-comment-main-cont">
        <div class="new-comment-cont">
          <div class="name-initial-custom"><?= strtoupper(substr($name, 0, 1)) ?></div>
          <form action="" method="POST">
            <div>
              <input class="custom-comment" id="review" name="review" type="text" placeholder="Write a comment...">
            </div>
          </form>
        </div>
      <?php } ?>

      <div class="comment-buttons">
        <button class="cancel-button">Cancel</button>
        <button class="write-comment-button" data-prod-id="<?php echo $_GET["item"] ?>">Comment</button>
      </div>

      <?php
      if (!empty($_SESSION['user_id'])) {
      ?>
        <div class="rating-box-cont">
          <div class="rating-box">
            <header>Rate the Product</header>
            <div class="stars">
              <i data-value="1" class="fa-solid fa-star"></i>
              <i data-value="2" class="fa-solid fa-star"></i>
              <i data-value="3" class="fa-solid fa-star"></i>
              <i data-value="4" class="fa-solid fa-star"></i>
              <i data-value="5" class="fa-solid fa-star"></i>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php
// Fetch 3 random related products (same concern)
$related_query = "SELECT * FROM tbl_products 
                  WHERE concern_id = (SELECT concern_id FROM tbl_products WHERE prod_id = ?) 
                  AND prod_id != ? 
                  ORDER BY RAND() 
                  LIMIT 4";
$stmt_related = $conn->prepare($related_query);
$stmt_related->bind_param("ii", $product_id, $product_id);
$stmt_related->execute();
$related_result = $stmt_related->get_result();
?>

<div class="related-products-section">
  <h2>You May Also Like</h2>
  <div class="product-list-items">
    <?php while($related = $related_result->fetch_assoc()) { 
      $rel_origprice = $related['prod_price'] + 100;
      $rel_prodprice = $rel_origprice;
      $rel_discprice = 0;
      
      // Check voucher for related product
      mysqli_data_seek($voucher_result, 0); // Reset pointer
      while ($voucher = mysqli_fetch_assoc($voucher_result)) {
          $target_items = json_decode($voucher['target_items'], true);
          if ($target_items) {
              foreach ($target_items as $item) {
                  if ($item['type'] == 'product' && $item['id'] == $related['prod_id']) {
                      if ($voucher['discount_type'] == 'percentage') {
                          $discount_amount = $rel_origprice * ($voucher['discount_value'] / 100);
                          if ($voucher['max_discount'] > 0 && $discount_amount > $voucher['max_discount']) {
                              $discount_amount = $voucher['max_discount'];
                          }
                          $rel_prodprice = $rel_origprice - $discount_amount;
                          $rel_discprice = $voucher['discount_value'];
                      } else {
                          $discount_amount = $voucher['discount_value'];
                          $rel_prodprice = max(0, $rel_origprice - $discount_amount);
                          $rel_discprice = ($discount_amount / $rel_origprice) * 100;
                      }
                      break 2;
                  }
              }
          }
      }
    ?>
    <a href="individual-product.php?item=<?= $related['prod_id'] ?>" class="product-items">
      <div class="prod-img-cont">
        <img src="../images/products/<?= $related['prod_img'] ?>" alt="<?= $related['prod_name'] ?>">
      </div>
      <div style="padding: 10px;">
        <div class="prod-name"><?= $related['prod_name'] ?></div>
        <div class="prod-description"><?= $related['prod-short-desc'] ?></div>
        <div class="discount-cont">
          <div style="font-weight: bold;">₱<?= number_format($rel_prodprice, 2) ?></div>
          <?php if ($rel_discprice > 0) { ?>
            <div style="text-decoration: line-through; color: gray;">₱<?= number_format($rel_origprice, 2) ?></div>
            <div style="color: red;"><?= number_format($rel_discprice, 0) ?>% off</div>
          <?php } ?>
        </div>
      </div>
    </a>
    <?php } ?>
  </div>
</div>
      </div>
  </div>


  <?php
  if ((!empty($_SESSION["user_id"]))) {
    include "cart.php";
  }
  include "footer.php"
  ?>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    function initializeSwiper() {
      var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
      });
      var swiper2 = new Swiper(".mySwiper2", {
        loop: true,
        spaceBetween: 10,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        thumbs: {
          swiper: swiper,
        },
      });
    }
  </script>
  <script>
    $(document).ready(function() {
      // Retrieve and display the saved count from localStorage on page load
      const savedCount = localStorage.getItem("count"); // Retrieve count from localStorage
      if (savedCount) {
        $(".count").text(savedCount); // Set the count to the saved value
      }

      // Decrement button click
      $(".decrement-button").click(function() {
        let currentCount = parseInt($(".count").text(), 10); // Get current count value
        if (currentCount > 1) { // Prevent going below 1
          currentCount -= 1; // Decrease the count
          $(".count").text(currentCount); // Update the count display
          localStorage.setItem("count", currentCount); // Save the updated count in localStorage
        }
      });

      // Increment button click
      $(".increment-button").click(function() {
        let currentCount = parseInt($(".count").text(), 10); // Get current count value
        currentCount += 1; // Increase the count
        $(".count").text(currentCount); // Update the count display
        localStorage.setItem("count", currentCount); // Save the updated count in localStorage
      });
    });
  </script>
  <script src="../scripts/individual-prod.js"></script>
  <script src="../jquery/addtocart-indiv-prod.js"></script>
  <script src="../jquery/submitReviews.js"></script>
</body>

</html>