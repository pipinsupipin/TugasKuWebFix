axios.defaults.withCredentials = true;
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;

// Fetch user data saat halaman dimuat
function fetchUserData() {
    axios.get('/api/user', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(response => {
        const { data } = response;
        if (data) {
            // Update UI dengan data user
            const usernameElement = document.querySelector('.username');
            const useremailElement = document.querySelector('.useremail');
            
            if (usernameElement) usernameElement.textContent = data.name;
            if (useremailElement) useremailElement.textContent = data.email;

            // Update foto profil di halaman utama
            const profilePic = document.getElementById('profilePic');
            if (profilePic) {
                if (data.profile_picture) {
                    profilePic.innerHTML = `<img src="${data.profile_picture}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" />
                        <div class="add-photo">
                            <svg width="24" height="24" fill="currentColor">
                                <path d="M12 5v14m7-7H5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>`;
                } else {
                    // Keep default SVG avatar
                    const defaultSvg = `<svg id="defaultAvatar" width="10rem" height="10rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="#6b7280" stroke-width="2" />
                        <path d="M12 12c-2 0-4 1.5-4 3.5S10 19 12 19s4-1.5 4-3.5S14 12 12 12zm0-5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z" fill="#6b7280" />
                    </svg>
                    <div class="add-photo">
                        <svg width="24" height="24" fill="currentColor">
                            <path d="M12 5v14m7-7H5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>`;
                    profilePic.innerHTML = defaultSvg;
                }
            }

            // Populate form fields di modal edit profile
            const nameInput = document.querySelector('#name');
            const emailInput = document.querySelector('#email');
            const profilePreview = document.querySelector('#profilePreview');
            
            if (nameInput) nameInput.value = data.name;
            if (emailInput) emailInput.value = data.email;
            if (profilePreview) {
                if (data.profile_picture) {
                    profilePreview.src = data.profile_picture;
                } else {
                    profilePreview.src = '/images/default-avatar.png';
                }
            }
        }
    })
    .catch(error => {
        console.error('Gagal mengambil data pengguna:', error);
        showToast('Gagal mengambil data pengguna', 'error');
    });
}

// Fungsi untuk update profile
function updateProfile() {
    const formData = new FormData();
    const nameInput = document.querySelector('#name');
    const profileImageInput = document.querySelector('#profileImageInput');

    if (nameInput && nameInput.value.trim()) {
        formData.append('name', nameInput.value.trim());
    }

    if (profileImageInput && profileImageInput.files[0]) {
        formData.append('profile_picture', profileImageInput.files[0]);
    }

    // Jika tidak ada data yang diubah
    if (!formData.has('name') && !formData.has('profile_picture')) {
        showToast('Tidak ada perubahan untuk disimpan', 'warning');
        return;
    }

    // Show loading
    showToast('Sedang memperbarui profil...', 'info');

    axios.post('/api/user/profile', formData, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(response => {
        console.log('Profile update response:', response.data);
        showToast(response.data.message || 'Profil berhasil diperbarui!', 'success');
        
        // Update UI dengan data baru
        if (response.data.user) {
            const userData = response.data.user;
            const usernameElement = document.querySelector('.username');
            if (usernameElement) usernameElement.textContent = userData.name;
            
            // Update foto profil di halaman utama dan preview
            if (userData.profile_picture) {
                const profilePic = document.getElementById('profilePic');
                const profilePreview = document.querySelector('#profilePreview');
                
                if (profilePic) {
                    profilePic.innerHTML = `<img src="${userData.profile_picture}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" />
                        <div class="add-photo">
                            <svg width="24" height="24" fill="currentColor">
                                <path d="M12 5v14m7-7H5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>`;
                }
                if (profilePreview) {
                    profilePreview.src = userData.profile_picture;
                }
            }
        }
        
        // Close modal
        closeModal('editProfileModal');
        
        // Reset form
        if (profileImageInput) profileImageInput.value = '';
    })
    .catch(error => {
        console.error('Error updating profile:', error);
        if (error.response && error.response.data) {
            const errorData = error.response.data;
            if (errorData.errors) {
                // Handle validation errors
                const errorMessages = Object.values(errorData.errors).flat();
                showToast(errorMessages.join(', '), 'error');
            } else {
                showToast(errorData.message || 'Gagal memperbarui profil', 'error');
            }
        } else {
            showToast('Terjadi kesalahan saat memperbarui profil', 'error');
        }
    });
}

// Fungsi untuk ganti password
function changePassword() {
    const oldPassword = document.querySelector('#oldPassword').value;
    const newPassword = document.querySelector('#newPassword').value;
    const confirmPassword = document.querySelector('#confirmPassword').value;

    // Validasi input
    if (!oldPassword || !newPassword || !confirmPassword) {
        showToast('Semua field password harus diisi', 'error');
        return;
    }

    if (newPassword !== confirmPassword) {
        showToast('Password baru dan konfirmasi password tidak cocok', 'error');
        return;
    }

    if (newPassword.length < 8) {
        showToast('Password baru minimal 8 karakter', 'error');
        return;
    }

    // Show loading
    showToast('Sedang mengubah password...', 'info');

    const payload = {
        current_password: oldPassword,
        new_password: newPassword,
        new_password_confirmation: confirmPassword
    };

    axios.put('/api/user/password', payload, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Password change response:', response.data);
        showToast(response.data.message || 'Password berhasil diubah!', 'success');
        closeModal('editPasswordModal');
        
        // Reset form
        document.querySelector('#oldPassword').value = '';
        document.querySelector('#newPassword').value = '';
        document.querySelector('#confirmPassword').value = '';
    })
    .catch(error => {
        console.error('Error changing password:', error);
        if (error.response && error.response.data) {
            const errorData = error.response.data;
            if (errorData.errors) {
                // Handle validation errors
                const errorMessages = Object.values(errorData.errors).flat();
                showToast(errorMessages.join(', '), 'error');
            } else {
                showToast(errorData.message || 'Gagal mengubah password', 'error');
            }
        } else {
            showToast('Terjadi kesalahan saat mengubah password', 'error');
        }
    });
}

// Fungsi untuk logout
function logout() {
    console.log('Logout function called');
    
    axios.post('/api/auth/logout', {}, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(response => {
        console.log('Logout berhasil');
        localStorage.removeItem('auth_token');
        showToast('Logout berhasil', 'success');
        setTimeout(() => {
            window.location.href = '/login';
        }, 1000);
    })
    .catch(error => {
        console.error('Gagal logout:', error);
        // Tetap logout meskipun ada error
        localStorage.removeItem('auth_token');
        window.location.href = '/login';
    });
}

// Fungsi untuk menampilkan toast menggunakan elemen yang sudah ada
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.querySelector('.toast-message');
    const toastIcon = document.querySelector('.toast-icon svg');
    
    if (!toast || !toastMessage) {
        console.error('Toast elements not found');
        // Fallback: alert jika toast tidak ditemukan
        alert(message);
        return;
    }

    // Update message
    toastMessage.textContent = message;
    
    // Reset all toast classes
    toast.className = 'toast';
    
    // Add appropriate class based on type
    switch(type) {
        case 'success':
            toast.classList.add('toast-success');
            if (toastIcon) {
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
            }
            break;
        case 'error':
            toast.classList.add('toast-error');
            if (toastIcon) {
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
            }
            break;
        case 'warning':
            toast.classList.add('toast-warning');
            if (toastIcon) {
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />';
            }
            break;
        case 'info':
            toast.classList.add('toast-info');
            if (toastIcon) {
                toastIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />';
            }
            break;
    }
    
    // Show toast with active class (sesuai CSS Anda)
    toast.classList.add('active');
    
    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.classList.remove('active');
    }, 3000);
    
    // Debug log
    console.log(`Toast shown: ${type} - ${message}`);
}

