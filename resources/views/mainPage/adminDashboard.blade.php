<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mainPage/admindashboard.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="main-content">
        <div class="content-header">
            <h1 class="page-title">Welcome back, Admin!</h1>

        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon">💬</div>
                <div class="stat-content">
                    <div class="stat-number">87</div>
                    <div class="stat-label">Total Kritik & Saran</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <div class="stat-number">42</div>
                    <div class="stat-label">Tugas Aktif</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <div class="stat-number">135</div>
                    <div class="stat-label">Pengguna Terdaftar</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏷️</div>
                <div class="stat-content">
                    <div class="stat-number">16</div>
                    <div class="stat-label">Kategori</div>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <div class="card wide-card">
                <div class="card-header">
                    <div class="card-title">Kritik & Saran Terbaru</div>
                    <div class="card-action">Lihat Semua</div>
                </div>
                <div class="card-body">
                    <div class="search-container">
                        <input type="text" class="search-input"
                            placeholder="Cari berdasarkan nama, email, atau konten...">
                        <span class="search-icon">🔍</span>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Rating</th>
                                    <th>Kategori</th>
                                    <th>Kritik & Saran</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ahmad Rizky</td>
                                    <td class="truncate">ahmad.rizky@email.com</td>
                                    <td>
                                        <div class="rating">
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star">★</span>
                                        </div>
                                    </td>
                                    <td>Website</td>
                                    <td class="feedback-content">Website sangat responsif dan mudah digunakan, tetapi
                                        saya menemukan beberapa kesalahan pada halaman kontak.</td>
                                    <td>15 Apr 2025</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>
                                        <span class="action-icon">👁️</span>
                                        <span class="action-icon">✏️</span>
                                        <span class="action-icon">🗑️</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Siti Rahma</td>
                                    <td class="truncate">siti.rahma@email.com</td>
                                    <td>
                                        <div class="rating">
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star">★</span>
                                            <span class="star">★</span>
                                        </div>
                                    </td>
                                    <td>Aplikasi</td>
                                    <td class="feedback-content">Aplikasi sering crash ketika saya mencoba mengupload
                                        gambar. Tolong diperbaiki segera.</td>
                                    <td>14 Apr 2025</td>
                                    <td><span class="status-badge status-progress">Diproses</span></td>
                                    <td>
                                        <span class="action-icon">👁️</span>
                                        <span class="action-icon">✏️</span>
                                        <span class="action-icon">🗑️</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Budi Santoso</td>
                                    <td class="truncate">budi.santoso@email.com</td>
                                    <td>
                                        <div class="rating">
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                        </div>
                                    </td>
                                    <td>Layanan</td>
                                    <td class="feedback-content">Customer service sangat responsif dan membantu. Sangat
                                        terkesan dengan pelayanan yang diberikan.</td>
                                    <td>13 Apr 2025</td>
                                    <td><span class="status-badge status-completed">Selesai</span></td>
                                    <td>
                                        <span class="action-icon">👁️</span>
                                        <span class="action-icon">✏️</span>
                                        <span class="action-icon">🗑️</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dewi Anggraini</td>
                                    <td class="truncate">dewi.anggraini@email.com</td>
                                    <td>
                                        <div class="rating">
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star">★</span>
                                            <span class="star">★</span>
                                            <span class="star">★</span>
                                        </div>
                                    </td>
                                    <td>Produk</td>
                                    <td class="feedback-content">Kualitas produk tidak sesuai dengan yang diiklankan.
                                        Bahan terasa murah dan mudah rusak.</td>
                                    <td>12 Apr 2025</td>
                                    <td><span class="status-badge status-progress">Diproses</span></td>
                                    <td>
                                        <span class="action-icon">👁️</span>
                                        <span class="action-icon">✏️</span>
                                        <span class="action-icon">🗑️</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Faisal Rahman</td>
                                    <td class="truncate">faisal.rahman@email.com</td>
                                    <td>
                                        <div class="rating">
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star filled">★</span>
                                            <span class="star">★</span>
                                        </div>
                                    </td>
                                    <td>Website</td>
                                    <td class="feedback-content">Proses checkout terlalu rumit dan membutuhkan terlalu
                                        banyak langkah. Mohon disederhanakan.</td>
                                    <td>11 Apr 2025</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>
                                        <span class="action-icon">👁️</span>
                                        <span class="action-icon">✏️</span>
                                        <span class="action-icon">🗑️</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tugas yang Ditugaskan</div>
                    <div class="card-action">Lihat Semua</div>
                </div>
                <div class="card-body card-body-scrollable">
                    <div class="tab-container">
                        <div class="tab active">Semua (12)</div>
                        <div class="tab">Menunggu (5)</div>
                        <div class="tab">Proses (4)</div>
                        <div class="tab">Selesai (3)</div>
                    </div>

                    <div class="task-item">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <div class="task-title">Perbaiki bug upload gambar di aplikasi</div>
                            <div class="task-details">
                                <div class="task-detail">
                                    <span class="task-detail-icon">📅</span>
                                    <span>Due: 18 Apr 2025</span>
                                </div>
                                <div class="task-detail">
                                    <span class="task-detail-icon">🏷️</span>
                                    <span>Bug Fix</span>
                                </div>
                            </div>
                        </div>
                        <div class="task-assignee">
                            <div class="assignee-avatar">FS</div>
                        </div>
                    </div>

                    <div class="task-item">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <div class="task-title">Redesign halaman checkout untuk penyederhanaan</div>
                            <div class="task-details">
                                <div class="task-detail">
                                    <span class="task-detail-icon">📅</span>
                                    <span>Due: 20 Apr 2025</span>
                                </div>
                                <div class="task-detail">
                                    <span class="task-detail-icon">🏷️</span>
                                    <span>Design</span>
                                </div>
                            </div>
                        </div>
                        <div class="task-assignee">
                            <div class="assignee-avatar">RA</div>
                        </div>
                    </div>

                    <div class="task-item">
                        <input type="checkbox" class="task-checkbox" checked>
                        <div class="task-content">
                            <div class="task-title">Implementasi sistem rating baru untuk ulasan</div>
                            <div class="task-details">
                                <div class="task-detail">
                                    <span class="task-detail-icon">📅</span>
                                    <span>Due: 15 Apr 2025</span>
                                </div>
                                <div class="task-detail">
                                    <span class="task-detail-icon">🏷️</span>
                                    <span>Feature</span>
                                </div>
                            </div>
                        </div>
                        <div class="task-assignee">
                            <div class="assignee-avatar">DN</div>
                        </div>
                    </div>

                    <div class="task-item">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <div class="task-title">Review dan respon kritik dari Siti Rahma</div>
                            <div class="task-details">
                                <div class="task-detail">
                                    <span class="task-detail-icon">📅</span>
                                    <span>Due: 16 Apr 2025</span>
                                </div>
                                <div class="task-detail">
                                    <span class="task-detail-icon">🏷️</span>
                                    <span>Customer Support</span>
                                </div>
                            </div>
                        </div>
                        <div class="task-assignee">
                            <div class="assignee-avatar">MT</div>
                        </div>
                    </div>

                    <div class="task-item">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <div class="task-title">Evaluasi kualitas produk berdasarkan feedback</div>
                            <div class="task-details">
                                <div class="task-detail">
                                    <span class="task-detail-icon">📅</span>
                                    <span>Due: 22 Apr 2025</span>
                                </div>
                                <div class="task-detail">
                                    <span class="task-detail-icon">🏷️</span>
                                    <span>Quality Control</span>
                                </div>
                            </div>
                        </div>
                        <div class="task-assignee">
                            <div class="assignee-avatar">BS</div>
                        </div>
                    </div>

                    <div class="task-item">
                        <input type="checkbox" class="task-checkbox">
                        <div class="task-content">
                            <div class="task-title">Buat laporan analisis feedback bulanan</div>
                            <div class="task-details">
                                <div class="task-detail">
                                    <span class="task-detail-icon">📅</span>
                                    <span>Due: 30 Apr 2025</span>
                                </div>
                                <div class="task-detail">
                                    <span class="task-detail-icon">🏷️</span>
                                    <span>Report</span>
                                </div>
                            </div>
                        </div>
                        <div class="task-assignee">
                            <div class="assignee-avatar">LM</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pengguna Terdaftar</div>
                    <div class="card-action">Lihat Semua</div>
                </div>
                <div class="card-body card-body-scrollable">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Cari pengguna...">
                        <span class="search-icon">🔍</span>
                    </div>

                    <div class="user-list">
                        <div class="user-item">
                            <div class="user-avatar">FS</div>
                            <div class="user-info">
                                <div class="user-name">Fadli Syahroni</div>
                                <div class="user-email">fadli.s@email.com</div>
                            </div>
                            <div class="user-role">Developer</div>
                        </div>

                        <div class="user-item">
                            <div class="user-avatar">RA</div>
                            <div class="user-info">
                                <div class="user-name">Rina Amelia</div>
                                <div class="user-email">rina.a@email.com</div>
                            </div>
                            <div class="user-role">Designer</div>
                        </div>

                        <div class="user-item">
                            <div class="user-avatar">DN</div>
                            <div class="user-info"></div>