
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
mysqli_select_db($conn, $dbname);
$selectNameQuery = "SELECT name FROM admin";
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
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></link>
    <style>

  
#container {
    width:1200px;
  display: flex;
  flex-direction: column;
  align-items:center;
}


.button {
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
#btn {
    background-color: black;
    color: white;
    cursor: pointer;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 10px;
    margin-top: 10px;
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


    
    #logOut{
        margin-left: 200px;
    }



#navContainer{
        width:1200px;
        background-color: black;
    }
    
    #logOut{
        margin-left: 200px;
    }

    .sell{
        margin-top:80px;
    }
    
    #edit{
        margin-top:20px;
    }
    #admin{
        margin-top:20px;
    }
    
    #sales{
        margin-top:20px;
    }
    </style>
</head>

<div id="navContainer"> 

    <!-- Your form fields here -->
    <input type="hidden" name="data" value="<?php echo $_SESSION['data']; ?>">
    <button class="button"><?php echo $name ?></button>
    <button id="logOut" class="button"><?php echo 'Log Out' ?></button>

</div>
<div id="container">
  
    <div class="sell">
    <button id="sell" class="button"><?php echo 'Sell Product' ?></button>
    </div>
    <div class="edit">
    <button id="edit" class="button"><?php echo 'Edit Product' ?></button>
    </div>
    <div class="admin">
    <button id="admin" class="button"><?php echo 'Sales' ?></button>
    </div>
    <div class="sales">
    <button id="sales" class="button"><?php echo 'Daily sales' ?></button>
    </div>
</div>
 
<script>
var logOutButton = document.getElementById("logOut");

logOutButton.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "sellerLogin.html";
});

var sell= document.getElementById("sell");
sell.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "createProduct.php";
});

var edit= document.getElementById("edit");

edit.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "editProduct.php";
});

var admin= document.getElementById("admin");
admin.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "sales.php";
});


var sales= document.getElementById("sales");
sales.addEventListener("click", function() {
  // Perform the navigation action here
  window.location.href = "dailySales.php";
});
</script>

  
   