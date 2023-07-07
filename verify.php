<?php
// Verify email
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgetShop";

require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
if (isset($_POST['emailConfirmation'])) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    mysqli_select_db($conn, $dbname);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result === false) {
        // Display SQL error message
        echo "SQL Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $to = $email;
        $subject = "Reset your Pit Stop password";
        $message = '<html>
                <body>
                    <p>We received a request to reset the password for your account.

                    If you made this request, click the link below. If not, you can ignore this email.
                    
                    <a href="http://localhost/Project/EnterpriseProject/reset.html">http://localhost/Project/EnterpriseProject/reset.html</a>
                    
                    (Clicking not working? Try pasting it into your browser!)
                </body>
            </html>';
                   
        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Enable SMTP debugging (if needed)
            $mail->SMTPDebug = SMTP::DEBUG_OFF;

            // Set the SMTP server and credentials
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'chenteik_99@hotmail.com';
            $mail->Password = 'wizard12183';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set the sender, recipient, subject, and message
            $mail->setFrom('chenteik_99@hotmail.com', 'Pit Stop for Computer');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $message;

            // Send the email
            $mail->send();
            header("Location: checkEmail.html?success=8");
            exit();
        } catch (Exception $e) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error saving the password reset token in the database.";
    }
}