<?php
$conn = new mysqli("localhost", "root", "", "zerowaste");
$id = $_POST['post_id'];
$conn->query("UPDATE food_posts SET status='accepted' WHERE id=$id");
?>
