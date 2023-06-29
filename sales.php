<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadgetShop";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, $dbname);
$selectOrderQuery = "SELECT user_id, order_id, name, email, address, contact, clickDate FROM orders";
$result = $conn->query($selectOrderQuery);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $user_id = $row['user_id'];
    $order_id = $row['order_id'];
    $name = $row['name'];
    $email = $row['email'];
    $address = $row['address'];
    $contact = $row['contact'];
    $clickDate = $row['clickDate'];
    $shippingDate = date('Y-m-d', strtotime($clickDate . '+1 day'));
    $deliveryDate = date('Y-m-d', strtotime($clickDate . '+4 days')); // 1 day for shipping + 3 days for delivery
  }
}