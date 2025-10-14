

<?php
    session_start();
    if(empty($_SESSION["user_id"])){
        header("Location: ../index.php");
        exit();
    }
    else{
        session_abort();
    }
?>  
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" href="../styles/profile.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/cart.css">
    <link rel="stylesheet" href="../styles/processed.css">
    <script src="../jquery/jquery.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
   </head>
<body>

<?php include "./header.php" ?>
<?php
    $acc_id = $_SESSION["user_id"];
?>
    

<div class="profile-main-cont">

  <?php
    $query = "SELECT tc.*, tp.*, ts.status_name
    FROM tbl_cart tc
    JOIN tbl_products tp ON tc.prod_id = tp.prod_id
    JOIN tbl_status ts ON tc.status_id = ts.status_id
    WHERE tc.account_id = ? AND tc.status_id IN (3, 4, 6)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",  $acc_id);
    $stmt->execute();   
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $total = 0;
        $subtotalOnly = 0;
    ?>
    <main>
        <div class="center" style="flex-direction: column; align-items:end;">
            <a href="../components/history.php"><div class="order-status">Order History</div></a>
            <div class="div">
                <div class="left-con">
                    <div class="cart-con">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($data = $result->fetch_assoc()) {
                                    $subtotal = round($data["prod_qnty"] * $data["prod_price"], 2);
                                    $total += $subtotal;
                                    $subtotalOnly += round($data["prod_price"], 2);
                                ?>
                                <tr>
                                    <td>
                                        <div class="img-con">
                                        <img src="../assets/<?php echo $formattedTypeName; ?>/<?php echo $data["prod_img"]; ?>" alt="">
                                        </div>
                                    </td>
                                    <td><?php echo $data["prod_name"]; ?></td>
                                    <td>₱<?php echo number_format($data["prod_price"], 2); ?></td>
                                    <td>
                                        <div class="qnty-td">
                                            <div class="qnty-js"><?php echo $data["prod_qnty"]; ?></div>   
                                        </div>
                                    </td>
                                    <td class="total-price-js">₱<span class="subtotal-js"><?php echo number_format($subtotal, 2); ?></span></td>
                                    <td><?php echo $data["status_name"]; ?></td>
                                    <?php 
                                    if ($data["status_id"] == 3) {
                                    ?>
                                    <td class="delete-js" id="<?php echo $data["prod_id"]; ?>"><i class="fa-solid fa-x"></i></td>
                                    <?php }else{ ?>
                                        <td></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="right-con">
                    <div class="total-con">
                        <h1>Order totals</h1>
                        <div class="price-div">
                            <div class="text">
                                <div>Subtotal/Item:</div>
                                <span class="text-price">₱<?php echo number_format($subtotalOnly, 2); ?></span>
                            </div>
                            <div class="text">
                                <div>Total:</div>
                                <div class="text-total">₱<?php echo number_format($total, 2); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    } else {
    ?>
        <div class="no-products-message">
            <p>No products available at the moment.</p>
        </div>
    <?php } ?>
</div>



  <?php
  if((!empty($_SESSION["user_id"]))) {
    include "cart.php";
  }
  ?>

  <script src="../jquery/updateProfile.js"></script>
  <script src="../jquery/checkout.js"></script>
</body>
</html>