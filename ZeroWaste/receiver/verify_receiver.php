<?php
session_start();
$conn = new mysqli("localhost", "root", "", "zerowaste");
$email = $_POST['email'];

$result = $conn->query("SELECT * FROM ngos_volunteers WHERE email = '$email'");
if ($result->num_rows > 0) {
    $_SESSION['receiver'] = $email;
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Unauthorized: Email not found'); window.location.href='login.html';</script>";
}
?>
