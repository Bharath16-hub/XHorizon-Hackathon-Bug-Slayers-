<?php
session_start();
if (!isset($_SESSION['receiver'])) {
    header("Location: login.html");
    exit();
}
$conn = new mysqli("localhost", "root", "", "zerowaste");
$foodPosts = $conn->query("SELECT * FROM food_posts WHERE status = 'available'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Receiver Dashboard</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f4f4f4; }
    .card {
      background: white;
      padding: 15px;
      margin: 15px 0;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .card img { max-width: 100%; border-radius: 10px; }
  </style>
</head>
<body>
  <h2>Welcome, <?= $_SESSION['receiver'] ?> 👋</h2>
  <h3>Available Food Donations</h3>

  <?php while($row = $foodPosts->fetch_assoc()): ?>
    <div class="card">
      <img src="../<?= $row['image_path'] ?>" alt="Food Image" />
      <p><strong>Donor:</strong> <?= $row['donor_name'] ?></p>
      <p><strong>Food Type:</strong> <?= $row['food_type'] ?> (<?= $row['category'] ?>)</p>
      <p><strong>Quantity:</strong> <?= $row['quantity'] ?> kg</p>
      <p><strong>Expires:</strong> <?= $row['expiry'] ?></p>
      <form method="POST" action="accept_donation.php">
        <input type="hidden" name="post_id" value="<?= $row['id'] ?>" />
        <button type="submit">Accept Donation</button>
      </form>
    </div>
  <?php endwhile; ?>
</body>
</html>
