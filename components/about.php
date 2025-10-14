<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="../styles/blog.css">
    <link rel="stylesheet" href="../styles/cart.css">   
    <link rel="stylesheet" href="../styles/dropdown.css">
    <link rel="stylesheet" href="../styles/general-styles.css">
    <link rel="stylesheet" href="../styles/login-signup-popup.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/about.css">
    <style>
        .button{
        text-decoration: none;
        background-color: rgb(39,153,137);
        border: none;
        color: whitesmoke;
        transition: all 1s;
        letter-spacing: 0.125rem; /* 2px */
        font-size: 0.8125rem; /* 13px */
        color: white;
        border: none;
        height: 3.125rem; /* 50px */
        width: 250px ; /* 250px */
        font-weight: 300;
        margin-top: 0.75rem; 
        }

        .button:hover{
            background-image: linear-gradient(35deg, rgb(39,153,137), #c1ded3);
            background-position: 250px;
        }

        body{
            margin: 0px !important;
        }

        main{
            margin-bottom: 50px;
        }

        .flex-col div{
            font-size: 14px;
        }

    </style>
</head>
<body>

<?php include "../components/header.php" ?>
    <main>
        <div class="con-grid">
            <div class="img-con">
                <img src="../images/about/3.png" alt="">
            </div>
            <div class="center">
                <div class="desc">
                    <h1 style="text-transform: uppercase;">Filipino Skincare Made for You</h1>
                    <div class="flex-col">
                        <div>
                            DERMSIGNAL is a Philippine-based skincare brand founded by a board-certified dermatologist with a passion for helping Filipinos achieve healthy, radiant skin. We believe in the power of using high-quality ingredients formulated specifically for Filipino skin types and concerns.
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="con-grid reverse">
            <div class="img-con">
                <img src="../images/about/2.png" alt="">
            </div>
            <div class="center">
                <div class="desc">
                    <h1 style="text-transform: uppercase;" >Made by Filipinos, for Filipinos</h1>
                    <div class="flex-col">
                        <div>
                            We understand that Filipino skin has unique needs. That's why we develop our products with Filipino skin in mind, using ingredients and formulations proven to be effective for our climate and concerns.
                        </div>
                        <div>
                            We also take pride in supporting the local economy by sourcing ingredients and manufacturing our products within the Philippines.
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>

        <div class="con-grid">
            <div class="img-con">
                <img src="../images/about/12.png" alt="">
            </div>
            <div class="center">
                <div class="desc">
                    <h1>OUR PRODUCTS</h1>
                    <div class="flex-col">
                        <div>
                            At DERMSIGNAL, we offer a comprehensive range of skincare products designed to address a variety of concerns, from acne and dryness to hyperpigmentation and aging. We use only the highest quality ingredients and formulate our products to be gentle yet effective. 
                        </div>
                        <div>
                            Explore our range of cleansers, moisturizers, serums, and sunscreens to find the perfect regimen for your skin type and goals.
                        </div>
                        <a href="./all-products.php">
                        <div>
                            <button class="button">SHOP NOW</button>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="con-grid reverse">
            <div class="img-con">
                <img src="../images/about/8.png" alt="">
            </div>
            <div class="center">
                <div class="desc">
                    <h1>SKIN ASSESSMENT</h1>
                    <div class="flex-col">
                        <div>
                            Looking for personalized skincare advice? Take our Skin Assessment Test to get tailored recommendations! Receive expert guidance on creating a customized skincare routine that addresses your unique needs and concerns.
                        </div>
                        <a href="./assessment.php">
                        <div>
                            <button class="button">SKIN ASSESSMENT TEST</button>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="con-grid">
            <div class="img-con">
                <img src="../images/about/11.png" alt="">
            </div>
            <div class="center">
                <div class="desc">
                    <h1 style="text-transform: uppercase;">Affordable Skincare that Exceeds Expectations</h1>
                    <div class="flex-col">
                        <div>
                            We believe that everyone deserves access to high-quality skincare. That's why we offer our products at competitive prices, without compromising on quality or effectiveness. With DERMSIGNAL, you can achieve healthy, beautiful skin without breaking the bank.
                        </div>
                        <div>
                            Experience the DERMSIGNAL difference. Filipino-made skincare that delivers real results.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <hr>

    <?php
        if((!empty($_SESSION["user_id"]))) {
            include "cart.php";
        }
            include "footer.php"
    ?>

</body>
</html>


