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
$email=$_SESSION['email'];
$product3_id=$_SESSION['product3_id'];
mysqli_select_db($conn, $dbname);

$selectQuery = "SELECT * FROM products WHERE product_id = $product3_id";
$result = $conn->query($selectQuery);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $image = $row['image'];
} else {
    echo 'Image not found';
}

?>

<div id="navContainer"> 
    <button id="back" class="button"><?php echo 'Back' ?></button>

</div>
<div id="container">
  <img src="<?php echo $image;?>" alt="" srcset="">
    
</div>

<script>
var back = document.getElementById("back");

back.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "refund.php";
});
</script>