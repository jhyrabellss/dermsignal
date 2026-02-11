<?php require_once("../backend/config/config.php") ?>
<?php session_start(); ?>
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

        /* Review Header Section */
        .review-header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            margin-bottom: 20px;
        }

        .write-review-btn {
            background: rgb(39, 153, 137);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .write-review-btn:hover {
            background: rgba(33, 133, 120, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 159, 32, 0.3);
        }

        /* Review Modal */
        .review-modal {
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
        }

        .review-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .review-close {
            color: #aaa;
            float: right;
            font-size: 35px;
            font-weight: bold;
            line-height: 1;
            cursor: pointer;
            transition: 0.3s;
        }

        .review-close:hover,
        .review-close:focus {
            color: #000;
        }

        .review-modal-content h2 {
            margin-top: 0;
            color: #333;
            font-size: 28px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4a9f20ff;
        }

        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px dashed #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Star Rating */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 35px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked~label {
            color: #ffc300;
        }

        .char-count {
            display: block;
            text-align: right;
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }

        .submit-review-btn {
            width: 100%;
            background: rgb(39, 153, 137);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-review-btn:hover {
            background: rgba(33, 133, 120, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(74, 159, 32, 0.3);
        }

        .review-header-section .center {
            font-weight: 700;
            color: #333;
            margin-left: calc();
        }

     
.concerns-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 24px; /* closer together */
  padding: 60px 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.concern-card {
  text-align: center;
}

.concern-card img {
  width: 170px;   /* bigger */
  height: 170px;
  object-fit: cover;
  border-radius: 50%;
  background: #f3f7f6;
  padding: 6px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.concern-card img:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 26px rgba(39, 153, 137, 0.28);
}

.concern-card p {
  margin-top: 14px;
  font-size: 17px;
  font-weight: 600;
  color: #2f2f2f;
}

@media (max-width: 768px) {
  .concerns-container {
    gap: 20px;
  }

  .concern-card img {
    width: 135px;
    height: 135px;
  }
}

@media (max-width: 480px) {
  .concern-card img {
    width: 115px;
    height: 115px;
  }

  .concern-card p {
    font-size: 15px;
  }
}

/* Default (desktop & tablet) */
.concerns-container {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  padding: 60px 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.concern-card {
  text-align: center;
}

.concern-card img {
  width: 170px;
  height: 170px;
  object-fit: cover;
  border-radius: 50%;
  background: #f3f7f6;
  padding: 6px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.concern-card p {
  margin-top: 14px;
  font-size: 17px;
  font-weight: 600;
  color: #2f2f2f;
}

/* ===============================
   SKINCARE CONCERNS
================================ */

/* Desktop */
.concerns-container {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 19px;
  padding: 60px 20px;
  max-width: 1250px;
  margin: 0 auto;
}

.concern-card {
  text-align: center;
}

.concern-card img {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 50%;
  background: #f3f7f6;
  padding: 6px;
}

.concern-card p {
  margin-top: 14px;
  font-size: 17px;
  font-weight: 600;
  color: rgba(33, 133, 120, 1);
}


@media (max-width: 1024px) {
  .concerns-container {
    grid-template-columns: repeat(3, 1fr);
  }

  .concern-card img {
    width: 145px;
    height: 145px;
  }
}

@media (max-width: 600px) {
  .concerns-container {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }

  .concern-card img {
    width: 125px;
    height: 125px;
  }

  .concern-card p {
    font-size: 15px;
  }
}

@media (max-width: 380px) {
  .concern-card img {
    width: 110px;
    height: 110px;
  }
}

@media (max-width: 1024px) {
  .concerns-container {
    grid-template-columns: repeat(2, 1fr);
    gap: 22px;
  }

  .concern-card img {
    width: 150px;
    height: 150px;
  }
}

.title-review{
    font-size: 25px;
    color: rgba(33, 133, 120, 1);

}


    </style>
</head>

<body>

    <?php include "./header.php" ?>

    <div class="slideshow-div">

        <div class="slideshow-container">

            <div class="mySlides fade">
                <img src="..\images\banner\banner-1.png" style="width:100%">
                <!--<a href="./about.php"><button class="btn1">About Us</button></a>-->
            </div>
            <div class="mySlides fade">
                <img src="../images/banner/banner-2.png" style="width:100%">
                <!--<a href="./all-products.php"><button class="btn2">Shop Now</button></a>-->
            </div>
            <div class="mySlides fade">
                <img src="../images/banner/banner-3.png" style="width:100%">
                <!--<a href="./all-products.php"><button class="btn3">Shop Now</button></a>-->
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
    <br><br>

<!-- Skincare Concerns Section -->
<div class="concerns-container">
  <div class="concern-card">
    <a href="../components/concern-prod.php?concern_id=1">
      <img src="..\images\services\690d560ce2695.png" alt="Acne">
      <p>Acne</p>
    </a>
  </div>
  <div class="concern-card">
    <a href="../components/concern-prod.php?concern_id=2">
      <img src="..\images\services\690d556552b37.png" alt="Acne Marks">
      <p>Acne Marks</p>
    </a>
  </div>
  <div class="concern-card">
    <a href="../components/concern-prod.php?concern_id=3">
      <img src="..\images\services\690d56671984f.png" alt="Open Pores">
      <p>Open Pores</p>
    </a>
  </div>
  <div class="concern-card">
    <a href="../components/concern-prod.php?concern_id=4">
      <img src="..\images\services\690d560ce2695.png" alt="Pigmentation">
      <p>Pigmentation</p>
    </a>
  </div>
</div>


<br>
    <?php include "./voucher-banner.php" ?>

    <div class="products-cont swiper">
        <div class="wrapper">
            <div class="product-list-items swiper-wrapper">
                <?php
                $sql = "SELECT 
                                p.*,
                                COALESCE(SUM(c.prod_qnty), 0) as total_sold
                            FROM tbl_products p
                            LEFT JOIN tbl_cart c ON p.prod_id = c.prod_id AND c.status_id = 2
                            GROUP BY p.prod_id
                            ORDER BY total_sold DESC
                            LIMIT 5";

                $result = $conn->query($sql);

                // Fetch all active vouchers once
                $voucher_sql = "SELECT * FROM tbl_vouchers 
                                    WHERE is_active = 1 
                                    AND (voucher_type = 'product' OR voucher_type = 'both')
                                    AND CURDATE() BETWEEN start_date AND end_date
                                    ";
                $voucher_result = mysqli_query($conn, $voucher_sql);

                // Store vouchers in an array for reuse
                $active_vouchers = [];
                if ($voucher_result && mysqli_num_rows($voucher_result) > 0) {
                    while ($voucher = mysqli_fetch_assoc($voucher_result)) {
                        $active_vouchers[] = $voucher;
                    }
                }

                if ($result && $result->num_rows > 0) {
                    while ($data = $result->fetch_assoc()) {
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

                        // Get reviews and ratings for this product
                        $product_id = $data['prod_id'];
                        include "./reviews-ratings.php";
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

                                <div class="product-status">Best Seller (<?= $data['total_sold'] ?> sold)</div>
                            </div>
                            <div class="details-cont">
                                <div class="prod-name"><?php echo $data['prod_name']; ?></div>
                                <div class="prod-description"><?php echo $data['prod-short-desc']; ?></div>
                                <div class="prod-rating-cont">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                                    </svg>
                                    <div><?= $average_rating > 0 ? $average_rating : '0' ?></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16">
                                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff" />
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


    <!--<div>
        <div class="homepage-cont" style="margin: 30px 0px 30px 0px !important;">
            <img src="../images/banner/skin-assesment-banner.png" alt="">
            <a href="./assessment.php"><button>Skin Assessment Test</button></a>
        </div>
    </div>-->

    <!--<div class="products-cont swiper">
        <div class="wrapper">
            <div class="product-list-items swiper-wrapper">
                <?php
                $sql = "
                        SELECT *
                        FROM tbl_products
                        ORDER BY prod_id DESC
                        LIMIT 5";
                $result = $conn->query($sql);

                // Fetch all active vouchers once
                $voucher_sql = "SELECT * FROM tbl_vouchers 
                                    WHERE is_active = 1 
                                    AND (voucher_type = 'product' OR voucher_type = 'both')
                                    AND CURDATE() BETWEEN start_date AND end_date
                                    ";
                $voucher_result = mysqli_query($conn, $voucher_sql);

                // Store vouchers in an array for reuse
                $active_vouchers = [];
                if ($voucher_result && mysqli_num_rows($voucher_result) > 0) {
                    while ($voucher = mysqli_fetch_assoc($voucher_result)) {
                        $active_vouchers[] = $voucher;
                    }
                }

                if ($result->num_rows > 0) {
                    while ($data = $result->fetch_assoc()) {
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
                                    <div><?= isset($total_reviews) ? $total_reviews : 0 ?> reviews</div>
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
                <?php }
                } ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
<br><br><br>-->
<br><br><br>

    <!--<div class="claims-main-cont">
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
-->

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

    <div class="review-header-section">
        <h3 class="title-review">Real People, Real Stories</h3>
        <button class="write-review-btn" id="openReviewModal">
            <i class="fa-solid fa-pen"></i> Write a Review
        </button>
    </div>


    <div class="reviews-main-cont swiper">
        <div class="review-wrapper">
            <ul class="reviews-cont-list swiper-wrapper">
                <?php
                $query_reviews = "SELECT pr.*, td.first_name, td.last_name FROM tbl_page_reviews pr JOIN tbl_account_details td ON pr.account_id = td.ac_id WHERE pr.status = 'approved' ORDER BY pr.created_at DESC";
                $result_reviews = $conn->query($query_reviews);
                if ($result_reviews->num_rows > 0) {
                    while ($review = $result_reviews->fetch_assoc()) {
                ?>
                        <li class="reviews-cont <?php echo $result_reviews->num_rows >= 5 ? 'swiper-slide' : ''; ?>">
                            <div class="reviews-img">
                                <img src="../images/testimonials/<?php echo htmlspecialchars($review['reviewer_image']); ?>" alt="">
                            </div>
                            <div class="reviewer-details">
                                <div>
                                    <?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                                        <path id="star" d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                                    </svg>
                                </div>
                                <div>
                                    <?php
                                    $rating = (int)$review['rating'];
                                    echo $rating;
                                    ?>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                        <path id="verified_" data-name="verified " d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="reviewers-opinion">
                                "<?php echo htmlspecialchars($review['review_title']); ?>"
                            </div>
                            <div class="reviewers-description">
                                <?php echo htmlspecialchars($review['review_text']); ?>
                            </div>
                            <button class="read-more-btn"
                                data-reviewer-name="<?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?>"
                                data-reviewer-image="../images/testimonials/<?php echo htmlspecialchars($review['reviewer_image']); ?>"
                                data-rating="<?php echo (int)$review['rating']; ?>"
                                data-review-title="<?php echo htmlspecialchars($review['review_title']); ?>"
                                data-review-text="<?php echo htmlspecialchars($review['review_text']); ?>">
                                Read More
                            </button>
                        </li>
                <?php
                    }
                } else {
                    echo '<li class="no-reviews">No reviews found.</li>';
                }
                ?>
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="review-modal" id="readMoreModal">
        <div class="modal-content">
            <button class="modal-close" id="modalClose">&times;</button>
            <div class="modal-header">
                <img src="" alt="Reviewer" class="modal-reviewer-img" id="modalReviewerImg">
                <div class="modal-reviewer-info">
                    <h3 id="modalReviewerName"></h3>
                    <div class="modal-rating">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12.294" height="11.367" viewBox="0 0 12.294 11.367">
                            <path d="M8.147,11.135l3.8,2.232L10.937,9.161l3.356-2.83-4.42-.365L8.147,2,6.42,5.966,2,6.331l3.356,2.83L4.348,13.367Z" transform="translate(-2 -2)" fill="#ffc300" />
                        </svg>
                        <span id="modalRating"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M15.865,8.534,14.216,6.665l.23-2.472-2.439-.549L10.73,1.5l-2.3.978L6.135,1.5,4.858,3.637,2.419,4.18l.23,2.479L1,8.534,2.649,10.4l-.23,2.479,2.439.549,1.277,2.137,2.3-.985,2.3.978,1.277-2.137,2.439-.549-.23-2.472ZM7.142,11.7,4.574,9.144l1-.991L7.142,9.713l3.953-3.932,1,.991Z" transform="translate(-1 -1.5)" fill="#0082ff"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="modal-review-title" id="modalReviewTitle"></div>
            <div class="modal-review-text" id="modalReviewText"></div>
        </div>
    </div>
    <br><br>

    <div class="center-blog">
        <div class="blog-cont">
             <img src="..\images\blog\close-up-woman-with-acne-posing.jpg" alt="" class="blog-1">
            <p>January 5, 2026</p>
            <h1>Acne - Myths, Misconceptions and You</h1>
            <p class="desc">Research shows that nearly 98% of the general public harbors at least one erroneous belief about acne's causes and remedies. This extends to individuals directly affected, with studies reporting that over 80% of acne patients subscribe to at least one common myth.</p>
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
<br><br><br>
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
                                    $prodprice = $origprice;
                                    $subtotal = $data["prod_qnty"] * $prodprice;
                                    $total += $subtotal;

                                    $cartItems[] = [
                                        'prod_id' => $data['prod_id'],
                                        'subtotal' => $subtotal
                                    ];
                                }

                                // Calculate voucher discounts (only for eligible items)
                                $voucherEligibleTotal = 0;
                                $appliedVouchers = []; // Track applied vouchers for debugging

                                if ($resultVouchers->num_rows > 0) {
                                    mysqli_data_seek($resultVouchers, 0);
                                    while ($voucher = $resultVouchers->fetch_assoc()) {
                                        // Parse target items
                                        $targetItems = json_decode($voucher['target_items'], true);
                                        $eligibleProductIds = [];
                                        
                                        // Check if voucher applies to all products (empty target_items)
                                        $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null || count($targetItems) == 0);
                                        
                                        if ($applyToAll) {
                                            // Apply to ALL products in cart
                                            foreach ($cartItems as $cartItem) {
                                                $eligibleProductIds[] = $cartItem['prod_id'];
                                            }
                                        } else {
                                            // Extract eligible product IDs from target items
                                            if ($targetItems && is_array($targetItems)) {
                                                foreach ($targetItems as $item) {
                                                    if (isset($item['type']) && $item['type'] == 'product' && isset($item['id'])) {
                                                        $eligibleProductIds[] = intval($item['id']);
                                                    }
                                                }
                                            }
                                        }
                                        
                                        // Calculate subtotal for eligible items only
                                        $voucherSubtotal = 0;
                                        foreach ($cartItems as $cartItem) {
                                            // Check if this product is eligible for this voucher
                                            if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                                $voucherSubtotal += $cartItem['subtotal'];
                                            }
                                        }
                                        
                                        // Calculate discount based on eligible items only
                                        $currentDiscount = 0;
                                        if ($voucher['discount_type'] == 'percentage') {
                                            $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                            // Apply max discount cap if set
                                            if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                                $currentDiscount = $voucher['max_discount'];
                                            }
                                        } else {
                                            // Fixed amount discount
                                            $currentDiscount = min($voucher['discount_value'], $voucherSubtotal);
                                        }
                                        
                                        // Check minimum purchase requirement
                                        $meetsMinimum = ($total >= $voucher['min_purchase']);
                                        
                                        if ($meetsMinimum && $voucherSubtotal > 0) {
                                            $voucherDiscount += $currentDiscount;
                                            $voucherEligibleTotal += $voucherSubtotal;
                                            
                                            // Track applied voucher for debugging
                                            $appliedVouchers[] = [
                                                'name' => $voucher['voucher_name'],
                                                'eligible_subtotal' => $voucherSubtotal,
                                                'discount' => $currentDiscount,
                                                'eligible_products' => $eligibleProductIds
                                            ];
                                        }
                                    }
                                }
                                

                                // Display products
                                mysqli_data_seek($result, 0);
                                while ($data = $result->fetch_assoc()) {
                                    $origprice = $data['prod_price'] + 100;
                                    $prodprice = $origprice;
                                    $subtotal = $data["prod_qnty"] * $prodprice;
                                    
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
                                                    <div class="main-price"> ₱<?= number_format($prodprice, 2) ?> </div>
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
                                $targetItems = json_decode($voucher['target_items'], true);
                                $eligibleProductIds = [];

                                // Check if voucher applies to all products
                                $applyToAll = (empty($voucher['target_items']) || $voucher['target_items'] == '' || $voucher['target_items'] == '[]' || $targetItems === null || count($targetItems) == 0);

                                if ($applyToAll) {
                                    // Apply to ALL products in cart
                                    foreach ($cartItems as $cartItem) {
                                        $eligibleProductIds[] = $cartItem['prod_id'];
                                    }
                                } else {
                                    // Extract specific eligible products
                                    if ($targetItems && is_array($targetItems)) {
                                        foreach ($targetItems as $item) {
                                            if (isset($item['type']) && $item['type'] == 'product' && isset($item['id'])) {
                                                $eligibleProductIds[] = intval($item['id']);
                                            }
                                        }
                                    }
                                }

                                // Calculate subtotal for eligible items only
                                $voucherSubtotal = 0;
                                $eligibleProductNames = [];
                                foreach ($cartItems as $cartItem) {
                                    if (in_array($cartItem['prod_id'], $eligibleProductIds)) {
                                        $voucherSubtotal += $cartItem['subtotal'];
                                        // Get product name for display
                                        mysqli_data_seek($result, 0);
                                        while ($prod = $result->fetch_assoc()) {
                                            if ($prod['prod_id'] == $cartItem['prod_id']) {
                                                $eligibleProductNames[] = $prod['prod_name'];
                                                break;
                                            }
                                        }
                                    }
                                }
                                
                                // Calculate voucher discount
                                $currentDiscount = 0;
                                if ($voucher['discount_type'] == 'percentage') {
                                    $currentDiscount = ($voucherSubtotal * $voucher['discount_value']) / 100;
                                    if ($voucher['max_discount'] > 0 && $currentDiscount > $voucher['max_discount']) {
                                        $currentDiscount = $voucher['max_discount'];
                                    }
                                } else {
                                    $currentDiscount = min($voucher['discount_value'], $voucherSubtotal);
                                }

                                // Check minimum purchase requirement
                                $meetsMinimum = ($total >= $voucher['min_purchase']);
                                $hasEligibleItems = ($voucherSubtotal > 0);
                        ?>
                                <div class="item-cont-flex voucher-item" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-left: 4px solid #4a9f20ff; margin-bottom: 15px;">
                                    <div class="item-img-cont" style="background: #4a9f20ff; display: flex; align-items: center; justify-content: center; min-width: 70px;">
                                        <i class="fa-solid fa-ticket-simple" style="color: white; font-size: 40px;"></i>
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
                                        
                                        <!-- Show eligible items -->
                                        <?php if (!empty($eligibleProductNames)) { ?>
                                            <div class="voucher-eligible-items" style="font-size: 11px; color: #6c757d; margin-top: 5px;">
                                                <i class="fa-solid fa-box"></i> Applies to: <?= implode(', ', $eligibleProductNames) ?>
                                            </div>
                                            <div class="voucher-eligible-items" style="font-size: 11px; color: #6c757d; margin-top: 3px;">
                                                <i class="fa-solid fa-calculator"></i> Eligible items subtotal: ₱<?= number_format($voucherSubtotal, 2) ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="voucher-warning" style="background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px; margin-top: 8px; font-size: 11px;">
                                                <i class="fa-solid fa-exclamation-triangle"></i> No eligible items in cart
                                            </div>
                                        <?php } ?>
                                        
                                        <?php if (!$meetsMinimum) { ?>
                                            <div class="voucher-warning" style="background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px; margin-top: 8px; font-size: 11px;">
                                                <i class="fa-solid fa-exclamation-triangle"></i> Add ₱<?= number_format($voucher['min_purchase'] - $total, 2) ?> more to use this voucher
                                            </div>
                                        <?php } elseif ($hasEligibleItems) { ?>
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

                        // Calculate saved amount
                        $savedAmount = $voucherDiscount; // This is just voucher discount for now
                        // If you have product discounts, add them here too

                        // Calculate shipping fee (same logic as cart.php)
                        $shippingFee = 50; // Default shipping fee

                        // Calculate grand total BEFORE shipping to check if free shipping applies
                        $grandTotalBeforeShipping = $total - $voucherDiscount;
                        if ($grandTotalBeforeShipping < 0) {
                            $grandTotalBeforeShipping = 0;
                        }

                        // Apply free shipping if total before shipping is >= 500 (same logic as cart.php)
                        if ($grandTotalBeforeShipping >= 500) {
                            $shippingFee = 0;
                        }

                        // Calculate final grand total (WITH shipping fee)
                        $grandTotal = $grandTotalBeforeShipping + $shippingFee;
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
                                       <!--<div class="shipping-discount">
                                            <div>Shipping</div>
                                            <div>
                                                <?php 
                                                $shippingFee = ($grandTotal >= 500) ? 0 : 50;
                                                if ($shippingFee == 0) {
                                                    echo '<span style="text-decoration: line-through; color: black;">₱50</span> Free';
                                                } else {
                                                    echo '<span style="text-decoration: none !important;"> ₱' . number_format($shippingFee, 2) . '</span>';
                                                }
                                                ?>
                                            </div>
                                        </div>-->
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
                                        <!--<div class="secure-payment">
                                            <img src="../images/icons/icon-cart-safe-pay.png" alt="">
                                            <div>Safe and Secure Payment, Easy Return</div>
                                        </div>-->
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

    <!-- Review Modal -->
    <div id="reviewModal" class="review-modal" style="display: none;">
        <div class="review-modal-content">
            <span class="review-close">&times;</span>
            <h2>Write Your Review</h2>
            <form id="reviewForm" method="POST">
                <div class="form-group">
                    <label for="review_title">Review Title *</label>
                    <input type="text" id="review_title" name="review_title" required maxlength="100" placeholder="Sum up your experience">
                </div>

                <div class="form-group">
                    <label for="rating">Rating *</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5" title="5 stars">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" title="4 stars">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" title="3 stars">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" title="2 stars">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1" title="1 star">★</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="review_text">Your Review *</label>
                    <textarea id="review_text" name="review_text" rows="5" required maxlength="500" placeholder="Share your experience with us..."></textarea>
                    <small class="char-count">0/500 characters</small>
                </div>

                <div class="form-group">
                    <label for="reviewer_image">Profile Picture (Optional)</label>
                    <input type="file" id="reviewer_image" name="reviewer_image" accept="image/*">
                </div>

                <button type="submit" class="submit-review-btn">Submit Review</button>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../scripts/swiper.js"></script>
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

    <script>
        // Modal functionality
        const modal = document.getElementById('readMoreModal');
        const modalClose = document.getElementById('modalClose');
        const readMoreBtns = document.querySelectorAll('.read-more-btn');

        readMoreBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const reviewerName = this.getAttribute('data-reviewer-name');
                const reviewerImage = this.getAttribute('data-reviewer-image');
                const rating = this.getAttribute('data-rating');
                const reviewTitle = this.getAttribute('data-review-title');
                const reviewText = this.getAttribute('data-review-text');

                document.getElementById('modalReviewerImg').src = reviewerImage;
                document.getElementById('modalReviewerName').textContent = reviewerName;
                document.getElementById('modalRating').textContent = rating;
                document.getElementById('modalReviewTitle').textContent = `"${reviewTitle}"`;
                // Use innerText instead of textContent to preserve line breaks
                document.getElementById('modalReviewText').innerText = reviewText;

                modal.classList.add('active');
            });
        });

        modalClose.addEventListener('click', function() {
            modal.classList.remove('active');
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    </script>

    <script>
        // Review Modal Functionality
        $(document).ready(function() {
            const modal = $('#reviewModal');
            const btn = $('#openReviewModal');
            const span = $('.review-close');

            // Open modal
            btn.click(function() {
                <?php if (empty($_SESSION["user_id"])) { ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Login Required',
                        text: 'Please login to write a review',
                        confirmButtonColor: '#4a9f20ff'
                    });
                <?php } else { ?>
                    modal.fadeIn(300);
                <?php } ?>
            });

            // Close modal
            span.click(function() {
                modal.fadeOut(300);
            });

            $(window).click(function(event) {
                if (event.target == modal[0]) {
                    modal.fadeOut(300);
                }
            });

            // Character counter
            $('#review_text').on('input', function() {
                const length = $(this).val().length;
                $('.char-count').text(length + '/500 characters');
            });

            // Submit review
            $('#reviewForm').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);


                $.ajax({
                    url: '../backend/submit-review.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Close modal and reset form
                            modal.fadeOut(300);
                            $('#reviewForm')[0].reset();
                            $('.char-count').text('0/500 characters');

                            setTimeout(function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank you!',
                                    text: 'Your review has been submitted and is pending approval.',
                                    confirmButtonColor: '#4a9f20ff'
                                });
                            }, 500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to submit review. Please try again.',
                                confirmButtonColor: '#4a9f20ff'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonColor: '#4a9f20ff'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>