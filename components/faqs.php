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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>DermSignal FAQs</title> 

    <style>
      /* FAQ Container */
.center {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding-top: 20px;
  margin-bottom: 50px;
}

/* Main FAQ Section */
.faqs {
  max-width: 800px;
  width: 100%;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

/* Heading Style */
h3 {
  text-align: center;
  font-size: 32px;
  font-weight: 500;
  color: rgb(39, 153, 137); /* Your primary color */
}

h4 {
  font-size: 26px;
  font-weight: 500;
  color: rgb(39, 153, 137);
  margin-top: 40px;
}

details {
  width: 100%;
  margin-bottom: 10px;
}

/* Summary (Dropdown Button) Style */
summary {
  padding: 15px;
  /* Primary color for button */
  color: white;
  font-size: 18px;
  cursor: pointer;
  border: none;
  border-radius: 4px;
  position: relative;
  font-weight: 500;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

summary i {
  margin-left: 10px;
  font-size: 18px;
}

/* On hover: Slightly darken the button */
summary:hover {
  background-color: rgba(39, 153, 137, 0.1);
}

summary:focus {
  outline: none;
}

/* Opened State for Dropdown */
details[open] summary {
  background-color: rgba(39, 153, 137, 0.1);
}

/* Paragraph (Text inside Details) Style */
details p {
  background-color: #ffffff; /* Clean white background for content */
  padding: 15px;
  font-size: 14px;
  color: #555;
  border-left: 4px solid rgb(39, 153, 137); /* Border matches header color */
  border-bottom: 1px solid #ddd;
  margin: 0;
}

/* Adjusted Typography for Smaller Text */
.faqs p {
  font-size: 14px;
  color: gray;
}

.faqs h5 {
  font-size: 18px;
  font-weight: 500;
  margin: 0;
}

/* Section Header */
.faqs h4 {
  font-size: 24px;
  margin-top: 40px;
  font-weight: 600;
}

/* Margin adjustment for the FAQ sections */
.faqs h4 + details {
  margin-top: 15px;
}

/* Add spacing between sections */
.faqs h4, .faqs h3 {
  margin-top: 50px;
}

    </style>
</head>
<body>

<?php include "../components/header.php" ?>
<div class="center">
  <div class="faqs">
    <h3>Frequently Asked Questions</h3>
    
    <h4>General Inquiries</h4>

    <details>
      <summary><span>What is DermSignal?</span><i class="fas fa-chevron-down"></i></summary>   
      <p>DermSignal is an online shop offering a variety of dermatologically-tested skincare products and services.</p>
    </details>

    <details>
      <summary><span>What sets DermSignal apart from other skincare brands?</span><i class="fas fa-chevron-down"></i></summary>
      <p>We prioritize providing our customers with effective and safe skincare solutions through collaboration with dermatologists.</p>
    </details>

    <details>
      <summary><span>Do you offer consultations with a dermatologist?</span><i class="fas fa-chevron-down"></i></summary>   
      <p>Yes, we offer consultations with licensed dermatologists who can assess your skin concerns and recommend the best products and services for you.</p>
    </details>

    <h4>Products</h4>

    <details>
      <summary><span>What types of skincare products do you offer?</span><i class="fas fa-chevron-down"></i></summary>
      <p>We offer a wide range of skincare products to address various skin concerns, including cleansers, moisturizers, serums, sunscreens, and acne treatments.</p>
    </details>

    <details>
      <summary><span>Are your products suitable for all skin types?</span><i class="fas fa-chevron-down"></i></summary>
      <p>We offer products for different skin types, such as dry, oily, combination, and sensitive skin. Check the product description to see if it's suitable for your specific skin type.</p>
    </details>

    <details>
      <summary><span>Can I get more information about a specific product?</span><i class="fas fa-chevron-down"></i></summary>
      <p>Each product on our website has a detailed description that includes its ingredients, benefits, and how to use it.</p>
    </details>

    <h4>Orders and Shipping</h4>

    <details>
      <summary><span>Where do you ship?</span><i class="fas fa-chevron-down"></i></summary>
      <p>We currently ship within the Philippines.</p>
    </details>

    <details>
      <summary><span>How long will it take to receive my order?</span><i class="fas fa-chevron-down"></i></summary>
      <p>Shipping times vary based on location. We will provide an estimated delivery time upon checkout.</p>
    </details>

    <h4>Safety and Privacy</h4>

    <details>
      <summary><span>Are your products safe to use?</span><i class="fas fa-chevron-down"></i></summary>
      <p>We offer dermatologically-tested products that are safe for most skin types, but always do a patch test before using new products.</p>
    </details>

    <h4>Still have questions?</h4>
    <p>If you can't find the answer to your question, feel free to contact us through our website or social media pages. We're happy to help!</p>
  </div>
</div>

<hr>

<?php
    if((!empty($_SESSION["user_id"]))) {
        include "cart.php";
    }
        include "footer.php"
?>

  
</body>
</html>