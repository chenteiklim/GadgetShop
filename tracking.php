<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, $dbname);
$selectOrderQuery = "SELECT user_id, order_id, name, email, address, contact, clickDate FROM orders";
$result = $conn->query($selectOrderQuery);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $user_id = $row['user_id'];
    $order_id = $row['order_id'];
    $name = $row['name'];
    $email = $row['email'];
    $address = $row['address'];
    $contact = $row['contact'];
    $clickDate = $row['clickDate'];
    $shippingDate = date('Y-m-d', strtotime($clickDate . '+1 day'));
    $deliveryDate = date('Y-m-d', strtotime($clickDate . '+4 days')); // 1 day for shipping + 3 days for delivery
  }
}
else {
    // No orders found, redirect to mainpage.php
    $message = "Your order is empty.";
    // Append the message as a parameter to the URL
    header("Location: mainpage.php?message=" . urlencode($message));
    exit();
}




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="tracking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="script.js" defer></script>
    <style>
        /* CSS for tracking elements */
body{
    background-color:bisque;
}
.container{
    margin-top:100px;
    margin-left:400px;
    display:flex;
    justify-content:center;
    background-color:white;
    width:800px;
    height:200px;
}
.row{
    margin-right:600px;
    margin-bottom: 300px;
    display: flex;
    width: 400px;
}/* CSS for tracking elements */
.order-tracking {
    text-align: center;
    width: 33.33%;
    position: relative;
    display: block;
}
#navContainer{
    display:flex;
    justify-content:center;
    align-items:center;
        width:1400px;
        height:60px;
        background-color: black;
    }
.order-tracking .is-complete {
    display: block;
    position: relative;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    border: 0px solid #AFAFAF;
    background-color: #f7be16;
    margin: 0 auto;
    transition: background 0.25s linear;
    -webkit-transition: background 0.25s linear;
    z-index: 2;
}

.order-tracking.completed .is-complete {
    border-color: #27aa80;
    border-width: 0px;
    background-color: #27aa80;
}

.order-tracking.completed .is-complete::before {
    content: "\f00c";
    display: block;
    position: absolute;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: 16px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
}

.order-tracking p {
    color: #A4A4A4;
    font-size: 16px;
    margin-top: 8px;
    margin-bottom: 0;
    line-height: 20px;
}

.order-tracking p span {
    font-size: 14px;
}

.order-tracking::before {
    content: '';
    display: block;
    height: 3px;
    width: calc(100% - 40px);
    background-color: #f7be16;
    top: 13px;
    position: absolute;
    left: calc(-50% + 20px);
    z-index: 0;
}

.order-tracking:first-child:before {
    display: none;
}

.order-tracking.completed:before {
    background-color: #27aa80;
}

#back {
    margin-left:800px;
    background-color: black;
    color: white;
    cursor: pointer;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 16px;
    }
    button:active {
      transform: scale(0.9);
      background: radial-gradient( circle farthest-corner at 10% 20%,  rgba(255,94,247,1) 17.8%, rgba(2,245,255,1) 100.2% );
    }
    
#logOut{
    margin-left: 200px;
}
    </style>
</head>
<body>
<div id="navContainer"> 

<!-- Your form fields here -->
<button id="back" class="button"><?php echo 'Back' ?></button>

</div>
<div id="container">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                <div class="row justify-content-between">
                    <div class="order-tracking" id="order1">
                        <span class="is-complete"></span>
                        <p>Ordered<br><span><?php echo $clickDate ?></span></p>
                    </div>
                    <div class="order-tracking" id="order2">
                        <span class="is-complete"></span>
                        <p>Shipped<br><span><?php echo $shippingDate ?></span></p>
                    </div>
                    <div class="order-tracking" id="order3">
                        <span class="is-complete"></span>
                        <p>Delivered<br><span><?php echo $deliveryDate ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
var back = document.getElementById("back");

back.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "mainpage.php";
});

</script>