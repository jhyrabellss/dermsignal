<?php require_once("./backend/config/config.php") ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="./styles/slider.css">
    <link rel="stylesheet" href="./styles/general-styles.css">
    <link rel="stylesheet" href="./styles/dropdown.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <link rel="stylesheet" href="./styles/login-signup-popup.css">
    <link rel="stylesheet" href="./styles/profile-hover.css">
    <link rel="stylesheet" href="./styles/cart.css">
    <link rel="stylesheet" href="./styles/slideshow.css">
    <link rel="stylesheet" href="./styles/shop-by-concern.css">
    <link rel="stylesheet" href="./styles/reviews.css">
    <link rel="stylesheet" href="./styles/blog.css">
    <script src="./jquery/jquery.js"></script>
    <script src="./scripts/sweetalert.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>DermSignal</title>
</head>
<body>
<div class="nav-notification">Get Up to 15% Off Your Favorite Skincare Products – Limited Time Only!</div>
 <nav>
        <div class="nav-logo">
            <a href="./index.php"><img src="./images/icons/logo-no-bg.png" alt=""></a>
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
                        <a href="./components/concern-prod.php?concern_id=1">
                            <li >Acne</li>
                        </a>
                        <a href="./components/concern-prod.php?concern_id=2">
                            <li>Acne Scars</li>
                        </a>
                        <a href="./components/concern-prod.php?concern_id=3" >
                            <li>Open Pores</li>
                        </a>
                        <a href="./components/concern-prod.php?concern_id=4">
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
                            <div class="dropdown-img-cont img-con-click" data-item-id="<?= $data['prod_id']?>" >
                                    <img src="./images/products/<?= $data['prod_img']?>" alt="">
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
                        <a href="./components/ingredient-products.php?ingredients_id=1">
                            <li class="specific-ingredient">Salicylic Acid</li>
                        </a>
                        <a href="./components/ingredient-products.php?ingredients_id=2">
                            <li class="specific-ingredient">Niacinamide</li>
                        </a>
                        <a href="./components/ingredient-products.php?ingredients_id=3">
                            <li class="specific-ingredient">Glycolic Acid</li>
                        </a>
                        <a href="./components/ingredient-products.php?ingredients_id=4">
                            <li class="specific-ingredient">Retinol</li>
                        </a>
                        <a href="./components/ingredient-products.php?ingredients_id=5">
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
                                <img src="./images/products/<?= $data['prod_img']?>" alt="">
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
                <a href="./components/all-products.php">All Product</a>
            </div>
            <a href="./components/assessment.php">
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
                        <i class="fa-regular fa-user"></i>
                        <div class="dropdown" id="dropdownMenu">
                            <a href="../components/profile.php"><div>Profile</div></a>
                            <a href="../components/orders.php"><div>Orders</div></a>
                            <div id="logoutButton"> Log Out</div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div onclick="openForm('myFormSignUp')" style="cursor: pointer;">Sign up </div>
                <?php } ?>
            </div>
        </div>
    </nav>

                <div class="slideshow-div">

                <div class="slideshow-container">

                <div class="mySlides fade">
                <img src="./images/banner/banner-1.png" style="width:100%">
                <a href="./components/about.php"><button class="btn1">About Us</button></a>
                </div>
                <div class="mySlides fade">
                <img src="./images/banner/banner-2.png" style="width:100%">
                <a href="./components/all-products.php"><button class="btn2">Shop Now</button></a>
                </div>
                <div class="mySlides fade">
                <img src="./images/banner/banner-3.png" style="width:100%">
                <a href="./components/all-products.php"><button class="btn3">Shop Now</button></a>
                </div>


                    <!-- Next and previous buttons -->
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <br>
                
                <!-- The dots/circles -->
                <div class="dots" style="text-align:center"  >
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    
                </div>
                </div>  


    <div class="main-cont" id="main-cont">
    <div class="form-popup" id="myFormLogIn">
            <form class="form-container" action="./backend/user/login.php"  method="POST">
                <div class="close-popup-cont">
                    <div class="close-popup" onclick="closeForm('myFormLogIn')">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="15px" width="15px" version="1.1" id="Capa_1" viewBox="0 0 460.775 460.775" xml:space="preserve">
                        <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55  c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55  c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505  c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55  l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719  c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
                    </svg>
                    </div>
                </div>
                <div class="log-in-text">
                    <h1>
                        Log In
                    </h1>
                </div>
                <div> <input type="text" placeholder="Username" name="username" id="uname" required></div>
                <div><input type="password" placeholder="Password" name="password" id="pass" required></div>
                <div class="log-in-btn" ><button type="submit" id="submit">Log in</button></div>
                <div class="acc-status" >Dont Have an Account Yet? <span onclick="openForm('myFormSignUp')">Sign up</span> </div>
            </form>
    </div>
    <div class="form-popup" id="myFormSignUp">
                    <form class="form-container" action="./backend/user/signup.php"  method="POST">
                        <div class="close-popup-cont">
                            <div class="close-popup" onclick="closeForm('myFormSignUp')">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="10px" width="10px" version="1.1" id="Capa_1" viewBox="0 0 460.775 460.775" xml:space="preserve">
                                <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55  c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55  c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505  c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55  l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719  c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
                            </svg>
                            </div>
                        </div>
                        <div class="log-in-text">
                            <h1>
                                Sign Up
                            </h1>
                        </div>
                        <div><input type="text" placeholder="First Name" name="fname" id="fname" required></div>
                        <div><input type="text" placeholder="Middle Name" name="mname" id="mname" required></div>
                        <div><input type="text" placeholder="Last Name" name="lname" id="lname" required></div>
                        <div><input type="text" placeholder="Username" name="username" id="username" required></div>
                        <div><input type="email" placeholder="Email" name="email" id="email" required></div>
                        <div><input type="password" placeholder="Password" name="password" id="password"  required></div>
                        <div><input type="password" placeholder="Confirm Password" name="password" id="confirmPass"  style="margin-top: 10px;"></div>
                        <div class="log-in-btn" ><button type="submit" class="button">Sign up</button></div>
                        <div class="acc-status" >Already have an account? <span onclick="openForm('myFormLogIn')">Log in</span> </div>
                    </form>
    </div>
    </div>

    <div class="shop-by-concern">
        <h1>Shop By Concern</h1>
        <div class="concern-main-cont">
            <div class="concern">
                <a href="./components/concern-prod.php?concern_id=1">
                <div class = "concern-cont" id="Acne" onclick="concernHTMLIndex('Acne/Pimple')">
                    <div class="img-cont">
                    <img src="./images/skin-type/acne.jpg" alt="">
                    </div>
                    <div class="name-arrow">
                        <p>Acne</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" stroke="#279989" viewBox="0 0 19 20.243"><defs><style>.right-arrow{fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px;}</style></defs><g transform="translate(25 -5.379) rotate(90)"><path class="right-arrow" d="M18,23.5V7.5" transform="translate(-2.5)"></path><path class="right-arrow" d="M7.5,15.5l8-8,8,8" transform="translate(0 0)"></path></g></svg>
                    </div>
                </div>
                </a>
                <a href="./components/concern-prod.php?concern_id=2">
                <div class = "concern-cont" id="Acne Scar" onclick="concernHTMLIndex('Acne Scars')">
                    <div class="img-cont">
                        <img src="./images/skin-type/acne-scars.webp">
                    </div>
                    <div class="name-arrow">
                        <p>Acne Scars</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" stroke="#279989" viewBox="0 0 19 20.243"><defs><style>.right-arrow{fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px;}</style></defs><g transform="translate(25 -5.379) rotate(90)"><path class="right-arrow" d="M18,23.5V7.5" transform="translate(-2.5)"></path><path class="right-arrow" d="M7.5,15.5l8-8,8,8" transform="translate(0 0)"></path></g></svg>
                    </div>
                </div>
                </a>
                <a href="./components/concern-prod.php?concern_id=3">
                <div class = "concern-cont" id ="Open Pores"  onclick="concernHTMLIndex('Open Pores')">
                    <div class="img-cont">
                        <img src="./images/skin-type/open-pores.webp" alt="">
                    </div>
                    <div class="name-arrow">
                        <p>Open Pores</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" stroke="#279989" viewBox="0 0 19 20.243"><defs><style>.right-arrow{fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px;}</style></defs><g transform="translate(25 -5.379) rotate(90)"><path class="right-arrow" d="M18,23.5V7.5" transform="translate(-2.5)"></path><path class="right-arrow" d="M7.5,15.5l8-8,8,8" transform="translate(0 0)"></path></g></svg>
                    </div>
                </div>
                </a>
                <a href="./components/concern-prod.php?concern_id=4">
                <div class = "concern-cont" id ="Pigmentation" onclick="concernHTMLIndex('Pigmentation')">
                    <div class="img-cont">
                        <img src="./images/skin-type/pigmentation.jpeg" alt="">
                    </div>
                    <div class="name-arrow">
                        <p>Pigmentation</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" stroke="#279989" viewBox="0 0 19 20.243"><defs><style>.right-arrow{fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px;}</style></defs><g transform="translate(25 -5.379) rotate(90)"><path class="right-arrow" d="M18,23.5V7.5" transform="translate(-2.5)"></path><path class="right-arrow" d="M7.5,15.5l8-8,8,8" transform="translate(0 0)"></path></g></svg>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>

        <div class="products-cont swiper">
            <div class="wrapper">
                <div class="product-list-items swiper-wrapper">
                <?php
                    $sql = "SELECT * FROM tbl_prod_bestseller";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($data = $result->fetch_assoc()) {
                            $origprice = $data['prod_price'] + 100; // Adjusted original price
                            $proddiscount = $data['prod_discount'] / 100;
                            $prodprice = $origprice - ($origprice * $proddiscount); // Calculate discounted price
                            $discprice = $data['prod_discount']; // Convert to percentage for display
                            include "./components/reviews-ratings.php"
                            
                    ?>
                            <div class="product-items swiper-slide"  data-prod-id="<?= $data['prod_id']?>" >
                        <div class="prod-img-cont img-con-click" data-item-id="<?= $data['prod_id']?>">
                            <img src="./images/products/<?php echo $data['prod_img']; ?>" >
                            <img src="./images/products-hover/<?php echo $data['prod_hover_img']; ?>" class="hovered-image">
                            <div class="product-status">Best Seller</div>
                        </div>
                        <div class="details-cont">
                            <div class="prod-name"><?php echo $data['prod_name']; ?></div>
                            <div class="prod-description"><?php echo $data['prod-short-desc']; ?></div>
                            <div class="prod-rating-cont">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                    <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                                </svg> 
                                <div>4.8</div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                                <div><?= $total_reviews?> reviews</div>                     
                            </div>
                            <div class="discount-cont">
                                <div id="item-price">₱<?php echo $prodprice?> </div>
                                <div id="original-price">₱<?php echo $origprice?> </div>
                                <div id="percentage-off"><?php echo $discprice?>% off</div>
                            </div>
                        </div>
                        <button class="cart-button submit-cart" >Add to Cart</button>
                        </div>
                        <?php } } ?>
                    </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>


        <div>
            <div class="homepage-cont" style="margin: 30px 0px 30px 0px !important;">
                <img src="./images/banner/skin-assesment-banner.png" alt="">
                <a href="./components/assessment.php"><button>Skin Assessment Test</button></a>
            </div>
        </div>

        <div class="products-cont swiper">
            <div class="wrapper">
                <div class="product-list-items swiper-wrapper">
                <?php
                    $sql = "SELECT * FROM tbl_prod_newarrivals";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($data = $result->fetch_assoc()) {
                            $origprice = $data['prod_price'] + 100; // Adjusted original price
                            $proddiscount = $data['prod_discount'] / 100;
                            $prodprice = $origprice - ($origprice * $proddiscount); // Calculate discounted price
                            $discprice = $data['prod_discount']; // Convert to percentage for display
                            include "./components/reviews-ratings.php"
                            
                    ?>
                            <div class="product-items swiper-slide"  data-prod-id="<?= $data['prod_id']?>">
                        <div class="prod-img-cont img-con-click" data-item-id="<?= $data['prod_id']?>">
                            <img src="./images/products/<?php echo $data['prod_img']; ?>" >
                            <img src="./images/products-hover/<?php echo $data['prod_hover_img']; ?>" class="hovered-image">
                            <div class="product-status" style="background-color: green;">New Arrivals</div>
                        </div>
                        <div class="details-cont">
                            <div class="prod-name"><?php echo $data['prod_name']; ?></div>
                            <div class="prod-description"><?php echo $data['prod-short-desc']; ?></div>
                            <div class="prod-rating-cont">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                    <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                                </svg> 
                                <div>4.8</div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                                <div><?= $total_reviews?> reviews</div>                     
                            </div>
                            <div class="discount-cont">
                                <div id="item-price">₱<?php echo $prodprice?> </div>
                                <div id="original-price">₱<?php echo $origprice?> </div>
                                <div id="percentage-off"><?php echo $discprice?>% off</div>
                            </div>
                        </div>
                        <button class="cart-button submit-cart">Add to Cart</button>
                        </div>
                        <?php } } ?>
                    </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        


        <div class="claims-main-cont">
        <div class="claims-cont">
            <div class="claims-img-cont">
                <img src="./images/icons/derm-tested.webp" alt="">
            </div>
            <div class="claims-details">
                <div>
                    Derm-tested
                </div>
                <div>
                    Our products are safely tested
                    <br>
                    and have proven effective
                </div>
            </div>
        </div>
        <div class="claims-cont">
            <div class="claims-img-cont">
                <img src="./images/icons/b-science.webp">
            </div>
            <div class="claims-details">
                <div>
                   Backed by Science
                </div>
                <div>
                    Our ingredients and products are
                    <br>
                    certified by our experts
                </div>
            </div>
        </div>
        <div class="claims-cont">
            <div class="claims-img-cont">
                <img src="./images/icons/delivery.webp" alt="">
            </div>
            <div class="claims-details">
                <div>
                    Nationwide Delivery
                </div>
                <div>
                    Fast delivery options with 
                    <br>
                    tracking nationwide
                </div>
            </div>
        </div>
        <div class="claims-cont">
            <div class="claims-img-cont">
                <img src="./images/icons/b-science.webp" alt="">
            </div>
            <div class="claims-details">
                <div>
                    Secure Ordering
                </div>
                <div>
                    We value and respect the privacy 
                    <br>
                    of our customers.
                </div>
            </div>
        </div>    
    </div>

    <div class="additional-detail-cont">
        
        <div class="additional-detail-img">
            <img src="./images/banner/learn-more-banner.png" alt="">
        </div>
        <div class="additional-detail-description">
            <div class="description-header">
                Made by Filipinos, for Filipinos
            </div>
            <div style="font-size: 18px;">
                We understand that Filipino skin has unique needs. That's why we develop our products with Filipino skin in mind, using ingredients and formulations proven to be effective for our climate and concerns.
            </div>
            <a href="./components/about.php">
                <button>
                    Learn More
                </button>
            </a>
        </div>
    </div>

    <h3>
        Real People, Real Stories
    </h3>

    <div class="reviews-main-cont swiper">
        <div class="review-wrapper">
            <ul class="reviews-cont-list swiper-wrapper">
                <li class="reviews-cont swiper-slide"">
                    <div class="reviews-img">
                        <img src="./images/testimonials/2.png" alt="">
                    </div>
                    <div class="reviewer-details">
                        <div>
                            Jhyra Mariano
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                              </svg>
                        </div>
                        <div>
                            4.5
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                        </div>
                    </div>
                    <div class="reviewers-opinion">
                        Trustworthy Brand with a Great Initiative
                    </div>
                    <div class="reviewers-description">
                        The DermSignal is one of the few brands in the Philippines that offers high-performing products. I am a fan of their salicylic acid range. And you know what? Every time you buy from their website, they provide science education to a child in need. Isn’t it just awesome?
                    </div>
                </li>
                <li class="reviews-cont swiper-slide">
                    <div class="reviews-img">
                        <img src="./images/testimonials/3.png" alt="">
                    </div>
                    <div class="reviewer-details">
                        <div>
                            Jhyra Mariano
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                              </svg>
                        </div>
                        <div>
                            4.5
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                        </div>
                    </div>
                    <div class="reviewers-opinion">
                        Trustworthy Brand with a Great Initiative
                    </div>
                    <div class="reviewers-description">
                        The DermSignal is one of the few brands in the Philippines that offers high-performing products. I am a fan of their salicylic acid range. And you know what? Every time you buy from their website, they provide science education to a child in need. Isn’t it just awesome?
                    </div>
                </li>
                <li class="reviews-cont swiper-slide">
                    <div class="reviews-img">
                        <img src="./images/testimonials/4.png" alt="">
                    </div>
                    <div class="reviewer-details">
                        <div>
                            Jhyra Mariano
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                              </svg>
                        </div>
                        <div>
                            4.5
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                        </div>
                    </div>
                    <div class="reviewers-opinion">
                        Trustworthy Brand with a Great Initiative
                    </div>
                    <div class="reviewers-description">
                        The DermSignal is one of the few brands in the Philippine that offers high-performing products. I am a fan of their salicylic acid range. And you know what? Every time you buy from their website, they provide science education to a child in need. Isn’t it just awesome?
                    </div>
                </li>
                <li class="reviews-cont swiper-slide">
                    <div class="reviews-img">
                        <img src="./images/testimonials/5.png" alt="">
                    </div>
                    <div class="reviewer-details">
                        <div>
                            Jhyra Mariano
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                              </svg>
                        </div>
                        <div>
                            4.5
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                        </div>
                    </div>
                    <div class="reviewers-opinion">
                        Trustworthy Brand with a Great Initiative
                    </div>
                    <div class="reviewers-description">
                        The Derma Co is one of the few brands in India that offers high-performing products. I am a fan of their salicylic acid range. And you know what? Every time you buy from their website, they provide science education to a child in need. Isn’t it just awesome?
                    </div>
                </li>
                <li class="reviews-cont swiper-slide">
                    <div class="reviews-img">
                        <img src="./images/testimonials/6.png" alt="">
                    </div>
                    <div class="reviewer-details">
                        <div>
                            Jhyra Mariano
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                              </svg>
                        </div>
                        <div>
                            4.5
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                        </div>
                    </div>
                    <div class="reviewers-opinion">
                        Trustworthy Brand with a Great Initiative
                    </div>
                    <div class="reviewers-description">
                        The Derma Co is one of the few brands in India that offers high-performing products. I am a fan of their salicylic acid range. And you know what? Every time you buy from their website, they provide science education to a child in need. Isn’t it just awesome?
                    </div>
                </li>
                <li class="reviews-cont swiper-slide">
                    <div class="reviews-img">
                        <img src="./images/testimonials/7.png" alt="">
                    </div>
                    <div class="reviewer-details">
                        <div>
                            Jhyra Mariano
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300"/>
                              </svg>
                        </div>
                        <div>
                            4.5
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path></svg>
                        </div>
                    </div>
                    <div class="reviewers-opinion">
                        Trustworthy Brand with a Great Initiative
                    </div>
                    <div class="reviewers-description">
                        The Derma Co is one of the few brands in India that offers high-performing products. I am a fan of their salicylic acid range. And you know what? Every time you buy from their website, they provide science education to a child in need. Isn’t it just awesome?
                    </div>
                </li>
            </ul>
            <div class="swiper-pagination"></div>
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>

    <div class="center-blog">
            <div class="blog-cont">
                <img src="./images/blog/acne-teenage-girl-applying-acne-medication-her-face-front-mirror-care-problem-skin.webp" alt="" class="blog-1">
                <p>MARCH 1, 2024</p>
                <h1>7 Acne Myths Debunked</h1>
                <p class="desc">Research shows that nearly 98% of the general public harbors at least one erroneous belief about acne's causes and remedies. Find out common myths that might be making your acne worse, and what to actually do. Check-out this beginner guide made with the Filipino skin in mind.</p>
                <a href="./components/blog-1.php">Read more</a>
            </div>
            <div class="blog-cont">
                <img src="./images/blog/bilastine.webp" alt="" class="blog-1">
                <p>FEBRUARY 26, 2024</p>
                <h1>A Step By Step Guide for...</h1>
                <p class="desc">Skincare remains the backbone of successful acne management. With all the skincare products released left and right, it can be overwhelming to choose which products to incorporate on your regimen. Check-out this beginner guide made with the Filipino skin in mind. </p>
                <a href="./components/blog-2.php">Read more</a>
            </div>
            <div class="blog-cont">
                <img src="./images/blog/blog-1-big.webp" alt="" class="blog-1">
                <p>MARCH 1, 2024</p>
                <h1>7 Acne Myths Debunked</h1>
                <p class="desc">Acne often necessitates the use of topical treatments that can lead to side effects like acne purging, irritation (irritant contact dermatitis), and allergic reaction (allergic contact dermatitis). Can this second-generation antihistamine help in improving purging and allergy while on acne treatment?</p>
                <a href="./components/blog-3.php">Read more</a>
            </div>
    </div>






