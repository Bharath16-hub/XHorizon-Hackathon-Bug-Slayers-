<?php
$conn = new mysqli("localhost", "root", "", "zerowaste");
if ($conn->connect_error) die("Connection failed");

$donor_name = $_POST['donor_name'];
$email = $_POST['email'];
$food_type = $_POST['food_type'];
$category = $_POST['category'];
$quantity = $_POST['quantity'];
$expiry = $_POST['expiry'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$image_path = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = "../uploads/";
    $image_name = uniqid() . "_" . basename($_FILES['image']['name']);
    $target_file = $upload_dir . $image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_path = "uploads/" . $image_name; // path used in frontend
    }
}

$query = "INSERT INTO food_posts (donor_name, email, food_type, category, quantity, expiry, latitude, longitude, image_path)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssssdsdds", $donor_name, $email, $food_type, $category, $quantity, $expiry, $lat, $lng, $image_path);
if ($stmt->execute()) {
    echo "Success: Donation Posted";
} else {
    echo "Error: " . $stmt->error;
}
$conn->close();
?>
