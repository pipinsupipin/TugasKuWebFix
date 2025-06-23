document.addEventListener('DOMContentLoaded', function () {
    // ========== SLIDER ==========
    const toRegister = document.getElementById('to-register');
    const toLogin = document.getElementById('to-login');

    const container = document.querySelector('.container');
    const body = document.body;
    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.register-form');

    toRegister.addEventListener('click', function () {
        container.classList.add('active');
        body.classList.remove('login-active');
        body.classList.add('register-active');

        setTimeout(() => {
            loginForm.classList.remove('visible');
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            registerForm.classList.add('visible');
        }, 300);
    });

    toLogin.addEventListener('click', function () {
        container.classList.remove('active');
        body.classList.remove('register-active');
        body.classList.add('login-active');

        setTimeout(() => {
            registerForm.classList.remove('visible');
            registerForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
            loginForm.classList.add('visible');
        }, 300);
    });
});

// ========== ALERT HANDLER ==========
function showAlert(message, type = 'error') {
    const alertContainer = document.getElementById('alert-container');
    const alertMessage = document.createElement('div');
    alertMessage.classList.add('alert-message', type);

    alertMessage.innerHTML = `
        <span>${message}</span>
        <span class="close-btn">&times;</span>
    `;

    alertMessage.querySelector('.close-btn').addEventListener('click', () => {
        alertMessage.style.opacity = '0';
        setTimeout(() => alertMessage.remove(), 300);
    });

    alertContainer.appendChild(alertMessage);

    setTimeout(() => {
        alertMessage.style.opacity = '0';
        setTimeout(() => alertMessage.remove(), 300);
    }, 5000);
}

// ========== LOGIN HANDLER ==========
// const baseUrl = 'http://127.0.0.1:8000';
// const baseUrl = 'http://localhost:8000';
const baseUrl = 'https://tugas-ku.cloud';
const loginButton = document.querySelector('.login-form .btn-primary');
loginButton.addEventListener('click', async function () {
    const email = document.querySelector('.login-form input[type="email"]').value;
    const password = document.querySelector('.login-form input[type="password"]').value;

    try {
        await fetch(`${baseUrl}/sanctum/csrf-cookie`, {
            method: 'GET',
            credentials: 'include',
        });
        
        const response = await fetch(`${baseUrl}/api/auth/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ email, password }),
            credentials: 'include',
        });

        if (!response.ok) {
            const errorData = await response.json();
            let errorMessage = 'Login gagal. Periksa email dan kata sandi Anda.';
            if (errorData.message?.includes('Unauthorized')) {
                errorMessage = 'Email atau kata sandi yang Anda masukkan salah.';
            } else if (errorData.message?.includes('User not found')) {
                errorMessage = 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.';
            }
            showAlert(errorMessage, 'error');
            return;
        }

        // ✅ Ambil JSON (bukan .text())
        const data = await response.json();

        // Simpan token dan user ke localStorage
        localStorage.setItem('auth_token', data.token);
        localStorage.setItem('user_data', JSON.stringify(data.user));

        // Redirect berdasarkan role
        if (data.user.role === 'admin') {
            window.location.href = '/admindashboard';
        } else {
            window.location.href = '/homepage';
        }

    } catch (error) {
        console.error('Login Error:', error);
        showAlert('Terjadi kesalahan saat login.', 'error');
    }
});

// ========== REGISTER HANDLER ==========
const registerButton = document.querySelector('.register-form .btn-primary');
registerButton.addEventListener('click', async function () {
    const name = document.querySelector('.register-form input[type="text"]').value;
    const email = document.querySelector('.register-form input[type="email"]').value;
    const password = document.querySelector('.register-form input[type="password"]').value;
    const confirmPassword = document.querySelector('.register-form input[placeholder="Konfirmasi Kata Sandi"]').value;

    if (password !== confirmPassword) {
        showAlert('Kata sandi dan konfirmasi harus sama.', 'error');
        return;
    }

    try {
        // Ambil CSRF token dari server
        await fetch(`${baseUrl}/sanctum/csrf-cookie`, {
            method: 'GET',
            credentials: 'include',
        });

        // Kirim data registrasi ke server
        const response = await fetch(`${baseUrl}/api/auth/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name,
                email,
                password,
                password_confirmation: confirmPassword,
            }),
            credentials: 'include',
        });

        // Jika respons gagal, tampilkan pesan error
        if (!response.ok) {
            const errorData = await response.json();
            let errorMessage = 'Registrasi gagal. Periksa isian form.';
            if (errorData.message.includes('email')) {
                errorMessage = 'Email sudah terdaftar.';
            } else if (errorData.message.includes('validation')) {
                errorMessage = 'Silakan periksa kembali format data yang dimasukkan.';
            }
            showAlert(errorMessage, 'error');
            return;
        }

        // Ambil data JSON dari response
        const data = await response.json();

        // Simpan token ke localStorage
        localStorage.setItem('auth_token', data.token);

        // Redirect ke halaman utama
        window.location.href = '/homepage';

    } catch (error) {
        console.error('Register Error:', error);
        showAlert('Terjadi kesalahan saat registrasi.', 'error');
    }
});