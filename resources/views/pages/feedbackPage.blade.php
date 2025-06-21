<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TugasKu - Kritik & Saran</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
  <!-- HEADER / NAVBAR -->
  <header class="header">
    <a href="#" class="logo">
      <i class='bx bxs-book-open'></i>
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

    <!-- Statistics Cards -->
    <div class="card-row">
      <div class="stat-card">
        <div class="stat-number">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-label">Feedback Diterima</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $stats['satisfaction'] ?? '92%' }}</div>
        <div class="stat-label">Tingkat Kepuasan</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $stats['response_time'] ?? '48 Jam' }}</div>
        <div class="stat-label">Waktu Respons</div>
      </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
      <div class="alert alert-success">
        <strong>✅ Berhasil!</strong> {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-error">
        <strong>❌ Error!</strong> {{ session('error') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-error">
        <strong>❌ Terdapat kesalahan:</strong>
        <ul style="margin: 10px 0 0 20px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="content-container">
      <!-- FORM FEEDBACK -->
      <div class="feedback-form">
        <h2 class="form-title">Sampaikan Pendapat Anda</h2>
        <p class="form-description">
          Kami sangat menghargai umpan balik dari Anda. Kritik dan saran Anda sangat berharga untuk meningkatkan layanan kami. Silakan lengkapi formulir di bawah ini.
        </p>

        <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" id="feedbackForm">
          @csrf
          
          <!-- Kategori -->
          <div class="form-group">
            <label class="form-label">Kategori *</label>
            <div class="category-selector">
              <div class="category-option {{ old('kategori', 'layanan') == 'layanan' ? 'active' : '' }}" data-value="layanan">Layanan</div>
              <div class="category-option {{ old('kategori') == 'aplikasi' ? 'active' : '' }}" data-value="aplikasi">Aplikasi</div>
              <div class="category-option {{ old('kategori') == 'website' ? 'active' : '' }}" data-value="website">Website</div>
              <div class="category-option {{ old('kategori') == 'produk' ? 'active' : '' }}" data-value="produk">Produk</div>
              <div class="category-option {{ old('kategori') == 'lainnya' ? 'active' : '' }}" data-value="lainnya">Lainnya</div>
            </div>
            <input type="hidden" name="kategori" id="kategori" value="{{ old('kategori', 'layanan') }}">
            @error('kategori')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Nama Lengkap -->
          <div class="form-group">
            <label class="form-label">Nama Lengkap *</label>
            <input type="text" name="nama_lengkap" class="form-input {{ $errors->has('nama_lengkap') ? 'error' : '' }}" 
                   placeholder="Masukkan nama lengkap Anda" 
                   value="{{ old('nama_lengkap') }}" required>
            @error('nama_lengkap')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Email -->
          <div class="form-group">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}" 
                   placeholder="Masukkan alamat email Anda" 
                   value="{{ old('email') }}" required>
            @error('email')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Rating -->
          <div class="rating-container">
            <div class="rating-title">Bagaimana pengalaman Anda dengan kami? *</div>
            <div class="stars">
              <div class="star {{ old('rating') >= 1 ? 'active' : '' }}" data-rating="1">★</div>
              <div class="star {{ old('rating') >= 2 ? 'active' : '' }}" data-rating="2">★</div>
              <div class="star {{ old('rating') >= 3 ? 'active' : '' }}" data-rating="3">★</div>
              <div class="star {{ old('rating') >= 4 ? 'active' : '' }}" data-rating="4">★</div>
              <div class="star {{ old('rating') >= 5 ? 'active' : '' }}" data-rating="5">★</div>
            </div>
            <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
            @error('rating')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Judul -->
          <div class="form-group">
            <label class="form-label">Judul *</label>
            <input type="text" name="judul" class="form-input {{ $errors->has('judul') ? 'error' : '' }}" 
                   placeholder="Judul singkat tentang feedback Anda" 
                   value="{{ old('judul') }}" required>
            @error('judul')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Detail Kritik & Saran -->
          <div class="form-group">
            <label class="form-label">Detail Kritik & Saran *</label>
            <textarea name="detail_kritik_saran" class="form-textarea {{ $errors->has('detail_kritik_saran') ? 'error' : '' }}"
                      placeholder="Tuliskan kritik dan saran Anda secara detail di sini (minimal 10 karakter)..." required>{{ old('detail_kritik_saran') }}</textarea>
            @error('detail_kritik_saran')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- File Upload -->
          <div class="file-upload" onclick="document.getElementById('file_pendukung').click();">
            <div>
              <div class="upload-icon">📎</div>
              <div class="upload-text">Lampirkan file pendukung (opsional)</div>
              <div class="small-text">Seret file ke sini atau klik untuk memilih</div>
              <div id="file-name" class="file-name"></div>
            </div>
            <input type="file" name="file_pendukung" id="file_pendukung" 
                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="display: none;">
          </div>
          @error('file_pendukung')
            <div class="error-message">{{ $message }}</div>
          @enderror

          <!-- Checkbox Publikasi -->
          <div class="checkbox-group">
            <input type="checkbox" id="public-feedback" name="is_public" class="checkbox-input" 
                   value="1" {{ old('is_public') ? 'checked' : '' }}>
            <label for="public-feedback" class="checkbox-label">
              Saya setuju feedback ini dapat dipublikasikan tanpa menyertakan data pribadi saya
            </label>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="form-button" id="submitBtn">
            <span id="btnText">Kirim Kritik & Saran</span>
            <span id="btnLoading" style="display: none;">Mengirim...</span>
          </button>
        </form>
      </div>

      <!-- SIDEBAR -->
      <div class="feedback-sidebar">
        <h3 class="sidebar-title">Feedback Terbaru</h3>

        @if(isset($recentFeedbacks) && $recentFeedbacks->count() > 0)
          @foreach($recentFeedbacks as $feedback)
            <div class="testimonial">
              <p class="testimonial-text">"{{ Str::limit($feedback->detail_kritik_saran, 120) }}"</p>
              <div class="testimonial-author">
                <div class="author-avatar">{{ substr($feedback->nama_lengkap, 0, 1) }}</div>
                <div class="author-name">{{ Str::mask($feedback->nama_lengkap, '*', 2) }}</div>
              </div>
            </div>
          @endforeach
        @else
          <div class="testimonial">
            <p class="testimonial-text">"Aplikasi ini sangat membantu saya dalam mengorganisir pekerjaan sehari-hari. Antarmuka yang intuitif membuat semua lebih mudah."</p>
            <div class="testimonial-author">
              <div class="author-avatar">A</div>
              <div class="author-name">Ahmad S.</div>
            </div>
          </div>

          <div class="testimonial">
            <p class="testimonial-text">"Saya suka sekali dengan pembaruan terbaru. Fitur-fitur baru sangat berguna dan membuat pekerjaan saya jauh lebih efisien."</p>
            <div class="testimonial-author">
              <div class="author-avatar">S</div>
              <div class="author-name">Siti R.</div>
            </div>
          </div>
        @endif

        <h3 class="sidebar-title" style="margin-top: 25px;">FAQ</h3>

        <div class="faq-item">
          <div class="faq-question">Berapa lama saya akan mendapatkan respon?</div>
          <div class="faq-answer">Tim kami akan merespon kritik dan saran Anda dalam waktu 1-2 hari kerja.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question">Apakah data saya akan aman?</div>
          <div class="faq-answer">Ya, kami menjamin keamanan data pribadi Anda dan tidak akan membagikannya kepada pihak ketiga tanpa izin.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question">Bagaimana cara melacak status kritik saya?</div>
          <div class="faq-answer">Anda akan menerima email konfirmasi dengan nomor tiket yang dapat digunakan untuk melacak status.</div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Star rating functionality
      const stars = document.querySelectorAll('.star');
      const ratingInput = document.getElementById('rating');
      
      stars.forEach((star, index) => {
        star.addEventListener('click', () => {
          const rating = parseInt(star.dataset.rating);
          ratingInput.value = rating;
          
          stars.forEach((s, i) => {
            if (i < rating) {
              s.classList.add('active');
            } else {
              s.classList.remove('active');
            }
          });
        });
      });

      // Category selection
      const categories = document.querySelectorAll('.category-option');
      const kategoriInput = document.getElementById('kategori');
      
      categories.forEach(category => {
        category.addEventListener('click', () => {
          categories.forEach(c => c.classList.remove('active'));
          category.classList.add('active');
          kategoriInput.value = category.dataset.value;
        });
      });

      // File upload handling
      const fileInput = document.getElementById('file_pendukung');
      const fileName = document.getElementById('file-name');
      
      fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
          fileName.textContent = `File dipilih: ${e.target.files[0].name}`;
          fileName.style.display = 'block';
        } else {
          fileName.style.display = 'none';
        }
      });

      // Form submission with loading state
      const form = document.getElementById('feedbackForm');
      const submitBtn = document.getElementById('submitBtn');
      const btnText = document.getElementById('btnText');
      const btnLoading = document.getElementById('btnLoading');
      
      form.addEventListener('submit', function(e) {
        const rating = parseInt(ratingInput.value);
        
        if (rating === 0 || isNaN(rating)) {
          e.preventDefault();
          alert('Silakan berikan rating terlebih dahulu!');
          return false;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
      });

      // Auto hide alerts after 5 seconds
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        setTimeout(() => {
          alert.style.opacity = '0';
          setTimeout(() => {
            alert.remove();
          }, 300);
        }, 5000);
      });

      // Drag and drop file upload
      const fileUpload = document.querySelector('.file-upload');
      
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUpload.addEventListener(eventName, preventDefaults, false);
      });
      
      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      }
      
      ['dragenter', 'dragover'].forEach(eventName => {
        fileUpload.addEventListener(eventName, highlight, false);
      });
      
      ['dragleave', 'drop'].forEach(eventName => {
        fileUpload.addEventListener(eventName, unhighlight, false);
      });
      
      function highlight(e) {
        fileUpload.classList.add('dragover');
      }
      
      function unhighlight(e) {
        fileUpload.classList.remove('dragover');
      }
      
      fileUpload.addEventListener('drop', handleDrop, false);
      
      function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
          fileInput.files = files;
          fileName.textContent = `File dipilih: ${files[0].name}`;
          fileName.style.display = 'block';
        }
      }
    });
  </script>

  <!-- Additional CSS for better styling -->
  <style>
    .alert {
      padding: 15px 20px;
      margin-bottom: 25px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
      animation: slideInDown 0.3s ease-out;
    }
    
    .alert-success {
      background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
      color: #155724;
      border: 1px solid #c3e6cb;
      border-left: 4px solid #28a745;
    }
    
    .alert-error {
      background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%);
      color: #721c24;
      border: 1px solid #f5c6cb;
      border-left: 4px solid #dc3545;
    }
    
    @keyframes slideInDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .error-message {
      color: #dc3545;
      font-size: 12px;
      margin-top: 6px;
      display: block;
      font-weight: 500;
      animation: fadeInUp 0.3s ease;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(5px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .form-input.error,
    .form-textarea.error {
      border-color: #dc3545;
      box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }
    
    .file-name {
      display: none;
      font-size: 13px;
      color: #28a745;
      margin-top: 12px;
      font-weight: 600;
      padding: 8px 15px;
      background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
      border-radius: 20px;
      border: 1px solid #c3e6cb;
    }
    
    .form-button.loading {
      position: relative;
      background: linear-gradient(135deg, #ccc 0%, #bbb 100%);
      cursor: not-allowed;
    }
    
    .file-upload.dragover {
      border-color: #F8BD00;
      background: linear-gradient(135deg, #fffbf0 0%, #fff8e1 100%);
      box-shadow: 0 4px 20px rgba(248, 189, 0, 0.2);
    }
  </style>
</body>
</html>