// ===================== Axios Setup =====================
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000';

initCategoryWidget();

// ===================== REFRESH TUGAS =====================
function fetchTasks() {
    axios.get('/api/tugas', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(response => {
        const { data } = response;
        if (data.success) {
            renderTaskList(data.data);
        }
    })
    .catch(error => {
        console.error('Gagal mengambil data tugas:', error);
    });
}

// ===================== REFRESH KATEGORI =====================
async function fetchCategories() {
    try {
        const response = await axios.get('/api/kategori', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            }
        });
        if (response.data.success) {
            console.log("Data kategori setelah refresh:", response.data.data);
            renderCategoryList(response.data.data);
        }
    } catch (error) {
        console.error('Gagal mengambil data kategori:', error);
    }
}

// ===================== SELECT KATEGORI =====================
document.querySelectorAll('.category-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

// ===================== RESPONSIVE MOBILE =====================
const checkWidth = () => {
    if (window.innerWidth <= 768) {
        document.querySelector('.sidebar').classList.add('collapsed');
    } else {
        document.querySelector('.sidebar').classList.remove('collapsed');
    }
};
window.addEventListener('resize', checkWidth);
checkWidth();

// ===================== GREETINGS =====================
const greetingElement = document.querySelector('.greeting h1');

axios.get('/api/user', {
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
    }
})
.then(response => {
    const userName = response.data.name || 'Kawan';
    greetingElement.textContent = `Selamat Datang, ${userName}!`;
})
.catch(error => {
    console.error('Terjadi kesalahan saat mengambil data user:', error);
    greetingElement.textContent = 'Selamat Datang, Kawan!';
});

// ===================== STREAK INFO =====================
const streakCountElement = document.getElementById('streak-count');
const streakTextElement = document.getElementById('streak-text');
const streakIconElement = document.getElementById('streak-icon');
const streakContentElement = document.querySelector('.streak-content');

axios.get('/api/streaks/summary', {
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
    }
})
.then(response => {
    const { current_streak } = response.data.data;

    // Setel nilai streak di elemen
    streakCountElement.textContent = current_streak;

    if (current_streak < 3) {
        // Jika kurang dari 3, icon berubah dan teks jadi abu-abu
        streakIconElement.src = '/img/streak-locked.png';
        streakContentElement.classList.add('low-streak');
        streakIconElement.classList.add('low-streak-icon');
    } else {
        // Jika 3 atau lebih, tetap normal
        streakIconElement.src = 'img/flame-icon.png';
        streakContentElement.classList.remove('low-streak');
        streakIconElement.classList.remove('low-streak-icon');
    }
})
.catch(error => {
    console.error('Terjadi kesalahan saat mengambil data streak:', error);
});

// ===================== FETCH TASKS =====================
const todoListElement = document.getElementById('todo-list');

function fetchTasks() {
    axios.get('/api/tugas', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(response => {
        const tasks = response.data.data;

        // Kosongkan dulu elemen sebelum di-render ulang
        todoListElement.innerHTML = '';

        // Filter tugas yang belum selesai dan urutkan berdasarkan waktu_mulai terdekat
        const incompleteTasks = tasks
            .filter(task => !task.is_completed)
            .sort((a, b) => new Date(a.waktu_mulai) - new Date(b.waktu_mulai));
        
        // Render ke dalam HTML
        if (incompleteTasks.length > 0) {
            incompleteTasks.forEach(task => {
                const waktuMulai = new Date(task.waktu_mulai).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const waktuSelesai = task.waktu_selesai 
                    ? new Date(task.waktu_selesai).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) 
                    : '';

                const waktuDitampilkan = waktuSelesai ? `${waktuMulai} - ${waktuSelesai}` : `${waktuMulai}`;

                const taskElement = `
                <div class="task-item ${task.is_completed ? 'completed' : ''}" data-id="${task.id}">
                    <div class="task-checkbox" data-id="${task.id}">
                        <div class="checkmark" style="opacity: ${task.is_completed ? '1' : '0'}"></div>
                    </div>
                    <div class="task-content">
                        <h4 class="task-title">${task.judul}</h4>
                        <p class="task-time">${waktuDitampilkan}</p>
                    </div>
                </div>
                `;
                todoListElement.insertAdjacentHTML('beforeend', taskElement);
            });
        } else {
            todoListElement.innerHTML = `<p>Wah, Tidak ada tugas yang tersisa!</p>`;
        }
    })
    .catch(error => {
        console.error('Terjadi kesalahan saat mengambil data tugas:', error);
        todoListElement.innerHTML = `<p>Gagal memuat tugas. Coba lagi nanti.</p>`;
    });
}

// ===================== TOGGLE TASK COMPLETE =====================
todoListElement.addEventListener('click', (e) => {
    const checkbox = e.target.closest('.task-checkbox');

    if (checkbox) {
        const taskId = checkbox.getAttribute('data-id');

        // Toggle UI
        const pathElement = checkbox.querySelector('.checkmark');

        if (pathElement.style.opacity === "1") {
            pathElement.style.opacity = "0";
        } else {
            pathElement.style.opacity = "1";
        }

        // Kirim request ke server
        axios.post(`/api/tugas/${taskId}/toggle-complete`, {}, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            }
        })
        .then(response => {
            console.log(`Tugas dengan ID ${taskId} berhasil di-update.`);
            
            // Menghapus elemen dari daftar karena sudah "Complete"
            if (response.data.success) {
                const taskItem = checkbox.closest('.task-item');
                taskItem.remove();
                
                // 🚀 Cek jika sudah kosong, tampilkan pesan
                if (todoListElement.children.length === 0) {
                    todoListElement.innerHTML = `<p>Wah, Tidak ada tugas yang tersisa!</p>`;
                }
            }
        })
        .catch(error => {
            console.error('Gagal memperbarui status tugas:', error);
            alert('Terjadi kesalahan saat memperbarui tugas.');
        });
    }
});

