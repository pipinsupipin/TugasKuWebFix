@extends('layouts.app')
@section('title', 'Pengaturan - TugasKu')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@endpush
@section('content')
<div class="settings-page">
    <div class="settings-header">
        <h1 class="settings-title">Pengaturan</h1>
    </div>
    
    <!-- Profil Akun -->
    <div class="profile-section">
        <div class="profile-pic" id="profilePic">
          <svg id="defaultAvatar" width="10rem" height="10rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" stroke="#6b7280" stroke-width="2" />
              <path d="M12 12c-2 0-4 1.5-4 3.5S10 19 12 19s4-1.5 4-3.5S14 12 12 12zm0-5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z" fill="#6b7280" />
          </svg>
          <div class="add-photo">
            <svg width="24" height="24" fill="currentColor">
                <path d="M12 5v14m7-7H5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
      </div>
        <div class="user-info">
            <div class="username">Nama</div>
            <div class="useremail">hello@email.com</div>
        </div>
    </div>
    
    <!-- Pengaturan Akun -->
    <div class="settings-group">
        <div class="settings-group-title">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Pengaturan Akun
        </div>
        <div class="setting-item" onclick="openModal('editProfileModal')">
            <div class="setting-left">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <div class="setting-label">Ubah Profil</div>
                    <div class="setting-description">Perbarui informasi pribadi Anda</div>
                </div>
            </div>
            <div class="chevron">›</div>
        </div>
        <div class="setting-item" onclick="openModal('editPasswordModal')">
            <div class="setting-left">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <div>
                    <div class="setting-label">Ubah Kata Sandi</div>
                    <div class="setting-description">Ganti kata sandi akun Anda</div>
                </div>
            </div>
            <div class="chevron">›</div>
        </div>
        <div class="setting-item" onclick="openModal('securityPrivacyModal')">
            <div class="setting-left">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <div class="setting-label">Keamanan dan Privasi</div>
                    <div class="setting-description">Kelola pengaturan keamanan</div>
                </div>
            </div>
            <div class="chevron">›</div>
        </div>
    </div>
    
    <!-- Pengaturan Notifikasi -->
    <div class="settings-group">
        <div class="settings-group-title">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            Pengaturan Notifikasi
        </div>
        <div class="setting-item">
            <div class="setting-left">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <div>
                    <div class="setting-label">Notifikasi</div>
                    <div class="setting-description">Aktifkan notifikasi tugas</div>
                </div>
            </div>
            <label class="toggle-container">
                <input type="checkbox" class="toggle-input" checked>
                <span class="toggle-slider"></span>
            </label>
        </div>
        <div class="setting-item">
            <div class="setting-left">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <div class="setting-label">Promosi</div>
                    <div class="setting-description">Terima info promosi dan penawaran</div>
                </div>
            </div>
            <label class="toggle-container">
                <input type="checkbox" class="toggle-input">
                <span class="toggle-slider"></span>
            </label>
        </div>
    </div>
    
    <!-- Tombol Keluar -->
    <div class="settings-group">
        <div class="setting-item logout" id="logoutBtn">
            <div class="setting-left">
                <div class="setting-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div class="setting-label">Keluar Akun</div>
            </div>
            <div class="chevron">›</div>
        </div>
    </div>
</div>

<!-- Modal Edit Profile -->
<div class="modal-overlay" id="editProfileModal">
  <div class="modal">
      <div class="modal-header">
          <h3 class="modal-title">Edit Profil</h3>
          <button class="modal-close">&times;</button>
      </div>
      <div class="modal-body">
          <form id="editProfileForm">
              <!-- Foto Profil -->
              <div class="form-group">
                  <label class="form-label">Foto Profil</label>
                  <div class="profile-pic-container">
                      <img id="profilePreview" src="{{ asset('images/default-avatar.png') }}" alt="Foto Profil">
                      <input type="file" id="profileImageInput" accept="image/*" hidden>
                      <button type="button" class="btn btn-outline" onclick="document.getElementById('profileImageInput').click()">Ganti Foto</button>
                  </div>
              </div>

              <!-- Nama -->
              <div class="form-group">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-input" id="name" value="Kevin Azaria Farrel" required>
              </div>

              <!-- Email -->
              <div class="form-group">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-input" id="email" value="kevin.azaria@email.com" required>
              </div>
          </form>
      </div>
      <div class="modal-footer">
          <button class="btn btn-outline modal-close">Batal</button>
          <button class="btn btn-primary" id="saveProfile">Simpan</button>
      </div>
  </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal-overlay" id="editPasswordModal">
  <div class="modal">
      <div class="modal-header">
          <h3 class="modal-title">Ubah Kata Sandi</h3>
          <button class="modal-close">&times;</button>
      </div>
      <div class="modal-body">
          <form id="editPasswordForm">
              <div class="form-group">
                  <label class="form-label">Kata Sandi Lama</label>
                  <input type="password" class="form-input" id="oldPassword">
              </div>
              <div class="form-group">
                  <label class="form-label">Kata Sandi Baru</label>
                  <input type="password" class="form-input" id="newPassword">
              </div>
              <div class="form-group">
                  <label class="form-label">Konfirmasi Kata Sandi</label>
                  <input type="password" class="form-input" id="confirmPassword">
              </div>
          </form>
      </div>
      <div class="modal-footer">
          <button class="btn btn-outline modal-close">Batal</button>
          <button class="btn btn-primary" id="savePassword">Simpan</button>
      </div>
  </div>
</div>

<!-- Modal Keamanan dan Privasi -->
<div class="modal-overlay" id="securityPrivacyModal">
  <div class="modal">
      <div class="modal-header">
          <h3 class="modal-title">Keamanan dan Privasi</h3>
          <button class="modal-close">&times;</button>
      </div>
      <div class="modal-body">
          <p>Atur keamanan akun dan privasi data Anda di sini.</p>
          <div class="form-group">
              <label class="form-label">Autentikasi Dua Faktor</label>
              <label class="toggle-container">
                  <input type="checkbox" class="toggle-input">
                  <span class="toggle-slider"></span>
              </label>
          </div>
          <div class="form-group">
              <label class="form-label">Notifikasi Login Tidak Dikenal</label>
              <label class="toggle-container">
                  <input type="checkbox" class="toggle-input">
                  <span class="toggle-slider"></span>
              </label>
          </div>
      </div>
      <div class="modal-footer">
          <button class="btn btn-outline modal-close">Batal</button>
          <button class="btn btn-primary">Simpan</button>
      </div>
  </div>
</div>

<!-- Toast Notification -->
<div class="toast toast-success" id="toast">
    <div class="toast-icon">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    <div class="toast-message">Perubahan berhasil disimpan!</div>
    <button class="toast-close">&times;</button>
</div>

@endsection

@push('scripts')
  <script src="{{ asset('js/settings.js') }}"></script>
@endpush