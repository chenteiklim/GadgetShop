<?php
$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $Username, $Password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();
$email=$_SESSION['email'];
mysqli_select_db($conn, $dbname);
$selectNameQuery = "SELECT name FROM users WHERE email = '$email'";
// Execute the query
$result = $conn->query($selectNameQuery);

if ($result->num_rows > 0) {
    // Fetch the row from the result
    $row = $result->fetch_assoc();
}
    // Get the address value from the fetched row
    $name = $row['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="img/logo.jpg" type="image/jpg">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage</title>

<link rel="stylesheet" href="homepage.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></link>
</head>
<body>
  <div id="successMessage1"></div>
      <div id="successMessage3"></div>
    
  <h1>Homepage</h1>
  <p>Please choose from the variety of Electronic devices</p> 
</div>


<div id="navContainer"> 
  <button class="button">Shopping Cart</button>
  <button class="button">Notification</button>
  <button class="button"><?php echo $name; ?></button>
<button id="logOut" class="button">Log-out</button>

</div>

<div id="container">
</div>
<script src="register.js"></script>
<script src="log-out.js"></script>
<script src="homepage4.js"></script>

  
</body>
</html>






    
   