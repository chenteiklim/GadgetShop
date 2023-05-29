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
    $sql = "SELECT id FROM products";
    $result=mysqli_query($conn,$sql);
    if($result){
        header("Content-Type:JSON");
        $response=array();
        while($row=mysqli_fetch_assoc($result)){
            $id=$row['id'];
            $sql = "SELECT * FROM products WHERE id = $id";
            $productResult = mysqli_query($conn, $sql);

            if ($productResult){
                $productRow=mysqli_fetch_assoc($productResult);
                $response[]=array(
                    'id' => $productRow['id'],
                    'name' => $productRow['name'],
                    'price' => $productRow['price'],
                    'description' => $productRow['description'],
                    'image' => $productRow['image'],
                    'quantity' => $productRow['quantity'],
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