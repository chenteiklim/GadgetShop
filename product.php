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
$product_id = $_SESSION['product_id'];
$email=$_SESSION['email'];
mysqli_select_db($conn, $dbname);
// Execute the query

$sql = "SELECT * FROM products WHERE product_id = '$product_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the user ID from the result
    $row = $result->fetch_assoc();
    $product_name = $row['product_name'];
    $price = $row['price'];

    $image= $row['image'];

    $status = $row['status'];

    $rating = $row['rating'];
}



$newProduct2 = '
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



  <div id="navContainer"> 
    <button id="Cart" class="button">Shopping Cart</button>
    <button class="button">Notification</button>
    <button class="button">profile</button>
    <button id="logOut" class="button">Log-out</button>
    <button id="back" class="button">Back</button>

  </div>
<style>
     .keyboard{
        width: 300px;
        height: 300px;
    }

    .names{
      font-size: 30px;
      margin-top: 20px;
      padding-left: 50px;
    }

    .prices{
      font-size: 20px;
      margin-top: 20px;
      padding-left: 50px;
    }    
    
    #container{
        display: flex;
    }
   
    #buyNowButton {
    background-color: black;
    color: white;
    cursor: pointer;
    margin-top: 20px;
    margin-left: 50px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
    font-size: 14px;
    }

    #addCartButton {
    background-color: black;
    color: white;
    cursor: pointer;
    margin-top: 20px;
    margin-left: 50px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
    font-size: 14px;
    }

    
    #addCartButton:active {
    transform: scale(0.9);
    background: radial-gradient( circle farthest-corner at 10% 20%,  rgba(255,94,247,1) 17.8%, rgba(2,245,255,1) 100.2% );
    }

    #buyNowButton:active {
    transform: scale(0.9);
    background: radial-gradient( circle farthest-corner at 10% 20%,  rgba(255,94,247,1) 17.8%, rgba(2,245,255,1) 100.2% );
    }

    .quantity{
      padding-left:50px ;
    }

    #increment{
      margin-left:15px ;
      margin-right: 0px;
    }

    #quantity_input{
      margin-left: 0px;
      padding-top: 5px;
      padding-bottom: 5px;
      width: 50px;
      height: 20px;
      text-align: center;
    }

    #decrement{
      margin-left:0px;
      padding-left: 13px;
      padding-right: 13px;
      
    }

    .buyBtn{
      display: flex;
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
    <div id="container">
        <div>
            <img class="keyboard" src="' . $image . '" alt="">
        </div>
        <div>
            <div class="names">' . $product_name . '</div>
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
            <div id="status-' . 0 . '" class="status">' . $status . ' sold</div>
        </div>
        <div id="price-' . 0 . '" class="prices">' . $price . '</div>
        <form action="order.php?product_id=1" method="post">
            <div class="quantity">
                <label for="quantity" class="quantity_label">Quantity:</label>
                <div id="messageContainer"></div>
                <button id="increment">+</button>
                <input type="number" id="quantity_input" name="quantity_input" min="1" value="1">
                <button id="decrement">-</button>
            </div>
            <div class="buyBtn">
                <div>
                    <input id="addCartButton" class="button" type="submit" name="addCart" value="Add To Cart">
                </div>
                <div>
                    <input id="buyNowButton" class="button" type="submit" name="addOrder" value="Buy Now">
                </div>
            </div>
        </form>
    </div>
</div>';

echo $newProduct2;
?>
<script>
const quantity_input=document.getElementById('quantity_input');  
const incrementButton = document.getElementById('increment');

incrementButton.addEventListener('click', function(event) {
    event.preventDefault();
    currentValue = parseInt(quantity_input.value)
    quantity_input.value=currentValue+1
});
const decrementButton = document.getElementById('decrement');

decrementButton.addEventListener('click', function(event) {
    if (currentValue>1){
        event.preventDefault();
        let currentValue = parseInt(quantity_input.value)
        quantity_input.value = currentValue - 1;
    }
    else{
        event.preventDefault();
    }
})

  document.getElementById("addCartButton").addEventListener("click", function(event) {
    // Prevent the default form submission
    event.preventDefault();

    var messageContainer = document.getElementById("messageContainer");
    messageContainer.textContent = "Added to cart successfully!";
    messageContainer.style.display = "block";
    messageContainer.classList.add("message-container");
    setTimeout(function() {
        messageContainer.style.display = "none";
      }, 2000);
  });
  document.getElementById("Cart").addEventListener("click", function() {
    window.location.href = "confirm.php";
  });

</script>

  
    