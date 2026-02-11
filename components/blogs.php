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
            <p>January 5, 2026</p>
            <h1>Acne - Myths, Misconceptions and You</h1>
            <p class="desc">Research shows that nearly 98% of the general public harbors at least one erroneous belief about acne's causes and remedies. This extends to individuals directly affected, with studies reporting that over 80% of acne patients subscribe to at least one common myth.</p>
            <a href="./blog-1.php">Read more</a>
        </div>

        <div class="blog-cont">
            <img src="../images/blog/acne-teenage-girl-applying-acne-medication-her-face-front-mirror-care-problem-skin.webp" alt="" class="blog-1">
            <p>FEBRUARY 26, 2024</p>
            <h1>A Step By Step Guide for...</h1>
            <p class="desc">Skincare remains the backbone of successful acne management. With all the skincare products released left and right, it can be overwhelming to choose which products to incorporate on your regimen. Check-out this beginner guide made with the Filipino skin in mind. </p>
            <a href="./blog-2.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/bilastine.webp" alt="" class="blog-1">
            <p>MARCH 1, 2024</p>
            <h1>7 Acne Myths Debunked</h1>
            <p class="desc">Acne often necessitates the use of topical treatments that can lead to side effects like acne purging, irritation (irritant contact dermatitis), and allergic reaction (allergic contact dermatitis). Can this second-generation antihistamine help in improving purging and allergy while on acne treatment?</p>
            <a href="./blog-3.php">Read more</a>
        </div>

        <div class="blog-cont">
            <img src="../images/blog/blog-4.webp" alt="" class="blog-1">
            <p>APRIL 13, 2024</p>
            <h1>Salicylic Acid: The Essen...</h1>
            <p class="desc">The Science of Salicylic Acid: A Deep Dive We all know how frustrating it can become when those unwelcome acne 
                bumps come popping up days before a big event. Fear not! Today, we discuss Salicylic Acid, a trusty weapon in our fight for 
                clearer skin! </p>
            <a href="./blog-4.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/blog-5.webp" alt="" class="blog-1">
            <p>APRIL 11, 2024</p>
            <h1>Niacinamide: The All Star...</h1>
            <p class="desc">Niacinamide: A Versatile Ingredient for Acne and Beyond Niacinamide is a form of vitamin B3 and is considered a star 
                in the skincare world. It is a true "multi-tasker,” as it tackles various skin concerns such as acne, compromised skin barrier, 
                and hyperpigmentation. </p>
            <a href="./blog-5.php">Read more</a>
        </div>
        <div class="blog-cont">
            <img src="../images/blog/b.log-6.webp" alt="" class="blog-1">
            <p>APRIL 9, 2024</p>
            <h1>Tranexamic Acid & Dark...</h1>
            <p class="desc">Tranexamic Acid: Essential in Your Regimen for Pimple Marks Removal Acne marks is a major concern of patients 
                experiencing acne breakouts. Acne leaves these dark and red discoloration on the skin, lasting for weeks to even years, 
                further impacting a person's self-image.... </p>
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