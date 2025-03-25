<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TugasKu - Form Registrasi</title>
    <link rel="stylesheet" href="registerPage.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

  </head>
  <body>
    <div class="container">
      <!-- Bagian Form -->
      <div class="form-section">
        <h1>Selamat Datang!</h1>
        <p>Isi data diri kamu disini</p>
        <form action="#" method="post">
          <input type="text" placeholder="Nama Lengkap" required />

          <input type="email" placeholder="Email" required />
          <input type="password" placeholder="Kata Sandi" required />
          <button type="submit" class="btn"><a href="{{ url('/homepage') }}">Daftar</a></button>
        </form>
        <p class="login-prompt">
          Sudah punya akun? <a href="{{url('/loginpage')}}">Masuk Disini</a>
        </p>
      </div>

      <!-- Bagian Gambar -->
      <div class="image-section">
        <img src="img\backpack.png" alt="Backpack Image" />
        <h1>
          Tugas<span class="dot">·</span><span class="highlight">Ku</span>
        </h1>
        <p>Jangan lupa kerjain tugas nya cuy!</p>
      </div>
    </div>
  </body>
</html>
