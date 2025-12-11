<?php require_once("../backend/config/config.php") ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<link rel="stylesheet" href="../styles/general-styles.css">
<link rel="stylesheet" href="../styles/dropdown.css">
<link rel="stylesheet" href="../styles/login-signup-popup.css">
<link rel="stylesheet" href="../styles/profile-hover.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="nav-notification">Get Up to 15% Off Your Favorite Skincare Products – Limited Time Only!</div>
<nav>
        <div class="nav-logo">
            <a href="../index.php"><img src="../images/icons/logo-no-bg.png" alt=""></a>
        </div>
        <div class="nav-text-cont">
            <div class="nav-concern-cont">
                <div class="nav-concern">
                    Shop by Concern
                </div>
                <svg id="tabler-icon-chevron-down_1_" data-name="tabler-icon-chevron-down (1)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path id="Path_116046" data-name="Path 116046" d="M0,0H24V24H0Z" fill="none"></path><path id="Path_116047" data-name="Path 116047" d="M6,9l6,6,6-6" fill="none" stroke="#279989" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
             </div>
             <div class="concern-dropdown-cont">
                <div class="concern-dropdown">
                    <div class="buy-by-concern">
                        <h1>Shop By Concern</h1>
                        <a href="../components/concern-prod.php?concern_id=1">
                            <li >Acne</li>
                        </a>
                        <a href="../components/concern-prod.php?concern_id=2">
                            <li>Acne Scars</li>
                        </a>
                        <a href="../components/concern-prod.php?concern_id=3" >
                            <li>Open Pores</li>
                        </a>
                        <a href="../components/concern-prod.php?concern_id=4">
                            <li>Pigmentation</li>
                        </a>
                    </div> 
                    <div class="favorites-cont">
                        <h1>
                            Customer Favorites
                        </h1>
                        <div class="dropdown-prod-cont">
                            <?php 
                                $concern_id = isset($_GET['concern_id']) ? intval($_GET['concern_id']) : 0;
                                $sql = "SELECT tbl_products.*
                                FROM tbl_products
                                JOIN tbl_concern ON tbl_products.concern_id = tbl_concern.concern_id
                                WHERE tbl_concern.concern_id = 2";
                                $result = $conn->query($sql);
                                if($result->num_rows){
                                    while($data = $result->fetch_assoc()){
                            ?>  
                            <div class="dropdown-img-cont img-con-click"  data-item-id="<?= $data['prod_id']?>">
                                    <img src="../images/products/<?= $data['prod_img']?>" alt="">
                                    <p class="dropdown-img-detail">
                                        <?= $data['prod_name']?>
                                    </p>
                            </div>
                            <?php } }?>
                        </div>
                    </div>
                </div>
             </div>
           

            <div class="nav-ingredients-cont">
                <div class="nav-ingredients">
                    Shop by Ingredients
                </div>
                <svg id="tabler-icon-chevron-down_1_" data-name="tabler-icon-chevron-down (1)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path id="Path_116046" data-name="Path 116046" d="M0,0H24V24H0Z" fill="none"></path><path id="Path_116047" data-name="Path 116047" d="M6,9l6,6,6-6" fill="none" stroke="#279989" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
            </div>

            <div class="ingredient-dropdown-cont concern-dropdown-cont">
                <div class="ingredient-dropdown concern-dropdown">
                    <div class="buy-by-ingredient buy-by-concern">
                        <h1>Ingredients</h1>
                        <a href="../components/ingredient-products.php?ingredients_id=1">
                            <li class="specific-ingredient">Salicylic Acid</li>
                        </a>
                        <a href="../components/ingredient-products.php?ingredients_id=2">
                            <li class="specific-ingredient">Niacinamide</li>
                        </a>
                        <a href="../components/ingredient-products.php?ingredients_id=3">
                            <li class="specific-ingredient">Glycolic Acid</li>
                        </a>
                        <a href="../components/ingredient-products.php?ingredients_id=4">
                            <li class="specific-ingredient">Retinol</li>
                        </a>
                        <a href="../components/ingredient-products.php?ingredients_id=5">
                            <li class="specific-ingredient">Vitamin C</li>
                        </a>
            </div> 
                    <div class="favorites-cont">
                        <h1>
                            Customer Favorites
                        </h1>
                        <div class="dropdown-ingredient-cont dropdown-prod-cont">
                        <?php 
                                $sql = "SELECT tbl_products.*
                                FROM tbl_products
                                JOIN tbl_ingredients ON tbl_products.ingredients_id = tbl_ingredients.ingredients_id
                                WHERE tbl_ingredients.ingredients_id = 2";
                                $result = $conn->query($sql);
                                if($result->num_rows){
                                    while($data = $result->fetch_assoc()){
                        ?>  
                            <div class="dropdown-ingredient-img-cont dropdown-img-cont img-con-click" data-item-id="<?= $data['prod_id']?>">
                                <img src="../images/products/<?= $data['prod_img']?>" alt="">
                                <p class="dropdown-img-detail">
                                    <?= $data['prod_name']?>
                                </p>
                            </div>
                        <?php } } ?>
                        </div>
                    </div>
                </div>
             </div>
            
             
            <div class="nav-allprod-cont">
                <a href="./all-products.php">All Product</a>
            </div>
            <a href="../components/assessment.php">
            <div class="nav-free-skin-assessment-cont">
                <svg id="tabler-icon-clipboard-check" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path id="Path_116054" data-name="Path 116054" d="M0,0H24V24H0Z" fill="none"></path><path id="Path_116055" data-name="Path 116055" d="M9,5H7A2,2,0,0,0,5,7V19a2,2,0,0,0,2,2H17a2,2,0,0,0,2-2V7a2,2,0,0,0-2-2H15" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><rect id="Rectangle_7428" data-name="Rectangle 7428" width="6" height="4" rx="2" transform="translate(9 3)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></rect><path id="Path_116056" data-name="Path 116056" d="M9,14l2,2,4-4" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                <div class="nav-free-skin-assessment">
                    Free Skin Assesment
                </div>
            </div>
            </a>
        </div>
        <div class="nav-right-icon" style="display:flex; gap: 20px;  ">
            <?php if(!empty($_SESSION["user_id"])){ 
                $query = "SELECT COUNT(*) AS CountItems FROM tbl_cart WHERE status_id = 1 and account_id = ?;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
            ?>
                
                <div class="nav-cart-icon">
                    <i class="fas fa-shopping-cart"  style="color: rgb(39,153,137); cursor:pointer "></i>
                    <span class="cart-counter"> <?= $data['CountItems']?> </span>
                </div>
            
            <?php } ?>
         
            <div class="nav-login-account-icon">
                <?php if(!empty($_SESSION["user_id"])){ ?>
                    <div style="display: flex; gap: 10px; align-items:center;">
                        <i class="fa-regular fa-user" style="color: gray;"></i>
                        <div class="dropdown" id="dropdownMenu">
                            <a href="../components/profile.php"><div>Profile</div></a>
                            <a href="../components/orders.php"><div>Orders</div></a>
                            <div id="logoutButton"> Log Out</div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div onclick="openForm('myFormSignUp')">Sign up </div>
                <?php } ?>
            </div>
        </div>
    </nav>


<script src="../scripts/log-in-sign-up.js"></script>
<script src="../scripts/header.js"></script>

<script>
    $('.img-con-click').click(function() {
        var itemId = $(this).data("item-id");
        const url = `../components/individual-product.php?item=${itemId}`;
        window.location.href = url;
    });
</script>