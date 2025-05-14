// document.addEventListener('DOMContentLoaded', function () {
//     axios.defaults.withCredentials = true;
//     axios.defaults.baseURL = 'http://localhost:8000';

//     const modalMapping = {
//         editProfileModal: {
//             button: ".profile-pic",
//             apiGet: "/api/user",
//             apiPut: "/api/user",
//             form: {
//                 name: "#name",
//                 email: "#email"
//             },
//             successMessage: "Profil berhasil diperbarui!",
//             updateUI: (data) => {
//                 document.querySelector(".username").textContent = data.name;
//                 document.querySelector(".user-email").textContent = data.email;
//             }
//         },
//         changePasswordModal: {
//             button: ".change-password-btn",
//             apiPut: "/api/user/password",
//             form: {
//                 current_password: "#currentPassword",
//                 new_password: "#newPassword",
//                 confirm_password: "#confirmPassword"
//             },
//             successMessage: "Kata sandi berhasil diubah!"
//         },
//         privacySecurityModal: {
//             button: ".privacy-security-btn",
//             apiGet: "/api/user/security",
//             apiPut: "/api/user/security",
//             form: {
//                 two_factor: "#twoFactor"
//             },
//             successMessage: "Keamanan & Privasi berhasil diperbarui!"
//         }
//     };

//     // Event listener untuk setiap modal
//     Object.keys(modalMapping).forEach(modalId => {
//         const { button, apiGet, form } = modalMapping[modalId];
//         const modal = document.getElementById(modalId);

//         document.querySelector(button).addEventListener("click", function () {
//             openModal(modalId);
//             if (apiGet) {
//                 axios.get(apiGet)
//                     .then(response => {
//                         Object.keys(form).forEach(key => {
//                             document.querySelector(form[key]).value = response.data[key] || "";
//                         });
//                     })
//                     .catch(error => console.error("Error fetching data:", error));
//             }
//         });
//     });

//     // Fungsi untuk menyimpan perubahan
//     document.querySelectorAll(".save-button").forEach(button => {
//         button.addEventListener("click", function () {
//             const modalId = button.dataset.modal;
//             const { apiPut, form, successMessage, updateUI } = modalMapping[modalId];
    
//             const payload = {};
//             Object.keys(form).forEach(key => {
//                 payload[key] = document.querySelector(form[key]).value;
//             });
    
//             console.log('Payload yang dikirim:', payload);  // Log payload untuk debug
    
//             axios.put(apiPut, payload)
//                 .then(response => {
//                     console.log('Response dari API:', response);  // Log response API
//                     showToast(successMessage);
//                     closeModal(modalId);
//                     if (updateUI) updateUI(response.data);
//                 })
//                 .catch(error => {
//                     console.error("Error updating data:", error);
//                     showToast("Terjadi kesalahan saat memperbarui data");
//                 });
//         });
//     });

//     // Fungsi untuk menampilkan toast
//     function showToast(message) {
//         const toast = document.getElementById('toast');
//         toast.querySelector('.toast-message').textContent = message;
//         toast.classList.add('show');

//         setTimeout(() => {
//             toast.classList.remove('show');
//         }, 3000);
//     }

//     // Fungsi untuk membuka modal
//     function openModal(modalId) {
//         document.getElementById(modalId).classList.add('active');
//     }

//     // Fungsi untuk menutup modal
//     function closeModal(modalId) {
//         document.getElementById(modalId).classList.remove('active');
//     }

//     // Tutup modal jika klik di luar area modal
//     window.addEventListener('click', function (event) {
//         document.querySelectorAll('.modal-overlay').forEach(overlay => {
//             if (event.target === overlay) {
//                 overlay.classList.remove('active');
//             }
//         });
//     });

//     // Menutup modal saat tombol "x" diklik
//     document.querySelectorAll(".modal-close").forEach(button => {
//         button.addEventListener("click", function () {
//             button.closest('.modal-overlay').classList.remove('active');
//         });
//     });
// });

// window.openModal = function(modalId) {
//     document.getElementById(modalId).classList.add('active');
// }

// document.querySelectorAll('.modal-close').forEach(button => {
//     button.addEventListener('click', () => {
//         const modal = button.closest('.modal-overlay');
//         if (modal) {
//             modal.classList.remove('active');
//         }
//     });
// });

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000';

function fetchUserData() {
    axios.get('/api/user', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(response => {
        const { data } = response;
        // Menampilkan nama dan email
        if (data) {
            document.querySelector('.username').textContent = data.name;
            document.querySelector('.useremail').textContent = data.email;

            // Menampilkan foto profil jika ada
            const profilePic = document.getElementById('profilePic');
            if (data.profile_picture) {
                profilePic.innerHTML = `<img src="${data.profile_picture}" alt="Foto Profil" />`;
            } else {
                // Jika tidak ada foto profil, tampilkan gambar default
                profilePic.innerHTML = `<img src="{{ asset('images/default-avatar.png') }}" alt="Foto Profil" />`;
            }
        }
    })
    .catch(error => {
        console.error('Gagal mengambil data pengguna:', error);
    });
}

// Panggil fungsi saat halaman dimuat
document.addEventListener('DOMContentLoaded', fetchUserData);

// ==============================

document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('logoutBtn');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            console.log('Tombol logout diklik');
            event.preventDefault();  // Mencegah aksi default (link)
        
            // Mengirim request ke API untuk logout
            axios.post('/api/auth/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            })
            .then(response => {
                console.log('Logout berhasil');
                // Jika logout berhasil, hapus token dan alihkan ke halaman login
                localStorage.removeItem('auth_token');
                window.location.href = '/login';  // Alihkan ke halaman login
            })
            .catch(error => {
                console.error('Gagal logout:', error);
            });
        });
    } else {
        console.error('Tombol logout tidak ditemukan');
    }
});

