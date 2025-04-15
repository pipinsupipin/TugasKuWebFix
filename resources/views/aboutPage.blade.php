<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TugasKu</title>
  <link rel="stylesheet" href="about.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
  <!-- HEADER / NAVBAR -->
  <header class="header">
    <a href="#" class="logo"><i class='bx bxs-book-open'></i>
      <span class="tugas">Tugas</span><span class="dot">•</span><span class="ku">Ku</span>
    </a>

    <nav class="navbar">
      <a href="/#home">Home</a>
      <a href="/#streak">Streak</a>
      <a href="/#kategori">Kategori</a>
      <a href="/#kalender">Kalender</a>
      <a href="/feedback">Kritik Saran</a>
      <a href="/about" class="active">Tentang Kami</a>
      <a href="#banner">Buka di Browser</a>
    </nav>
    <button class="btn"><a href="{{ url('/loginpage') }}">Login</a></button>
  </header>
  <div class="main-content">
    <div class="content-container">
      <div class="about-card">
        <div class="about-image">
          <img src="/img/foto2.jpg" alt="Foto tim">
        </div>
        <div class="about-content">
          <h2 class="about-title">Cerita Kami</h2>
          <p class="about-text">
            Seiring meningkatnya beban akademik, kami melihat tantangan nyata yang dihadapi oleh banyak siswa dan
            mahasiswa dalam mengatur tugas dan jadwal ujian mereka. Banyak dari mereka kewalahan karena tidak memiliki
            sistem pengingat yang terstruktur, yang berujung pada penumpukan pekerjaan, terlupakannya tenggat waktu,
            hingga menurunnya semangat belajar. Dari keresahan inilah ide TugasKu lahir—sebuah aplikasi yang dirancang
            untuk menjadi teman belajar yang membantu pengguna mengelola tugas dan ujian dengan lebih mudah dan efisien.
          </p>
          <p class="about-text">
            Melihat perkembangan teknologi digital dan potensi besar dari pendekatan habit-forming, kami menghadirkan
            fitur Streak sebagai bentuk dorongan motivasi harian. Fitur ini bertujuan untuk membangun konsistensi dan
            rasa
            pencapaian dalam proses belajar, mendorong pengguna untuk tetap disiplin dalam menyelesaikan tugas setiap
            hari. TugasKu bukan sekadar aplikasi manajemen tugas, tetapi juga alat yang mendukung terciptanya kebiasaan
            belajar yang lebih baik, lebih teratur, dan tentunya lebih menyenangkan.
          </p>
        </div>
      </div>

      <div class="mission-values">
        <div class="mission-card">
          <h3 class="card-title">
            <span class="card-icon">🎯</span>
            Misi Kami
          </h3>
          <p class="card-content">
            Misi kami adalah menyediakan solusi digital yang mendukung produktivitas belajar siswa dan mahasiswa melalui
            aplikasi yang intuitif dan efisien. Dengan fitur manajemen tugas, pengingat ujian, serta sistem streak
            harian
            yang memotivasi, kami bertujuan membantu pengguna membentuk kebiasaan belajar yang konsisten dan
            terstruktur,
            sehingga mereka dapat mencapai hasil akademik yang lebih optimal.
          </p>
        </div>

        <div class="mission-card">
          <h3 class="card-title">
            <span class="card-icon">💎</span>
            Nilai-Nilai Kami
          </h3>
          <div class="values-list">
            <div class="value-item">
              <div class="value-icon">✓</div>
              <div class="value-text">Produktivitas</div>
            </div>
            <div class="value-item">
              <div class="value-icon">✓</div>
              <div class="value-text">Konsistensi</div>
            </div>
            <div class="value-item">
              <div class="value-icon">✓</div>
              <div class="value-text">Inovasi</div>
            </div>
            <div class="value-item">
              <div class="value-icon">✓</div>
              <div class="value-text">Aksesibilitas</div>
            </div>
          </div>
        </div>
      </div>

      <div class="team-section">
        <h2 class="section-title">Tim Kami</h2>
        <div class="team-grid">
          <div class="team-member">
            <div class="member-photo">
              <img src="/img/kevin.png" alt="Foto Kevin">
            </div>
            <h3 class="member-name">Kevin Azaria</h3>
            <div class="member-title">CEO & Founder</div>
            <p class="member-bio">
              Kevin adalah seorang mahasiswa yang memulai startup-nya 3 bulan lalu. Dengan semangat inovasi dan
              keinginan
              kuat untuk menghadirkan solusi nyata, Kevin membangun perusahaannya dari nol. Meskipun masih dalam tahap
              awal, visinya untuk menciptakan teknologi yang inklusif dan berdampak positif menjadi landasan utama dalam
              mengembangkan startup ini.
            </p>
          </div>
          <div class="team-member">
            <div class="member-photo">
              <img src="/img/abi.png" alt="Foto Abi">
            </div>
            <h3 class="member-name">Abizar Rasyidin Sasmita</h3>
            <div class="member-title">CEO & Founder</div>
            <p class="member-bio">
              Abizar adalah seorang mahasiswa yang memulai startup-nya 3 bulan lalu. Dengan semangat inovasi dan
              keinginan
              kuat untuk menghadirkan solusi nyata, Kevin membangun perusahaannya dari nol. Meskipun masih dalam tahap
              awal, visinya untuk menciptakan teknologi yang inklusif dan berdampak positif menjadi landasan utama dalam
              mengembangkan startup ini.
            </p>
          </div>
        </div>
      </div>

      <div class="contact-section">
        <h2 class="section-title">Hubungi Kami</h2>
        <div class="contact-grid">
          <div class="contact-item">
            <div class="contact-icon">📍</div>
            <h3 class="contact-title">Alamat</h3>
            <p class="contact-text">
              Jl Mulyorejo, no 89 <br>
              Surabaya Timur, 12345<br>
              Indonesia
            </p>
          </div>
          <div class="contact-item">
            <div class="contact-icon">📧</div>
            <h3 class="contact-title">Email</h3>
            <p class="contact-text">
              kevinfarrel53@gmail.com<br>
              abizarsasmita@gmail.com
            </p>
          </div>
          <div class="contact-item">
            <div class="contact-icon">📱</div>
            <h3 class="contact-title">Telepon</h3>
            <p class="contact-text">
              +62 812-1255-0004<br>
              +62 821-6791-1911
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
  </script>
</body>