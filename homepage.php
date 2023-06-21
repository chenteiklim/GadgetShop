
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></link>
    <style>

  
#container {

  display: flex;
  flex-direction: row;
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
        background-color: black;
    }
    
    #logOut{
        margin-left: 200px;
    }

    
.unit{
  color:black;
    font-size: 12px;
}

#description1{
    display: flex;
    align-items: center;
}
#rating{
}
.starItem{
    width: 20px;
    height: 20px;
}



.checked{
    color: orange;
}


#navContainer{
        width:1200px;
        background-color: black;
    }
    
    #logOut{
        margin-left: 200px;
    }
    </style>
</head>

<div id="navContainer"> 
<form id="dataForm">
    <!-- Your form fields here -->
    <input type="hidden" name="data" value="<?php echo $_SESSION['data']; ?>">
    <button class="button"><?php echo 'Shopping Cart'; ?></button>
    <button class="button"><?php echo 'Notification' ?></button>
    <button class="button"><?php echo $name ?></button>
    <button id="logOut" class="button"><?php echo 'Log Out' ?></button>
</form>
  
</div>
<div id="container">

    <?php
    $productHTML = '';

      // Loop through the array of rows
      foreach ($rows as $index => $row) {
          $product_id = $row['product_id'];
          $product_name = $row['product_name'];
          $price = $row['price'];
          $description=$row['description'];
          $image = $row['image'];
          $stock=$row['stock'];
          $status=$row['status'];
          $rating=$row['rating'];
          $review=$row['review'];
          $discount=$row['discount'];
          $category=$row['category'];  
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
      <div id="rating">';
      for ($i = 1; $i <= $rating; $i++) {
        $newProduct2 .= '
        <span class="fa fa-star checked"></span>';
      }

      for ($i = $rating + 1; $i <= 5; $i++) {
        $newProduct2 .= '
        <span class="fa fa-star"></span>';
      }

      $newProduct2 .= '
      <div class="status">' . $status . ' sold</div>
      <form action="" method="post">
      <button class="button" type="submit" name="view" value="' . $button_id . '">View</button>
      </form>
     
    </div>
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
      echo '<script>window.location.href = "product.php";</script>';
     
      
  } else {
      // Product ID is not saved in the session
      echo "Product ID not found in the session.";
  }

    exit;
}
?>
<script src="register.js"></script>

  
   