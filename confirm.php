<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgetShop";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve product data using your own logic
// Replace the following code with your actual data retrieval logic

// Assuming you have retrieved the product ID for a specific user
session_start();
$email = $_SESSION['email'];
$quantity=$_SESSION['quantity'];
$sql = "SELECT product_id FROM orders WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the product ID from the result
    $row = $result->fetch_assoc();
    $product_id = $row['product_id'];
}

$sql2 = "SELECT * FROM orders WHERE product_id = '$product_id'";
$result = $conn->query($sql2);

if ($result->num_rows > 0) {
    // Fetch the product ID from the result
    $row = $result->fetch_assoc();
    $image = $row['image'];
    $product_name = $row['product_name'];
    $price = $row['price'];
}
$sql3 = "SELECT COUNT(DISTINCT product_id) AS product_count FROM orders WHERE email = '$email'";
$result = $conn->query($sql3);

if ($result->num_rows > 0) {
    // Fetch the product count from the result
    $row = $result->fetch_assoc();
    $product_count = $row['product_count'];
}
?>
<head>
    <style>
       
  
#container {

  display: grid;
  grid-template-columns: repeat(4, 2fr);
  grid-gap: 10px; /* Optional: Add spacing between columns */
  flex-wrap: wrap; /* Allow columns to wrap to new rows */
}

.item{
 width:100px;
 height:100px;
}
#container > * {
  display: flex;
  justify-content: center;
  align-items: center;
}
.Product{
    font-size:20px;
}

.product_name {
    font-size:20px;
    margin-left:80px;
    color: black;
}

.price {
    margin-left:80px;
    font-size: 20px;
    color: red;
}

.quantity {
    font-size: 20px;
    margin-left:80px;
}

#prices{
    font-size:30px;
    color:red;
}
#checkOut{
    display:flex;
    font-size: 20px;
    align-items:center;
    margin-left:600px;
    margin-top:400px;
    position: fixed;
    
}

button {
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
    
    button:active {
      transform: scale(0.9);
      background: radial-gradient( circle farthest-corner at 10% 20%,  rgba(255,94,247,1) 17.8%, rgba(2,245,255,1) 100.2% );
    }
    
    body{
        background-color: bisque;
        width: 1400px;
        height: 1400px;
    }
      
    
    #navContainer{
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
    <button class="button"><?php echo 'Profile' ?></button>
    <button id="logOut" class="button"><?php echo 'Log Out' ?></button>
    <button id="back" class="button"><?php echo 'Back' ?></button>
</form>
  
</div>
<div id="container">
<?php
for ($order_id = 1; $order_id <= 10; $i++) {
    echo $i . ' ';
}
?>
    <div class="Product"><?php echo 'Product'; ?> </div>
    <div class="product_name"><?php echo 'Product Name'; ?></div>
    <div class="price"><?php echo 'Price'; ?></div>
    <div class="quantity"><?php echo 'Quantity'; ?></div>
    <div>
        <img class="item" src="<?php echo $image; ?>" alt="">
    </div>
    <div class="product_name"><?php echo $product_name; ?></div>
    <div class="price"><?php echo 'RM'.$price; ?></div>
    <div class="quantity">x<?php echo $quantity; ?></div>
</div>
<div id=checkOut>
    
    <div>
    <?php echo 'Total'.$product_count.'item';?>
    </div>
    <div id=prices>
        <?php echo 'RM'.$price*$quantity;?>
    </div>
    <div>
        <button class="button"><?php echo 'Check Out' ?></button>        
    </div>
</div>


<script>
document.getElementById('back').addEventListener('click', function(e) {
    e.preventDefault();

    // Get the form data
    var formData = new FormData(document.getElementById('dataForm'));

    // Make an AJAX request to save the data in session
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'homepage.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Data saved successfully, handle the response if needed
           console.log('data saved successfully')
           window.location.href=('homepage.php')
        } else {
            // Error occurred, handle the error if needed
            console.error('Error occurred while saving data.');
        }
    };
    xhr.onerror = function() {
        // Request error occurred, handle the error if needed
        console.error('Request error occurred.');
    };
    xhr.send(formData);
});
</script>



