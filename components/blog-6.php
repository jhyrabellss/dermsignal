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

    <title>SPF 101: Why Your Sunscreen Isn't Working Except</title>
    <style>
p{
    font-size: 14px;
    color: #000;
}

h1{
    font-size: 20px;
    
}
.main-blog{
    max-width: 900px;
}

.blog-1 h1{
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 15px;

}

.blog-header-txt{
    display: flex;
}

.blog-header-txt p{
    margin-bottom: 18px;
    padding-right: 50px;
    border-width: 1px;
}

.soc-icons{
    margin-left: 50px;
    
}
.soc-icons img{
    height: 18px;
    width: 18px;
    margin-right: 8px;
}


.main-blog-img img{
    height: 700.1px;
    object-fit: cover;
}

.head-text{
    margin-top: 50px;
    margin-bottom: 40px;
}

a{
    cursor: pointer;
    text-decoration: underline;
    font-size: 14px;
}

h2{
    font-size: 30px;
    font-weight: 700;
    margin-top: 30px;
    margin-bottom: 40px;
}

li{
    font-size: 14px;
}

.link-1-img{
    margin-top: 17px;
    height: 481px;
    width: 436px;
    margin-left: 40px;
}
.italic{
    font-style: italic;
    color: #60504d;
    opacity: 0.8;
}

.center{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding-top: 20px;
}

img{
    width: 100%;
}

    </style>
</head>
<body>
<?php include "../components/header.php" ?>


<div class="center" style="margin-bottom: 50px;">
        <div class="main-blog">
            <div class="blog-1">
                <h1 style="text-align: left;">SPF 101: Why Your Sunscreen Isn't Working Except</h1>
                <div class="blog-header-txt">
                    <p>April 9, 2024</p>
                    <!--<div class="soc-icons">
                        <a href="https://www.facebook.com/">
                        <img src="../images/icons/icon-fb.png" alt="">
                    </a>
                    <a href="https://www.google.com/search?q=gmail&rlz=1C1VDKB_enPH985PH989&oq=gm&gs_lcrp=EgZjaHJvbWUqDQgBEAAYgwEYsQMYgAQyDwgAEEUYORiDARixAxiABDINCAEQABiDARixAxiABDIGCAIQRRg7Mg0IAxAAGIMBGLEDGIAEMg0IBBAAGIMBGLEDGIAEMgYIBRBFGD0yBggGEEUYPTIGCAcQRRg80gEINDkxNGowajeoAgCwAgA&sourceid=chrome&ie=UTF-8">
                        <img src="../images/icons/icon-mail.png" alt="">
                    </a>
                    </div>-->
                </div> 
                    <!--<div class="main-blog-img">
                        <img src="/images/blog/b.log-6.webp" alt="">
                    </div>-->
            </div>
            <div class="blog-info-1">
                <div class="blog-text">
                <h1 class="head-text" style="text-align:left; font-size: 40px;">The Science of Sun Protection</h1> 
                <p>
                    Many Filipinos believe that a high SPF number is a "shield" that lasts all day, but the reality is more complex. SPF primarily measures UVB protection, but UVA rays—the ones responsible for deep-tissue aging and melasma—require "Broad Spectrum" filters. If you are applying less than the recommended two-finger amount for your face and neck, your SPF 50 is likely performing like an SPF 15. Furthermore, chemical filters break down after two hours of direct sun exposure. In this guide, we break down the molecular difference between physical and chemical blockers and how to choose a formula that won't clog your pores in tropical humidity. 
                </p>
            </div>
    </div>
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
