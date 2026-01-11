<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KontrakanFinder</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="login-container">

    <div class="login-card">
        <h2 class="title">KontrakanFinder</h2>

        {{-- Error login --}}
        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Success message (misal dari register) --}}
        @if (session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

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

            <button type="submit" class="btn-login">
                Login
            </button>

            <p class="regis-text">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar</a>
            </p>
        </form>
    </div>

</div>

</body>
</html>