<?php
    if(!empty($_SESSION["user_id"])) { 
        $current_user = $_SESSION['user_id'];
        $query = "SELECT tc.*, tp.*
        FROM tbl_cart tc
        JOIN tbl_products tp ON tc.prod_id = tp.prod_id
        WHERE tc.account_id = ? AND tc.status_id = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $current_user);
        $stmt->execute();
        $result = $stmt->get_result();
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
                <h1>
                    My Cart
                </h1>
            </div>
            <div class="whole-cont-display">
            <?php if($result->num_rows > 0) { ?>
                <div class="whole-item-cont" id="whole-item-cont">
                    <div class="order-summary-header">
                        Order Sumarry
                    </div>
                    <div class="item-cont" id="item-cont">
                    <?php 
                  
                        $total = 0;
                        $subtotalOnly = 0;
                        while ($data = $result->fetch_assoc()) {
                            $subtotalOnly += $data["prod_price"];
                            $origprice = $data['prod_price'] + 100; // Adjusted original price
                            $proddiscount = $data['prod_discount'] / 100;
                            $prodprice = $origprice - ($origprice * $proddiscount); 
                            $subtotal = $data["prod_qnty"] * $prodprice;
                            $total += $subtotal;// Calculate discounted price
                            $discprice = $data['prod_discount']; // Convert to percentage for display  
                            $onlineDisc = $total * 0.05; 
                            $grandTotal = $total - $onlineDisc;
                            $savedAmount = $total - $grandTotal;
                    ?>
                        <div class="item-cont-flex">
                            <div class="item-img-cont">
                                      <img src="../images/products/<?= $data['prod_img']; ?>" alt="img" >
                            </div>
                            <div class="item-details">
                                <p class="item-name"> <?= $data['prod_name']?> </p>
                                <div class="item-classification"><?= $data['prod-short-desc']?> </div>
                                <div class="item-prices">
                                    <div class="prices-cont">
                                        <div class="main-price"> <?=  number_format($prodprice, 2)?> </div>
                                        <div class="discounted-price"> ₱<?= $origprice?> </div>
                                        <div class="discounted-price-percent"><?= $discprice ?>% off</div>
                                    </div>
                                    <div class="quantity-buttons">
                                        <button class="minus-btn" data-item-id="<?= $data["prod_id"] ?>"> - </button>
                                        <div class="quantity-display" ><?= $data["prod_qnty"] ?> </div>
                                        <button class="add-btn" data-item-id="<?= $data["prod_id"] ?>"> + </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>



                <div>
                    <div class="cart-details" id="cart-details">
                        <div class="saved-amount-cont">
                            <div class="saved-amount">
                                <div>
                                You saved <span>₱ <?= $savedAmount ?></span> on this order
                                </div>
                                <div>
                                  
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
                                    <div>₱<?= number_format($total, 2)?></div>
                                </div>
                                <div class="shipping-discount">
                                    <div>Shipping</div>
                                    <div> <span style="text-decoration: line-through; color: black;">₱40</span> Free
                                    </div>
                                </div>
                                <div class="online-payment-discount">
                                    <div>5% online payment discount</div>
                                    <div>-₱<?= number_format($onlineDisc, 2)?></div>
                                </div>
                                <div class="grand-total">
                                    <div>Grand Total</div>
                                    <div>₱<?= number_format($grandTotal, 2)?></div>
                                </div>
                                <div class="secure-payment">
                                    <img src="./images/icons/icon-cart-safe-pay.png" alt="">
                                    <div>Safe and Secure Payment, Easy Return</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-button-cont" id="checkout-button-cont">
                        <div class="item-details-price">
                            <div>₱<?= number_format($grandTotal, 2)?></div>
                        </div>
                        <div>
                            <a href="./components/checkout.php">
                                <button>Checkout</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
             else{?>

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

<hr>

<footer>
    <div class="footer-choices">
        <div class="footer-components-cont">
            <div class="footer-components">
                <div class="components-img">
                    <img src="./images/icons/icon-footer-free-shipping.png" alt="">
                </div>
                <div>
                    <div>Free Shipping</div>
                    <div>On Orders Above ₱ 1000</div>
                </div>
            </div>
            <div class="footer-components">
                <div class="components-img">
                    <img src="./images/icons/icon-footer-cod-avail.png" alt="">
                </div>
                <div>
                    <div>Free Shipping</div>
                    <div>On Orders Above ₱ 1000</div>
                </div>
            </div>
        </div>

        <div class="footer-queries">
            <div>Have Queries or Concerns?</div>
            <a href="./components/contacts.php"><div>Contact Us</div></a>
        </div>

    </div>
    <div class="footer-main-details">
        <div class="footer-details">
            <div class="combined">
                <div class="footer-logo">
                    <a href="./index.php">
                        <img src="./images/icons/logo-no-bg.png" alt="">
                    </a>
                </div>
                <div>
                    <p class="catchphrase">Affordable Skincare That Exceeds Expectations</p>
                </div>
            </div>
           
            <div class="footer-options">
                <div class="shop">
                    <h5>Shop</h5>
                    <a href="./components/all-products.php"><p>Products</p></a>
                </div>
        
                <div class="learn">
                    <h5>Learn</h5>
                    <a href="./components/about.php"><p>About Us</p></a>
                    <a href="./components/blogs.php"><p>Blog</p></a>
                </div>
                <div class="help">
                    <h5>Help & Support</h5>
                    <a href="./components/faqs.php"><p>FAQs</p></a>
                    <a href="./components/terms-condition.php"><p>Terms & Conditions</p></a>
                    <a href="./components/privacy-policy.php"><p>Privacy Policy</p> </a>
                </div>
            </div>
        </div>
        <div  class="footer-icons">
            <a href="https://www.facebook.com/dermsignal">
                <div class="facebook">
                    <img src="./images/footer-icons/icons8-facebook-384 (1).png" alt="">
                    <img class="white"src="./images/footer-icons/icons8-facebook-384 (2).png" alt="">
                </div>
            </a>
            <a href="https://www.pinterest.ph/">
                <div class="pinterest">
                    <img src="./images/footer-icons/icons8-pinterest-512.png" alt="">
                    <img class="white" src="./images/footer-icons/icons8-pinterest-512 (1).png" alt="">
                </div>
            </a>
            <a href="https://twitter.com/?lang=en">
                <div class="twitter">
                    <img src="./images/footer-icons/icons8-twitter-500.png" alt="">
                    <img class="white" src="./images/footer-icons/icons8-twitter-500 (3).png" alt="">
                </div>
            </a>
            <a href="https://www.instagram.com/dermsignal/?hl=en">
                <div class="instagram">
                    <img src="./images/footer-icons/icons8-ig-500 (2).png" alt="">
                    <img class="white" src="./images/footer-icons/icons8-ig-500 (3).png" alt="">
                </div>
            </a>
            <a href="https://shopee.ph/dermsignal">
                <div class="shopee ">
                    <img src="./images/footer-icons/icons8-shopee-500 (1).png" alt="">
                    <img class="white" src="./images/footer-icons/icons8-shopee-500.png" alt="">
                </div>
            </a>
            <a href="https://www.youtube.com/">
                <div class="youtube">
                    <img src="./images/footer-icons/icons8-youtube-500.png" alt="">
                    <img class="white" src="./images/footer-icons/icons8-youtube-500 (1).png" alt="">
                </div>
            </a>
        </div>
    </div> 
</footer> 
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="./scripts/swiper.js"></script>

<script src="./scripts/log-in-sign-up.js"></script>
<script src="./scripts/cart.js"></script>
<script src="./jquery/addtocart-index.js"></script>
<script src="./scripts/profile.js"></script>
<script src="./scripts/slideshow.js"> </script>
<script>
    $('.img-con-click').click(function() {
        var itemId = $(this).data("item-id");
        const url = `./components/individual-product.php?item=${itemId}`;
        window.location.href = url;
    });

    const categoryButtons = document.querySelectorAll('.prod-button button');
            let bestSellersButton = null;
            
            categoryButtons.forEach(button => {
                button.addEventListener('click', () => {
                    removeBGColor();
                    button.classList.add('button-bg-color');
                    
                    if (button.innerHTML === 'Best Seller') {
                        addDataToHTML(randomizedItems);
                        console.log(randomizedItems)
                    } else {
                        addDataToHTML(uniqueItems);
                        console.log(uniqueItems)
                    }
                    
                    console.log(button.innerHTML);

                    const swiper = getSwiperInstance(); // Access the Swiper instance
                    if (swiper) {
                        swiper.update(); // Update the Swiper layout
                    }
                });
            
                // Identify the "Best Sellers" button
                if (button.innerHTML === 'Best Seller') {
                    bestSellersButton = button;
                }
            });
            
            // Trigger a click event on the "Best Sellers" button to activate it by default
            if (bestSellersButton) {
                bestSellersButton.click();
            }
            
            function removeBGColor() {
                categoryButtons.forEach(button => {
                    button.classList.remove('button-bg-color');
                });
            }
</script>
</body>
</html>