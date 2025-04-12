<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "zerowaste");
if ($conn->connect_error) die("Connection failed");

$report = $conn->query("SELECT SUM(quantity) AS total_food, COUNT(*) AS total_posts FROM food_posts WHERE status != 'expired'");
$row = $report->fetch_assoc();

$food_kg = $row['total_food'] ?? 0;
$people_served = round($food_kg * 2);
$co2_saved = round($food_kg * 2.5);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f5f5;
      padding: 30px;
    }
    h2 {
      color: #00796b;
    }
    .stats, table {
      background: white;
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table th, table td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }
    .danger { color: red; font-weight: bold; }
    .btn-delete {
      background: red; color: white; padding: 5px 10px; border: none; cursor: pointer;
    }
  </style>
</head>
<body>
  <h2>Welcome, Admin</h2>

  <div class="stats">
    <h3>📊 Daily Report</h3>
    <p><strong>Food Saved:</strong> <?= $food_kg ?> kg</p>
    <p><strong>People Served:</strong> <?= $people_served ?></p>
    <p><strong>CO₂ Prevented:</strong> <?= $co2_saved ?> kg</p>
  </div>

  <div class="stats">
    <h3>🧾 Manage Food Posts</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Donor</th>
        <th>Food Type</th>
        <th>Quantity</th>
        <th>Status</th>
        <th>Expiry</th>
        <th>Action</th>
      </tr>
      <?php
      $posts = $conn->query("SELECT * FROM food_posts ORDER BY expiry ASC");
      while ($post = $posts->fetch_assoc()) {
          echo "<tr>
            <td>{$post['id']}</td>
            <td>{$post['donor_name']}</td>
            <td>{$post['food_type']}</td>
            <td>{$post['quantity']} kg</td>
            <td class='" . ($post['status'] === 'expired' ? "danger" : "") . "'>{$post['status']}</td>
            <td>{$post['expiry']}</td>
            <td><form method='POST' action='delete_post.php'><input type='hidden' name='id' value='{$post['id']}' /><button class='btn-delete'>Delete</button></form></td>
          </tr>";
      }
      ?>
    </table>
  </div>

  <div class="stats">
    <h3>✅ Onboard NGO / Volunteers</h3>
    <form method="POST" action="add_ngo.php">
      <input type="text" name="name" placeholder="Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="text" name="phone" placeholder="Phone" />
      <select name="role" required>
        <option value="NGO">NGO</option>
        <option value="Volunteer">Volunteer</option>
      </select>
      <input type="text" name="location" placeholder="Location" />
      <button type="submit">Add</button>
    </form>

    <hr><h4>Onboarded List</h4>
    <table>
      <tr><th>Name</th><th>Email</th><th>Role</th><th>Location</th></tr>
      <?php
        $list = $conn->query("SELECT * FROM ngos_volunteers");
        while ($ngo = $list->fetch_assoc()) {
          echo "<tr>
                  <td>{$ngo['name']}</td>
                  <td>{$ngo['email']}</td>
                  <td>{$ngo['role']}</td>
                  <td>{$ngo['location']}</td>
                </tr>";
        }
      ?>
    </table>
  </div>
</body>
</html>