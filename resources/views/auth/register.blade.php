<h2>Form Register</h2>

<form method="POST" action="/register">
    @csrf
    <label>Nama:</label><br>
    <input type="text" name="name" placeholder="Nama Lengkap"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" placeholder="Alamat Email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" placeholder="Kata Sandi"><br><br>

    <label>Konfirmasi Password:</label><br>
    <input type="password" name="password_confirmation" placeholder="Ulangi Kata Sandi"><br><br>

    <button type="submit">Daftar</button>
</form>