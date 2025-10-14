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
    html{
      height: 100vh;
    }


    hr{
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
    $query = "
        SELECT 
            COUNT(*) AS total_reviews, 
            COUNT(DISTINCT ac_id) AS total_rated_accounts
        FROM tbl_item_reviews
        WHERE prod_id = $product_id
    ";

    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Use the values
        $total_reviews = $row['total_reviews'];
        $total_rated_accounts = $row['total_rated_accounts'];
    } else {
        echo "No reviews found for this product.";
    }
} else {
    echo "Invalid Product ID.";
}
?>



<?php
$sql = "SELECT * FROM tbl_products WHERE prod_id = ?"; 
$stmt = $conn->prepare($sql); // Fixed variable name from $query to $sql
$stmt->bind_param("i", $_GET["item"]);
$stmt->execute();
$result = $stmt->get_result();

$products = [];

while ($data = $result->fetch_assoc()) {
    $products[] = $data;
}

// Assuming there's only one product, we'll take the first one from the array
    $product = $products[0];

// Calculate prices outside the loop
    $origprice = $product['prod_price'] + 100; // Adjusted original price
    $proddiscount = $product['prod_discount'] / 100;
    $prodprice = $origprice - ($origprice * $proddiscount); // Calculate discounted price
    $discprice = $product['prod_discount']; // Convert to percentage for display
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
            <div>4.8</div>
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
            <div><?= $total_reviews?> reviews</div>                     
          </div>
          <div>Special Price</div>  
          <div class="discount-cont">
              <div id="item-price">₱<?= number_format($prodprice,2) ?></div>
              <div id="original-price"><?= number_format($origprice,2) ?> </div>
              <div id="percentage-off"><?= $product['prod_discount'] ?>% off</div>
          </div>
          <hr>
          <div class="prod-buttons">
          <div class="quantity-buttons" style="padding: 8px;">
            <button class="decrement-button" > - </button>
            <div class="count"> 1 </div> 
            <button class="increment-button"> + </button>
          </div>
          <button class="cart-button submit-cart " data-prod-id="<?= $product['prod_id']?>" >Add to Cart</button>
          </div>
          <div class="product-info">
            <img src="../images/icons/icon-indiv-prod.png" alt="">
          </div>
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
          <div>4.9</div>
          <div><svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
            <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg>
        </div>
        </div>

        <div> <?= $total_rated_accounts ?> Ratings & <?= $total_reviews?> Reviews</div>
        </div></div>

    <div class="bar-rating-cont">
      <div class="bar-rating" id="5">
        <div>5</div>
        <div class="rating-bar rating-bar-5">
          <div class="rating-bar-div"></div>
        </div>
        <div><svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
          <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg></div>
      </div>
      <div class="bar-rating" id="4">
        <div>4</div>
        <div class="rating-bar rating-bar-4">
          <div class="rating-bar-div"></div>
        </div>
        <div><svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
          <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg></div>
      </div>
      <div class="bar-rating" id="3">
        <div>3</div>
        <div class="rating-bar rating-bar-3">
          <div class="rating-bar-div"></div>
        </div>
        <div><svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
          <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg></div>
      </div>
      <div class="bar-rating" id="2">
        <div>2</div>
        <div class="rating-bar rating-bar-2">
          <div class="rating-bar-div"></div>
        </div>
        <div><svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
          <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg></div>
      </div>
      <div class="bar-rating" id="1">
        <div>1</div>
        <div class="rating-bar rating-bar-1">
          <div class="rating-bar-div"></div>
        </div>
        <div><svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
          <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg></div>
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
        if($resultFd->num_rows == 0){
        }
        while($row = $resultFd->fetch_assoc()){
            $date = new DateTime($row["rv_date"]);
            $current_date =  $date->format(' d Y ');
            $month = $date->format(' F ')
      ?>
      <div class="comments-cont">
          <div class="name-initial"><?= strtoupper(substr($row['first_name'],0,1)) ?></div>
          <div>
            <div>
              <?= $row['first_name'] ?> | <?= $month, $current_date ?> </div>
              <div class="rated">
                <div> <svg class ="rating-icon" xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                  <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"></path></svg></div>
                  <div><?= $row['rating'] ?>.0</div>
              </div> 
            <div class="commented"><?= $row['rv_comment']?></div>
          </div>
      </div> 
      <?php }?>
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
        <div class="name-initial-custom"><?= strtoupper(substr($name,0,1)) ?></div>
        <form action="" method="POST">
            <div>
                <input class="custom-comment" id="review" name="review" type="text" placeholder="Write a comment...">
            </div>
        </form>
    </div>
<?php }?>

    <div class="comment-buttons">
      <button class="cancel-button">Cancel</button>
      <button class="write-comment-button" data-prod-id="<?php echo $_GET["item"] ?>">Comment</button>
    </div>

    <?php 
     if (!empty($_SESSION['user_id'])){
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
    <?php }?>
  </div>
</div>


<?php
  if((!empty($_SESSION["user_id"]))) {
    include "cart.php";
  }
    include "footer.php"
?>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
function initializeSwiper(){
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
    const savedCount = localStorage.getItem("count");  // Retrieve count from localStorage
    if (savedCount) {
        $(".count").text(savedCount);  // Set the count to the saved value
    }

    // Decrement button click
    $(".decrement-button").click(function() {
        let currentCount = parseInt($(".count").text(), 10);  // Get current count value
        if (currentCount > 1) {  // Prevent going below 1
            currentCount -= 1;  // Decrease the count
            $(".count").text(currentCount);  // Update the count display
            localStorage.setItem("count", currentCount);  // Save the updated count in localStorage
        }
    });

    // Increment button click
    $(".increment-button").click(function() {
        let currentCount = parseInt($(".count").text(), 10);  // Get current count value
        currentCount += 1;  // Increase the count
        $(".count").text(currentCount);  // Update the count display
        localStorage.setItem("count", currentCount);  // Save the updated count in localStorage
    });
});

</script>
<script src="../scripts/individual-prod.js"></script>
<script src="../jquery/addtocart-indiv-prod.js"></script>
<script src="../jquery/submitReviews.js"></script>
</body>
</html>