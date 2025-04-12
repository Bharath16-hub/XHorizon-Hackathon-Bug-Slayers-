<?php
session_start();
if (!isset($_SESSION['receiver'])) {
    die("Unauthorized access");
}
$conn = new mysqli("localhost", "root", "", "zerowaste");

$post_id = $_POST['post_id'];
$conn->query("UPDATE food_posts SET status = 'accepted' WHERE id = $post_id");

header("Location: dashboard.php");
?>
