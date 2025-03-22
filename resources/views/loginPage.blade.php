<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TugasKu - Form Registrasi</title>
    <link rel="stylesheet" href="LoginPage.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="container">
      <!-- Bagian Gambar -->
      <div class="image-section">
        <img src="backpack.png" alt="Backpack Image" />
        <h1>
          Tugas<span class="dot">·</span><span class="highlight">Ku</span>
        </h1>
        <p>Jangan lupa kerjain tugas nya cuy!</p>
      </div>

      <!-- Bagian Form -->
      <div class="form-section">
        <h1>Kembali Lagi!</h1>
        <p>Masukkan Email dan Kata Sandi kamu</p>
        <form action="#" method="post">
          <input type="email" placeholder="Email" required />
          <input type="password" placeholder="Kata Sandi" required />
          <button type="submit" class="btn">Daftar</button>
        </form>
        <div class="link-container">
          <div class="New-Account"><a href="{{ url('/registerpage') }}">Buat Akun Baru</a></div>
          <div class="Forget-Password"><a href="#">Lupa Password?</a></div>
        </div>
      </div>
    </div>
  </body>
</html>
