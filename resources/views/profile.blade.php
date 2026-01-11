@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image">
            <img src="{{ asset('assets/img/user-placeholder.png') }}" alt="Foto Profil">
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->name }}</h2>
            <p class="email">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <div class="profile-card">
        <h3>Informasi Akun</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Nama Lengkap</label>
                <input type="text" value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="info-item">
                <label>Email</label>
                <input type="text" value="{{ Auth::user()->email }}" readonly>
            </div>

            <div class="info-item">
                <label>Tanggal Dibuat</label>
                <input type="text" value="{{ Auth::user()->created_at->format('d M Y') }}" readonly>
            </div>
        </div>

        <a href="#" class="btn-edit">Edit Profil</a>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
