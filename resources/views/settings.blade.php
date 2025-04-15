@include("layout.sidebarS")
<div class="container">

  <div class="profile-section">
    <div class="profile-pic">
      <img src="/img/abi.png" alt="Foto Kevin">
      <div class="add-photo">+</div>
    </div>
    <div class="username">Kevin Azaria Farrel</div>
    <div class="account-type">Pengaturan Akun</div>
  </div>

  <div class="settings-group">
    <div class="setting-item">
      <div class="setting-label">Ubah Profil</div>
      <div class="chevron">›</div>
    </div>
    <div class="setting-item">
      <div class="setting-label">Ubah Kata Sandi</div>
      <div class="chevron">›</div>
    </div>
    <div class="setting-item">
      <div class="setting-label">Keamanan dan Privasi</div>
      <div class="chevron">›</div>
    </div>
  </div>

  <div class="settings-group">
    <div class="settings-group-title">Pengaturan Notifikasi</div>
    <div class="setting-item">
      <div class="setting-label">Notifikasi</div>
      <label class="toggle-container">
        <input type="checkbox" class="toggle-input" checked>
        <span class="toggle-slider"></span>
      </label>
    </div>
    <div class="setting-item">
      <div class="setting-label">Promosi</div>
      <label class="toggle-container">
        <input type="checkbox" class="toggle-input">
        <span class="toggle-slider"></span>
      </label>
    </div>
  </div>
</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>
</body>