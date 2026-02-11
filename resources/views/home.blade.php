<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nearby Hotels</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body { margin: 0; font-family: sans-serif; }
        #map { height: 100vh; width: 100%; }

        /* Spinner */
        #spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2000;
            display: none;
        }
        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #1976d2;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div id="map"></div>
<div id="spinner"><div class="loader"></div></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
let map;
let markers = [];
let circle;

// عرض أو إخفاء spinner
function showSpinner(show = true) {
    document.getElementById('spinner').style.display = show ? 'block' : 'none';
}

// نبدأ عند تحميل الصفحة
window.addEventListener('load', () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const { latitude, longitude } = position.coords;
                fetchHotels(latitude, longitude);
            },
            () => alert('Location permission denied')
        );
    } else {
        alert('Geolocation not supported by your browser');
    }
});

function fetchHotels(lat, lng) {
    showSpinner(true);
    fetch('/api/hotels', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ latitude: lat, longitude: lng })
    })
    .then(res => res.json())
    .then(hotels => {
        if (!Array.isArray(hotels)) hotels = [];
        initMap(lat, lng, hotels);
    })
    .catch(err => {
        console.error(err);
        alert('Failed to fetch hotels');
    })
    .finally(() => showSpinner(false));
}

function initMap(lat, lng, hotels) {
    // إنشاء الخريطة إذا لم تكن موجودة
    if (!map) {
        map = L.map('map').setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
    } else {
        map.setView([lat, lng], 14);
        markers.forEach(m => map.removeLayer(m));
        markers = [];
        if (circle) map.removeLayer(circle);
    }

    // دائرة نصف قطرها 5 كم
    circle = L.circle([lat, lng], { radius: 5000, color: 'blue', fillColor: '#1976d2', fillOpacity: 0.1 }).addTo(map);

    // Marker لموقع المستخدم
    const userMarker = L.marker([lat, lng]).addTo(map).bindPopup('Your Location').openPopup();
    markers.push(userMarker);

    // Markers للفنادق
    hotels.forEach(hotel => {
        const hLat = hotel.lat || hotel.center?.lat;
        const hLng = hotel.lon || hotel.center?.lon;
        if (hLat && hLng) {
            const marker = L.marker([hLat, hLng])
                .addTo(map)
                .bindPopup(hotel.tags?.name || 'Hotel');
            markers.push(marker);
        }
    });
}
</script>

</body>
</html>
