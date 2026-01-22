@extends('layouts.app')

@section('title', 'Laporkan Kontrakan')

@push('css')
<style>
    body {
        background-color: #FFFDE7;
    }

    .card-report {
        border-radius: 18px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        border: none;
    }

    .header-report {
        background: linear-gradient(135deg, #FFD54F, #FFB300);
        padding: 20px;
        border-radius: 18px 18px 0 0;
        font-weight: bold;
        color: #333;
    }

    .btn-yellow {
        background: #FFD54F;
        border: none;
        font-weight: 600;
        border-radius: 12px;
    }

    .btn-yellow:hover {
        background: #FFCA28;
    }

    label {
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container py-5">

    <div class="card card-report">

        <div class="header-report">
            🚨 Laporkan Kontrakan
        </div>

        <div class="card-body p-4">

            <p class="mb-3">
                <strong>Kontrakan:</strong><br>
                {{ $kontrakan->judul }} <br>
                <small>{{ $kontrakan->alamat }}</small>
            </p>

            <form method="POST" action="{{ route('laporan.store') }}">
                @csrf

                <input type="hidden" name="kontrakan_id" value="{{ $kontrakan->id }}">

                <div class="mb-3">
                    <label>Alasan Laporan</label>
                    <select name="alasan" class="form-select" required>
                        <option value="">-- Pilih Alasan --</option>
                        <option value="Penipuan">Penipuan</option>
                        <option value="Data Tidak Valid">Data Tidak Valid</option>
                        <option value="Harga Tidak Wajar">Harga Tidak Wajar</option>
                        <option value="Konten Tidak Pantas">Konten Tidak Pantas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="4"
                              placeholder="Jelaskan detail laporan (opsional)"></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        ⬅️ Batal
                    </a>

                    <button class="btn btn-yellow">
                        🚨 Kirim Laporan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
