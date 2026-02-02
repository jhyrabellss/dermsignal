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

    <title>Smart Skincare: Creating a Routine for Clearer Skin</title>

    <style>
        p { font-size: 14px; }
        h1 { font-size: 20px; }
        .main-blog { max-width: 900px; }
        .blog-1 h1 { font-size: 22px; font-weight: 600; margin-bottom: 15px; }
        .blog-header-txt { display: flex; }
        .blog-header-txt p { margin-bottom: 18px; padding-right: 50px; border-right: solid 1px; }
        .soc-icons { margin-left: 50px; }
        .soc-icons img { height: 18px; width: 18px; margin-right: 8px; }
        .main-blog-img img { height: 700px; object-fit: cover; }
        .head-text { margin-top: 50px; margin-bottom: 40px; }
        a { cursor: pointer; text-decoration: underline; font-size: 14px; }
        h2 { font-size: 30px; font-weight: 700; margin-top: 30px; margin-bottom: 40px; }
        li { font-size: 14px; }
        .italic { font-style: italic; color: #60504d; opacity: 0.8; }
        .center { display: flex; align-items: center; justify-content: center; width: 100%; padding-top: 20px; }
        img { width: 100%; }
    </style>
</head>
<body>
<?php include "../components/header.php" ?>

<div class="center" style="margin-bottom: 50px;">
    <div class="main-blog">
        <div class="blog-1">
            <h1 style="text-align: left;">Smart Skincare: Creating a Routine for Clearer Skin</h1>
            <div class="blog-header-txt">
                <p>February 26, 2024</p>
                <div class="soc-icons">
                    <a href="https://www.facebook.com/"><img src="../images/icons/icon-fb.png" alt=""></a>
                    <a href="https://mail.google.com/"><img src="../images/icons/icon-mail.png" alt=""></a>
                </div>
            </div> 
            <div class="main-blog-img">
                <img src="images\testimonials\690d556552b37.png" alt="">
            </div>
        </div>

        <div class="blog-info-1">
            <div class="blog-text">
                <h1 class="head-text">Step-by-Step Routine for Acne-Prone Skin</h1> 
                <p>
                    Clear skin isn’t about using the strongest products—it’s about building a routine that works with your skin, not against it. 
                    <br><br>
                    Many people make the mistake of overloading their skin with treatments, which can cause dryness and irritation. A balanced approach with gentle cleansing, targeted treatment, and hydration is far more effective in the long run.
                </p>
            </div>
        </div> <br>

        <p>
            Strong actives like benzoyl peroxide or retinoids can help, but they should be introduced slowly. 
            <strong>Rule of thumb:</strong> start simple, then add products one at a time so you can track how your skin reacts.
        </p>

        <h2>Why Does Acne Flare Up?</h2>
        <img src="/images/blog/wepik-export-2024022806011909X9_480x480.webp" alt=""> <br><br>
        <p>
            Acne isn’t random—it’s influenced by genetics, hormones, lifestyle, and environment. Breakouts occur when excess oil, dead skin cells, and bacteria clog pores, leading to inflammation.
        </p>

        <h2>Internal Factors</h2>
        <ul>
            <li><strong>Hormones:</strong> Oil production spikes during puberty, menstrual cycles, or pregnancy.</li>
            <li><strong>Stress:</strong> Stress hormones can worsen inflammation and slow skin recovery.</li>
            <li><strong>Gut health:</strong> Some studies suggest imbalances in gut bacteria may affect skin health.</li>
        </ul>
        <img src="/images/blog/skin-gut.webp" alt="">

        <h2>External Factors</h2>
        <ul>
            <li><strong>Skincare misuse:</strong> Harsh scrubs or overuse of acids can damage the skin barrier.</li>
            <li><strong>Cosmetics:</strong> Heavy, pore-clogging makeup can worsen acne. Opt for non-comedogenic products.</li>
            <li><strong>Friction:</strong> Helmets, masks, or constant touching can irritate skin and trigger breakouts.</li>
            <li><strong>Environment:</strong> Humidity, pollution, and sun exposure can all contribute to flare-ups.</li>
            <li><strong>Medications:</strong> Certain drugs, like steroids or high-dose vitamins, may cause acne in some people.</li>
            <li><strong>Lifestyle:</strong> Smoking and poor sleep habits can make acne harder to manage.</li>
            <li><strong>Diet:</strong> Sugary foods and dairy may trigger acne in some individuals, though results vary.</li>
        </ul>

        <p>
            Managing acne means looking beyond skincare—healthy habits like stress management, sleep, and nutrition are just as important.
        </p>

        <h2>How to Build Your Routine</h2>
        <p>
            Start with the basics: a gentle cleanser, a treatment suited to your skin type, a lightweight moisturizer, and daily sunscreen. 
            <br><br>
            Add new products gradually, and listen to your skin. With patience and consistency, you’ll find the routine that helps you achieve clearer, healthier skin.
        </p>
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
