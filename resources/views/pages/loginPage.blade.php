<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TugasKu - Aplikasi Manajemen Tugas</title>
  <link rel="stylesheet" href="auth/loginPage.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
</head>

<body class="login-active">
  <div class="container">
    <!-- Alert Container -->
    <div id="alert-container" class="alert-container"></div>

    <div class="brand-side">
      <!-- Brand logo and slogan -->
      <img src="img/backpack.png" alt="Backpack" class="backpack-img" />
      <div class="brand">
        <span class="tugas">Tugas</span><span class="dot">•</span><span class="ku">Ku</span>
        <p class="brand-slogan">Jangan lupa kerjain tugas nya cuy!</p>
      </div>
    </div>

    <div class="form-side">
      <div class="form-content">
        <!-- Login Form -->
        <div class="login-form visible">
          <h2 class="form-title">Kembali Lagi!</h2>
          <p class="form-subtitle">Masukkan Email dan Kata Sandi kamu</p>
          <div class="input-group">
            <input type="email" placeholder="Email" required />
            <input type="password" placeholder="Kata Sandi" required />
          </div>
          <button class="btn btn-primary">Masuk</button>

          <!-- Footer with links -->
          <div class="form-footer">
            <a id="to-register">Daftar Akun Baru? Daftar Disini</a>
            <a>Lupa Kata Sandi?</a>
          </div>
        </div>

        <!-- Register Form -->
        <div class="register-form hidden">
          <h2 class="form-title">Selamat Datang!</h2>
          <p class="form-subtitle">Isi data diri untuk mulai</p>
          <div class="input-group">
            <input type="text" placeholder="Nama Lengkap" required />
            <input type="email" placeholder="Email" required />
            <input type="password" placeholder="Kata Sandi" required />
            <input type="password" placeholder="Konfirmasi Kata Sandi" required />
          </div>
          <button class="btn btn-primary">Daftar</button>

          <!-- Footer with login redirect -->
          <div class="form-footer">
            <p><a id="to-login">Sudah Punya Akun? Masuk</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>