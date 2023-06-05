
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



$sql = "SELECT user_id FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the user ID from the result
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
}
mysqli_select_db($conn, $dbname);
$maxIdQuery = "SELECT MAX(id) AS max_id FROM user_{$user_id}";
$maxIdResult = $conn->query($maxIdQuery);

if ($maxIdResult && $maxIdResult->num_rows > 0) {
    $row9 = $maxIdResult->fetch_assoc();
    $maxId = $row9['max_id'];
}

// Query to retrieve all rows in ascending order
$selectRowsQuery = "SELECT * FROM user_$user_id ORDER BY id ASC";
$selectRowsResult = $conn->query($selectRowsQuery);

$rows = []; // Initialize an empty array to store the rows

if ($selectRowsResult && $selectRowsResult->num_rows > 0) {
    while ($row = $selectRowsResult->fetch_assoc()) {
        $rows[] = $row; // Add each row to the array
    }
}

// Loop through the array of rows
foreach ($rows as $row) {
    $product_id = $row['product_id'];
    $product_name = $row['product_name'];
    $name = $row['name'];
    $address = $row['address'];
    $price = $row['price'];
    $image = $row['image'];
}


// Query to count the total number of rows in the table
$countQuery = "SELECT COUNT(*) AS total FROM user_$user_id";
$countResult = $conn->query($countQuery);

if ($countResult && $countResult->num_rows > 0) {
    $row6 = $countResult->fetch_assoc();
    $total_rows = $row6['total'];
} else {
    $total_rows = 0;
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
// Loop through the orders
for ($order_id = 1; $order_id <= $maxId ; $order_id++) {
    $selectRowQuery = "SELECT * FROM user_$user_id WHERE id = $order_id";
    $selectRowResult = $conn->query($selectRowQuery);

    if ($selectRowResult && $selectRowResult->num_rows > 0) {
        $row = $selectRowResult->fetch_assoc();
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $name = $row['name'];
        $address = $row['address'];
        $price = $row['price'];
        $image = $row['image'];
        $quantity = $row['quantity'];
    }
        ?>
        <div id="container">
            <div class="Product"><?php echo 'product'; ?> </div>
            <div class="product_name"><?php echo 'product_name'; ?></div>
            <div class="price"><?php echo 'price'; ?></div>
            <div class="quantity"><?php echo 'quantity'; ?></div>
            <div>
                <img class="item" src="<?php echo $image; ?>" alt="">
            </div>
            <div class="product_name"><?php echo $product_name; ?></div>
            <div class="price"><?php echo 'RM'.$price; ?></div>
            <div class="quantity">x<?php echo $quantity; ?></div>
        </div>
        <div id="checkOut">
            <div>
            </div>
            <div id="prices">
                <?php echo 'RM'.$price*$quantity; ?>
            </div>
            <div>
                <button class="button"><?php echo 'Check Out'; ?></button>
            </div>
        </div>
        <script src="confirm.js"></script>
<?php
}
?>
