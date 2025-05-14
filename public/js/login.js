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
const loginButton = document.querySelector('.login-form .btn-primary');
loginButton.addEventListener('click', async function () {
    const email = document.querySelector('.login-form input[type="email"]').value;
    const password = document.querySelector('.login-form input[type="password"]').value;

    try {
        await fetch('http://localhost:8000/sanctum/csrf-cookie', {
            method: 'GET',
            credentials: 'include',
        });

        const response = await fetch('http://localhost:8000/api/auth/login', {
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
        if (errorData.message.includes('Unauthorized')) {
            errorMessage = 'Email atau kata sandi yang Anda masukkan salah.';
        } else if (errorData.message.includes('User not found')) {
            errorMessage = 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.';
        }
        showAlert(errorMessage, 'error');
        return;
        }

        const token = await response.text();
        localStorage.setItem('auth_token', token);
        window.location.href = '/homepage';

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
        await fetch('http://localhost:8000/sanctum/csrf-cookie', {
            method: 'GET',
            credentials: 'include',
        });

        const response = await fetch('http://localhost:8000/api/auth/register', {
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

        const data = await response.text();

        if (!response.ok) {
            let errorMessage = 'Registrasi gagal. Periksa isian form.';
            if (data.message.includes('email')) {
                errorMessage = 'Email sudah terdaftar.';
            } else if (data.message.includes('validation')) {
                errorMessage = 'Silakan periksa kembali format data yang dimasukkan.';
            }
            showAlert(errorMessage, 'error');
            return;
        }

        window.location.href = '/homepage';

    } catch (error) {
        console.error('Register Error:', error);
        showAlert('Terjadi kesalahan saat registrasi.', 'error');
    }
});