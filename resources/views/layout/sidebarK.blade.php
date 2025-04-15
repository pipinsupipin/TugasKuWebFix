<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage TugasKu</title>
    <link rel="stylesheet" href="{{ asset('kategori.css') }}">

</head>

<body>
    
    <div class="wrapper">
        <div class="sidebar-container">
            <h2 class="logo">Tugas<span class="dot">•</span><span class="ku">Ku</span></h2>
            <div class="menu">
                <h3>Menu</h3>
                <a href="/homepage" class="menu-item" id="dashboard-btn">
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

                <a href="/kategori" class="menu-item active" id="kategori-btn">
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
                <a href="/aboutuspage" class="menu-item" id="about-btn">
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
