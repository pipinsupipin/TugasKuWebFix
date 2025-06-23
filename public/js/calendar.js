let currentDate = new Date();
const calendarTitle = document.getElementById('calendar-title');
const calendarGrid = document.getElementById('calendar-grid');
const tasksList = document.getElementById('tasks-list');

let tasksData = [];

// ===================== FETCH SEMUA TUGAS SEKALI SAJA =====================
function fetchAllTasks() {
    axios.get('/api/tugas', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            
        }
    })
    .then(response => {
        tasksData = response.data.data;
        renderCalendar();
    })
    .catch(error => {
        console.error('Terjadi kesalahan saat mengambil data tugas:', error);
    });
}

// ===================== RENDER KALENDER =====================
function renderCalendar() {
    calendarGrid.innerHTML = '';

    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    calendarTitle.textContent = `${firstDay.toLocaleString('id-ID', { month: 'long' })} ${firstDay.getFullYear()}`;

    // Render Header Hari
    const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    days.forEach(day => {
        calendarGrid.innerHTML += `<div class="calendar-day-header">${day}</div>`;
    });

    // Kosongkan kalender dan buat grid
    for (let i = 0; i < firstDay.getDay(); i++) {
        calendarGrid.innerHTML += `<div></div>`;
    }

    for (let day = 1; day <= lastDay.getDate(); day++) {
        const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
        const formattedDate = date.toISOString().split('T')[0];

        // Cek jika ada tugas pada tanggal ini
        const hasTasks = tasksData.some(task => task.waktu_mulai.startsWith(formattedDate));
        const dot = hasTasks ? `<div class="task-dot"></div>` : '';

        calendarGrid.innerHTML += `
            <div class="calendar-day" onclick="selectDate('${date.toISOString()}')" id="day-${formattedDate}">
                <span class="day-number">${day}</span>
                ${dot}
            </div>
        `;
    }
}

// ===================== PILIH TANGGAL =====================
function selectDate(dateString) {
    const date = new Date(dateString);
    const formattedDate = date.toISOString().split('T')[0];

    // Highlight active date
    document.querySelectorAll('.calendar-day').forEach(day => day.classList.remove('active'));
    document.getElementById(`day-${formattedDate}`).classList.add('active');

    // Set header dengan format yang benar
    const fullDate = date.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    document.getElementById('selected-date').textContent = `${fullDate}`;
    
    // Fetch tasks for the selected date
    fetchTasksByDate(formattedDate);
}

// ===================== FETCH TUGAS PER TANGGAL =====================
function fetchTasksByDate(date) {
    tasksList.innerHTML = '';

    // Filter tugas yang sesuai dengan tanggal yang dipilih
    const filteredTasks = tasksData.filter(task => {
        const taskDate = task.waktu_mulai.split('T')[0];
        return taskDate === date;
    });

    if (filteredTasks.length > 0) {
        filteredTasks.forEach(task => {
            const waktuMulai = new Date(task.waktu_mulai).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const waktuSelesai = task.waktu_selesai 
                ? new Date(task.waktu_selesai).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) 
                : '-';

            const waktuDitampilkan = (waktuMulai !== '-' && waktuSelesai !== '-') 
                ? `${waktuMulai} - ${waktuSelesai}` 
                : (waktuMulai !== '-' ? waktuMulai : waktuSelesai !== '-' ? waktuSelesai : 'Waktu tidak tersedia');
        
            const taskElement = `
                <div class="task-item ${task.is_completed ? 'completed' : ''}">
                    <div class="task-checkbox" data-id="${task.id}">
                    <div class="checkmark" style="opacity: ${task.is_completed ? '1' : '0'}"></div>
                    </div>
                    <div class="task-content">
                        <h4 class="task-title">${task.judul}</h4>
                        <p class="task-time">${waktuDitampilkan}</p>
                    </div>
                </div>`;
            
            tasksList.insertAdjacentHTML('beforeend', taskElement);
        });
    } else {
        tasksList.innerHTML = `<p>Tidak ada tugas di tanggal ini.</p>`;
    }
}

// ===================== CENTANG =====================
tasksList.addEventListener('click', (e) => {
    const checkbox = e.target.closest('.task-checkbox');

    if (checkbox) {
        const taskId = checkbox.getAttribute('data-id');
        const pathElement = checkbox.querySelector('.checkmark');

        // Toggle UI
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
            
            // 🚀 Jika status berubah ke completed, tambahkan class completed
            if (response.data.success) {
                const taskItem = checkbox.closest('.task-item');
                taskItem.classList.toggle('completed');
                
                // Jika ingin menghapus elemen secara langsung setelah complete, aktifkan kode di bawah ini
                // taskItem.remove();
                
                if (tasksList.children.length === 0) {
                    tasksList.innerHTML = `<p>Wah, Tidak ada tugas yang tersisa!</p>`;
                }
            }
        })
        .catch(error => {
            console.error('Gagal memperbarui status tugas:', error);
            alert('Terjadi kesalahan saat memperbarui tugas.');
        });
    }
});

// ===================== NAVIGASI BULAN =====================
document.getElementById('prev-month').onclick = () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
};

document.getElementById('next-month').onclick = () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
};

document.getElementById('today').onclick = () => {
    currentDate = new Date();
    renderCalendar();
};

// Panggil pertama kali
fetchAllTasks();