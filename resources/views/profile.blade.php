<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>Profil Saya</h1>

    <p>Halo, {{ Auth::user()->name }}!</p>
    <p>Email kamu adalah {{ Auth::user()->email }}</p>
    <p>Peran kamu adalah {{ Auth::user()->role }}</p>

    <br>
    <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
</body>
</html>