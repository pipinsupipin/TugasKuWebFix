<aside class="sidebar">
    <div class="sidebar-header">
        <h2 class="logo">Tugas<span class="dot">•</span><span class="ku">Ku</span></h2>
    </div>

    <nav class="sidebar-nav">
        <!-- Menu Utama -->
        <div class="nav-section">
            <h3 class="nav-title">Menu</h3>
            <a href="/homepage" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <!-- SVG untuk Dashboard -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="/calendarpage" class="nav-item {{ request()->is('calendarpage') ? 'active' : '' }}">
                <!-- SVG untuk Calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                </svg>
                <span>Calendar View</span>
            </a>
            <a href="/kategoripage" class="nav-item {{ request()->is('kategori') ? 'active' : '' }}">
                <!-- SVG untuk Kategori -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <rect width="20" height="14" x="2" y="7" rx="2" ry="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
                <span>Semua Kategori</span>
            </a>
            <a href="/tugas" class="nav-item {{ request()->is('tugas') ? 'active' : '' }}">
                <!-- SVG untuk Tugas -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z" />
                </svg>
                <span>Semua Tugas</span>
            </a>
        </div>

        <!-- General Section -->
        <div class="nav-section">
            <h3 class="nav-title">General</h3>
            <a href="/settingspage" class="nav-item {{ request()->is('settingspage') ? 'active' : '' }}">
                <!-- SVG untuk Pengaturan -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <span>Pengaturan</span>
            </a>
            <a href="/aboutuspage" class="nav-item {{ request()->is('aboutuspage') ? 'active' : '' }}">
                <!-- SVG untuk Tentang Kami -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                    <path d="M12 17h.01" />
                </svg>
                <span>Tentang Kami</span>
            </a>
            <a href="#" id="logoutBtn" class="nav-item">
                <!-- SVG untuk Keluar -->
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
            </a>
        </div>
    </nav>

    <!-- Download Card -->
    <div class="download-card">
        <p><strong>Download TugasKu di Smartphone Anda!</strong></p>
        <p class="download-text">Mencatat tugas lebih mudah</p>
        <button class="download-btn">Download</button>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navItems = document.querySelectorAll('.nav-item');

        navItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });
    });

    document.getElementById('logoutBtn').addEventListener('click', function(event) {
        event.preventDefault();  // Mencegah aksi default (link)
        
        // Mengirim request ke API untuk logout
        axios.post('/api/auth/logout', {}, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            }
        })
        .then(response => {
            // Jika logout berhasil, hapus token dan alihkan ke halaman login
            localStorage.removeItem('auth_token');
            window.location.href = '/loginpage';  // Alihkan ke halaman login
        })
        .catch(error => {
            console.error('Gagal logout:', error);
        });
    });
</script>
