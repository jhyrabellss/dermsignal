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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <title>DermSignal Privacy Policy</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 30px;
            text-align: center;
            margin-top: 40px;
            font-weight: 600;
            color: #2b7b6e;
        }

        h3 {
            font-size: 20px;
            font-weight: 600;
            color: #2b7b6e;
            margin-top: 30px;
        }

        p, li {
            font-size: 16px;
            color: #555;
            margin: 15px 0;
        }

        ul {
            list-style-type: disc;
            margin-left: 30px;
        }

        li {
            margin: 10px 0;
        }

        .privacy-container {
            width: 100%;
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Centered title */
        .privacy-container h1 {
            text-align: center;
        }

        /* Align the rest of the content to the left */
        .privacy-container p, .privacy-container ul, .privacy-container li, .privacy-container h3 {
            text-align: left;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .privacy-container {
                width: 100%;
                padding: 15px;
            }

            h1 {
                font-size: 26px;
            }

            h3 {
                font-size: 18px;
            }

            p, li {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php include "../components/header.php" ?>

<!-- Main Content Section -->
<div class="privacy-container">
    <h1>DermSignal Privacy Policy</h1>
    <p>DermSignal is committed to protecting your privacy and the security of your personal information. 
    This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>

    <!-- Information We Collect Section -->
    <h3>Information We Collect</h3>
    <p>We collect several types of information to provide you with the best possible experience and service:</p>
    <ul>
        <li><strong>Information you provide:</strong> This includes information you enter when creating an account, placing an order, scheduling a consultation, or contacting customer service. This may include your name, billing and shipping address, email address, phone number, and any information you share about your skin concerns.</li>
        <li><strong>Information collected automatically:</strong> When you visit our website, we may collect certain information automatically through cookies and other tracking technologies. This information may include your IP address, browser type, operating system, referring URL, pages visited on our website, and your browsing activity.</li>
    </ul>

    <!-- How We Use Your Information Section -->
    <h3>How We Use Your Information</h3>
    <p>We use your information for various purposes, including:</p>
    <ul>
        <li>To process your orders and deliver your purchases.</li>
        <li>To provide you with customer service and support.</li>
        <li>To personalize your shopping experience and recommend products that may be of interest to you.</li>
        <li>To send you marketing communications (with your consent).</li>
        <li>To improve our website and services.</li>
        <li>To comply with legal and regulatory requirements.</li>
    </ul>

    <!-- Sharing Your Information Section -->
    <h3>Sharing Your Information</h3>
    <p>We may share your information with third-party service providers who help us operate our business and website. These providers are obligated to keep your information confidential and use it only for the purposes we have specified.</p>
    <p>We will not sell or rent your personal information to third parties. We may disclose your information if required by law or if we believe it is necessary to protect the rights and safety of ourselves or others.</p>

    <!-- Data Security Section -->
    <h3>Data Security</h3>
    <p>We take reasonable steps to protect your information from unauthorized access, disclosure, alteration, or destruction. However, no website or internet transmission is completely secure. We cannot guarantee the security of your information.</p>

    <!-- Your Choices Section -->
    <h3>Your Choices</h3>
    <p>You have choices regarding your information. You can:</p>
    <ul>
        <li>Access and update your personal information.</li>
        <li>Opt-out of receiving marketing communications.</li>
        <li>Request that we delete your personal information.</li>
    </ul>

    <!-- Children's Privacy Section -->
    <h3>Children's Privacy</h3>
    <p>Our website is not directed towards children under 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us so we can delete it.</p>

    <!-- Changes to the Privacy Policy Section -->
    <h3>Changes to this Privacy Policy</h3>
    <p>We may update this Privacy Policy from time to time. We will post any changes on our website. We encourage you to review this Privacy Policy periodically to stay informed about how we are using your information.</p>

    <!-- Contact Us Section -->
    <h3>Contact Us</h3>
    <p>If you have any questions about this Privacy Policy, please contact us at dermsignal@gmail.com.</p>
</div>

<hr>

<?php
    if((!empty($_SESSION["user_id"]))) {
        include "cart.php";
    }
    include "footer.php";
?>

</body>
</html>
