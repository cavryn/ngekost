@extends('layouts.app')

@section('title', 'Tambah Kontrakan')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    body {
        background: #FFFDE7;
    }

    .card-yellow {
        border-radius: 18px;
        border: 2px solid #FBC02D;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .card-header-yellow {
        background: #FFD54F;
        border-radius: 16px 16px 0 0;
        font-weight: bold;
    }

    #map {
        height: 350px;
        border-radius: 15px;
        margin-bottom: 15px;
        border: 2px solid #FBC02D;
    }

    label {
        font-weight: 600;
    }

    .btn-yellow {
        background: #FFEB3B;
        border: 2px solid #FBC02D;
        font-weight: bold;
    }

    .btn-yellow:hover {
        background: #FDD835;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="card card-yellow">
        <div class="card-header card-header-yellow">
            🏠 Tambah Kontrakan
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route('kontrakan.store') }}"
                  enctype="multipart/form-data">
                @csrf

                {{-- JUDUL --}}
                <div class="mb-3">
                    <label>Judul Kontrakan</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                {{-- ALAMAT --}}
                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>

                {{-- HARGA --}}
                <div class="mb-3">
                    <label>Harga / Bulan</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                {{-- FOTO --}}
                <div class="mb-3">
                    <label>Foto Kontrakan</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                {{-- PENGHUNI --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Maksimal Penghuni</label>
                        <input type="number"
                               name="max_penghuni"
                               class="form-control"
                               min="1"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jumlah Penghuni Saat Ini</label>
                        <input type="number"
                               name="jumlah_penghuni"
                               class="form-control"
                               min="0"
                               value="0">
                    </div>
                </div>

                {{-- MAP --}}
                <div class="mb-3">
                    <label>📍 Pilih Lokasi Kontrakan (Klik Map)</label>
                    <div id="map"></div>
                </div>

                {{-- HIDDEN COORDINATE --}}
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                {{-- BUTTON --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        ⬅️ Kembali
                    </a>

                    <button class="btn btn-yellow">
                        💾 Simpan Kontrakan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    let map = L.map('map').setView([-6.200000, 106.816666], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker;

    map.on('click', function(e) {
        let lat = e.latlng.lat;
        let lng = e.latlng.lng;

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
    });
</script>
@endpush
