<?php
$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $Username, $Password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['addOrder'])) {
    $id = $_GET['id'];
    mysqli_select_db($conn, $dbname);
    $sql = "SELECT product_name, price FROM products WHERE id = " . $id;
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the row from the result set
        $row = $result->fetch_assoc();

        // Retrieve the name and price from the row
        $product_name = $row['product_name'];
        $price = $row['price'];
    }

    session_start();
    $quantity = $_POST['quantity_input'];
    $email=$_SESSION['email'];
    
    $selectAddressQuery = "SELECT name,address FROM users WHERE email = '$email'";
    // Execute the query
    $result = $conn->query($selectAddressQuery);

    if ($result->num_rows > 0) {
        // Fetch the row from the result
        $row = $result->fetch_assoc();
    }
        // Get the address value from the fetched row
        $name = $row['name'];
        $address = $row['address'];
        mysqli_select_db($conn, $dbname); 
    $insertUserQuery = "INSERT INTO orders (quantity,name,email,address,product_name,price) VALUES ('$quantity','$name','$email','$address','$product_name','$price')";
        if ($conn->query($insertUserQuery) === true) 
            {
                echo('hello world');
                exit();
            }
}

?>