// ============================================================================

// ===================== FORMAT DATETIME =====================
function formatDatetime(datetime) {
    if (!datetime) return null;
    const date = new Date(datetime);
    if (isNaN(date.getTime())) {
        console.error("Invalid datetime value:", datetime);
        return null;
    }
    return date.toISOString().slice(0, 19).replace('T', ' ');
}

// ===================== AMBIL KATEGORI DARI API =====================
const categoryButtonsContainer = document.getElementById('category-buttons-container');
const categorySelect = document.getElementById('category-select');

axios.get('/api/kategori', {
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
    }
}).then(response => {
    const { data } = response;
    if (data.success && data.data.length > 0) {
        categoryButtonsContainer.innerHTML = '';
        categorySelect.innerHTML = '';

        // Inject ke dalam tombol (max 3 tombol, sisanya ke dropdown)
        data.data.slice(0, 3).forEach((item, index) => {
            const categoryButton = document.createElement('button');
            categoryButton.classList.add('category-btn');
            categoryButton.dataset.id = item.id; // Simpan ID kategori di dataset
            if (index === 0) categoryButton.classList.add('active');
            categoryButton.textContent = item.nama_kategori;
        
            // Event Listener untuk toggle aktif
            categoryButton.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
                categoryButton.classList.add('active');
            });
        
            categoryButtonsContainer.appendChild(categoryButton);
        });

        // Inject ke dalam dropdown
        data.data.slice(3).forEach((item) => {
            const categoryOption = document.createElement('option');
            categoryOption.value = item.id;
            categoryOption.textContent = item.nama_kategori;
            categorySelect.appendChild(categoryOption);
        });
    }
}).catch(error => {
    console.error('Terjadi kesalahan saat mengambil data kategori:', error);
});

// Inisialisasi Notyf
const notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'center',
        y: 'top',
    },
    dismissible: true
});

// ===================== SUBMIT TUGAS =====================
const addTaskButton = document.getElementById('add-category-btn');
addTaskButton.addEventListener('click', () => {
    const title = document.querySelector('.task-input').value;
    const description = document.querySelector('.task-desc-input').value || "Tidak ada deskripsi";
    const startTime = document.getElementById('start-time').value;
    const endTime = document.getElementById('end-time').value;
    let categoryId = document.querySelector('.category-btn.active')?.dataset.id || categorySelect.value;

    if (!title || !startTime || !categoryId) {
        notyf.error('Harap lengkapi data tugas!');
        return;
    }

    axios.post('/api/tugas', {
        kategori_id: categoryId,
        judul: title,
        deskripsi: description,
        waktu_mulai: formatDatetime(startTime),
        waktu_selesai: formatDatetime(endTime),
        is_completed: false,
        completed_at: null
    }, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    })
    .then(response => {
        if (response.data.success) {
            notyf.success('Tugas berhasil ditambahkan!');

            document.querySelector('.task-input').value = '';
            document.querySelector('.task-desc-input').value = '';
            document.getElementById('start-time').value = '';
            document.getElementById('end-time').value = '';
            fetchCategories();
            fetchTasks();
        }
    })
    .catch(error => {
        console.error('Gagal menambah tugas:', error);
        notyf.error(error.response && error.response.data ? error.response.data.message : 'Terjadi kesalahan saat menambah tugas.');
    });
});

window.onload = fetchTasks;

// ===================== POMODORO TIMER =====================
const WORK_DURATION = 25 * 60; // 25 menit
const BREAK_DURATION = 5 * 60; // 5 menit
let remainingTime = WORK_DURATION;
let isRunning = false;
let isBreak = false;
let timerInterval = null;

const display = document.getElementById('timer-display');
const toggleBtn = document.getElementById('toggle-btn');
const toggleIcon = document.getElementById('icon-toggle');
const restartBtn = document.getElementById('restart-btn');

function formatTime(seconds) {
    const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
    const secs = String(seconds % 60).padStart(2, '0');
    return `${mins}:${secs}`;
}

function updateDisplay() {
    display.textContent = formatTime(remainingTime);
}

function setPlayIcon() {
    toggleIcon.innerHTML = `<polygon points="5 3 19 12 5 21 5 3" />`;
}

function setPauseIcon() {
    toggleIcon.innerHTML = `
        <rect x="6" y="4" width="4" height="16" />
        <rect x="14" y="4" width="4" height="16" />
    `;
}

function startTimer() {
    isRunning = true;
    setPauseIcon();
    timerInterval = setInterval(() => {
        if (remainingTime > 0) {
            remainingTime--;
            updateDisplay();
        } else {
            clearInterval(timerInterval);
            isRunning = false;
            if (!isBreak) {
                alert("Waktu belajar selesai! Saatnya istirahat.");
                isBreak = true;
                remainingTime = BREAK_DURATION;
            } else {
                alert("Waktu istirahat selesai! Kembali fokus yuk!");
                isBreak = false;
                remainingTime = WORK_DURATION;
            }
            updateDisplay();
            setPlayIcon();
        }
    }, 1000);
}

function toggleTimer() {
    isRunning ? clearInterval(timerInterval) : startTimer();
    isRunning = !isRunning;
    isRunning ? setPauseIcon() : setPlayIcon();
}

function restartTimer() {
    clearInterval(timerInterval);
    isRunning = false;
    isBreak = false;
    remainingTime = WORK_DURATION;
    updateDisplay();
    setPlayIcon();
}

toggleBtn.addEventListener('click', toggleTimer);
restartBtn.addEventListener('click', restartTimer);

updateDisplay();