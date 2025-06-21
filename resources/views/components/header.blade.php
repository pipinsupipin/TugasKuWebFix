<!-- Header Component -->
<header class="header">
    <div class="search-container">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.3-4.3" />
        </svg>
        <input type="text" placeholder="Cari dari nama tugas..." class="search-input">
    </div>
    
    <div class="user-profile">
        <div class="user-details">
            <span id="user-name" class="user-name">Pengguna</span>
            <span id="user-email" class="user-email">pengguna@mail.com</span>
        </div>
        <div class="avatar" id="avatar-container">
            <img id="user-avatar" src="{{ asset('img/user-profile.png') }}" alt="Profile Avatar">
        </div>
    </div>
</header>

<script>
// ===================== PROFILE INFO =====================
axios.defaults.withCredentials = true;
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
    
const userNameElement = document.getElementById('user-name');
const userEmailElement = document.getElementById('user-email');
const avatarContainer = document.getElementById('avatar-container');
const userAvatarElement = document.getElementById('user-avatar');

axios.get('/api/user', {
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
    }
})
.then(response => {
    const { name, email, profile_picture } = response.data;

    // Set Name dan Email
    userNameElement.textContent = name || 'Pengguna';
    userEmailElement.textContent = email || 'Email tidak ditemukan';

    // Set Avatar
    if (profile_picture) {
        userAvatarElement.src = profile_picture;
    } else {
        // Gantikan <img> dengan SVG langsung, dan styling terpusat
        avatarContainer.innerHTML = `
            <svg width="4.5rem" height="4.5rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="#6b7280" stroke-width="2" />
                <path d="M12 12c-2 0-4 1.5-4 3.5S10 19 12 19s4-1.5 4-3.5S14 12 12 12zm0-5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z" fill="#6b7280" />
            </svg>
        `;
    }
})
.catch(error => {
    console.error('Terjadi kesalahan saat mengambil data user:', error);
    userNameElement.textContent = 'Pengguna';
    userEmailElement.textContent = 'Email tidak ditemukan';
    avatarContainer.innerHTML = `
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" stroke="#6b7280" stroke-width="2" />
            <path d="M12 12c-2 0-4 1.5-4 3.5S10 19 12 19s4-1.5 4-3.5S14 12 12 12zm0-5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z" fill="#6b7280" />
        </svg>
    `;
});
</script>