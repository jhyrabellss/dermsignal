<?php
require_once("../backend/config/config.php");
session_start();
?>
<?php

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

<?php

        $query1 = "
        SELECT 
            details.ac_id, details.first_name, details.middle_name, details.last_name, 
            details.contact, details.address, account.ac_email 
        FROM tbl_account_details AS details
        INNER JOIN tbl_account AS account ON details.ac_id = account.ac_id
        WHERE details.ac_id = ?
        ";

        $statement = $conn->prepare($query1);
        $statement->bind_param("i", $current_user);
        $statement->execute();
        $resultSet = $statement->get_result();

        if ($resultSet->num_rows > 0) {
        // Fetch and output user details in JSON format
        $userData = $resultSet->fetch_assoc();

        } else {
        echo json_encode(["message" => "No user found"]);
        }

?>

<html lang="en"><head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../styles/checkout.css">
  <link rel="stylesheet" href="../styles/general-styles.css">
  <link rel="stylesheet" href="../styles/footer.css">
  <script src="../jquery/jquery.js"></script>
  <script src="../scripts/sweetalert.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    .modal-body form{
        width: 90% !important;
    }
  </style>
</head>
<body>
  <nav>
      <a href="../index.php">
        <div class="nav-logo">
            <img src="../images/icons/logo-no-bg.png" alt="">
        </div> 
      </a> 
  </nav>
<div class="checkout-combined-cont">
  <div class="checkout-main-cont">
    <div class="form-cont">
    <form id="billingForm" method="POST">
    <div class="contact-input">
        <div>
            <h3>Contact</h3>
        </div>
    </div>
    <div class="log-in-status"></div>
    <!-- Email input -->
    <div>
        <input type="email" name="email" placeholder="Email" value="<?= $userData['ac_email'] ?>" required id="email">
    </div>
    <div class="delivery-input">
        <h3>Delivery</h3>
    </div>
    <div class="form-delivery">
        <!-- Radio buttons (no validation for now) -->
        <div class="radio-input-cont" data-form-id="1">
            <div>Ship</div>
        </div>
        <div class="radio-input-cont" id="location" data-form-id="2">
            <div>Pick up</div>
        </div>
    </div>

    <div class="store-location-cont">
        <div>
            Store location
        </div>

        <div class="main-location">
            <div>
                <div class="current-loc" style="font-weight: 500; font-size: 13px;">
                    Derm Signal Skin Care Clinic(5.8 km)
                </div>
                <div>
                    63e Katipunan Ave, Quezon City, Metro Manila, PH-00
                </div>
            </div>
            <div>
                <div style="text-align: end;">Free</div>
                <div>Usually ready in 2-4 days</div>
            </div>
        </div>
    </div>
    <div class="loc-status"></div>

    <div class="billing-address">
        <h3>Billing Address</h3>
    </div>
    <div class="name-input">
        <!-- Name inputs -->
        <div>
            <input type="text" name="first_name" placeholder="First Name" id="fname"  value="<?= $userData['first_name'] ?>" required>
        </div>
        <div>
            <input type="text" name="last_name" placeholder="Last Name" id="lname" value="<?= $userData['last_name'] ?>" required>
        </div>
    </div>
    <!-- Address inputs -->
    <div>
        <div>
            <input type="text" name="unit_number" placeholder="Unit Number, Building, Street Name, etc." id="unit_number" required>
        </div>
    </div>
    <div>
        <input type="text" name="barangay" placeholder="Barangay" id="barangay" required>
    </div>
    <!-- City and postal code inputs -->
    <div class="city-info">
        <div>
            <input type="text" name="postal_code" placeholder="Postal Code" id="postal_code" required>
        </div>
        <div>
            <input type="text" name="city" placeholder="City" id="city" required>
        </div>
    </div>
    <!-- Region and phone number -->
    <div class="select-region">
        <select name="region" id="region" required>
            <option value="1" disabled>Region</option>
            <option value="Region 2">Region 2</option>
            <option value="Region 3">Region 3</option>
            <option value="Region 4">Region 4</option>
            <option value="Region 5">Region 5</option>
            <option value="Region 6">Region 6</option>
            <option value="Region 7">Region 7</option>
            <option value="Region 8">Region 8</option>
            <option value="Region 9">Region 9</option>
            <option value="Region 10">Region 10</option>
            <option value="Region 11">Region 11</option>
            <option value="Region 12">Region 12</option>
            <option value="Region 13">Region 13</option>
        </select>
    </div>
    <div>
        <input type="number" name="phone_number" placeholder="Phone (optional)" id="phone_number" >
    </div>

    <div class="billing-address">
        <h3 class="payment">Payment</h3>
    </div>
    <div class="all-transact">All transactions are secure and encrypted</div>
    <div class="form-payment-active">
        <div class="form-payment payment-option" data-payment-id="1" >
            <div>Gcash</div>
        </div>
        <div class="payment-disclaimer">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-252.3 356.1 163 80.9" class="zjrzY">
                    <path fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M-108.9 404.1v30c0 1.1-.9 2-2 2H-231c-1.1 0-2-.9-2-2v-75c0-1.1.9-2 2-2h120.1c1.1 0 2 .9 2 2v37m-124.1-29h124.1"></path>
                    <circle cx="-227.8" cy="361.9" r="1.8" fill="currentColor"></circle>
                    <circle cx="-222.2" cy="361.9" r="1.8" fill="currentColor"></circle>
                    <circle cx="-216.6" cy="361.9" r="1.8" fill="currentColor"></circle>
                    <path fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M-128.7 400.1H-92m-3.6-4.1 4 4.1-4 4.1"></path>
                </svg>
            </div>
            <div>
                <div>After clicking “Pay now”, you will be redirected to GCash to complete your purchase securely.</div>
            </div>
        </div>
    </div>

    <button type="button" type="button" class="btn btn-secondary pay-now" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="submitForm">Pay Now</button>
