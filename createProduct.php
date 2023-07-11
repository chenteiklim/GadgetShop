
<?php

$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $Username, $Password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
    if (isset($_POST['submit'])) {
        $productName = $_POST['productName'];
        $productImage = $_FILES['productImage']['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        

        $targetDir = "C:/xampp/htdocs/Project/EnterpriseProject/"; // Directory where you want to store the uploaded files
        $filename = $_FILES['productImage']['name'];

        $targetFile = $targetDir . $filename;
        move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile);

        // Perform any necessary validation or sanitization of the input values here
        mysqli_select_db($conn, $dbname);
        // Retrieve the next available product_id value
$nextProductIDQuery = "SELECT MAX(product_id) AS max_id FROM products";
$result = $conn->query($nextProductIDQuery);
$row = $result->fetch_assoc();
$maxProductID = $row['max_id'];
echo $maxProductID;
$nextProductID = $maxProductID + 1;

// Insert the product with the custom incrementing value
$insertProduct = "INSERT INTO products (product_id, product_name, image, price, stock, status) VALUES ('$nextProductID', '$productName', '$productImage', '$price', '$stock', 0)";
    
        // Execute the SQL statement
        if ($conn->query($insertProduct) === TRUE) {
          $product_id = $conn->insert_id; 
        } else {
            echo "Error: " . $mysqli->error;
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
form{
  height:320px;

}
  
.container {
  margin-top:20px;
  width: 550px;
  height:500px;
  background-color:white;
  display: flex;
  flex-direction: column;
  gap:5px;
}


.button {
    background-color: darkblue;
    width:200px;
    color: white;
    cursor: pointer;
    margin-left: 20px;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 16px;
    }
    .button:active {
      transform: scale(0.9);
      background: radial-gradient( circle farthest-corner at 10% 20%,  rgba(255,94,247,1) 17.8%, rgba(2,245,255,1) 100.2% );
    }
    
    body{
        display:flex;
        flex-direction:column;
        align-items:center;
        background-color: bisque;
        width: 100%;
        height: 1400px;
    }



#navContainer{
        display:flex;
        align-items:center;
        justify-content:center;
        width:100%;
        background-color: black;
    }
    form {
      margin-top:30px;
      border: 3px solid #f1f1f1;
    }

input[type=file],input[type=text],input[type=number]{
  padding: 12px 20px;
  width:300px;
  margin: 8px 5px;
  border: 1px solid #ccc;
  box-sizing: border-box;
  
}


#createProduct{
  background-color: blueviolet;
  color: white;
  padding: 14px 20px;
  border: none;
  cursor: pointer;
  width: 120px;
  margin-top:10px;
  margin-left:300px;
}

#register{
  background-color: blueviolet;
  color: white;
  padding: 14px 20px;
  border: none;
  cursor: pointer;
  width: 120px;
}

#reset{
  background-color: blue;
  color: white;
  padding: 10px 16px;
  margin-top: 10px;
  border: none;
  cursor: pointer;
  width: 160px;
  border-radius: 5%;
}

#title{
  font-size:20px;
  margin-top:30px;
}

.content{
  margin-left:40px;
  width: 480px;
}
    </style>
</head>

<div id="navContainer"> 
    <button id="back" class="button"><?php echo 'Back' ?></button>
    <button id="logOut" class="button"><?php echo 'Log Out' ?></button>
</div>
<div class="container">
  <div class="content">
  <div id='title'>
    Create Product
  </div>
  <form action="createProduct.php" method="post" enctype="multipart/form-data">
      <div id="nameContainer">
        <label for="productName"><b>Product Name</b></label>
        <input type="text" placeholder="Enter Product Name" name="productName" required>
      </div>
    <div class="imageContainer">
      <label for="productImage"><b>Product Image address</b></label>
      <input type="file" name="productImage" required>
    </div>
    <div class="priceContainer">   
      <label for="price"><b>Price wanted to sell</b></label>
      <input type="number" placeholder="Enter price" name="price" required>
    </div>
    <div class='stockContainer'>
      <label for="stock"><b>Stock</b></label>
      <input type="text" placeholder="Enter how many stock do you have (minimum 10)" name="stock" required>
    </div>
    <input id="createProduct" type="submit" name="submit" value="Create Product">
      
  </form>
  </div>
</div>
<script>
var logOutButton = document.getElementById("logOut");

logOutButton.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "sellerLogin.html";
});

var back= document.getElementById("back");

back.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "adminHomepage.php";
});

</script>

  
   