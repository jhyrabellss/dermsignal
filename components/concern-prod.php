<?php require_once("../backend/config/config.php") ?>
<?php
    // database query to get the concern_name
    if (isset($_GET['concern_id'])) {
        $concern_id1 = intval($_GET['concern_id']); // Sanitize input
        $sql1 = "SELECT concern_name FROM tbl_concern WHERE concern_id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $concern_id1);
        $stmt1->execute();
        $stmt1->bind_result($concern_name);
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
    <script src="../scripts/jquery.js"></script>
    <style>
     
    </style>
    <title><?=$concern_name ?> Product</title>
</head>
<body>
<?php include "../components/header.php" ?>



<div class="individual-prod-main-cont">
    <a href="../index.html">
        <div id="main-title">Home > <?= htmlspecialchars($concern_name) ?> </div>
    </a>
      <h3 id="ingredient-title"> <?= htmlspecialchars($concern_name) ?> Products</h3>
      <div class="selection-cont">
        <div class="sort-div">
        <div class="ingredients">Ingredients</div>
        <form method="GET" action="">
      <?php if (isset($_GET['ingredients_id']) && !empty($_GET['ingredients_id'])): ?>
        <input type="hidden" name="ingredients_id" value="<?= intval($_GET['ingredients_id']) ?>">
      <?php endif; ?>
     <input type="hidden" name="concern_id" value="<?= isset($_GET['concern_id']) ? intval($_GET['concern_id']) : 1 ?>">
     <select class="sort-by" name="sort" id="sort" onchange="this.form.submit()">
        <option value="high" <?= isset($_GET['sort']) && $_GET['sort'] == 'high' ? 'selected' : '' ?>>High to Low</option>
        <option value="low" <?= isset($_GET['sort']) && $_GET['sort'] == 'low' ? 'selected' : '' ?>>Low to High</option>
     </select>
   </form>
        </div>
        <div class="ingredient-cont">
            <div class="ingredient-type" onclick="filterProducts(1)">Glycolic Acid</div>
            <div class="ingredient-type" onclick="filterProducts(2)">Salicylic Acid</div>
            <div class="ingredient-type" onclick="filterProducts(3)">Vitamin C</div>
            <div class="ingredient-type" onclick="filterProducts(4)">Niacinamide</div>
            <div class="ingredient-type" onclick="filterProducts(5)">Retinol</div>
        </div>
      </div>
      
      <div class="product-list-items-cont">
        <?php 
          $sort = isset($_GET['sort']) ? $_GET['sort'] : 'high';
          $order = $sort == 'low' ? 'ASC' : 'DESC';

          if (isset($_GET['concern_id'])) {
            $concern_id = isset($_GET['concern_id']) ? intval($_GET['concern_id']) : 1;
          } else {
              die("Error: 'concern_id' is not provided in the URL.");
          }

          if (isset($_GET['ingredients_id'])) {
            $ingredients_id = intval($_GET['ingredients_id']);
            $ingredients_filter = "AND tbl_products.ingredients_id = ?";
          } else {
              $ingredients_filter = ''; // No filter for ingredients if not set
          }


          $sql = "SELECT tbl_products.*
          FROM tbl_products
          JOIN tbl_concern ON tbl_products.concern_id = tbl_concern.concern_id
          WHERE tbl_concern.concern_id = ? $ingredients_filter ORDER BY prod_price $order";


          $stmt = $conn->prepare($sql);
           if ($ingredients_filter) {
          $stmt->bind_param("ii", $concern_id, $ingredients_id);
          } else {
              $stmt->bind_param("i", $concern_id);
          }

          $stmt->execute();
          $result =  $stmt->get_result();
          if($result->num_rows){
            while($data = $result->fetch_assoc()){
            $origprice = $data['prod_price'] + 100; // Adjusted original price
            $proddiscount = $data['prod_discount'] / 100;
            $prodprice = $origprice - ($origprice * $proddiscount); // Calculate discounted price
            $discprice = $data['prod_discount']; // Convert to percentage for display  
            include "../components/reviews-ratings.php"
        ?>  
        <div class="product-list-items" data-prod-id="<?= $data['prod_id']?>">
            <div class="product-items>">
            <div>
              <div class="prod-img-cont  img-con-click" data-item-id="<?= $data['prod_id']?> ">
                  <img src="../images/products/<?= $data['prod_img']; ?>" alt="img" >
                  <img src="./images/products-hover/<?php echo $data['prod_hover_img']; ?>" class="hovered-image">
              </div>
              <div class="details-cont">
                  <div class="prod-name"><?= $data['prod_name']; ?></div>
                  <div class="prod-description"><?=$data['prod-short-desc']; ?></div>
                  <div class="prod-rating-cont">
                      <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                          <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                      </svg> 
                      <div>4.8</div>
                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                      <div><?= $total_reviews?> reviews</div>                     
                  </div>
                  <div class="discount-cont">
                      <div id="item-price">₱<?= $prodprice?> </div>
                      <div id="original-price">₱<?= $origprice?> </div>
                      <div id="percentage-off"><?= $discprice?>% off</div>
                  </div>
              </div>
              <button class="cart-button submit-cart">Add to Cart</button>
            </div>
            </div>
        </div>
          <?php } }else{?>
            <div style="font-size: 20px;">No products available!</div>
          <?php }?>

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
<script src="../scripts/concern.js"></script>
<script>
  function filterProducts(ingredientsId) {
    const concernId = <?= $concern_id ?>; // This is your concern_id that is already set
    // Update the URL with the selected ingredient and concern_id
    window.location.href = `?concern_id=${concernId}&ingredients_id=${ingredientsId}&sort=high`; // Add any other parameters you need
}
</script>
<script>
    $('.img-con-click').click(function() {
      var itemId = $(this).data("item-id"); // Correct way to get the data-item-id attribute
      const url = `../components/individual-product.php?item=${itemId}`;
      window.location.href = url;
    });

</script>
</body>
</html>