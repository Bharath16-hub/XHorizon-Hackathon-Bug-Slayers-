<?php
session_start();
if (!isset($_SESSION['admin'])) die("Unauthorized");

$conn = new mysqli("localhost", "root", "", "zerowaste");
if ($conn->connect_error) die("Connection failed");

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$role = $_POST['role'];
$location = $_POST['location'];

$stmt = $conn->prepare("INSERT INTO ngos_volunteers (name, email, phone, role, location) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $role, $location);

if ($stmt->execute()) {
    header("Location: dashboard.php");
} else {
    echo "Error: " . $stmt->error;
}
?>