// Fungsi untuk membuka modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        
        // Jika modal edit profile, fetch data terbaru
        if (modalId === 'editProfileModal') {
            fetchUserData();
        }
    }
}

// Fungsi untuk menutup modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Event listeners saat DOM dimuat
document.addEventListener('DOMContentLoaded', function () {
    // Fetch user data saat halaman dimuat
    fetchUserData();

    // Event listener untuk profile pic click - buka modal edit profile
    const profilePic = document.getElementById('profilePic');
    if (profilePic) {
        profilePic.addEventListener('click', function(e) {
            e.preventDefault();
            openModal('editProfileModal');
        });
    }

    // Event listener untuk setting items dengan onclick attribute sudah ada di HTML
    // Kita tidak perlu menambahkan event listener lagi karena sudah menggunakan onclick="openModal()"

    // Event listener untuk tombol save profile
    const saveProfileBtn = document.getElementById('saveProfile');
    if (saveProfileBtn) {
        saveProfileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            updateProfile();
        });
    }

    // Event listener untuk tombol save password
    const savePasswordBtn = document.getElementById('savePassword');
    if (savePasswordBtn) {
        savePasswordBtn.addEventListener('click', function(e) {
            e.preventDefault();
            changePassword();
        });
    }

    // Event listener untuk tombol logout
    const logoutButton = document.getElementById('logoutBtn');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Konfirmasi logout
            if (confirm('Apakah Anda yakin ingin logout?')) {
                logout();
            }
        });
    }

    // Event listener untuk menutup modal
    document.querySelectorAll('.modal-close').forEach(button => {
        button.addEventListener('click', function() {
            const modal = button.closest('.modal-overlay');
            if (modal) {
                modal.classList.remove('active');
            }
        });
    });

    // Event listener untuk toast close button
    const toastCloseBtn = document.querySelector('.toast-close');
    if (toastCloseBtn) {
        toastCloseBtn.addEventListener('click', function() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.remove('active');
            }
        });
    }

    // Tutup modal jika klik di luar area modal
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(event) {
            if (event.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });

    // Preview image saat upload foto profil
    const profileImageInput = document.querySelector('#profileImageInput');
    const profilePreview = document.querySelector('#profilePreview');
    
    if (profileImageInput && profilePreview) {
        profileImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Validasi file
                if (!file.type.startsWith('image/')) {
                    showToast('File harus berupa gambar', 'error');
                    event.target.value = '';
                    return;
                }

                // Validasi ukuran file (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showToast('Ukuran file maksimal 2MB', 'error');
                    event.target.value = '';
                    return;
                }

                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Expose functions to global scope untuk onclick di HTML
window.openModal = openModal;
window.closeModal = closeModal;
window.logout = logout;