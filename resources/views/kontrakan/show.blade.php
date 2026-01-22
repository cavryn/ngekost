@extends('layouts.app')

@section('title', 'Detail Kontrakan')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    body {
        background-color: #FFFDE7;
    }

    .detail-card {
        border-radius: 18px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        border: none;
    }

    .badge-tersedia {
        background: #4CAF50;
        color: white;
        padding: 6px 12px;
        border-radius: 12px;
        font-weight: bold;
    }

    .badge-penuh {
        background: #E53935;
        color: white;
        padding: 6px 12px;
        border-radius: 12px;
        font-weight: bold;
    }

    #map {
        height: 300px;
        border-radius: 15px;
    }

    .btn-yellow {
        background: #FFD54F;
        border: none;
        font-weight: 600;
        border-radius: 12px;
        padding: 10px 16px;
        color: #333;
    }

    .btn-yellow:hover {
        background: #FFCA28;
        color: #000;
    }

    .btn-report {
        background: #FFCDD2;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        color: #B71C1C;
        padding: 10px 16px;
        text-decoration: none;
    }

    .btn-report:hover {
        background: #EF9A9A;
        color: #7F0000;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>🏠 {{ $kontrakan->judul }}</h3>

        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            ⬅️ Dashboard
        </a>
    </div>

    {{-- CARD DETAIL --}}
    <div class="card detail-card mb-4">
        @if($kontrakan->foto)
            <img src="{{ asset('storage/kontrakan/'.$kontrakan->foto) }}"
                 style="height:300px;object-fit:cover;border-top-left-radius:18px;border-top-right-radius:18px;">
        @endif

        <div class="card-body p-4">
            <p class="mb-2">📍 {{ $kontrakan->alamat }}</p>

            <p>
                👥 {{ $kontrakan->jumlah_penghuni }} / {{ $kontrakan->max_penghuni }} orang
                <br>
                @if($kontrakan->jumlah_penghuni >= $kontrakan->max_penghuni)
                    <span class="badge-penuh">PENUH</span>
                @else
                    <span class="badge-tersedia">TERSEDIA</span>
                @endif
            </p>

            <h4 class="mt-3">💰 Rp {{ number_format($kontrakan->harga) }}/bulan</h4>

            @if($kontrakan->deskripsi)
                <hr>
                <p>{{ $kontrakan->deskripsi }}</p>
            @endif
        </div>
    </div>

    {{-- MAP --}}
    @if($kontrakan->latitude && $kontrakan->longitude)
    <div class="card detail-card mb-4">
        <div class="card-body">
            <h5 class="mb-3">📍 Lokasi Kontrakan</h5>
            <div id="map"></div>
        </div>
    </div>
    @endif

    {{-- ACTION BUTTON --}}
    <div class="d-flex justify-content-between">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            ⬅️ Kembali
        </a>

<a href="{{ route('laporan.create', $kontrakan->id) }}"
   class="btn btn-report"
   onclick="return confirm('Laporkan kontrakan ini?')">
   🚨 Laporkan Kontrakan
</a>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@if($kontrakan->latitude && $kontrakan->longitude)
<script>
    let map = L.map('map').setView(
        [{{ $kontrakan->latitude }}, {{ $kontrakan->longitude }}],
        16
    );

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    L.marker([{{ $kontrakan->latitude }}, {{ $kontrakan->longitude }}])
        .addTo(map)
        .bindPopup("{{ $kontrakan->judul }}")
        .openPopup();
</script>
@endif
@endpush
