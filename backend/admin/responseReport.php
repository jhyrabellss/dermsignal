<?php

    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "../../PHPMailer/src/Exception.php";
    require "../../PHPMailer/src/PHPMailer.php";
    require "../../PHPMailer/src/SMTP.php";
    
    require_once("../reports/reports.php");

    if(isset($_POST["report"]) && $_POST["email"])
    { 
            $mail = new PHPMailer();
            $email = $_POST["email"];
            $report = $_POST["report"];

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply.eternasky@gmail.com';
            $mail->Password = "ukitmgoknxfuwgaf";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('noreply.eternasky@gmail.com');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Report Feedback";
            $mail->Body = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Report Feedback</title>
</head>
<body style='font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;'>
    <div style='max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);'>
        <h1 style='color: #333333; font-size: 24px; text-align: center;'>Report Feedback</h1>
        <p style='color: #555555; font-size: 16px; line-height: 1.5;'>{$report}</p>
        <div style='margin-top: 20px; text-align: center; font-size: 12px; color: #999999;'>
            <p>&copy; 2024 Kafeinated. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
";


            if ($mail->send()) {
                echo 'success';
            } else {
                echo 'Error: ' . $mail->ErrorInfo;
            }

        exit();
    }
?>
