<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['addCart'])) {
    session_start();
    $email = $_SESSION['email'];
    $product_id = $_SESSION['product_id'];
    $clickDate = date("Y-m-d");
  // Format the date in the desired format "Y-m-d"
  $formattedDate = date("Y-m-d", strtotime($clickDate));
    echo($product_id);
    mysqli_select_db($conn, $dbname);

if (!isset($_SESSION['order_id'])) {
    $maxIdQuery = "SELECT MAX(order_id) AS max_id FROM orders WHERE email= '$email'";
    $maxIdResult = $conn->query($maxIdQuery);

    if ($maxIdResult->num_rows > 0) {
        $row= $maxIdResult->fetch_assoc();
    $order_id = $row['max_id'] + 1;
    $_SESSION['order_id'] = $order_id;
    echo $order_id;
    }

}
else{
    $order_id=1;
    echo $order_id;
    }
}
    

    $sql = "SELECT user_id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        // Fetch the user ID from the result
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    }
  


  


    $result = $conn->query($sql);

    $sql = "SELECT product_name, price, image FROM products WHERE product_id = " . $product_id;
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the row from the result set
        $row = $result->fetch_assoc();

        // Retrieve the name and price from the row
        $product_name = $row['product_name'];
        $price = $row['price'];
        $image=$row['image'];
    }

    $quantity = $_POST['quantity_input'];
    $_SESSION['quantity'] = $quantity;
    $email=$_SESSION['email'];
    $total_price=$quantity*$price;
    $selectAddressQuery = "SELECT name,address,contact FROM users WHERE email = '$email'";
    // Execute the query
    $result = $conn->query($selectAddressQuery);

    if ($result->num_rows > 0) {
        // Fetch the row from the result
        $row = $result->fetch_assoc();
    }
        // Get the address value from the fetched row
        $name = $row['name'];
        $address = $row['address'];
        $contact= $row['contact'];
        echo($name);
        echo($address);

        mysqli_select_db($conn, $dbname); 
        

// Check if the ID exists in the table
echo $order_id;
$checkQuery = "SELECT COUNT(*) AS count FROM cart" . $order_id . " WHERE id = 1";
$checkResult = $conn->query($checkQuery);

if ($checkResult && $checkResult->num_rows > 0) {
    $row8 = $checkResult->fetch_assoc();
    $count = $row8['count'];

    if ($count > 0) {
        // If the ID exists, fetch the highest ID value
        $maxIdQuery = "SELECT MAX(id) AS max_id FROM cart$order_id";
        $maxIdResult = $conn->query($maxIdQuery);

        if ($maxIdResult && $maxIdResult->num_rows > 0) {
            $row9 = $maxIdResult->fetch_assoc();
            $maxId = $row9['max_id'];
            $id2 = $maxId + 1;
        }
    }
}

// If the ID is still not set, set it to 1
if (!isset($id2)) {
    $id2 = 1;
}


$checkQuery2 = "SELECT COUNT(*) AS count FROM cart" . $order_id . " WHERE product_id = $product_id";
$checkResult2 = $conn->query($checkQuery2);

if ($checkResult2 && $checkResult2->num_rows > 0) {
    $row3 = $checkResult2->fetch_assoc();
    $count3 = $row3['count'];

    if ($count3 > 0) {
        // If the ID exists, perform the desired action
        $successMessage3 = "Product has been selected";
          header("Location: product.php?message=" . urlencode($successMessage3));  
            exit();
    }
    else{
        echo $order_id;
        $insertcart = "INSERT INTO cart$order_id (id,user_id,order_id,product_id,quantity,name,email,address,product_name,price,image,total_price,contact) VALUES ('$id2','$user_id','$order_id','$product_id','$quantity','$name','$email','$address','$product_name','$price','$image','$total_price','$contact')";
        $insertorders = "INSERT INTO orders (user_id,order_id,product_id,quantity,name,email,address,product_name,price,image,total_price,contact,order_status) VALUES ('$user_id','$order_id','$product_id','$quantity','$name','$email','$address','$product_name','$price','$image','$total_price','$contact','cart')";
        $adminOrders = "INSERT INTO adminorders (user_id,order_id,product_id,quantity,name,email,address,product_name,price,image,total_price,contact,order_status) VALUES ('$user_id','$order_id','$product_id','$quantity','$name','$email','$address','$product_name','$price','$image','$total_price','$contact','cart')";
        
        $_SESSION['order_id']=$order_id;
        if ($conn->query($insertcart)&& $conn->query($insertorders)&& $conn->query($adminOrders)=== true) {
            $successMessage = "Added to cart successfully!";
            echo $order_id;
           header("Location: product.php?message=" . urlencode($successMessage));  
            exit();
        }
        else {
            // Handle the error if the query fails
            echo "Error inserting order: " . $conn->error;
        }
        }
}





?>

