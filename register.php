<?php
$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $Username, $Password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['success']) && $_GET['success'] == 5) {
  echo "<div class='message-container'>Registration successful!</div>";
}

session_start();
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $address=$_POST['address'];
  $_SESSION['address'] = $address;
  $contact=$_POST['contact'];

  //Select Database
  mysqli_select_db($conn, $dbname); 

  // Check if username already exists in the database
  $checkUsername = "SELECT * FROM users WHERE name = '$username'";
  $result = $conn->query($checkUsername);
  if ($result->num_rows > 0) {
    header("Location: register.html?success=1");
    exit();
  }

  
  //Check if email already exist
  $checkEmail = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($checkEmail);
  if ($result->num_rows > 0) {
    header("Location: register.html?success=2");
    exit();
  }

    // Check if password already exists in the database
  $checkPassword = "SELECT * FROM users WHERE password = '$password'";
  $result = $conn->query($checkPassword);
  if ($result->num_rows > 0) {
    header("Location: register.html?success=3");
    exit();
  }

  elseif ($password != $confirm_password) {
    header("Location: register.html?success=4");
    exit();
  } 
  
  else{
    // Insert the new user into the database
    $insertUserQuery = "INSERT INTO users (name, address, email, password, contact) VALUES ('$username', '$address', '$email', '$password', '$contact')";
    if ($conn->query($insertUserQuery) === true) 
    {
      header("Location: homepage.php?success=5");
      exit();
    }
  }

}
?>
