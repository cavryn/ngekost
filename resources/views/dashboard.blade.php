@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch/dist/geosearch.css" />

<style>
    #map {
        width: 100%;
        height: 100vh;
    }

    /* === SEARCH BAR KUNING === */
    .search-bar {
        position: absolute;
        z-index: 9999;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #FFD54F;          /* 🌟 Kuning */
        padding: 12px 18px;
        border-radius: 30px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        border: 2px solid #FFB300;    /* border kuning tua */
    }

    .search-input {
        border: none;
        outline: none;
        font-size: 16px;
        margin-left: 8px;
        width: 260px;
        background: transparent;
    }

    /* === FLOATING BUTTON KUNING === */
    .floating-btn {
        position: fixed;
        right: 20px;
        width: 55px;
        height: 55px;
        background: #FFEB3B;          /* 🌟 Kuning terang */
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 3px 10px rgba(0,0,0,0.4);
        z-index: 9999;
        cursor: pointer;
        font-size: 24px;
        border: 2px solid #FBC02D;    /* kuning tua */
    }

    .btn-profile { bottom: 140px; }
    .btn-chat { bottom: 85px; }
    .btn-favorite { bottom: 30px; }
    .btn-filter { bottom: 195px; }

    /* === AUTOCOMPLETE LIST === */
    #autocomplete-list {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #FFB300;
    }

    .autocomplete-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .autocomplete-item:hover {
        background: #FFF59D;      /* 🌟 Hover kuning */
    }
</style>
@endpush

@section('content')

<div class="search-bar">
    🔍 <input type="text" placeholder="Cari alamat atau tempat" class="search-input" id="search">
</div>

{{-- Floating buttons (tetap kuning) --}}
<div class="floating-btn btn-profile">👤</div>
<div class="floating-btn btn-chat">💬</div>
<div class="floating-btn btn-favorite">⭐</div>
<div class="floating-btn btn-filter">⚙️</div>

<div id="map"></div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geosearch/dist/bundle.min.js"></script>

<script>
    let map = L.map('map').setView([-6.200000, 106.816666], 13);

    // === OSM TILE ===
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // === DEFAULT MARKER ===
    let marker = L.marker([-6.200000, 106.816666]).addTo(map);

    const provider = new window.GeoSearch.OpenStreetMapProvider();
    const input = document.getElementById("search");

    let timeout = null;
    let resultsBox;

    function createBox() {
        resultsBox = document.createElement("div");
        resultsBox.id = "autocomplete-list";

        resultsBox.style.position = "absolute";
        resultsBox.style.top = "70px";
        resultsBox.style.left = "50%";
        resultsBox.style.transform = "translateX(-50%)";
        resultsBox.style.width = "320px";
        resultsBox.style.maxHeight = "300px";
        resultsBox.style.overflowY = "auto";
        resultsBox.style.background = "white";
        resultsBox.style.zIndex = "10000";
        resultsBox.style.boxShadow = "0 4px 12px rgba(0,0,0,0.3)";

        document.body.appendChild(resultsBox);
    }
    createBox();

    // === AUTOCOMPLETE ===
    input.addEventListener("input", function() {
        clearTimeout(timeout);
        const query = this.value;

        if (query.length < 3) {
            resultsBox.innerHTML = "";
            return;
        }

        timeout = setTimeout(async () => {
            const results = await provider.search({ query });

            resultsBox.innerHTML = "";
            results.forEach(r => {
                const item = document.createElement("div");
                item.className = "autocomplete-item";
                item.innerText = r.label;

                item.addEventListener("click", () => {
                    map.setView([r.y, r.x], 17);
                    marker.setLatLng([r.y, r.x]);
                    input.value = r.label;
                    resultsBox.innerHTML = "";
                });

                resultsBox.appendChild(item);
            });
        }, 300);
    });

    // === ENTER KEY SEARCH ===
    input.addEventListener("keypress", async function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            const query = this.value;

            const results = await provider.search({ query });

            if (results.length === 0) {
                alert("Alamat tidak ditemukan.");
                return;
            }

            const r = results[0];
            map.setView([r.y, r.x], 17);
            marker.setLatLng([r.y, r.x]);
            resultsBox.innerHTML = "";
        }
    });
</script>
@endpush
