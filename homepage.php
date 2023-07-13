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


    mysqli_select_db($conn, $dbname);
    $maxIdQuery = "SELECT MAX(product_id) AS max_id FROM products";
    $maxIdResult = $conn->query($maxIdQuery);
    
    if ($maxIdResult && $maxIdResult->num_rows > 0) {
        $row9 = $maxIdResult->fetch_assoc();
        $maxId = $row9['max_id'];
    }
    
    // Query to retrieve all rows in ascending order
    $selectRowsQuery = "SELECT * FROM products ORDER BY product_id ASC";
    $selectRowsResult = $conn->query($selectRowsQuery);
    
    $rows = []; // Initialize an empty array to store the rows
    
    if ($selectRowsResult && $selectRowsResult->num_rows > 0) {
        while ($row = $selectRowsResult->fetch_assoc()) {
            $rows[] = $row; // Add each row to the array
        }
    }
  ?>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="icon" href="pitstop.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></link>
    <style>

  
#container {

  display: flex;
  flex-direction: row;
  flex-wrap:wrap;
}

.item{
 width:100px;
 height:100px;
}


.product_name {
  margin-top:15px;
    font-size:20px;
    color: black;
}

.price {
  display: flex;
  gap: 3px;
  justify-content:center;
  align-items:center;
    color: red;
}
.status{
  margin-top:10px;
}

#prices{
    font-size:30px;
    color:red;
}

.button {
    background-color: black;
    color: white;
    cursor: pointer;
    margin-left: 20px;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 16px;
    }
#btn {
    background-color: black;
    color: white;
    cursor: pointer;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 10px;
    margin-top: 10px;
    padding-bottom: 10px;
    font-size: 16px;
    }
    
    button:active {
      transform: scale(0.9);
      background: radial-gradient( circle farthest-corner at 10% 20%,  rgba(255,94,247,1) 17.8%, rgba(2,245,255,1) 100.2% );
    }
    
    body{
        background-color: bisque;
        width: 1400px;
        height: 1400px;
    }
.imageContainer{
  display: flex;
  align-items: center;
  justify-content:center;
    width: 180px;
    height: 170px;
    background-color: antiquewhite;
}
.productDetails{
  font-size:18px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content:center;
  text-align: center; /* Horizontally center the content */
  gap: 10px;

}
.product{
    margin: 20px;
    background-color: white;
    width: 180px;
    height: 400px;
    font-size: 12px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    letter-spacing: 0.2px
}
    #navContainer{
      display:flex;
     align-items:center;
    background-color: black;
    }

    
.unit{
  color:black;
    font-size: 12px;
}


.checked{
    color: orange;
}


#navContainer{
  display:flex;
        width:1400px;
        background-color: black;
    }

#register{
    margin-left: 600px;
}

.img{
  margin-left:50px;
  width:50px;
  height:50px;
  }
  .message-container {
      
      background-color: rgba(0, 0, 0, 0.7);
      position: fixed;
      padding-left: 120px;
      padding-right: 120px;
      padding-top: 90px;
      padding-bottom: 90px;
      color: white;
      font-size: 30px;
      display: flex;
    align-items: center;
    justify-content: center;
    }


  
    </style>
</head>

<div id="navContainer"> 
  <img class='img' src="pitStop.png" alt="" srcset="">
    <button class="button" id='register'><?php echo 'Register'?></button>
    <button id="login" class="button"><?php echo 'Log in' ?></button>
    <button id='seller' class='button'><?php echo 'seller center' ?></button>
</div>
<div id="messageContainer"></div>

<div id="container">

    <?php
    $productHTML = '';

      // Loop through the array of rows
      foreach ($rows as $index => $row) {
          $product_id = $row['product_id'];
          $product_name = $row['product_name'];
          $price = $row['price'];
          $image = $row['image'];
          $stock=$row['stock'];
          $status=$row['status'];
          $button_id = $product_id;

    $newProduct2 = '
    <div class="product">
      <div class="imageContainer">
          <img class="item" src="' . $image . '" alt="">
      </div>
      <div class="productDetails">
        <div class="product_name">' . $product_name . '</div>
        <div class="price">
          <div class="unit">RM</div>
          <div>' . $price . '</div>
        </div>
        <div class="stock">' . ($stock > 0 ? $stock . ' stock available' : 'Out of stock') . '</div>      <div class="status">' . $status . ' sold</div>
      <form action="" method="post">
      <button class="button" type="submit" name="view" value="' . $button_id . '">View</button>
      </form>
     
    </div>
    </div>
    ';
    $productHTML .= $newProduct2;
    
  }
  echo $productHTML;
  if (isset($_POST['view'])) {
    $product2_id = $_POST['view'];

    // Use the $product2_id variable as needed
    // For example, you can store it in a session variable
    $_SESSION['product_id'] = $product2_id;
    
    if (isset($_SESSION['product_id'])) {
      // Product ID is saved in the session
      $product_id = $_SESSION['product_id'];
      echo '<script>window.location.href = "login.html";</script>';
     
      
  } else {
      // Product ID is not saved in the session
      echo "Product ID not found in the session.";
  }

    exit;
}
?>
</div>
<script src="homepage.js"></script>

