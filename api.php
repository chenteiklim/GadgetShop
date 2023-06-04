<?php
$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $Username, $Password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
mysqli_select_db($conn, $dbname); 
if ($conn){
    $sql = "SELECT product_id FROM products";
    $result=mysqli_query($conn,$sql);
    if($result){
        header("Content-Type:JSON");
        $response=array();
        while($row=mysqli_fetch_assoc($result)){
            $product_id=$row['product_id'];
            $sql = "SELECT * FROM products WHERE product_id = $product_id";
            $productResult = mysqli_query($conn, $sql);

            if ($productResult){
                $productRow=mysqli_fetch_assoc($productResult);
                $response[]=array(
                    'product_id' => $productRow['product_id'],
                    'product_name' => $productRow['product_name'],
                    'price' => $productRow['price'],
                    'description' => $productRow['description'],
                    'image' => $productRow['image'],
                    'stock' => $productRow['stock'],
                    'status' => $productRow['status'],
                    'rating' => $productRow['rating'],
                    'review' => $productRow['review'],
                    'discount' => $productRow['discount'],
                    'category' => $productRow['category']

                );
            }
        }
        echo json_encode($response,JSON_PRETTY_PRINT);
    }
}
?>