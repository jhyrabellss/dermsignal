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
    <title>DermSignal Terms and Conditions</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 40px;
        }

        h1 {
            font-size: 32px;
            text-align: center;
            color: #2b7b6e;
            margin-bottom: 20px;
            font-weight: 600;
        }

        h3 {
            font-size: 22px;
            font-weight: 600;
            color: #2b7b6e;
            margin-top: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .container p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin: 20px 0;
            text-align: justify;
        }

        .container ol {
            margin: 20px 0;
            padding-left: 30px;
            list-style-type: decimal;
        }

        .container li {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 500;
        }

       .container li p {
            font-size: 16px;
            font-weight: 300;
            margin-top: 5px;
            text-align: justify;
        }

        hr {
            margin: 40px 0;
            border: 0;
            border-top: 1px solid #eee;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 28px;
            }

            h3 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            li {
                font-size: 16px;
            }

            .container {
                width: 100%;
                padding: 20px;
                padding-bottom: 0px !important;
            }
        }
    </style>
</head>
<body>

<?php include "../components/header.php" ?>

<!-- Main Content Container -->
<div class="container">
    <h1>DermSignal Terms and Conditions</h1>

    <h3>Welcome to DermSignal!</h3>

    <p>These Terms and Conditions ("Terms") govern your use of our website (the "Site") and the services we offer (the "Services"), including online consultations, personalized skincare routines, and product purchases (collectively, the "DermSignal Services"). By accessing or using the DermSignal Services, you agree to be bound by these Terms.</p>

    <ol>
        <li>
            <strong>Eligibility</strong>
            <p>You must be at least 18 years old and have the legal capacity to enter into contracts to use the DermSignal Services.</p>
        </li>
        <li>
            <strong>User Accounts</strong>
            <p>You may need to create an account to access certain features of the Services. You are responsible for maintaining the confidentiality of your account information and password and for all activity that occurs under your account.</p>
        </li>
        <li>
            <strong>Orders and Payment</strong>
            <p>If you place an order for products, you agree to pay the listed price for such products, including any applicable taxes or shipping fees. We accept payment through the methods listed on our website.</p>
        </li>
        <li>
            <strong>Returns and Exchanges</strong>
            <p>We offer returns and exchanges for unused and unopened products within [Number] days of purchase. Please refer to our Returns and Exchanges Policy on our website for detailed instructions.</p>
        </li>
        <li>
            <strong>Intellectual Property</strong>
            <p>The content on the Site, including text, graphics, logos, trademarks, and service marks, is owned by DermSignal or its licensors and is protected by copyright and other intellectual property laws.</p>
        </li>
        <li>
            <strong>Disclaimer</strong>
            <p>The DermSignal Services are provided "as is" and "as available" without any warranties of any kind, express or implied. DermSignal does not warrant that the Services will be uninterrupted, error-free, or virus-free.</p>
        </li>
        <li>
            <strong>Limitation of Liability</strong>
            <p>DermSignal shall not be liable for any direct, indirect, incidental, consequential, or special damages arising out of or in any way connected with your use of the DermSignal Services.</p>
        </li>
        <li>
            <strong>Termination</strong>
            <p>We may terminate your access to the DermSignal Services at any time, for any reason, with or without notice.</p>
        </li>
        <li>
            <strong>Governing Law</strong>
            <p>These Terms shall be governed by and construed in accordance with the laws of the Philippines.</p>
        </li>
        <li>
            <strong>Entire Agreement</strong>
            <p>These Terms constitute the entire agreement between you and DermSignal regarding your use of the DermSignal Services.</p>
        </li>
        <li>
            <strong>Contact Us</strong>
            <p>If you have any questions about these Terms, please contact us at dermsignal@gmail.com or by phone at 09493444483.</p>
        </li>
    </ol>

    <hr>
</div> <!-- End of .container -->


<?php
    if((!empty($_SESSION["user_id"]))) {
        include "cart.php";
    }
    include "footer.php";
?>

</body>
</html>
