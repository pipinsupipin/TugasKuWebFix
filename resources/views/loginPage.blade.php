<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TugasKu - Form Registrasi</title>
  <link rel="stylesheet" href="LoginPage.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
</head>

<body>

  <body>

    <body class="login-active">
      <div class="container">
        <div class="brand-side">
          <img src="img/backpack.png" alt="Backpack" class="backpack-img">
          <div class="brand">
          <h1 class="brand-name">Tugas<span>Ku</span></h1>
          <p class="brand-slogan">Jangan lupa kerjain tugas nya cuy!</p>
          </div>
          
        </div>
        <div class="form-side">
          <div class="form-content">
            <div class="login-form visible">
              <h2 class="form-title">Kembali Lagi!</h2>
              <p class="form-subtitle">Masukkan Email dan Kata Sandi kamu</p>
              <div class="input-group">
                <input type="email" placeholder="Email" required>
                
              </div>
              <div class="input-group">
                <input type="password" placeholder="Kata Sandi" required>
                
              </div>
              <button class="btn btn-primary">Masuk</button>
              <div class="form-footer">
                <p><a Daftar id="to-register">Daftar Akun Baru? Daftar</a></p>
              </div>
              <div class="form-footer">
                <a>Lupa Kata Sandi?</a>
              </div>
            </div>

            <div class="register-form hidden">
              <h2 class="form-title">Selamat Datang!</h2>
              <p class="form-subtitle">Isi data diri untuk mulai</p>
              <div class="input-group">
                <input type="text" placeholder="Nama Lengkap" required>
                
              </div>
              <div class="input-group">
                <input type="email" placeholder="Email" required>
                
              </div>
              <div class="input-group">
                <input type="password" placeholder="Kata Sandi" required>
                
              </div>
              <div class="input-group">
                <input type="confirm-password" placeholder="Konfirmasi Kata Sandi" required>
                
              </div>
              <button class="btn btn-primary">Daftar</button>
              <div class="form-footer">
                <p><a id="to-login">Sudah Punya Akun? Masuk</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const toRegister = document.getElementById('to-register');
          const toLogin = document.getElementById('to-login');

          const container = document.querySelector('.container');
          const body = document.body;

          const loginForm = document.querySelector('.login-form');
          const registerForm = document.querySelector('.register-form');

          toRegister.addEventListener('click', function () {
            // Switch containers position
            container.classList.add('active');
            body.classList.remove('login-active');
            body.classList.add('register-active');

            // Fade out login form and fade in register form
            setTimeout(() => {
              loginForm.classList.remove('visible');
              loginForm.classList.add('hidden');
              registerForm.classList.remove('hidden');
              registerForm.classList.add('visible');
            }, 300);
          });

          toLogin.addEventListener('click', function () {
            // Switch containers position
            container.classList.remove('active');
            body.classList.remove('register-active');
            body.classList.add('login-active');

            // Fade out register form and fade in login form
            setTimeout(() => {
              registerForm.classList.remove('visible');
              registerForm.classList.add('hidden');
              loginForm.classList.remove('hidden');
              loginForm.classList.add('visible');
            }, 300);
          });
        });
      </script>
    </body>

</html>