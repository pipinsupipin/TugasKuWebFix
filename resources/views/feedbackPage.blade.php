<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TugasKu</title>
  <link rel="stylesheet" href="feedback.css">
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
      <a href="#krisan" class="active">Kritik Saran</a>
      <a href="/about">Tentang Kami</a>
    </nav>
    <button class="btn"><a href="{{ url('/loginpage') }}">Login</a></button>
  </header>
  <div class="main-content">
    <div class="content-header">
      <h1 class="page-title">Kritik & Saran</h1>
    </div>

    <div class="card-row">
      <div class="stat-card">
        <div class="stat-number">578</div>
        <div class="stat-label">Feedback Diterima</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">92%</div>
        <div class="stat-label">Tingkat Kepuasan</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">48 Jam</div>
        <div class="stat-label">Waktu Respons</div>
      </div>
    </div>

    <div class="content-container">
      <div class="feedback-form">
        <h2 class="form-title">Sampaikan Pendapat Anda</h2>
        <p class="form-description">
          Kami sangat menghargai umpan balik dari Anda. Kritik dan saran Anda sangat berharga untuk meningkatkan layanan
          kami. Silakan lengkapi formulir di bawah ini.
        </p>

        <div class="form-group">
          <label class="form-label">Kategori</label>
          <div class="category-selector">
            <div class="category-option active">Layanan</div>
            <div class="category-option">Aplikasi</div>
            <div class="category-option">Website</div>
            <div class="category-option">Produk</div>
            <div class="category-option">Lainnya</div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" class="form-input" placeholder="Masukkan nama lengkap Anda">
        </div>

        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" class="form-input" placeholder="Masukkan alamat email Anda">
        </div>

        <div class="rating-container">
          <div class="rating-title">Bagaimana pengalaman Anda dengan kami?</div>
          <div class="stars">
            <div class="star">★</div>
            <div class="star">★</div>
            <div class="star">★</div>
            <div class="star">★</div>
            <div class="star">★</div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Judul</label>
          <input type="text" class="form-input" placeholder="Judul singkat tentang feedback Anda">
        </div>

        <div class="form-group">
          <label class="form-label">Detail Kritik & Saran</label>
          <textarea class="form-textarea"
            placeholder="Tuliskan kritik dan saran Anda secara detail di sini..."></textarea>
        </div>

        <div class="file-upload">
          <div>
            <div class="upload-icon">📎</div>
            <div class="upload-text">Lampirkan file pendukung (opsional)</div>
            <div class="small-text">Seret file ke sini atau klik untuk memilih</div>
          </div>
        </div>

        <div class="checkbox-group">
          <input type="checkbox" id="public-feedback" class="checkbox-input">
          <label for="public-feedback" class="checkbox-label">Saya setuju feedback ini dapat dipublikasikan tanpa
            menyertakan data pribadi saya</label>
        </div>

        <button class="form-button">Kirim Kritik & Saran</button>
      </div>

      <div class="feedback-sidebar">
        <h3 class="sidebar-title">Feedback Terbaru</h3>

        <div class="testimonial">
          <p class="testimonial-text">"Aplikasi ini sangat membantu saya dalam mengorganisir pekerjaan sehari-hari.
            Antarmuka yang intuitif membuat semua lebih mudah."</p>
          <div class="testimonial-author">
            <div class="author-avatar"></div>
            <div class="author-name">Ahmad S.</div>
          </div>
        </div>

        <div class="testimonial">
          <p class="testimonial-text">"Saya suka sekali dengan pembaruan terbaru. Fitur-fitur baru sangat berguna dan
            membuat pekerjaan saya jauh lebih efisien."</p>
          <div class="testimonial-author">
            <div class="author-avatar"></div>
            <div class="author-name">Siti R.</div>
          </div>
        </div>

        <h3 class="sidebar-title" style="margin-top: 25px;">FAQ</h3>

        <div class="faq-item">
          <div class="faq-question">Berapa lama saya akan mendapatkan respon?</div>
          <div class="faq-answer">Tim kami akan merespon kritik dan saran Anda dalam waktu 1-2 hari kerja.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question">Apakah data saya akan aman?</div>
          <div class="faq-answer">Ya, kami menjamin keamanan data pribadi Anda dan tidak akan membagikannya kepada pihak
            ketiga tanpa izin.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question">Bagaimana cara melacak status kritik saya?</div>
          <div class="faq-answer">Anda akan menerima email konfirmasi dengan nomor tiket yang dapat digunakan untuk
            melacak status.</div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
    document.addEventListener('DOMContentLoaded', function () {
      // Star rating functionality
      const stars = document.querySelectorAll('.star');
      stars.forEach((star, index) => {
        star.addEventListener('click', () => {
          stars.forEach((s, i) => {
            if (i <= index) {
              s.classList.add('active');
            } else {
              s.classList.remove('active');
            }
          });
        });
      });

      // Category selection
      const categories = document.querySelectorAll('.category-option');
      categories.forEach(category => {
        category.addEventListener('click', () => {
          categories.forEach(c => c.classList.remove('active'));
          category.classList.add('active');
        });
      });
    });
  </script>
</body>