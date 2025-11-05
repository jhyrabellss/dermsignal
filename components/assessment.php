<?php
    session_start();
    if(!empty($_SESSION['user_id'])){
        session_abort();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/assessment.css">
    <link rel="stylesheet" href="../styles/cart.css">



</head>
<body>
<?php 

  if(empty($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
    }
?>
<?php include "../components/header.php"?>
  <div class="assessment-whole-cont">
      <div class="assessment-main-cont">
          <!-- Step 1: Skin Texture -->
        <div class="whole-cont-assessment step" id="step-1" >
          <div class="assessment-bar">
            <img src="https://images.thedermaco.com/Stepper%201.svg" alt="">
          </div>
          <div class="assessment-cont" >
              <h3>What is your Skin Texture?</h3>
              <h4>This helps us know the moisture content in your skin</h4>
  
              <div class="container-info" data-value="Oily">
                  <div class="image-type">
                      <div class="skin-type-img"><img src="../images/skin-type/oily.jpg" alt=""></div>
                      <div class="skin-type">Oily</div>
                  </div>
                  <div class="checkbox"></div>
              </div>
  
              <div class="container-info" data-value="Dry">
                  <div class="image-type">
                      <div class="skin-type-img"><img src="../images/skin-type/dry.jpeg" alt=""></div>
                      <div class="skin-type">Dry</div>
                  </div>
                  <div class="checkbox"></div>
              </div>
  
              <div class="container-info" data-value="Combination">
                  <div class="image-type">
                      <div class="skin-type-img"><img src="../images/skin-type/combination.webp" alt=""></div>
                      <div class="skin-type">Combination</div>
                  </div>
                  <div class="checkbox"></div>
              </div>
          </div>
        </div>

        <!--Step 2: Skin Type-->
        
        <div class="whole-cont-assessment step" id="step-2">
          <div class="previous-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30.071" height="30.071" viewBox="0 0 30.071 30.071"><defs><style>.a{fill:none;}.b{fill:#747474;}</style></defs><path class="a" d="M0,0H30.071V30.071H0Z"/><path class="b" d="M24.047,12.771H8.8l7-7L14.024,4,4,14.024,14.024,24.047,15.79,22.28l-6.991-7H24.047Z" transform="translate(1.012 1.012)"/></svg> 
          </div>
          <div class="assessment-bar">
            <img src="https://images.thedermaco.com/Stepper%202.svg" alt="">
          </div>
          <div class="assessment-cont">
              <h3>What is your Skin Type?</h3>
              <h4>This helps us with the right ingredients for your skin..</h4>
              <div class="container-info" data-value="Normal">
                <div class="image-type">
                    <div class="skin-type-img"><img src="../images/skin-type/normal.webp" alt=""></div>
                    <div class="skin-type">Normal</div>
                </div>
                <div class="checkbox"></div>
            </div>

            <div class="container-info" data-value="Sensitive">
                <div class="image-type">
                    <div class="skin-type-img"><img src="../images/skin-type/sensitive.jpg" alt=""></div>
                    <div class="skin-type">Sensitive</div>
                </div>
                <div class="checkbox"></div>
            </div>
              
          </div>
        </div>

        <!--Step 3:Understanding Concern-->
        <div class="whole-cont-assessment step" id="step-3">
          <div class="previous-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="30.071" height="30.071" viewBox="0 0 30.071 30.071"><defs><style>.a{fill:none;}.b{fill:#747474;}</style></defs><path class="a" d="M0,0H30.071V30.071H0Z"/><path class="b" d="M24.047,12.771H8.8l7-7L14.024,4,4,14.024,14.024,24.047,15.79,22.28l-6.991-7H24.047Z" transform="translate(1.012 1.012)"/></svg> 
          </div>
          <div class="assessment-bar">
            <img src="https://images.thedermaco.com/Stepper%203.svg" alt="">
          </div>

            <h3>Which of this describes your concern?</h3>
            <h4>Select Any One</h4>
            <a href="?concern_id=1">
                <div class="container-info" data-value="Acne">
                <div class="image-type">
                    <div class="skin-type-img"><img src="../images/skin-type/acne.jpg" alt=""></div>
                    <div class="info-details">
                    <div class="skin-type">Acne</div>
                        <div class="issue-details">A skin condition that occurs when the hair follicles under the skin become clogged</div>
                    </div>
                </div>
                <div class="checkbox"></div>
                </div>
            </a>

        <a href="?concern_id=3">
          <div class="container-info" data-value="Open Pores">
              <div class="image-type">
                  <div class="skin-type-img"><img src="../images/skin-type/open-pores.webp" alt=""></div>
                  <div class="info-details">
                  <div class="skin-type">Open Pores</div>
                    <div class="issue-details">A result of excess oil production, reduced elasticity, or thick hair follicles</div>
                  </div>       
              </div>
              <div class="checkbox"></div>
          </div>
        </a>

        <a href="?concern_id=4">
          <div class="container-info" data-value="Pigmentation">
            <div class="image-type">
                <div class="skin-type-img"><img src="../images/skin-type/pigmentation.jpeg" alt=""></div>
                <div class="info-details">
                <div class="skin-type">Pigmentation</div>
                  <div class="issue-details">A condition in which patches of skin become darker than surrounding skin.</div>
                </div>
            </div>
            <div class="checkbox"></div>
          </div>
        </a>

        <a href="?concern_id=2">
          <div class="container-info" data-value="Acne Scars">
            <div class="image-type">
                <div class="skin-type-img"><img src="../images/skin-type/acne-scars.webp" alt=""></div>
                <div class="info-details">
               <div class="skin-type">Acne Scars</div>
                  <div class="issue-details">A result of inflamed blemishes caused by clogged pores.</div>
                </div>
            </div>
                <div class="checkbox"></div>
            </div> 
          </div>
        </a>

        <div class="skin-analysis-cont step" id="step-4" data-value="analysis">
            <span class="retake-button">
              <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#279989"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path></svg>
              <div>Retake</div>
            </span>
            <div class="skin-analysis">
                <div class="skin-analysis-title">
                    <h3>Here is your Personalized Skincare Regime</h3>
                </div>
            </div>
            
            <div>
              
            </div>
              <div class="concern-analysis">
                    <div class="issue-concerns-cont">
                        <div class="issue-concerns">Concern:</div>
                        <div  class="concern-issue"></div>
                    </div>
                    <div class="issue-concerns-cont">
                        <div class="issue-concerns">Skin Texture:</div>
                        <div class="skin-texture-issue"></div>
                    </div>
                    <div class="issue-concerns-cont">
                        <div class="issue-concerns">Skin Type:</div>
                        <div class="skin-type-issue"></div>
                    </div>
                </div>

            <div class="reco-product-main-cont" >
              <div class="reco-product-cont">
                <h3>Here's what we recommend for you</h3>
                
                <div class="consumer-feedback">89% of consumers said they saw visible action in active acne after using this regimen</div>
                <div  class="product-reco-main-cont">

                <div class="product-reco-cont-parent">
                <?php
                  if (isset($_GET['concern_id'])) {
                      $concern_id = isset($_GET['concern_id']) ? intval($_GET['concern_id']) : 1;

                      $sql = "SELECT tbl_products.*
                      FROM tbl_products
                      JOIN tbl_concern ON tbl_products.concern_id = tbl_concern.concern_id
                      WHERE tbl_concern.concern_id = ? LIMIT 2";

                      $stmt = $conn->prepare($sql);
                      $stmt->bind_param("i", $concern_id);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      
                      if($result->num_rows){
                          while($row = $result->fetch_assoc()){
                              $prodprice = $row['prod_price'];
                              
                              // Check if there's an active voucher that applies to this product
                              $voucher_sql = "SELECT v.*, cv.cart_voucher_id 
                                            FROM tbl_cart_vouchers cv
                                            JOIN tbl_vouchers v ON cv.voucher_id = v.voucher_id
                                            WHERE cv.account_id = ? 
                                            AND cv.status_id = 1
                                            AND v.is_active = 1
                                            AND v.start_date <= CURDATE()
                                            AND v.end_date >= CURDATE()
                                            AND (v.voucher_type = 'product' OR v.voucher_type = 'both')
                                            ORDER BY cv.added_date DESC
                                            LIMIT 1";
                              
                              $voucher_stmt = $conn->prepare($voucher_sql);
                              $voucher_stmt->bind_param("i", $_SESSION['user_id']);
                              $voucher_stmt->execute();
                              $voucher_result = $voucher_stmt->get_result();
                              
                              $discount_amount = 0;
                              $has_voucher = false;
                              
                              if($voucher_result->num_rows > 0) {
                                  $voucher = $voucher_result->fetch_assoc();
                                  
                                  // Check if this product is in target_items
                                  $target_items = json_decode($voucher['target_items'], true);
                                  $product_in_voucher = false;
                                  
                                  if($target_items) {
                                      foreach($target_items as $item) {
                                          if($item['type'] == 'product' && $item['id'] == $row['prod_id']) {
                                              $product_in_voucher = true;
                                              break;
                                          }
                                      }
                                  }
                                  
                                  if($product_in_voucher) {
                                      $has_voucher = true;
                                      if($voucher['discount_type'] == 'percentage') {
                                          $discount_amount = ($prodprice * $voucher['discount_value']) / 100;
                                          if($voucher['max_discount'] && $discount_amount > $voucher['max_discount']) {
                                              $discount_amount = $voucher['max_discount'];
                                          }
                                      } else {
                                          $discount_amount = $voucher['discount_value'];
                                      }
                                  }
                              }
                              
                              $final_price = $prodprice - $discount_amount;
                  ?>   
                      <div class="product-reco-cont">
                          <div class="product-image img-con-click" data-item-id="<?= $row['prod_id']?>">
                              <img src="../images/products/<?= $row['prod_img']?>" alt="">
                          </div>
                          <div class="product-details">
                              <div class="product-name"><?= $row['prod_name']?></div>
                              <div class="product-description"><?= $row['prod-short-desc'] ?></div>
                              <div class="price-cont">
                                  <?php if($has_voucher && $discount_amount > 0): ?>
                                      <div class="product-price">₱<?= number_format($final_price, 2) ?></div>
                                      <div style="text-decoration: line-through; color: gray;">₱<?= number_format($prodprice, 2) ?></div>
                                      <div class="discount-off"><?= number_format(($discount_amount / $prodprice) * 100, 0) ?>% off</div>
                                  <?php else: ?>
                                      <div class="product-price">₱<?= number_format($prodprice, 2) ?></div>
                                  <?php endif; ?>
                              </div>
                          </div>
                      </div>
                      <div class="benefits-cont">
                      <?php
                          if (!function_exists('getFirstTwoSentences')) {
                              function getFirstTwoSentences($text) {
                                  $sentences = preg_split('/(?<=[.!?])\s+/', $text);
                                  $firstTwoSentences = array_slice($sentences, 0, 2);
                                  $shortText = implode(' ', $firstTwoSentences);
                                  if (strlen($shortText) > 120) {
                                      $shortText = substr($shortText, 0, 120) . '...';
                                  }
                                  return $shortText;
                              }
                          }
                          $text = $row['prod_description'];
                          $shorthandText = getFirstTwoSentences($text);
                      ?>
                          <div><?= $shorthandText ?></div>
                      </div>
                  <?php 
                          } 
                      } 
                  }
                  ?>
                </div>
                </div>
              </div>
              
            </div>
          

          <h2 class="faq-title">Frequently Asked Questions</h2>
          <p class="faq-subtitle">Find answers to common questions about our skin assessment and products</p>
          <div class="faqs-main-cont">
              <div class="faqs-cont">
                  <details> 
                    <summary> <h1>Is The Skin Assessment Test Chargeable?</h1> </summary>
                    <p>No. The Skin Assessment Test by The Derma Co. </p>
                  </details>

                  <details>
                    <summary> <h1>How Can I Take This Test? </h1> </summary>
                    <p> Visit our website (https://thedermaco.com/) and click on ‘Free Skin Assessment’ at the top. Enter your personal details and begin the test. The initial steps involve choosing your skin concern and texture. Once these are selected, you’ll get a customized regimen based on your skin type and concern.</p>
                  </details>

                  <details>
                    <summary> <h1>What Is the Purpose of the Skin Assessment Test? </h1> </summary>
                    <p> The purpose of our Skin Assessment Test is to treat your skin concern by offering you a personalized regimen that’s designed just for you. The products recommended are targeted at your skin concern and offer a visible difference in 3-6 weeks.</p>
                  </details>

                  <details> 
                    <summary> <h1>Why Should I Trust the Regimen Recommended In the Test?</h1> </summary>
                    <p>Your skin is our priority. Hence, we leave no stone unturned in keeping it healthy and free from concerns. The customized regimen suggested in the test is safe, effective, backed by science, and recommended by dermatologists.</p>
                  </details>

                  <details>
                    <summary><h1>Will I Get A Common Regimen for All My Skin Problems?</h1></summary>
                    <p> Absolutely not! Our skin assessment test is designed to give you a personalized regimen depending on your skin type and concern. In case of multiple skin issues, take the skin assessment test multiple times by entering one skin problem at a time.</p>
                  </details>

                  <details> 
                    <summary> <h1>Why Shouldn’t I Visit A Dermatologist Instead of Taking this Test?</h1> </summary>
                    <p>There are several benefits of taking our skin assessment test. It is free and you get a personalized skincare regimen specially created for your skin type. All this from the comfort of your home!</p>
                  </details>
                  <details> 
                    <summary> <h1> What Should Be the Order of my Skincare Regimen Recommended in the Test? </h1> </summary>
                    <p>For any skincare regimen recommended to you in the test, apply the products in the below order: i) Face Wash ii) Serum iii) Toner iv) Moisturizer v) Sunscreen </p>
                  </details>

                  <details> 
                    <summary> <h1>When Can I Expect the Results? </h1></summary>
                    <p>All our products take roughly 3-6 weeks to show visible results. However, there are no shortcuts in treating skin concerns, hence we suggest using the products in continuation for at least 3 months for better results. </p>
                  </details>

                  <details>
                    <summary>  <h1>Are the Products Recommended in the Test tested by Dermatologists?</h1> </summary>
                    <p>Yes! All our products are backed by science and tested by Dermatologists. </p>
                  </details>

                  <details> 
                    <summary> <h1>Will the Products In My Regimen Cause Any Side Effects?</h1> </summary>
                    <p>No. However, in the case of formulations consisting of highly potent ingredients, you might feel a tingling sensation or redness. Hence, we advise our customers to perform a patch test before applying the product to their faces.</p>
                  </details>
              </div>
          </div>

        </div>    

        <div class="main-cart-cont" id="main-cart-cont">
          <div class="cart-cont" id="cart-cont">
              <div class="my-cart-title" id="my-cart-title">
                  <div class="exit">
                  <svg  xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7071 4.29289C12.0976 4.68342 12.0976 5.31658 11.7071 5.70711L6.41421 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H6.41421L11.7071 18.2929C12.0976 18.6834 12.0976 19.3166 11.7071 19.7071C11.3166 20.0976 10.6834 20.0976 10.2929 19.7071L3.29289 12.7071C3.10536 12.5196 3 12.2652 3 12C3 11.7348 3.10536 11.4804 3.29289 11.2929L10.2929 4.29289C10.6834 3.90237 11.3166 3.90237 11.7071 4.29289Z" fill="#000000"/>
                      </svg>
                  </div>
                  <h1>
                      My Cart
                  </h1>
              </div>
              <div class="whole-cont-display"> 
                  <div  class="whole-item-cont" id="whole-item-cont">
                      <div class="order-summary-header">
                          Order Sumarry
                      </div>
                      <div class="item-cont" id="item-cont">
                          <div class="item-cont-flex">
                              <div class="item-img-cont">
                                      <img src="../images/PLaceholder/sunscreen_monsoon_creatives_redeen35_website_3847f6c387.jpg" alt="">
                              </div>
                              <div class="item-details">
                                      <p class="item-name">1% Hyaluronic Sunscreen Aqua Gel with SPF 50 &amp; PA++++ - 80g</p>
                                      <div class="item-classification">Lightweight &amp; Quick Absorbing | No White Cast</div>
                                      <div class="item-prices">
                                          <div class="prices-cont">
                                              <div class="main-price">$ 558</div>
                                              <div class="discounted-price"> $ 640</div>
                                              <div class="discounted-price-percent">14% off</div>
                                          </div>
                                          <div class="quantity-buttons">
                                              <button class="decrement-button" > - </button>
                                              <div class="count"> 1 </div> 
                                              <button class="increment-button"> + </button>
                                          </div>
                                      </div>
                                  </div>
                          </div>
                      </div>
                  </div>
  
                
  
                  <div>
                  <div class="cart-details" id="cart-details">
                  <div class="apply-offers-cont">
                      <div class="apply-offers">
                          <svg id="tabler-icon-discount-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path id="Path_31915" data-name="Path 31915" d="M0,0H24V24H0Z" fill="none"></path><line id="Line_342" data-name="Line 342" y1="6" x2="6" transform="translate(9 9)" fill="none" stroke="#279989" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></line><circle id="Ellipse_795" data-name="Ellipse 795" cx="0.5" cy="0.5" r="0.5" transform="translate(9 9)" stroke="#279989" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle><circle id="Ellipse_796" data-name="Ellipse 796" cx="0.5" cy="0.5" r="0.5" transform="translate(14 14)" stroke="#279989" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle><path id="Path_31916" data-name="Path 31916" d="M5,7.2A2.2,2.2,0,0,1,7.2,5h1a2.2,2.2,0,0,0,1.55-.64l.7-.7a2.2,2.2,0,0,1,3.12,0l.7.7A2.2,2.2,0,0,0,15.82,5h1a2.2,2.2,0,0,1,2.2,2.2v1a2.2,2.2,0,0,0,.64,1.55l.7.7a2.2,2.2,0,0,1,0,3.12l-.7.7a2.2,2.2,0,0,0-.64,1.55v1a2.2,2.2,0,0,1-2.2,2.2h-1a2.2,2.2,0,0,0-1.55.64l-.7.7a2.2,2.2,0,0,1-3.12,0l-.7-.7a2.2,2.2,0,0,0-1.55-.64h-1A2.2,2.2,0,0,1,5,16.82v-1a2.2,2.2,0,0,0-.64-1.55l-.7-.7a2.2,2.2,0,0,1,0-3.12l.7-.7A2.2,2.2,0,0,0,5,8.2v-1" fill="none" stroke="#279989" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                          <div>APPLY OFFERS</div>
                      </div>  
                      <div>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="1.5rem" width="1.5rem" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>    
                      </div>
                  </div>
                  <div class="saved-amount-cont">
                      <div class="saved-amount">
                          <div>
                              You saved <span></span> on this order
                          </div>
                          <div>
                              You will get $ 41.70 cashback after delivery
                          </div>
                      </div>
                  </div >
                  <div class="price-summary-cont">
                      <div>
                              <div class="price-summary">
                                  Price Summary 
                              </div>
                              <div class="order-total">
                                  <div>Order Total</div>
                                  <div>$499.00</div>
                              </div>
                              <div class="items-discount">
                                  <div>Items Discount</div>
                                  <div></div>
                              </div>
                              <div class="shipping-discount">
                                  <div>Shipping</div>
                                  <div> <span style="text-decoration: line-through; color: black;">$40</span> Free</div>
                              </div>
                              <div class="online-payment-discount">
                                  <div>5% online payment discount</div>
                                  <div>-$43.90</div>
                              </div>
                              <div class="grand-total">
                                  <div>Grand Total</div>
                                  <div>$499.00</div>
                              </div>
                              <div class="secure-payment">
                                  <img src="../images/dlf2x.png" alt="">
                                  <div>Safe and Secure Payment, Easy Return</div>
                              </div>
                      </div>
                  </div>
                  </div>
                  
                  <div class="checkout-button-cont" id="checkout-button-cont">
                      <div class="item-details-price">
                          <div>$830.10</div>
                          <div>View Details</div>
                      </div>
                      <a href="/components/checkout.html">
                        <button>Checkout</button>
                      </a>
                  </div>
                  </div>
              </div>
                    <div class="empty-cont" id="empty-cont">
                      <div class="empty-cont-img">
                          <img src="../images/dermaco_bag_desktop.png" alt="">
                      </div>
                      <div class="empty-cart-text">
                          Your Cart is empty !
                      </div>
                      <div>
                          It's a good day  to buy the items you saved for later
                      </div>
                      <div class="shop-now-cont">
                        <a href="../components/all-products.html">
                          <button class="shop-now">Shop Now</button>
                        </a>
                      </div>
                  </div>
          </div>
  
      </div>
      </div>
          <!-- Submit Button -->
          <div id="submit-step" style="display:none;">
              <button id="submit-btn">Submit</button>
          </div>
  
          <div id="recommendation" style="display:none;">
              <h3>Recommended Product:</h3>
              <p id="product-output"></p>
          </div>
      </div>
  </div>



</body>
<script>
   const details = document.querySelectorAll('details');

  details.forEach(detail => {
    detail.addEventListener('toggle', () => {
      const summary = detail.querySelector('summary');
      if (detail.open) {
        summary.classList.add('summary-left-arrow');
      } else {
        summary.classList.remove('summary-left-arrow') // Reset background color when closed
      }
    });
  });
</script>

<script>
     $('.img-con-click').click(function() {
        var itemId = $(this).data("item-id");
        const url = `../components/individual-product.php?item=${itemId}`;
        window.location.href = url;
    });
</script>
<script src="../scripts/assessment.js"></script>
<script src="../scripts/cart.js"></script>
</html>