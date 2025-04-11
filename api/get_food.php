<?php
$conn = new mysqli("localhost", "root", "", "zerowaste");
if ($conn->connect_error) die("Connection failed");

$result = $conn->query("SELECT * FROM food_posts WHERE status = 'available'");
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
