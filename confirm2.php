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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    
    // Delete the record from the database
    $sql = "DELETE FROM user_$user_id WHERE product_id = '$product_id'";
    $result = $conn->query($sql);
    
    // Redirect the user back to the current page after deletion
    header("Location: confirm2.php");
    exit;
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

<head>
    <style>

body{
    display: flex;
    flex-direction:column;

}

#container {

width:1200px;
background-color: #CDCDCD;
display: flex;
align-items:center;
flex-direction:column;
height: 100%;

 
}

.item{
 width:100px;
 height:100px;
}

.title{
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    width:800px;
    grid-gap: 10px;
    margin-top: 50px;
    margin-bottom:40px;
    font-size:20px;
   
}
.total_price{
    text-align:center;
    color:red;
}
.content{
    width:800px;
    font-size:20px;
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    grid-gap: 10px;
    align-items:center;
    margin-bottom: 50px;
    

}

.Product{
    font-size:20px;
    text-align:center;
}

.product_name {
    text-align:center;
    font-size:20px;
    color: black;
}

.price {
    text-align:center;
    font-size: 20px;
    color: red;
}

.quantity {
    text-align:center;
    font-size: 20px;
}

#prices{
    text-align:center;
    font-size:30px;
    color:red;
}
#checkOut{
    background-color:white;
    display:flex;
    font-size: 25px;
    width:1200px;
    margin-top:480px;
    height:400px;
    position: fixed;
}

.total{
    width:700px;
    margin-left:400px;
    margin-top:120px;
    display:flex;
}

#total_item{
    padding-left:10px;
}
#price{
    display:flex;
    align-items:center;
    justify-content:center;
    
}

#total_price{
    text-align:center;
}

#quantity{
    text-align:center;
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
        display:flex;
        text-align:center;
        align-items:center;
        background-color: bisque;
        width: 1400px;
        height: 1400px;
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
<form action="homepage.php" method="POST">
    <!-- Your form fields here -->
    <button class="button"><?php echo 'Shopping Cart'; ?></button>
    <button class="button"><?php echo 'Notification' ?></button>
    <button class="button"><?php echo $name;?></button>
    <button id="logOut" class="button"><?php echo 'Log Out' ?></button>
        <button type="submit" class="back-button">Home</button>
</form>  

  
</div>
<div id="container">
<div class='title'>
    <div class="Product"><?php echo 'Product'; ?> </div>
    <div class="product_name"><?php echo 'Product Name'; ?></div>
    <div class="price"><?php echo 'Price'; ?></div>
    <div class="quantity"><?php echo 'Quantity'; ?></div>
    <div class="total_price"><?php echo 'Total Price'; ?></div>
</div>

<?php
$grandTotal=0;
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
        $total_price=$row['total_price'];
        $grandTotal += $total_price;
        $product_ids[] = $product_id;
        $_SESSION['product_ids'] = $product_ids;

    }

    
?>  
<div class="content">
    <img class="item" src="<?php echo $image; ?>" alt="">
    <div class="product_name"><?php echo $product_name; ?></div>
    <div id="price"><?php echo 'RM'.$price; ?></div>
    <div id="quantity">x<?php echo $quantity; ?></div>
    <div id="total_price"><?php echo 'RM'.$total_price; ?></div>
    <form action="confirm2.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <button type="submit" class="delete-button">Delete</button>
    </form>  
</div>

<script src="confirm.js"></script>
<?php
}
?>
</div>
    <div id="checkOut">
        <form action="checkOut.php" method="POST">
            <div class="total">
            <div>
            Total
            </div>
            <div id="total_item">
            <?php echo "($total_rows item):"?>
            </div>
            <div id="total_prices">
            <?php echo "RM $grandTotal"?>
                <button id="checkOutbtn" class="button"><?php echo 'Check Out' ?></button>
        </form>  
    </div>
</div>
</div>
