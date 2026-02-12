<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/blog.css">
    <link rel="stylesheet" href="../styles/cart.css">   
    <link rel="stylesheet" href="../styles/dropdown.css">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/login-signup-popup.css">
    <link rel="stylesheet" href="../styles/footer.css">

    

    <style>
        .head1{
            text-align: center;
            font-size: 32px;
            font-weight: 500;
            color: rgb(89, 89, 89);
        }

        .blogs{
            margin-top: 50px;
        }

        .center-blog{
            margin-bottom: 60px;
        }

       .desc {
  color: rgb(79, 78, 78);
}
        
    </style>
   
    <title>DermSignal Blog</title>
</head>
<body>
<?php include "../components/header.php" ?>
    <div class="blogs">
        <!--<h1 class="head1">DermSignal Blog</h1>-->
    </div>
    
    <div class="center-blog">
        <div class="blog-cont">
            <img src="..\images\blog\close-up-woman-with-acne-posing.jpg" alt="" class="blog-1">
            <p>JANUARY 5, 2026</p>
            <h1>Acne - Myths, Misconceptions and You</h1>
            <p class="desc">Research shows that nearly 98% of the general public harbors at least one erroneous belief about acne's causes and remedies. This extends to individuals directly affected, with studies reporting that over 80% of acne patients subscribe to at least one common myth.</p>
            <a href="./blog-1.php">Read more</a>
        </div>

        <div class="blog-cont">
            <img src="../images/blog/2.jpg" alt="" class="blog-1">
            <p>FEBRUARY 26, 2024</p>
            <h1>The Cycle: Managing Hormonal Jawline Acne</h1>
            <p class="desc">If you notice deep, cystic bumps along your jawline and chin that flare up like clockwork every month, you are likely dealing with hormonal acne. Unlike surface-level whiteheads caused by external dirt, hormonal breakouts are driven by internal fluctuations in androgens which increase sebum viscosity.</p>
            <a href="./blog-2.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/3.jpg" alt="" class="blog-1">
            <p>MARCH 1, 2024</p>
            <h1>Vitamin C: The Secret to...</h1>
            <p class="desc">Post-Inflammatory Hyperpigmentation (PIH) can be more frustrating than the acne itself. Vitamin C is a potent antioxidant that inhibits tyrosinase, the enzyme responsible for melanin production. However, not all Vitamin C is created equal. </p>
            <a href="./blog-3.php">Read more</a>
        </div>

        <div class="blog-cont">
            <img src="../images/blog/4.jpg" alt="" class="blog-1">
            <p>APRIL 13, 2024</p>
            <h1>Can You Really "Shrink" Yo...</h1>
            <p class="desc">One of the most common misconceptions in skincare is that pores open and close like windows. In reality, pores do not have muscles; their size is largely determined by gene... </p>
            <a href="./blog-4.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/5.jpg" alt="" class="blog-1">
            <p>APRIL 11, 2024</p>
            <h1>Niacinamide: The Multi-Tasking Pow...</h1>
            <p class="desc">If you could only use one "active" besides sunscreen, Niacinamide (Vitamin B3) would be the top contender. Unlike many harsh acids, Niacinamide is incredibly well-tolerated and addresses multiple concerns simultaneously. </p>
            <a href="./blog-5.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/6.jpg" alt="" class="blog-1">
            <p>APRIL 9, 2024</p>
            <h1>SPF 101: Why Your Sunscre...</h1>
            <p class="desc">Many Filipinos believe that a high SPF number is a "shield" that lasts all day, but the reality is more complex. SPF primarily measures UVB protection, but UVA rays—the ones resp...</p>
            <a href="./blog-6.php">Read more</a>
        </div>
</div>

<hr>

<?php
  if((!empty($_SESSION["user_id"]))) {
    include "cart.php";
  }
    include "footer.php"
?>

<script src="../jquery/addtocart.js"></script>


  
</body>
</html>