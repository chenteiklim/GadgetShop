<?php
$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $Username, $Password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['forgetPassword'])) {
    header("Location: verify.html");
    exit(); 
  }
session_start();
$product_ids = $_SESSION['product_ids'];

if (isset($_POST['submit'])) {
  $email=$_POST['email'];
  $_SESSION['email'] = $email;
  $password = $_POST['password'];

  mysqli_select_db($conn, $dbname); 
  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      // email exists and password exists, proceed with the login
      $row = $result->fetch_assoc(); 
      $user_id = $row['user_id'];
      $name=$row['name'];
      $address = $row['address'];
      $contact = $row['contact'];
      $email=$row['email'];
      $insertUserQuery = "INSERT INTO `order` (user_id,name,email,address,contact) VALUES ('$user_id','$name','$email','$address','$contact')";
      if ($conn->query($insertUserQuery) === true) {
       // Convert the product_ids array to a comma-separated string
        $product_ids_str = implode(',', $product_ids);
        // Construct the SQL update query
        $sql_update = "UPDATE products SET stock = stock - 1 WHERE product_id IN ($product_ids_str)";
        $sql_update2 = "UPDATE products SET status = status + 1 WHERE product_id IN ($product_ids_str)";
        if ($conn->query($sql_update) && $conn->query($sql_update2) === true) {
          header("Location: success.html");
          exit();
        }
      }
    }   

  else {
      // email doesn't exist, display an error message
      echo "Invalid email or password. Please try again.";
  }
}
?>