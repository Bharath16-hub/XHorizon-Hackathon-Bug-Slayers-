<?php
$conn = new mysqli("localhost", "root", "", "zerowaste");
if ($conn->connect_error) die("Connection failed");

$donor_name = $_POST['donor_name'];
$food_type = $_POST['food_type'];
$category = $_POST['category'];
$quantity = $_POST['quantity'];
$expiry = $_POST['expiry'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$query = "INSERT INTO food_posts (donor_name, food_type, category, quantity, expiry, latitude, longitude)
          VALUES ('$donor_name', '$food_type', '$category', '$quantity', '$expiry', '$lat', '$lng')";

echo $conn->query($query) ? "Success" : "Error: " . $conn->error;
$conn->close();
?>
