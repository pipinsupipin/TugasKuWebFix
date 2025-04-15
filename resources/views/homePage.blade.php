<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage TugasKu</title>
    <link rel="stylesheet" href="homePage.css">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar-container">
            <h2 class="logo">Tugas<span class="dot">•</span><span class="ku">Ku</span></h2>
            <div class="menu">
                <h3>Menu</h3>
                <a href="#" class="menu-item active" id="dashboard-btn">
                    <span class="icon-with-text">
                        <i data-lucide="layout-dashboard" class="icon"></i>
                        <span class="label">Dashboard</span>
                    </span>
                </a>
                <a href="/calendarpage" class="menu-item" id="calendar-btn">
                    <span class="icon-with-text">
                        <i data-lucide="calendar" class="icon"></i>
                        <span class="label">Calendar View</span>
                    </span>
                </a>

                <a href="/kategori" class="menu-item" id="kategori-btn">
                    <span class="icon-with-text">
                        <i data-lucide="archive" class="icon"></i>
                        <span class="label">Semua Kategori</span>
                    </span>
                </a>
                <a href="/tugas" class="menu-item" id="tugas-btn">
                    <span class="icon-with-text">
                        <i data-lucide="logs" class="icon"></i>
                        <span class="label">Semua Tugas</span>
                    </span>
                </a>
            </div>

            <div class="general">
                <h3>General</h3>
                <a href="/settingspage" class="menu-item" id="settings-btn">
                    <span class="icon-with-text">
                        <i data-lucide="settings" class="icon"></i>
                        <span class="label">Pengaturan</span>
                    </span>
                </a>
                <a href="aboutuspage" class="menu-item" id="about-btn">
                    <span class="icon-with-text">
                        <i data-lucide="circle-help" class="icon"></i>
                        <span class="label">Tentang Kami</span>
                    </span>
                </a>
                <a href="/" class="menu-item" id="logout-btn">
                    <span class="icon-with-text">
                        <i data-lucide="log-out" class="icon"></i>
                        <span class="label">Keluar</span>
                    </span>
                </a>
            </div>

            <div class="download-card">
                <p><strong>Download TugasKu di Smartphone</strong><br>Mencatat tugas lebih mudah</p>
                <button>Download</button>
            </div>
        </div>

        <div class="main-container" id="dashboard-view">

            <div class="search-bar">
                <div class="search-form">
                    <input type="text" placeholder="Cari dari nama tugas ...">
                </div>
                <div class="user-profile">
                    <img src="img/user-profile.png" alt="TugasKu Mobile">
                    <div class="user-info">
                        <strong>Kevin Azaria</strong>
                        <p>kevinazaria@mail.com</p>
                    </div>
                </div>
            </div>


            <div class="main">
                <div class="kiri">
                    <div class="greeting">
                        <h1>Selamat Pagi, Kevin!</h1>
                        <p>Semangat kerjain tugasnya ya!</p>
                    </div>
                    <div class="first-row">
                        <div class="streak">
                            <img src="img/flame-icon.png" alt="Streak">
                            <h2>Kamu memiliki <span class="angka">27</span> Streaks!</h2>
                        </div>
                        <div class="add-task">
                            <div class="add-form">
                                <h2>Catat Tugas Disini!</h2>
                                <input type="text">
                            </div>
                            <div class="task-time">
                                <h2>Waktu</h2>
                                <input type="datetime-local" id="jam1" name="jam">
                                <input type="datetime-local" id="jam2" name="jam">
                            </div>
                            <div class="category">
                                <h2>Kategori</h2>
                                <div class="category-list">
                                    <button class="categoryL active">Tugas</button>
                                    <button class="categoryL">Proyek</button>
                                    <button class="categoryL">Quiz</button>
                                    <select class="categoryL">
                                        <option value="lainnya">Lainnya</option>
                                        <option value="Les rutin">Les rutin</option>
                                        <option value="ujian">Ujian</option>
                                        <option value="rapat">Rapat</option>
                                    </select>
                                    <div class="add-icon">
                                        <h1>+</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="second-row">
                        <h2>Kategori Tugas</h2>
                        <div class="category-box">
                            <div class="box">
                                <div class="icon-box">
                                    <i data-lucide="user" class="icon"></i>
                                </div>
                                <h2>Rapat</h2>
                                <p>18 Februari 2025</p>
                                <div class="bar"></div>
                                <p><span class="detail-tugas">1/2 Selesai</span></p>
                            </div>
                            <div class="box">
                                <div class="icon-box">
                                    <i data-lucide="wrench" class="icon"></i>
                                </div>
                                <h2>Proyek</h2>
                                <p>18 Februari 2025</p>
                                <div class="bar"></div>
                                <p><span class="detail-tugas">1/2 Selesai</span></p>
                            </div>
                            <div class="box">
                                <div class="icon-box">
                                    <i data-lucide="notepad-text" class="icon"></i>
                                </div>
                                <h2>Quiz</h2>
                                <p>18 Februari 2025</p>
                                <div class="bar"></div>
                                <p><span class="detail-tugas">1/2 Selesai</span></p>
                            </div>
                            <div class="box">
                                <div class="icon-box">
                                    <i data-lucide="school" class="icon"></i>
                                </div>
                                <h2>Ujian</h2>
                                <p>18 Februari 2025</p>
                                <div class="bar"></div>
                                <p><span class="detail-tugas">1/2 Selesai</span></p>
                            </div>
                            <div class="box">
                                <div class="icon-box">
                                    <i data-lucide="flask-conical" class="icon"></i>
                                </div>
                                <h2>Penelitian</h2>
                                <p>18 Februari 2025</p>
                                <div class="bar"></div>
                                <p><span class="detail-tugas">1/2 Selesai</span></p>
                            </div>
                            <div class="box">
                                <div class="icon-box">
                                    <i data-lucide="users-round" class="icon"></i>
                                </div>
                                <h2>Bimbingan</h2>
                                <p>18 Februari 2025</p>
                                <div class="bar"></div>
                                <p><span class="detail-tugas">1/2 Selesai</span></p>
                            </div>
                            <div class="box">
                                <div class="icon-box">
                                    <i data-lucide="presentation" class="icon"></i>
                                </div>
                                <h2>Briefing</h2>
                                <p>18 Februari 2025</p>
                                <div class="bar"></div>
                                <p><span class="detail-tugas">1/2 Selesai</span></p>
                            </div>
                        </div>
                        <div class="timer">
                            <div class="icon">
                                <img src="img/play.png" alt="">
                                <img src="img/pause.png" alt="">
                            </div>
                            <div class="time">
                                <h1>01:24:08</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kanan">
                    <h1>Sisa Tugas</h1>
                    <div class="list-tugas">
                        <div class="box-list">
                            <i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Pembuatan Aplikasi Mobile</h3>
                                <p>07.00 - 08.00</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Meeting Tim Proyek</h3>
                                <p>09.00 - 10.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Review Code Backend</h3>
                                <p>11.00 - 12.00</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Diskusi UI/UX</h3>
                                <p>13.30 - 14.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Presentasi Proyek</h3>
                                <p>15.00 - 16.00</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Latihan Algoritma</h3>
                                <p>16.30 - 17.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Pengerjaan Laporan</h3>
                                <p>18.00 - 19.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Mengerjakan Tugas Kuliah</h3>
                                <p>20.00 - 21.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Belajar Flutter</h3>
                                <p>22.00 - 23.00</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Brainstorming Ide Startup</h3>
                                <p>23.30 - 00.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Brainstorming Ide Startup</h3>
                                <p>23.30 - 00.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Brainstorming Ide Startup</h3>
                                <p>23.30 - 00.30</p>
                            </div>
                        </div>
                        <div class="box-list"><i data-lucide="square" class="icon"></i>
                            <div class="box-list2">
                                <h3>Brainstorming Ide Startup</h3>
                                <p>23.30 - 00.30</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    <script src="script.js"></script>
</body>

</html>