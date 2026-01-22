@extends('layouts.app')

@section('title', 'Map')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch/dist/geosearch.css" />
<style>
    #map { width: 100%; height: 80vh; }
    .yellow-btn { background: #f3c623; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; }
</style>
@endpush

@section('content')

<h3>Tambah Lokasi Baru</h3>

<form id="locationForm">
    @csrf
    <label>Nama Lokasi:</label>
    <input type="text" id="name" class="form-control" required>

    <label>Latitude:</label>
    <input type="text" id="latitude" class="form-control" readonly>

    <label>Longitude:</label>
    <input type="text" id="longitude" class="form-control" readonly>

    <br>
    <button type="submit" class="yellow-btn">💾 Simpan Lokasi</button>
</form>

<hr>

<div id="map"></div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geosearch/dist/bundle.min.js"></script>

<script>

let map = L.map('map').setView([-6.2, 106.816666], 12);

// OSM Layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);

let mainMarker = null;
let routeLine = null;

// ==============================================================
// 1. KLIK MAP → DROP MARKER + UPDATE FORM
// ==============================================================

map.on('click', function(e) {
    let lat = e.latlng.lat;
    let lng = e.latlng.lng;

    if (mainMarker) {
        map.removeLayer(mainMarker);
    }

    mainMarker = L.marker([lat, lng]).addTo(map);

    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;
});

// ==============================================================
// 2. SIMPAN LOKASI KE DATABASE (AJAX)
// ==============================================================

document.getElementById("locationForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("{{ route('locations.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": formData.get("_token")
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert("Lokasi berhasil disimpan!");
        loadLocations();
    })
    .catch(err => console.error(err));
});


let markers = [];

function loadLocations() {
    fetch("{{ route('locations.all') }}")
        .then(res => res.json())
        .then(data => {

            markers.forEach(m => map.removeLayer(m));
            markers = [];

            data.forEach(loc => {
                let m = L.marker([loc.latitude, loc.longitude]).addTo(map);

                m.bindPopup(`
                    <b>${loc.name}</b><br>
                    <button class="yellow-btn" onclick="routeTo(${loc.latitude}, ${loc.longitude})">
                        ➡ Tampilkan Rute
                    </button>
                `);

                markers.push(m);
            });
        });
}

loadLocations();


function routeTo(lat, lng) {
    if (!mainMarker) {
        alert("Klik map terlebih dahulu untuk menentukan posisi Anda.");
        return;
    }

    const start = mainMarker.getLatLng();
    const end = { lat, lng };

    const url = `https://router.project-osrm.org/route/v1/driving/${start.lng},${start.lat};${lng},${lat}?overview=full&geometries=geojson`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            const coords = data.routes[0].geometry.coordinates;

            const latLngs = coords.map(c => [c[1], c[0]]);

            if (routeLine) {
                map.removeLayer(routeLine);
            }

            routeLine = L.polyline(latLngs, {color: "yellow", weight: 5}).addTo(map);

            map.fitBounds(routeLine.getBounds());
        })
        .catch(err => console.error(err));
}

</script>
@endpush
