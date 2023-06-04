<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['addOrder'])) {
    session_start();
    $email = $_SESSION['email'];
    $product_id = $_GET['product_id'];
    echo($product_id);
    mysqli_select_db($conn, $dbname);
    $sql = "SELECT user_id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user ID from the result
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    }
    $tableName = "user_" . $user_id;

    // Check if the table already exists
    $tableExists = $conn->query("SHOW TABLES LIKE '$tableName'");

    if ($tableExists->num_rows == 0) {
        // Create the table if it doesn't exist
        $createTableQuery = "CREATE TABLE $tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            product_id INT(6) NOT NULL,
            quantity INT(6) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            image VARCHAR(255) NOT NULL
        )";

        if ($conn->query($createTableQuery) === TRUE) {
            echo "Table '$tableName' created successfully.";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    }
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
        echo($name);
        echo($address);

        mysqli_select_db($conn, $dbname); 
    $insertUserQuery = "INSERT INTO user_$user_id (product_id,quantity,name,email,address,product_name,price,image) VALUES ('$product_id','$quantity','$name','$email','$address','$product_name','$price','$image')";
        if ($conn->query($insertUserQuery) === true) 
            {
                header("Location: confirm.php");
                exit();
            }


?>

