<?php
$conn = new mysqli("localhost", "root", "", "zerowaste");
if ($conn->connect_error) die("Connection failed");

$sql = "SELECT id, donor_name, latitude, longitude, expiry, status FROM food_posts";
$res = $conn->query($sql);
$data = [];

while ($row = $res->fetch_assoc()) {
    $expiry_time = strtotime($row['expiry']);
    $now = time();
    if ($row['status'] === 'picked') {
        $status = 'picked';
    } elseif ($expiry_time < $now) {
        $status = 'expired';
    } elseif ($expiry_time - $now < 3600) { // less than 1 hour left
        $status = 'near_expiry';
    } else {
        $status = 'fresh';
    }
    $row['status'] = $status;
    $data[] = $row;
}
echo json_encode($data);
?>
