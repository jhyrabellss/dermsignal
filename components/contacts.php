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
    <link rel="stylesheet" href="../styles/contacts.css">
    <title>DermSignal Contact Us</title>
    <style>
       .add-info .facebook::after{
    content: "";
    background-color: black;
    position: absolute;
    border-radius: 50%;
    width: 0px;
    height: 0px;
    z-index: 0;
    transition: all 0.5s ease;
   
}

.add-info  .facebook:hover::after{
    width: 100%;
    height: 100%;
}
.add-info  .facebook:hover  .white{
    z-index: 6;
}

footer .help p, .learn p, .shop p{
    margin: 0px;
}

.box button{
    margin-top: 0px;
}

.box{
    padding-top: 40px;
}

.container-maps{
    margin-bottom: 50px;
}

/* General Styles */
body {
  font-family: 'Arial', sans-serif;
  line-height: 1.6;
  margin: 0;
  padding: 0;
  background-color: #f7f7f7;
}

.container {
  width: 80%;
  margin: 0 auto;
  padding: 20px;
}

h2 {
  font-size: 2rem;
  color: rgb(39, 153, 137); /* Brand Color */
  text-align: center;
  margin-bottom: 20px;
}

p {
  font-size: 1rem;
  color: #555;
  margin-bottom: 20px;
}

.contact-section {
  background-color: #ffffff;
  padding: 40px 0;
}

.contact-methods {
  display: flex;
  justify-content: space-between;
  gap: 30px;
}

.contact-item {
  background-color: #f1f1f1;
  padding: 20px;
  border-radius: 8px;
  flex: 1;
}

.contact-item h3 {
  font-size: 1.5rem;
  color: rgb(39, 153, 137); /* Brand Color */
  margin-bottom: 10px;
}

.contact-link {
  color: rgb(39, 153, 137); /* Brand Color */
  text-decoration: none;
  font-weight: bold;
}

.contact-link:hover {
  text-decoration: underline;
  color: #007bff; /* Lighter shade for hover effect */
}

/* Media Query for Mobile */
@media screen and (max-width: 768px) {
  .contact-methods {
    flex-direction: column;
    gap: 20px;
  }

  .contact-item {
    width: 100%;
  }
}


 </style>
</head>
<body>
<?php include "../components/header.php" ?>

<section id="contact-us" class="contact-section">
  <div class="container">
    <h2>Contact Us</h2>
    <p style="margin-bottom: 20px;">At DermSignal, we believe in offering personalized customer service to make your skincare journey easier and more enjoyable. Whether you have a question about our products, need help with an order, or simply want to learn more about skincare, we're here for you! Reach out to us through any of the following methods, and we'll respond as quickly as possible.</p>

    <div class="contact-methods">
      <div class="contact-item">
        <h3>Email</h3>
        <p>For any product inquiries, customer support, or general questions, feel free to send us an email:</p>
        <a href="mailto:contact@dermsignal.com" class="contact-link">dermsignal@gmail.com</a>
        <p>Our team is available to assist you with order details, skincare advice, and any other concerns you may have. We aim to respond within 24-48 hours.</p>
      </div>

      <div class="contact-item">
        <h3>Phone</h3>
        <p>Prefer to speak with someone directly? Give us a call!</p>
        <a href="tel:+15551234567" class="contact-link">+63 949 344 4483</a>
        <p>Our customer service line is available during business hours (listed below) to assist you with anything you need—whether it’s about your order status, product recommendations, or our store locations.</p>
      </div>
    </div>
  </div>
</section>


    <div class="container-maps">
        <div class="box">
            <h3>OUR STORE</h3>
            <p>63e Katipunan Ave, Quezon City, Metro Manila <br> <br>
            Mon - Fri, 8:30am - 10:30pm <br>
            Saturday, 8:30am - 10:30pm <br>
            Sunday, 8:30am - 10:30pm <br><br><br>
        </p>
            <a href="https://www.google.com/maps/place/Derm+Signal+Skin+Care+Clinic/@14.7020617,121.0200075,17z/data=!3m1!4b1!4m6!3m5!1s0x3397b1a4a96a94ed:0x3c578af182ecc2a5!8m2!3d14.7020565!4d121.0225824!16s%2Fg%2F11s_b6g7k1?entry=ttu" target="_blank">
                <button class="sign">GET DIRECTIONS</button>
            </a>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.1861672743426!2d121.0200074745747!3d14.702061674585607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b1a4a96a94ed%3A0x3c578af182ecc2a5!2sDerm%20Signal%20Skin%20Care%20Clinic!5e0!3m2!1sen!2sph!4v1714896505331!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
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