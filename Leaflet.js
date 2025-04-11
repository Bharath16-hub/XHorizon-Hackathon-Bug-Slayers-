<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<div id="map" style="height: 500px;"></div>

<script>
const map = L.map('map').setView([20.59, 78.96], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 18,
}).addTo(map);

function loadMarkers() {
  fetch('api/get_map_markers.php')
    .then(res => res.json())
    .then(data => {
      data.forEach(post => {
        let emoji = '🍱'; // fresh
        if (post.status === 'near_expiry') emoji = '⚠️';
        else if (post.status === 'expired' || post.status === 'picked') emoji = '❌';

        L.marker([post.latitude, post.longitude], {
          title: post.donor_name
        })
        .bindPopup(`<strong>${post.donor_name}</strong><br>Status: ${post.status}<br>Expiry: ${post.expiry}`)
        .addTo(map)
        .bindTooltip(emoji, { permanent: true, direction: 'top' });
      });
    });
}
loadMarkers();
</script>
