<?php
session_start();
if (!isset($_SESSION['admin'])) die("Unauthorized");

$conn = new mysqli("localhost", "root", "", "zerowaste");
$id = $_POST['id'];

$conn->query("DELETE FROM food_posts WHERE id = $id");
header("Location: dashboard.php");
?>
