@extends('layouts.app')

@section('title', 'Profile')

@push('css')
<style>
    body {
        background-color: #FFFDE7;
    }

    .profile-header {
        background: linear-gradient(135deg, #FFD54F, #FFB300);
        padding: 30px;
        border-radius: 18px;
        color: #333;
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    .profile-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #FFF;
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        background: white;
    }

    .btn-yellow {
        background-color: #FFD54F;
        border: none;
        color: #333;
        font-weight: 600;
        border-radius: 12px;
        padding: 10px 20px;
    }

    .btn-yellow:hover {
        background-color: #FFCA28;
        color: #000;
    }

    .btn-back {
        background: rgba(255,255,255,0.9);
        border-radius: 12px;
        padding: 8px 16px;
        font-weight: 600;
        text-decoration: none;
        color: #333;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    .btn-back:hover {
        background: #FFF59D;
        color: #000;
    }

    .btn-logout {
        background: #FFF3E0;
        border-radius: 12px;
        padding: 8px 16px;
        font-weight: 600;
        color: #E65100;
        border: 2px solid #F57C00;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    .btn-logout:hover {
        background: #FFE0B2;
        color: #BF360C;
    }

    .btn-manage {
        background: #FFF9C4;
        border: 2px solid #FBC02D;
        border-radius: 14px;
        font-weight: 600;
        color: #333;
        padding: 12px;
        transition: 0.2s;
    }

    .btn-manage:hover {
        background: #FFECB3;
        color: #000;
    }

    .form-control, .form-select {
        border-radius: 12px;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="profile-header mb-4">
        <div class="d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center">
                @if($profile->foto)
                    <img src="{{ asset('storage/profile/'.$profile->foto) }}"
                         class="profile-avatar me-4">
                @else
                    <img src="https://ui-avatars.com/api/?name=User&background=FFD54F&color=000&size=200"
                         class="profile-avatar me-4">
                @endif

                <div>
                    <h3 class="mb-1">Profile Saya</h3>
                    <p class="mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>

            {{-- DASHBOARD + LOGOUT --}}
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn-back">
                    ⬅️ Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        🚪 Logout
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- QUICK ACTION --}}
    <div class="card profile-card mb-4">
        <div class="card-body text-center">
            <a href="{{ route('kontrakan.index') }}"
               class="btn btn-manage w-100">
                🏠 Kelola Kontrakan Saya
            </a>
        </div>
    </div>

    @if(Auth::user()->role === 'admin')
<div class="card profile-card mb-4">
    <div class="card-body text-center">
        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-danger w-100">
            🛡️ Admin Dashboard
        </a>
    </div>
</div>
@endif


    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM PROFILE --}}
    <div class="card profile-card">
        <div class="card-body p-4">

            <form method="POST"
                  action="{{ route('profile.update') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Foto Profile</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Usia</label>
                        <input type="number"
                               name="usia"
                               class="form-control"
                               value="{{ old('usia', $profile->usia) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ $profile->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="P" {{ $profile->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Domisili</label>
                        <input type="text"
                               name="domisili"
                               class="form-control"
                               value="{{ old('domisili', $profile->domisili) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Deskripsi Diri</label>
                        <textarea name="deskripsi_diri"
                                  class="form-control"
                                  rows="4">{{ old('deskripsi_diri', $profile->deskripsi_diri) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        ⬅️ Kembali
                    </a>

                    <button type="submit" class="btn btn-yellow">
                        💾 Simpan Profile
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