</form>
    </div>
    
  </div>


  <div class="checkout-item-cont">
    <div class="checkout-overall">
         <?php 
                if ($result->num_rows > 0) {
                    $total = 0;
                    $subtotalOnly = 0;
                    $itemDisc = 100;
                    $shippingDisc = 40;
                while ($data = $result->fetch_assoc()) {
                $subtotal = round($data["prod_qnty"] * $data["prod_price"], 2);
                $total += $subtotal;
                $subtotalOnly += round($data["prod_price"], 2);
                $origprice = $data['prod_price'] + 100; // Adjusted original price
                $proddiscount = $data['prod_discount'] / 100;
                $prodprice = $origprice - ($origprice * $proddiscount); // Calculate discounted price
                $discprice = $data['prod_discount']; // Convert to percentage for display  
                $onlineDisc = $total * 0.05; 
                $grandTotal = $total - $onlineDisc;
          ?>    
            <div class="checkout-item-details">
                <div class="item-img-cont">
                    <img src="../images/products/<?= $data['prod_img'] ?>" alt="">
                    <span class="item-quantity"><?= $data["prod_qnty"] ?></span>
                </div>
                <div class="item-name"><?= $data['prod_name'] ?></div>
                <div class="item-price"> ₱<?=  number_format($prodprice, 2)?></div>
            </div>
        <?php } ?>
        <div style="display: flex; justify-content:center; font-weight:bold; font-size:15px">Discount Applied!</div>
    </div>
    <div class="checkout-subtotal">
    <?php if(!empty($_SESSION["user_id"])){ 
                $query = "SELECT COUNT(*) AS CountItems FROM tbl_cart WHERE status_id = 1 and account_id = ?;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
            ?>
        <div class="all-quantity"> Subtotal • <?= $data['CountItems'] ?> items</div>
    <?php }?>
        <div class="total-price"> ₱<?= number_format($grandTotal, 2) ?></div>
    </div>

    <div class="checkout-shipping">
        <div> Clinic checkout </div>
        <div> Free </div>
    </div>

    <div class="checkout-total">
        <div> Total </div>
        <div class="grand-total-price"> <span>₱</span> <?= number_format($grandTotal, 2) ?></div>
    </div>
  </div>

  <?php }else{  ?>
        <div>Nothing on cart</div>
  <?php }?>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Receipt Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="display: flex; justify-content:center;">
                    <form>
                    <div class="mb-3">
                        <label class="col-form-label">Total Amount:</label>
                        <input type="text" disabled id="overAllTotal" class="font-weight-bold" value="₱<?php echo number_format($grandTotal, 2); ?>">
                    </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload Your Receipt:</label>
                            <input type="file" class="form-control-file" id="receiptFile">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Reference Number</label>
                            <input type="text" class="form-control" id="refNumber" maxlength="13"
                            placeholder="xxxxxxxxxxxxx">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Deposit Amount:</label>
                            <input type="text" class="form-control" id="depAmount" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                        <div class="img-con" style="justify-content: center;">
                            <label class="col-form-label">Send Your Payment Here:</label>
                            <img src="../images/icons/qr-cash.jpg" alt="" style="object-fit: contain; width:100%; heigth:100%;">
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary proceed-btn">Proceed</button>
                </div>
            </div>
        </div>
    </div>



