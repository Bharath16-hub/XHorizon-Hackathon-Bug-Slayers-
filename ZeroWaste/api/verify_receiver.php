<?php
$conn = new mysqli("localhost", "root", "", "zerowaste");
$email = $_POST['email'];
$res = $conn->query("SELECT * FROM ngos_volunteers WHERE email = '$email'");
echo $res->num_rows > 0 ? 'valid' : 'invalid';
?>
