@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">

<div class="edit-container">

    <h2>Edit Profil</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="photo-section">
            <img src="{{ $user->photo ? asset('uploads/profile/' . $user->photo) : asset('assets/img/user-placeholder.png') }}" class="preview-img" id="previewImage">
            <label class="upload-btn">
                Ganti Foto
                <input type="file" name="photo" id="photoInput">
            </label>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ $user->name }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{ $user->email }}">
        </div>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
    </form>
</div>

<script>
    document.getElementById("photoInput").addEventListener("change", function(event){
        let reader = new FileReader();
        reader.onload = () => {
            document.getElementById("previewImage").src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

@endsection