<!-- Your form and HTML content here -->

<script>
   const formPaymentActive = document.querySelector('.form-payment-active')

   formPaymentActive.addEventListener('click', () =>{
     formPaymentActive.classList.toggle('open')
   })

  
   
</script>
<script>
     function validateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com|hotmail\.com)$/;
    return emailPattern.test(email);
}

$(document).ready(() => {
    let deliveryType = null;
    let paymentType = null;

    // Handle delivery type selection
    $(".form-delivery .radio-input-cont").on("click", function () {
        deliveryType = $(this).data("form-id"); // Get data-prod-id
        console.log("Selected delivery type:", deliveryType);
    });

    // Handle payment type selection
    $(document).ready(() => {
    $(".form-payment-active").on("click", ".payment-option", function () {
        paymentType = $(this).data("payment-id"); // Get data-payment-id
        console.log("Selected payment type:", paymentType);

        // Optionally highlight the selected payment option
        $(".form-payment .payment-option").removeClass("selected"); // Deselect others
        $(this).addClass("selected"); // Highlight selected
    });
});

    $(".pay-now").on("click", function (event) {
        event.preventDefault();

        const email = $('#email').val();
        const fname = $('#fname').val();
        const lname = $('#lname').val();
        const unit_number = $('#unit_number').val();
        const barangay = $('#barangay').val();
        const postal_code = $('#postal_code').val();
        const city = $('#city').val();
        const region = $('#region').val();
        const phone_number = $('#phone_number').val();

        // Validation for required fields
        if (!email || !fname || !lname || !unit_number || !barangay || !postal_code || !city || !region){
            Swal.fire({
                title: "Empty Field!",
                text: "Make sure all required fields are filled.",
            });
            return;
        }

        // Validate email format
        if (!validateEmail(email)) {
            Swal.fire({
                title: "Invalid Email!",
                text: "Please enter a valid email address from gmail.com, yahoo.com, etc.",
            });
            return;
        }

        // Validate delivery and payment selections
        if (!deliveryType) {
            Swal.fire({
                title: "Delivery Method Missing!",
                text: "Please select a delivery method.",
            });
            return;
        }

        if (!paymentType) {
            Swal.fire({
                title: "Payment Method Missing!",
                text: "Please select a payment method.",
            });
            return;
        }

        // AJAX request to save billing details
        $.ajax({
            url: "../backend/user/billing.php",
            method: "POST",
            data: {
                email,
                first_name: fname,
                last_name: lname,
                unit_number,
                barangay,
                postal_code,
                city,
                region,
                phone_number,
                payment_type_id: paymentType,
                delivery_type_id: deliveryType
            },
            success: (response) => {
                const res = JSON.parse(response);
                if (res.success) {
                    Swal.fire({
                        title: "Billing Saved!",
                        text: "Your billing details have been successfully saved.",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //window.location.href = '../components/profile.php'
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: res.message || "An error occurred while saving the billing details.",
                    });
                }
            },
            error: () => {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to connect to the server.",
                });
            }
        });
    });
});

</script>
<script src="../scripts/checkout.js"></script>
<script src="../jquery/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</body></html>