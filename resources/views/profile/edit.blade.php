<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
</head>
<body>

    <h1>Edit Profil</h1>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <label>Nama</label><br>
        <input type="text" name="name" value="{{ $user->profile->name ?? '' }}"><br><br>

        <label>Phone</label><br>
        <input type="text" name="phone" value="{{ $user->profile->phone ?? '' }}"><br><br>

        <label>Bio</label><br>
        <textarea name="bio">{{ $user->profile->bio ?? '' }}</textarea><br><br>

        <button type="submit">Simpan</button>
    </form>

</body>
</html>
