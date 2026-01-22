@extends('layouts.app')

@section('title', 'Kelola Kontrakan')

@push('css')
<style>
    body {
        background: #FFFDE7;
    }

    .page-header {
        background: linear-gradient(135deg, #FFD54F, #FFB300);
        padding: 25px;
        border-radius: 18px;
        color: #333;
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        margin-bottom: 25px;
    }

    .card-kontrakan {
        border-radius: 18px;
        border: none;
        background: #FFF9C4;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transition: transform .2s;
    }

    .card-kontrakan:hover {
        transform: translateY(-4px);
    }

    .card-kontrakan img {
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
        height: 200px;
        object-fit: cover;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        display: inline-block;
        margin-top: 5px;
    }

    .tersedia {
        background: #C8E6C9;
        color: #256029;
    }

    .penuh {
        background: #FFCDD2;
        color: #C62828;
    }

    .btn-yellow {
        background: #FFD54F;
        border: none;
        color: #333;
        font-weight: 600;
        border-radius: 12px;
        padding: 8px 16px;
    }

    .btn-yellow:hover {
        background: #FFCA28;
        color: #000;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="page-header">
        <h3 class="mb-0">📋 Kontrakan Saya</h3>
    </div>

    <div class="row">
        @forelse($kontrakans as $k)
        <div class="col-md-4 mb-4">
            <div class="card card-kontrakan h-100">

                @if($k->foto)
                <img src="{{ asset('storage/kontrakan/'.$k->foto) }}">
                @endif

                <div class="card-body">
                    <h5 class="mb-1">{{ $k->judul }}</h5>

                    <p class="mb-1">
                        💰 <strong>Rp {{ number_format($k->harga) }}/bulan</strong>
                    </p>

                    <p class="mb-2">
                        👥 {{ $k->jumlah_penghuni }} / {{ $k->max_penghuni }} orang
                    </p>

                    <span class="status-badge {{ $k->jumlah_penghuni >= $k->max_penghuni ? 'penuh' : 'tersedia' }}">
                        {{ $k->jumlah_penghuni >= $k->max_penghuni ? 'PENUH' : 'TERSEDIA' }}
                    </span>

                    <div class="mt-3">
                        <a href="{{ route('kontrakan.edit', $k->id) }}"
                           class="btn btn-yellow w-100">
                            ✏️ Edit Kontrakan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center text-muted">
                Belum ada kontrakan.
            </div>
        @endforelse
    </div>

    <a href="{{ route('dashboard') }}"
       class="btn btn-outline-secondary mt-3">
        ⬅️ Kembali ke Dashboard
    </a>
</div>
@endsection
