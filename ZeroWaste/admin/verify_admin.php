<?php
session_start();

$valid_user = "admin";
$valid_pass = "zerowaste123"; // You can hash this later

if ($_POST['username'] === $valid_user && $_POST['password'] === $valid_pass) {
    $_SESSION['admin'] = true;
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Invalid credentials'); window.location.href='login.html';</script>";
}
?>
