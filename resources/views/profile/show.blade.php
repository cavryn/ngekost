<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
</head>
<body>

    <h1>Profil Pengguna</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role }}</p>

    <hr>

    @if($user->profile)
        <p><strong>Nama:</strong> {{ $user->profile->name }}</p>
        <p><strong>Phone:</strong> {{ $user->profile->phone ?? '-' }}</p>
        <p><strong>Bio:</strong> {{ $user->profile->bio ?? '-' }}</p>
    @else
        <p>Profil belum dibuat.</p>
    @endif

    <br>

    <a href="{{ route('profile.edit') }}">Edit Profil</a>

</body>
</html>
