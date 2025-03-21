<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TugasKu</title>
    <link rel="stylesheet" href="landingPage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <!-- HEADER / NAVBAR -->
    <header class="header">
        <a href="#" class="logo"><i class='bx bxs-book-open'></i>
            <span class="tugas">Tugas</span><span class="dot">•</span><span class="ku">Ku</span>
        </a>

        <nav class="navbar">
            <a href="#home" class="active">Home</a>
            <a href="#streak">Streak</a>
            <a href="#kategori">Kategori</a>
            <a href="#kalender">Kalender</a>
            <a href="#banner">Buka di Browser</a>
        </nav>
        <button class="btn">Login</button>     
    </header>

    <!-- HOME PAGE -->
    <section class="home" id="home">
        <div class="home-container">
            <div class="home-content">
                <h1 id="baris1">ATUR JADWAL</h1>
                <h1 id="baris2">JADI LEBIH</h1>
                <h1 id="baris3">ASIK & SERU</h1>
                <p>Aplikasi manajemen tugas dan jadwal belajar untuk siswa dan mahasiswa. Dengan fitur Streak, pencatatan tugas dan reminder belajar akan lebih teratur dan menyenangkan!</p>
    
                <div class="main-button">
                    <a href="" id="login" class="btn">Masuk</a>
                    <a href="" id="download" class="btn"><i class='bx bxs-download'></i>Download di Play Store</a>
                </div>
            </div>
    
            <div class="home-img">
                <img src="img/hero-img.png" alt="TugasKu Mobile">
            </div>
        </div>
    </section>

    <!-- STREAK SECTION -->
    <section class="streak" id="streak">
        <div class="streak-image">
            <img src="img/memoji-streak.png" alt="Memoji Berpikir">
        </div>

        <div class="streak-container">
            <div class="streak-content">
                <h1>JAGA <span class="highlight">STREAK</span> APIMU <br>JANGAN SAMPAI PADAM!</h1>
                <p>
                    Selesaikan tugas kamu setiap hari agar Streak tetap menyala. Semakin lama Streakmu bertahan, semakin besar motivasi untuk tetap produktif. Jangan biarkan apinya padam!
                </p>
            </div>

            <div class="streak-fire">
                <img src="img/flame-icon.png" alt="Api Streak">
                <p>Kamu memiliki <span class="highlight">27</span> Streaks!</p>
            </div>

        </div>
    </section>

    <!-- KATEGORI SECTION -->
    <section class="kategori" id="kategori">
        <div class="kategori-container">
            <div class="kategori-icon">
                <img src="img/memoji-kategori.png" alt="Memoji Peace">
            </div>

            <div class="kategori-content">
                <h1>KATEGORIKAN TUGASMU AGAR LEBIH MUDAH</h1>
                <p>Pilah tugas berdasarkan jenisnya, seperti Tugas, Ujian, atau Meeting agar lebih terorganisir. Temukan dan kelola tugas dengan mudah tanpa perlu mencari satu per satu!</p>
            </div>

            <div class="kategori-image">
                <img src="img/category-view.png" alt="Kategori View">
            </div>
        </div>
    </section>

    <!-- KALENDER SECTION -->
    <section class="kalender" id="kalender">
        <div class="kalender-image">
            <img src="img/kalender-img.png" alt="Kalender View">
        </div>

        <div class="kalender-container">
            <div class="kalender-title">
                <h1>LIHAT TUGAS BERDASARKAN <span>DEADLINE</span> NYA</h1>
            </div>
    
            <div class="kalender-content">
                <p>Cek tugas yang harus diselesaikan lewat Calendar View. Lihat jadwal harian atau mingguanmu dalam sekali lihat agar lebih mudah mengatur waktu belajar.</p>
                <img src="img/memoji_dl.png" alt="Memoji Deadline">
            </div>
        </div>
    </section>

    <!-- BANNER SECTION -->
    <section class="banner" id="banner">
        <h1>TUNGGU APA LAGI? YUK CATAT<br>TUGASMU SEKARANG!</h1>
        <div class="main-button">
            <a href="" id="login" class="btn">Buka di browser kamu</a>
        </div>

        <div class="banner-image">
            <img src="img/banner-footer.png" alt="Banner Footer">
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-text">
            <p>Copyright &copy; 2025 by TugasKu | All Rights Reserved.</p>
        </div>

        <div class="footer-iconTop">
            <a href="#home"><i class='bx bx-up-arrow-alt'></i></a>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>



