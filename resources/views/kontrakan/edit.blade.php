@extends('layouts.app')

@section('title', 'Edit Kontrakan')

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

    .card-yellow {
        border-radius: 18px;
        border: none;
        background: #FFF9C4;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-control {
        border-radius: 12px;
    }

    .btn-yellow {
        background: #FFD54F;
        border: none;
        color: #333;
        font-weight: 600;
        border-radius: 12px;
        padding: 10px 20px;
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
        <h3 class="mb-0">✏️ Edit Kontrakan</h3>
    </div>

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- FORM --}}
    <div class="card card-yellow">
        <div class="card-body p-4">

            <form method="POST"
                  action="{{ route('kontrakan.update', $kontrakan->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Judul Kontrakan</label>
                    <input type="text"
                           name="judul"
                           value="{{ $kontrakan->judul }}"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Harga / Bulan</label>
                    <input type="number"
                           name="harga"
                           value="{{ $kontrakan->harga }}"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Jumlah Penghuni</label>
                    <input type="number"
                           name="jumlah_penghuni"
                           value="{{ $kontrakan->jumlah_penghuni }}"
                           class="form-control"
                           min="0"
                           max="{{ $kontrakan->max_penghuni }}">
                    <small class="text-muted">
                        Maksimal {{ $kontrakan->max_penghuni }} orang
                    </small>
                </div>

                <div class="mb-3">
                    <label>Foto Baru (Opsional)</label>
                    <input type="file"
                           name="foto"
                           class="form-control">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('kontrakan.index') }}"
                       class="btn btn-secondary">
                        ⬅️ Kembali
                    </a>

                    <button class="btn btn-yellow">
                        💾 Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
