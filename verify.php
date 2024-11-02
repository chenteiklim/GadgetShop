<?php
// Verify email
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgetShop";

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
      
