@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<style>
    body {
        background-color: #FFFDE7;
    }

    #map {
        width: 100%;
        height: 100vh;
    }

    /* SEARCH BAR */
    .search-bar {
        position: absolute;
        z-index: 9999;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #FFD54F;
        padding: 12px 18px;
        border-radius: 30px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        border: 2px solid #FFB300;
    }

    .search-input {
        border: none;
        outline: none;
        font-size: 16px;
        margin-left: 8px;
        width: 260px;
        background: transparent;
    }

    /* FLOATING BUTTON */
    .floating-btn {
        position: fixed;
        right: 20px;
        width: 55px;
        height: 55px;
        background: #FFEB3B;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 3px 10px rgba(0,0,0,0.4);
        z-index: 9999;
        cursor: pointer;
        font-size: 24px;
        border: 2px solid #FBC02D;
        color: black;
        text-decoration: none;
    }

    .btn-profile { bottom: 140px; }
    .btn-add { bottom: 80px; }

    /* CARD */
    .kontrakan-card {
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        border: none;
    }

    .badge-tersedia {
        background: #4CAF50;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        font-weight: bold;
    }

    .badge-penuh {
        background: #E53935;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        font-weight: bold;
    }
</style>
@endpush

@section('content')

{{-- SEARCH --}}
<div class="search-bar">
    🔍 <input type="text" placeholder="Cari lokasi" class="search-input" id="search">
</div>

{{-- FLOATING BUTTON --}}
<a href="{{ route('profile') }}" class="floating-btn btn-profile" title="Profile">👤</a>
<a href="{{ route('kontrakan.create') }}" class="floating-btn btn-add" title="Tambah Kontrakan">➕</a>

{{-- MAP --}}
<div id="map"></div>

{{-- LIST KONTRAKAN --}}
<div class="container my-4">
    <h4 class="mb-3">📋 Daftar Kontrakan</h4>

    <div class="row">
        @foreach($kontrakans as $k)
        <div class="col-md-4 mb-4">
            <div class="card kontrakan-card">

                @if($k->foto)
                <img src="{{ asset('storage/kontrakan/'.$k->foto) }}"
                     class="card-img-top"
                     style="height:200px;object-fit:cover;">
                @endif

                <div class="card-body">
                    <h5>{{ $k->judul }}</h5>
                    <p class="mb-1">📍 {{ $k->alamat }}</p>

                    <p class="mb-1">
                        👥 {{ $k->jumlah_penghuni }} / {{ $k->max_penghuni }} orang
                    </p>

                    @if($k->jumlah_penghuni >= $k->max_penghuni)
                        <span class="badge-penuh">PENUH</span>
                    @else
                        <span class="badge-tersedia">TERSEDIA</span>
                    @endif

                    <hr>
                    <strong>Rp {{ number_format($k->harga) }}/bulan</strong>

                    <a href="{{ route('kontrakan.show', $k->id) }}"
                       class="btn btn-warning w-100 mt-3">
                        🔍 Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geosearch/dist/bundle.min.js"></script>

<script>
    // INIT MAP
    let map = L.map('map').setView([-6.200000, 106.816666], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const kontrakans = @json($kontrakans);

    kontrakans.forEach(k => {
        if (k.latitude && k.longitude) {

            let status = (k.jumlah_penghuni >= k.max_penghuni)
                ? '<span style="color:red;font-weight:bold;">PENUH</span>'
                : '<span style="color:green;font-weight:bold;">TERSEDIA</span>';

            let popupContent = `
                <strong>${k.judul}</strong><br>
                ${k.alamat}<br>
                👥 ${k.jumlah_penghuni} / ${k.max_penghuni} orang<br>
                ${status}<br>
                Rp ${Number(k.harga).toLocaleString('id-ID')}/bulan<br>
                <small><i>Klik marker untuk detail</i></small>
            `;

            let marker = L.marker([k.latitude, k.longitude]).addTo(map);

            // HOVER POPUP
            marker.bindPopup(popupContent);

            marker.on('mouseover', function () {
                this.openPopup();
            });

            marker.on('mouseout', function () {
                this.closePopup();
            });

            // CLICK → DETAIL
            marker.on('click', function () {
                window.location.href = `/kontrakan/${k.id}`;
            });
        }
    });

    // SEARCH LOCATION
    const provider = new window.GeoSearch.OpenStreetMapProvider();
    const input = document.getElementById("search");
    let searchMarker = null;

    input.addEventListener("change", async function() {
        const results = await provider.search({ query: this.value });
        if (results.length > 0) {
            const r = results[0];
            map.setView([r.y, r.x], 17);

            if (searchMarker) {
                searchMarker.setLatLng([r.y, r.x]);
            } else {
                searchMarker = L.marker([r.y, r.x]).addTo(map);
            }
        }
    });
</script>
@endpush
