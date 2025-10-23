<?php require_once("../backend/config/config.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="../styles/slider.css">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/dropdown.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/login-signup-popup.css">
    <link rel="stylesheet" href="../styles/profile-hover.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="../styles/slideshow.css">
    <link rel="stylesheet" href="../styles/shop-by-concern.css">
    <link rel="stylesheet" href="../styles/reviews.css">
    <link rel="stylesheet" href="../styles/blog.css">
    <link rel="stylesheet" href="../styles/voucher-banner.css">
    <script src="../jquery/jquery.js"></script>
    <script src="../scripts/sweetalert.js"></script>
    <script src="../jquery/add-voucher-to-cart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>DermSignal</title>
    <style>
        .product-list-items {
            gap: 20px;
        }
    </style>
</head>

<body>

    <?php include "./header.php" ?>

    <div class="slideshow-div">

        <div class="slideshow-container">

            <div class="mySlides fade">
                <img src="../images/banner/banner-1.png" style="width:100%">
                <a href="./about.php"><button class="btn1">About Us</button></a>
            </div>
            <div class="mySlides fade">
                <img src="../images/banner/banner-2.png" style="width:100%">
                <a href="./all-products.php"><button class="btn2">Shop Now</button></a>
            </div>
            <div class="mySlides fade">
                <img src="../images/banner/banner-3.png" style="width:100%">
                <a href="./all-products.php"><button class="btn3">Shop Now</button></a>
            </div>


            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles -->
        <div class="dots" style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>

        </div>
    </div>



    <?php include "./voucher-banner.php" ?>

    <div class="products-cont swiper">
        <div class="wrapper">
            <div class="product-list-items swiper-wrapper">
                <?php
                $sql = "SELECT 
                                p.*,
                                SUM(c.prod_qnty) as total_sold
                            FROM tbl_products p
                            INNER JOIN tbl_cart c ON p.prod_id = c.prod_id
                            WHERE c.status_id = 2
                            GROUP BY p.prod_id
                            ORDER BY total_sold DESC
                            LIMIT 5";

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $origprice = $data['prod_price'] + 100;
                        $proddiscount = $data['prod_discount'] / 100;
                        $prodprice = $origprice - ($origprice * $proddiscount);
                        $discprice = $data['prod_discount'];

                        // Get reviews and ratings for this product
                        $product_id = $data['prod_id'];
                        include "./reviews-ratings.php";
                ?>
                        <div class="product-items " data-prod-id="<?= $data['prod_id'] ?>">
                            <div class="prod-img-cont img-con-click" data-item-id="<?= $data['prod_id'] ?>">
                                <?php
                                if (file_exists('../images/products/' . $data["prod_img"]) == false || $data["prod_img"] == NULL) {
                                    echo '<div class="no-image-placeholder" style="color: rgb(77, 77, 77);">No Image Available</div>';
                                } else {
                                    echo '<img src="../images/products/' . $data["prod_img"] . '" >';
                                    echo '<img src="../images/products-hover/' . $data["prod_hover_img"] . '" class="hovered-image">';
                                }
                                ?>

                                <div class="product-status">Best Seller (<?= $data['total_sold'] ?> sold)</div>
                            </div>
                            <div class="details-cont">
                                <div class="prod-name"><?php echo $data['prod_name']; ?></div>
                                <div class="prod-description"><?php echo $data['prod-short-desc']; ?></div>
                                <div class="prod-rating-cont">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                                    </svg>
                                    <div>4.8</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16">
                                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff" />
                                    </svg>
                                    <div><?= $total_reviews ?> reviews</div>
                                </div>
                                <div class="discount-cont">
                                    <div id="item-price">₱<?php echo $prodprice ?></div>
                                    <div id="original-price">₱<?php echo $origprice ?></div>
                                    <div id="percentage-off"><?php echo $discprice ?>% off</div>
                                </div>
                            </div>
                            <button class="cart-button submit-cart">Add to Cart</button>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="no-products">No best sellers found yet.</div>';
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>


    <div>
        <div class="homepage-cont" style="margin: 30px 0px 30px 0px !important;">
            <img src="../images/banner/skin-assesment-banner.png" alt="">
            <a href="./assessment.php"><button>Skin Assessment Test</button></a>
        </div>
    </div>

    <div class="products-cont swiper">
        <div class="wrapper">
            <div class="product-list-items swiper-wrapper">
                <?php
                $sql = "
                        SELECT *
                        FROM tbl_products
                        ORDER BY prod_id DESC
                        LIMIT 5";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($data = $result->fetch_assoc()) {
                        $origprice = $data['prod_price'] + 100; // Adjusted original price
                        $proddiscount = $data['prod_discount'] / 100;
                        $prodprice = $origprice - ($origprice * $proddiscount); // Calculate discounted price
                        $discprice = $data['prod_discount']; // Convert to percentage for display


                ?>
                        <div class="product-items swiper-slide" data-prod-id="<?= $data['prod_id'] ?>">
                            <div class="prod-img-cont img-con-click" data-item-id="<?= $data['prod_id'] ?>">
                                <?php
                                if (file_exists('../images/products/' . $data["prod_img"]) == false || $data["prod_img"] == NULL) {
                                    echo '<div class="no-image-placeholder" style="color: rgb(77, 77, 77);">No Image Available</div>';
                                } else {
                                    echo '<img src="../images/products/' . $data["prod_img"] . '" >';
                                    echo '<img src="../images/products-hover/' . $data["prod_hover_img"] . '" class="hovered-image">';
                                }
                                ?>
                                <div class="product-status" style="background-color: green;">New Arrivals</div>
                            </div>
                            <div class="details-cont">
                                <div class="prod-name"><?php echo $data['prod_name']; ?></div>
                                <div class="prod-description"><?php echo $data['prod-short-desc']; ?></div>
                                <div class="prod-rating-cont">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                                    </svg>
                                    <div>4.8</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16">
                                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                                    </svg>
                                    <div><?= $total_reviews ?> reviews</div>
                                </div>
                                <div class="discount-cont">
                                    <div id="item-price">₱<?php echo $prodprice ?> </div>
                                    <div id="original-price">₱<?php echo $origprice ?> </div>
                                    <div id="percentage-off"><?php echo $discprice ?>% off</div>
                                </div>
                            </div>
                            <button class="cart-button submit-cart">Add to Cart</button>
                        </div>
                <?php }
                } ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>



    <div class="claims-main-cont">
        <div class="claims-cont">
            <div class="claims-img-cont">
                <img src="../images/icons/derm-tested.webp" alt="">
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
                <img src="../images/icons/b-science.webp">
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
                <img src="../images/icons/delivery.webp" alt="">
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
                <img src="../images/icons/b-science.webp" alt="">
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
            <img src="../images/banner/learn-more-banner.png" alt="">
        </div>
        <div class="additional-detail-description">
            <div class="description-header">
                Made by Filipinos, for Filipinos
            </div>
            <div style="font-size: 18px;">
                We understand that Filipino skin has unique needs. That's why we develop our products with Filipino skin in mind, using ingredients and formulations proven to be effective for our climate and concerns.
            </div>
            <a href="./about.php">
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
                    <div class=" reviews-img">
                    <img src="../images/testimonials/2.png" alt="">
        </div>
        <div class="reviewer-details">
            <div>
                Jhyra Mariano
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                    <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                </svg>
            </div>
            <div>
                4.5
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                </svg>
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
                <img src="../images/testimonials/3.png" alt="">
            </div>
            <div class="reviewer-details">
                <div>
                    Jhyra Mariano
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                    </svg>
                </div>
                <div>
                    4.5
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                    </svg>
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
                <img src="../images/testimonials/4.png" alt="">
            </div>
            <div class="reviewer-details">
                <div>
                    Jhyra Mariano
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                    </svg>
                </div>
                <div>
                    4.5
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                    </svg>
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
                <img src="../images/testimonials/5.png" alt="">
            </div>
            <div class="reviewer-details">
                <div>
                    Jhyra Mariano
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                    </svg>
                </div>
                <div>
                    4.5
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                    </svg>
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
                <img src="../images/testimonials/6.png" alt="">
            </div>
            <div class="reviewer-details">
                <div>
                    Jhyra Mariano
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                    </svg>
                </div>
                <div>
                    4.5
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                    </svg>
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
                <img src="../images/testimonials/7.png" alt="">
            </div>
            <div class="reviewer-details">
                <div>
                    Jhyra Mariano
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                    </svg>
                </div>
                <div>
                    4.5
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                    </svg>
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
            <img src="../images/blog/acne-teenage-girl-applying-acne-medication-her-face-front-mirror-care-problem-skin.webp" alt="" class="blog-1">
            <p>MARCH 1, 2024</p>
            <h1>7 Acne Myths Debunked</h1>
            <p class="desc">Research shows that nearly 98% of the general public harbors at least one erroneous belief about acne's causes and remedies. Find out common myths that might be making your acne worse, and what to actually do. Check-out this beginner guide made with the Filipino skin in mind.</p>
            <a href="./blog-1.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/bilastine.webp" alt="" class="blog-1">
            <p>FEBRUARY 26, 2024</p>
            <h1>A Step By Step Guide for...</h1>
            <p class="desc">Skincare remains the backbone of successful acne management. With all the skincare products released left and right, it can be overwhelming to choose which products to incorporate on your regimen. Check-out this beginner guide made with the Filipino skin in mind. </p>
            <a href="./blog-2.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/blog-1-big.webp" alt="" class="blog-1">
            <p>MARCH 1, 2024</p>
            <h1>7 Acne Myths Debunked</h1>
            <p class="desc">Acne often necessitates the use of topical treatments that can lead to side effects like acne purging, irritation (irritant contact dermatitis), and allergic reaction (allergic contact dermatitis). Can this second-generation antihistamine help in improving purging and allergy while on acne treatment?</p>
            <a href="./blog-3.php">Read more</a>
        </div>
    </div>






    <?php
    if (!empty($_SESSION["user_id"])) {
        

    $current_user = $_SESSION['user_id'];
    ?>

    <?php
    // Get products in cart
    $query = "SELECT tc.*, tp.*
    FROM tbl_cart tc
    JOIN tbl_products tp ON tc.prod_id = tp.prod_id
    WHERE tc.account_id = ? AND tc.status_id = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $current_user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get vouchers in cart
    $queryVouchers = "SELECT cv.*, v.*
    FROM tbl_cart_vouchers cv
    JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
    WHERE cv.account_id = ? AND cv.status_id = 1";
    $stmtVouchers = $conn->prepare($queryVouchers);
    $stmtVouchers->bind_param("i", $current_user);
    $stmtVouchers->execute();
    $resultVouchers = $stmtVouchers->get_result();

    // Check if cart has items
    $hasItems = ($result->num_rows > 0 || $resultVouchers->num_rows > 0);
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
                <h1>My Cart</h1>
            </div>
            <div class="whole-cont-display">
                <?php if ($hasItems) { ?>
                    <div class="whole-item-cont" id="whole-item-cont">
                        <div class="order-summary-header">Order Summary</div>
                        <div class="item-cont" id="item-cont">
                            <?php
                            $total = 0;
                            $voucherDiscount = 0;

                            // Store all cart items for voucher calculation
                            $cartItems = [];
                            mysqli_data_seek($result, 0);
                            while ($data = $result->fetch_assoc()) {
                                $origprice = $data['prod_price'] + 100;
                                $proddiscount = $data['prod_discount'] / 100;
                                $prodprice = $origprice - ($origprice * $proddiscount);
                                $subtotal = $data["prod_qnty"] * $prodprice;
                                $total += $subtotal;

                                $cartItems[] = [
                                    'prod_id' => $data['prod_id'],
                                    'subtotal' => $subtotal
                                ];
                            }

                            // Calculate voucher discounts (only for eligible items)
                            $voucherEligibleTotal = 0;
                            if ($resultVouchers->num_rows > 0) {
                                mysqli_data_seek($resultVouchers, 0);
                                while ($voucher = $resultVouchers->fetch_assoc()) {
                                    // Parse target items
                                    $targetItems = json_decode($voucher['target_items'], true);
                                    $eligibleProductIds = [];

                                    if ($targetItems) {
                                        foreach ($targetItems as $item) {
                                            if ($item['type'] == 'product') {
                                                $eligibleProductIds[] = $item['id'];
                                            }
                                        }
                                    }

                                    // Calculate subtotal for eligible items only
                                    $voucherSubtotal = 0;
                                    foreach ($cartItems as $cartItem) {
                                        if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                            $voucherSubtotal += $cartItem['subtotal'];
                                        }
                                    }

                                    // Calculate discount based on eligible items only
                                    if ($voucher['discount_type'] == 'percentage') {
                                        $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                        if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                            $currentDiscount = $voucher['max_discount'];
                                        }
                                    } else {
                                        $currentDiscount = $voucher['discount_value'];
                                    }

                                    // Check minimum purchase requirement
                                    $meetsMinimum = ($total >= $voucher['min_purchase']);
                                    if ($meetsMinimum) {
                                        $voucherDiscount += $currentDiscount;
                                        $voucherEligibleTotal += $voucherSubtotal;
                                    }
                                }
                            }

                            // Display products
                            mysqli_data_seek($result, 0);
                            while ($data = $result->fetch_assoc()) {
                                $origprice = $data['prod_price'] + 100;
                                $proddiscount = $data['prod_discount'] / 100;
                                $prodprice = $origprice - ($origprice * $proddiscount);
                                $subtotal = $data["prod_qnty"] * $prodprice;
                                $discprice = $data['prod_discount'];
                            ?>
                                <div class="item-cont-flex">
                                    <div class="item-img-cont">
                                        <img src="../images/products/<?= $data['prod_img']; ?>" alt="img">
                                    </div>
                                    <div class="item-details">
                                        <p class="item-name"> <?= $data['prod_name'] ?> </p>
                                        <div class="item-classification"><?= $data['prod-short-desc'] ?> </div>
                                        <div class="item-prices">
                                            <div class="prices-cont">
                                                <div class="main-price"> <?= number_format($prodprice, 2) ?> </div>
                                                <div class="discounted-price"> ₱<?= $origprice ?> </div>
                                                <div class="discounted-price-percent"><?= $discprice ?>% off</div>
                                            </div>
                                            <div class="quantity-buttons">
                                                <button class="minus-btn" data-item-id="<?= $data["prod_id"] ?>"> - </button>
                                                <div class="quantity-display"><?= $data["prod_qnty"] ?> </div>
                                                <button class="add-btn" data-item-id="<?= $data["prod_id"] ?>"> + </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php
                            // Display vouchers in cart
                            if ($resultVouchers->num_rows > 0) {
                                mysqli_data_seek($resultVouchers, 0);

                                while ($voucher = $resultVouchers->fetch_assoc()) {
                                    // Parse target items
                                    $targetItems = json_decode($voucher['target_items'], true);
                                    $eligibleProductIds = [];

                                    if ($targetItems) {
                                        foreach ($targetItems as $item) {
                                            if ($item['type'] == 'product') {
                                                $eligibleProductIds[] = $item['id'];
                                            }
                                        }
                                    }

                                    // Calculate subtotal for eligible items only
                                    $voucherSubtotal = 0;
                                    foreach ($cartItems as $cartItem) {
                                        if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                            $voucherSubtotal += $cartItem['subtotal'];
                                        }
                                    }

                                    // Calculate voucher discount
                                    if ($voucher['discount_type'] == 'percentage') {
                                        $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                        if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                            $currentDiscount = $voucher['max_discount'];
                                        }
                                    } else {
                                        $currentDiscount = $voucher['discount_value'];
                                    }

                                    // Check minimum purchase requirement
                                    $meetsMinimum = ($total >= $voucher['min_purchase']);
                            ?>
                                    <div class="item-cont-flex voucher-item" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-left: 4px solid #4a9f20ff; margin-bottom: 15px;">
                                        <div class="item-img-cont" style="background: #4a9f20ff; display: flex; align-items: center; justify-content: center; min-width: 70px;">
                                            <i class="fa-solid fa-ticket-simple" style="color: white; font-size: 20px;"></i>
                                        </div>
                                        <div class="item-details" style="flex: 1;">
                                            <p class="item-name" style="color: #4a9f20ff; font-weight: bold; font-size: 16px;">
                                                <i class="fa-solid fa-tag"></i> <?= htmlspecialchars($voucher['voucher_name']) ?>
                                            </p>
                                            <div class="item-classification" style="font-weight: 600; margin: 5px 0;">
                                                Code: <span style="background: #4a9f20ff; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px;"><?= htmlspecialchars($voucher['voucher_code']) ?></span>
                                            </div>
                                            <div class="voucher-details" style="font-size: 12px; color: #6c757d; margin-top: 5px;">
                                                <?php if ($voucher['discount_type'] == 'percentage') { ?>
                                                    <span><i class="fa-solid fa-percent"></i> <?= intval($voucher['discount_value']) ?>% OFF</span>
                                                    <?php if ($voucher['max_discount'] > 0) { ?>
                                                        <span style="margin-left: 10px;">(Max: ₱<?= number_format($voucher['max_discount'], 2) ?>)</span>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <span><i class="fa-solid fa-peso-sign"></i> ₱<?= number_format($voucher['discount_value'], 2) ?> OFF</span>
                                                <?php } ?>
                                                <?php if ($voucher['min_purchase'] > 0) { ?>
                                                    <span style="margin-left: 10px;"><i class="fa-solid fa-cart-shopping"></i> Min: ₱<?= number_format($voucher['min_purchase'], 2) ?></span>
                                                <?php } ?>
                                            </div>
                                            <div class="voucher-eligible-items" style="font-size: 11px; color: #6c757d; margin-top: 5px;">
                                                <i class="fa-solid fa-box"></i> Eligible items subtotal: ₱<?= number_format($voucherSubtotal, 2) ?>
                                            </div>
                                            <?php if (!$meetsMinimum) { ?>
                                                <div class="voucher-warning" style="background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px; margin-top: 8px; font-size: 11px;">
                                                    <i class="fa-solid fa-exclamation-triangle"></i> Add ₱<?= number_format($voucher['min_purchase'] - $total, 2) ?> more to use this voucher
                                                </div>
                                            <?php } else { ?>
                                                <div class="voucher-applied" style="background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 5px; margin-top: 8px; font-size: 11px;">
                                                    <i class="fa-solid fa-check-circle"></i> Discount applied: -₱<?= number_format($currentDiscount, 2) ?>
                                                </div>
                                            <?php } ?>
                                            <div class="item-prices" style="margin-top: 10px;">
                                                <button class="remove-voucher-btn" data-voucher-id="<?= $voucher['voucher_id'] ?>"
                                                    style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 12px;">
                                                    <i class="fa-solid fa-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }

                            // Recalculate totals with voucher discounts
                            $onlineDisc = $total * 0.05;
                            $grandTotal = $total - $onlineDisc - $voucherDiscount;
                            if ($grandTotal < 0) $grandTotal = 0;
                            $savedAmount = $onlineDisc + $voucherDiscount;
                            ?>
                        </div>
                    </div>

                    <div>
                        <div class="cart-details" id="cart-details">
                            <div class="saved-amount-cont">
                                <div class="saved-amount">
                                    <div>
                                        You saved <span>₱ <?= number_format($savedAmount, 2) ?></span> on this order
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
                                        <div>₱<?= number_format($total, 2) ?></div>
                                    </div>
                                    <div class="shipping-discount">
                                        <div>Shipping</div>
                                        <div> <span style="text-decoration: line-through; color: black;">₱40</span> Free
                                        </div>
                                    </div>
                                    <div class="online-payment-discount">
                                        <div>5% online payment discount</div>
                                        <div>-₱<?= number_format($onlineDisc, 2) ?></div>
                                    </div>
                                    <?php if ($voucherDiscount > 0) { ?>
                                        <div class="voucher-discount" style="color: white; font-weight: 500; padding: 10px 20px;
                                    font-size: 18px; border-top: 1px dashed #dee2e6;">
                                            <div><i class="fa-solid fa-ticket-simple"></i> Voucher Discount</div>
                                            <div>-₱<?= number_format($voucherDiscount, 2) ?></div>
                                        </div>
                                    <?php } ?>
                                    <div class="grand-total">
                                        <div>Grand Total</div>
                                        <div>₱<?= number_format($grandTotal, 2) ?></div>
                                    </div>
                                    <div class="secure-payment">
                                        <img src="../images/icons/icon-cart-safe-pay.png" alt="">
                                        <div>Safe and Secure Payment, Easy Return</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-button-cont" id="checkout-button-cont">
                            <div class="item-details-price">
                                <div>₱<?= number_format($grandTotal, 2) ?></div>
                            </div>
                            <div>
                                <a href="./checkout.php">
                                    <button>Checkout</button>
                                </a>
                            </div>
                        </div>
                    </div>
            </div>
        <?php } else { ?>

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
                    <a href="./all-products.php">
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
                        <img src="../images/icons/icon-footer-free-shipping.png" alt="">
                    </div>
                    <div>
                        <div>Free Shipping</div>
                        <div>On Orders Above ₱ 1000</div>
                    </div>
                </div>
                <div class="footer-components">
                    <div class="components-img">
                        <img src="../images/icons/icon-footer-cod-avail.png" alt="">
                    </div>
                    <div>
                        <div>Free Shipping</div>
                        <div>On Orders Above ₱ 1000</div>
                    </div>
                </div>
            </div>

            <div class="footer-queries">
                <div>Have Queries or Concerns?</div>
                <a href="./contacts.php">
                    <div>Contact Us</div>
                </a>
            </div>

        </div>
        <div class="footer-main-details">
            <div class="footer-details">
                <div class="combined">
                    <div class="footer-logo">
                        <a href="./index.php">
                            <img src="../images/icons/logo-no-bg.png" alt="">
                        </a>
                    </div>
                    <div>
                        <p class="catchphrase">Affordable Skincare That Exceeds Expectations</p>
                    </div>
                </div>

                <div class="footer-options">
                    <div class="shop">
                        <h5>Shop</h5>
                        <a href="./all-products.php">
                            <p>Products</p>
                        </a>
                    </div>

                    <div class="learn">
                        <h5>Learn</h5>
                        <a href="./about.php">
                            <p>About Us</p>
                        </a>
                        <a href="./blogs.php">
                            <p>Blog</p>
                        </a>
                    </div>
                    <div class="help">
                        <h5>Help & Support</h5>
                        <a href="./faqs.php">
                            <p>FAQs</p>
                        </a>
                        <a href="./terms-condition.php">
                            <p>Terms & Conditions</p>
                        </a>
                        <a href="./privacy-policy.php">
                            <p>Privacy Policy</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-icons">
                <a href="https://www.facebook.com/dermsignal">
                    <div class="facebook">
                        <img src="../images/footer-icons/icons8-facebook-384 (1).png" alt="">
                        <img class="white" src="../images/footer-icons/icons8-facebook-384 (2).png" alt="">
                    </div>
                </a>
                <a href="https://www.pinterest.ph/">
                    <div class="pinterest">
                        <img src="../images/footer-icons/icons8-pinterest-512.png" alt="">
                        <img class="white" src="../images/footer-icons/icons8-pinterest-512 (1).png" alt="">
                    </div>
                </a>
                <a href="https://twitter.com/?lang=en">
                    <div class="twitter">
                        <img src="../images/footer-icons/icons8-twitter-500.png" alt="">
                        <img class="white" src="../images/footer-icons/icons8-twitter-500 (3).png" alt="">
                    </div>
                </a>
                <a href="https://www.instagram.com/dermsignal/?hl=en">
                    <div class="instagram">
                        <img src="../images/footer-icons/icons8-ig-500 (2).png" alt="">
                        <img class="white" src="../images/footer-icons/icons8-ig-500 (3).png" alt="">
                    </div>
                </a>
                <a href="https://shopee.ph/dermsignal">
                    <div class="shopee ">
                        <img src="../images/footer-icons/icons8-shopee-500 (1).png" alt="">
                        <img class="white" src="../images/footer-icons/icons8-shopee-500.png" alt="">
                    </div>
                </a>
                <a href="https://www.youtube.com/">
                    <div class="youtube">
                        <img src="../images/footer-icons/icons8-youtube-500.png" alt="">
                        <img class="white" src="../images/footer-icons/icons8-youtube-500 (1).png" alt="">
                    </div>
                </a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../scripts/swiper.js"></script>
    <script src="../jquery/signup.js"></script>
    <script src="../scripts/log-in-sign-up.js"></script>
    <script src="../scripts/cart.js"></script>
    <script src="../jquery/addtocart-index.js"></script>
    <script src="../scripts/profile.js"></script>
    <script src="../scripts/slideshow.js"> </script>

    <script>
        $('.img-con-click').click(function() {
            var itemId = $(this).data("item-id");
            const url = `./individual-product.php?item=${itemId}`;
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