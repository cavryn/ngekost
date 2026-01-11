<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KontrakanFinder</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="login-container">

    <div class="login-card">
        <h2 class="title">KontrakanFinder</h2>

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <label>Nama Lengkap</label>
            <input
                type="text"
                name="name"
                placeholder="Masukkan nama lengkap"
                value="{{ old('name') }}"
                required
            >

            <label>Email</label>
            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
                value="{{ old('email') }}"
                required
            >

            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <label>Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
            >

            <button type="submit" class="btn-login">
                Daftar
            </button>

            <p class="regis-text">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>

</div>

</body>
</html>
