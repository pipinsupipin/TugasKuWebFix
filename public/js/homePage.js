// ===================== Axios Setup =====================
axios.defaults.withCredentials = true;
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;

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

// ===================== ENHANCED STREAK INFO =====================
class StreakManager {
    constructor() {
        this.currentStreak = 0;
        this.isLoading = true;
        this.animationInProgress = false;
        
        // DOM Elements
        this.elements = {
            streakCount: document.getElementById('streak-count'),
            streakText: document.getElementById('streak-text'),
            streakTitle: document.getElementById('streak-title'),
            streakIcon: document.getElementById('streak-icon'),
            streakContent: document.querySelector('.streak-content'),
            streakGlow: document.getElementById('streak-glow'),
            streakSparkles: document.getElementById('streak-sparkles'),
            streakLoading: document.getElementById('streak-loading')
        };
        
        this.init();
    }
    
    async init() {
        try {
            this.showLoading();
            await this.fetchStreakData();
            this.hideLoading();
        } catch (error) {
            console.error('Error initializing streak:', error);
            this.hideLoading();
        }
    }
    
    showLoading() {
        if (this.elements.streakLoading) {
            this.elements.streakLoading.classList.remove('hidden');
        }
    }
    
    hideLoading() {
        if (this.elements.streakLoading) {
            this.elements.streakLoading.classList.add('hidden');
        }
    }
    
    async fetchStreakData() {
        try {
            const response = await axios.get('/api/streaks/summary', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            
            const { current_streak } = response.data.data;
            await this.updateStreak(current_streak); // BUAT TES STREAK DISINI
            
        } catch (error) {
            console.error('Terjadi kesalahan saat mengambil data streak:', error);
            // Set default values on error
            await this.updateStreak(0);
        }
    }
    
    async updateStreak(newStreak) {
        this.currentStreak = newStreak;
        
        // Update all streak elements
        this.updateStreakTitle();
        this.updateStreakIcon();
        this.updateStreakTheme();
        await this.animateStreakCount();
        this.setupVisualEffects();
        
        // Start animations
        this.startAnimations();
    }
    
    updateStreakTitle() {
        const title = this.getStreakTitle();
        if (this.elements.streakTitle) {
            this.elements.streakTitle.textContent = title;
            this.elements.streakTitle.style.animation = 'count-up 0.6s ease-out';
        }
    }
    
    updateStreakIcon() {
        if (!this.elements.streakIcon) return;
        
        if (this.currentStreak < 3) {
            this.elements.streakIcon.src = '/img/streak-locked.png';
            this.elements.streakIcon.classList.add('low-streak');
            this.elements.streakContent.classList.add('low-streak');
        } else {
            this.elements.streakIcon.src = '/img/flame-icon.png';
            this.elements.streakIcon.classList.remove('low-streak');
            this.elements.streakContent.classList.remove('low-streak');
        }
    }
    
    updateStreakTheme() {
        if (!this.elements.streakContent) return;
        
        // Remove all existing themes
        const themes = ['grey', 'orange', 'blue', 'purple', 'red', 'amber', 'pink'];
        themes.forEach(theme => {
            this.elements.streakContent.classList.remove(`streak-theme-${theme}`);
        });
        
        // Add new theme
        const currentTheme = this.getStreakTheme();
        this.elements.streakContent.classList.add(`streak-theme-${currentTheme}`);
        this.elements.streakContent.setAttribute('data-theme', currentTheme);
    }
    
    async animateStreakCount() {
        if (!this.elements.streakCount) return;
        
        return new Promise((resolve) => {
            let currentCount = 0;
            const targetCount = this.currentStreak;
            const duration = 1000; // 1 second
            const steps = Math.min(targetCount, 50); // Max 50 steps for smooth animation
            const increment = targetCount / steps;
            const stepDuration = duration / steps;
            
            const updateCount = () => {
                currentCount += increment;
                const displayCount = Math.floor(currentCount);
                
                if (displayCount >= targetCount) {
                    this.elements.streakCount.textContent = targetCount;
                    this.elements.streakCount.style.animation = 'count-up 0.3s ease-out';
                    resolve();
                } else {
                    this.elements.streakCount.textContent = displayCount;
                    setTimeout(updateCount, stepDuration);
                }
            };
            
            updateCount();
        });
    }
    
    setupVisualEffects() {
        // Setup glow effect for streaks >= 3
        if (this.currentStreak >= 3 && this.elements.streakGlow) {
            this.elements.streakGlow.classList.add('active');
        } else if (this.elements.streakGlow) {
            this.elements.streakGlow.classList.remove('active');
        }
        
        // Setup sparkles for streaks >= 3
        if (this.currentStreak >= 3) {
            this.createSparkles();
        } else {
            this.clearSparkles();
        }
    }
    
    createSparkles() {
        if (!this.elements.streakSparkles) return;
        
        // Clear existing sparkles
        this.clearSparkles();
        
        const sparkleCount = Math.min(this.currentStreak, 12); // Max 12 sparkles
        
        for (let i = 0; i < sparkleCount; i++) {
            const sparkle = document.createElement('div');
            sparkle.className = Math.random() > 0.5 ? 'sparkle star' : 'sparkle';
            
            // Position sparkles in a circle
            const angle = (i * 360 / sparkleCount) + Math.random() * 30;
            const radius = 45 + Math.random() * 10; // 45-55% from center
            const x = 50 + radius * Math.cos(angle * Math.PI / 180);
            const y = 50 + radius * Math.sin(angle * Math.PI / 180);
            
            sparkle.style.left = `${x}%`;
            sparkle.style.top = `${y}%`;
            sparkle.style.animationDelay = `${i * 0.2}s`;
            
            this.elements.streakSparkles.appendChild(sparkle);
        }
    }
    
    clearSparkles() {
        if (this.elements.streakSparkles) {
            this.elements.streakSparkles.innerHTML = '';
        }
    }
    
    startAnimations() {
        // Pulse animation for icon
        if (this.elements.streakIcon) {
            this.elements.streakIcon.classList.add('pulse');
            setTimeout(() => {
                this.elements.streakIcon.classList.remove('pulse');
            }, 800);
        }
        
        // Additional entrance animations
        setTimeout(() => {
            if (this.elements.streakContent) {
                this.elements.streakContent.style.animation = 'count-up 0.8s ease-out';
            }
        }, 200);
    }
    
    getStreakTitle() {
        if (this.currentStreak < 3) return 'Perintis Petualangan!';
        if (this.currentStreak < 7) return 'Pejuang Muda';
        if (this.currentStreak < 14) return 'Ninja Produktif';
        if (this.currentStreak < 30) return 'Raja Konsistensi';
        if (this.currentStreak < 50) return 'Master Disiplin';
        if (this.currentStreak < 100) return 'Legenda Hidup';
        return 'Dewa Produktivitas';
    }
    
    getStreakTheme() {
        if (this.currentStreak < 3) return 'grey';
        if (this.currentStreak < 7) return 'orange';
        if (this.currentStreak < 14) return 'blue';
        if (this.currentStreak < 30) return 'purple';
        if (this.currentStreak < 50) return 'red';
        if (this.currentStreak < 100) return 'amber';
        return 'pink';
    }
    
    // Public method to refresh streak data
    async refresh() {
        if (this.animationInProgress) return;
        
        this.animationInProgress = true;
        this.showLoading();
        
        try {
            await this.fetchStreakData();
        } catch (error) {
            console.error('Error refreshing streak:', error);
        } finally {
            this.hideLoading();
            this.animationInProgress = false;
        }
    }
    
    // Get current streak value
    getCurrentStreak() {
        return this.currentStreak;
    }
}

// ===================== ENHANCED TASK FORM MANAGER =====================
class TaskFormManager {
    constructor() {
        this.selectedCategoryId = null;
        this.isSubmitting = false;
        
        // DOM Elements
        this.elements = {
            taskTitle: document.getElementById('task-title'),
            startTime: document.getElementById('start-time'),
            endTime: document.getElementById('end-time'),
            taskDescription: document.getElementById('task-description'),
            categoryContainer: document.getElementById('category-buttons-container'),
            categorySelect: document.getElementById('category-select'),
            addTaskBtn: document.getElementById('add-category-btn'),
            timeHint: document.getElementById('time-hint'),
            formErrors: document.getElementById('form-errors'),
            errorMessage: document.getElementById('error-message'),
            btnContent: document.querySelector('.btn-content'),
            btnLoading: document.getElementById('btn-loading')
        };
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.setMinDateTime();
    }
    
    setupEventListeners() {
        // Time inputs
        if (this.elements.startTime) {
            this.elements.startTime.addEventListener('change', () => {
                this.handleStartTimeChange();
            });
        }
        
        // Category selection - use event delegation for dynamic elements
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('category-btn')) {
                this.selectCategory(e.target.dataset.id, 'chip');
            }
        });
        
        if (this.elements.categorySelect) {
            this.elements.categorySelect.addEventListener('change', () => {
                this.handleDropdownCategorySelect();
            });
        }
        
        // Submit button
        if (this.elements.addTaskBtn) {
            this.elements.addTaskBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleSubmit();
            });
        }
        
        // Hide errors when user starts typing
        if (this.elements.taskTitle) {
            this.elements.taskTitle.addEventListener('input', () => {
                this.hideErrors();
            });
        }
    }
    
    setMinDateTime() {
        // Set minimum datetime to current time
        const now = new Date();
        const minDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
            .toISOString()
            .slice(0, 16);
        
        if (this.elements.startTime) {
            this.elements.startTime.min = minDateTime;
        }
    }
    
    handleStartTimeChange() {
        const startTimeValue = this.elements.startTime.value;
        
        if (startTimeValue) {
            // Enable end time input
            if (this.elements.endTime) {
                this.elements.endTime.disabled = false;
                this.elements.endTime.classList.remove('disabled');
                
                // Set minimum end time to start time
                this.elements.endTime.min = startTimeValue;
                
                // Clear any existing end time if it's before start time
                if (this.elements.endTime.value && this.elements.endTime.value <= startTimeValue) {
                    this.elements.endTime.value = '';
                }
            }
            
            // Hide hint with smooth transition
            if (this.elements.timeHint) {
                this.elements.timeHint.classList.add('hidden');
            }
        } else {
            // Disable end time input
            if (this.elements.endTime) {
                this.elements.endTime.disabled = true;
                this.elements.endTime.classList.add('disabled');
                this.elements.endTime.value = '';
            }
            
            // Show hint
            if (this.elements.timeHint) {
                this.elements.timeHint.classList.remove('hidden');
            }
        }
        
        this.hideErrors();
    }
    
    selectCategory(categoryId, source = 'chip') {
        // Clear all selections first
        this.clearCategorySelections();
        
        this.selectedCategoryId = categoryId;
        
        if (source === 'chip') {
            // Highlight the selected chip
            const selectedChip = this.elements.categoryContainer.querySelector(`[data-id="${categoryId}"]`);
            if (selectedChip) {
                selectedChip.classList.add('active');
            }
            
            // Clear dropdown selection
            if (this.elements.categorySelect) {
                this.elements.categorySelect.value = '';
            }
        } else if (source === 'dropdown') {
            // Clear all chip selections
            const allChips = this.elements.categoryContainer.querySelectorAll('.category-btn');
            allChips.forEach(chip => chip.classList.remove('active'));
            
            // Set dropdown value
            if (this.elements.categorySelect) {
                this.elements.categorySelect.value = categoryId;
            }
        }
        
        this.hideErrors();
    }
    
    handleDropdownCategorySelect() {
        const selectedValue = this.elements.categorySelect.value;
        if (selectedValue) {
            this.selectCategory(selectedValue, 'dropdown');
        } else {
            this.clearCategorySelections();
        }
    }
    
    clearCategorySelections() {
        // Clear chip selections
        const allChips = this.elements.categoryContainer.querySelectorAll('.category-btn');
        allChips.forEach(chip => chip.classList.remove('active'));
        
        // Clear dropdown selection
        if (this.elements.categorySelect) {
            this.elements.categorySelect.value = '';
        }
        
        this.selectedCategoryId = null;
    }
    
    // Validation (only on submit)
    validateForm() {
        const errors = [];
        
        // Validate title
        const title = this.elements.taskTitle ? this.elements.taskTitle.value.trim() : '';
        if (!title) {
            errors.push('Judul tugas harus diisi');
            if (this.elements.taskTitle) this.elements.taskTitle.classList.add('error');
        } else if (title.length < 3) {
            errors.push('Judul tugas minimal 3 karakter');
            if (this.elements.taskTitle) this.elements.taskTitle.classList.add('error');
        } else {
            if (this.elements.taskTitle) this.elements.taskTitle.classList.remove('error');
        }
        
        // Validate start time
        const startTime = this.elements.startTime ? this.elements.startTime.value : '';
        if (!startTime) {
            errors.push('Waktu mulai harus diisi');
            if (this.elements.startTime) this.elements.startTime.classList.add('error');
        } else {
            const now = new Date();
            const startDateTime = new Date(startTime);
            
            if (startDateTime < now) {
                errors.push('Waktu mulai tidak boleh di masa lalu');
                if (this.elements.startTime) this.elements.startTime.classList.add('error');
            } else {
                if (this.elements.startTime) this.elements.startTime.classList.remove('error');
            }
        }
        
        // Validate end time (if filled)
        const endTime = this.elements.endTime ? this.elements.endTime.value : '';
        if (endTime && startTime) {
            const startDateTime = new Date(startTime);
            const endDateTime = new Date(endTime);
            
            if (endDateTime <= startDateTime) {
                errors.push('Waktu selesai harus setelah waktu mulai');
                if (this.elements.endTime) this.elements.endTime.classList.add('error');
            } else {
                if (this.elements.endTime) this.elements.endTime.classList.remove('error');
            }
        }
        
        // Validate category
        if (!this.selectedCategoryId) {
            errors.push('Pilih kategori tugas');
            if (this.elements.categorySelect) this.elements.categorySelect.classList.add('error');
        } else {
            if (this.elements.categorySelect) this.elements.categorySelect.classList.remove('error');
        }
        
        return errors;
    }
    
    showErrors(errors) {
        if (errors.length > 0 && this.elements.formErrors && this.elements.errorMessage) {
            this.elements.errorMessage.textContent = errors[0]; // Show first error
            this.elements.formErrors.style.display = 'block';
            
            // Add shake animation
            this.elements.formErrors.classList.add('shake');
            setTimeout(() => {
                this.elements.formErrors.classList.remove('shake');
            }, 500);
        }
    }
    
    hideErrors() {
        if (this.elements.formErrors) {
            this.elements.formErrors.style.display = 'none';
        }
        
        // Remove error classes
        if (this.elements.taskTitle) this.elements.taskTitle.classList.remove('error');
        if (this.elements.startTime) this.elements.startTime.classList.remove('error');
        if (this.elements.endTime) this.elements.endTime.classList.remove('error');
        if (this.elements.categorySelect) this.elements.categorySelect.classList.remove('error');
    }
    
    showLoadingState() {
        if (this.elements.addTaskBtn) {
            this.elements.addTaskBtn.classList.add('loading');
            this.elements.addTaskBtn.style.pointerEvents = 'none';
        }
        if (this.elements.btnLoading) {
            this.elements.btnLoading.style.display = 'flex';
        }
    }
    
    hideLoadingState() {
        if (this.elements.addTaskBtn) {
            this.elements.addTaskBtn.classList.remove('loading');
            this.elements.addTaskBtn.style.pointerEvents = 'auto';
        }
        if (this.elements.btnLoading) {
            this.elements.btnLoading.style.display = 'none';
        }
    }
    
    // Submit Handler (using existing logic)
    async handleSubmit() {
        if (this.isSubmitting) return;
        
        this.hideErrors();
        
        // Validate form
        const errors = this.validateForm();
        if (errors.length > 0) {
            this.showErrors(errors);
            if (typeof notyf !== 'undefined') {
                notyf.error(errors[0]);
            }
            return;
        }
        
        this.isSubmitting = true;
        this.showLoadingState();
        
        try {
            const taskData = {
                kategori_id: this.selectedCategoryId,
                judul: this.elements.taskTitle.value.trim(),
                deskripsi: this.elements.taskDescription ? this.elements.taskDescription.value.trim() || "Tidak ada deskripsi" : "Tidak ada deskripsi",
                waktu_mulai: formatDatetime(this.elements.startTime.value),
                waktu_selesai: this.elements.endTime && this.elements.endTime.value ? 
                    formatDatetime(this.elements.endTime.value) : null,
                is_completed: false,
                completed_at: null
            };
            
            const response = await axios.post('/api/tugas', taskData, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            
            if (response.data.success) {
                // Use existing notyf if available
                if (typeof notyf !== 'undefined') {
                    notyf.success('✅ Tugas berhasil ditambahkan!');
                }
                
                this.resetForm();
                
                // Refresh data using existing functions
                if (typeof fetchTasks === 'function') fetchTasks();
                if (typeof fetchCategories === 'function') fetchCategories();
                if (typeof window.streakManager !== 'undefined') {
                    window.streakManager.refresh();
                }
            }
            
        } catch (error) {
            console.error('Gagal menambah tugas:', error);
            const errorMessage = error.response?.data?.message || 
                'Terjadi kesalahan saat menambah tugas.';
            
            if (typeof notyf !== 'undefined') {
                notyf.error(`❌ ${errorMessage}`);
            } else {
                this.showErrors([errorMessage]);
            }
        } finally {
            this.isSubmitting = false;
            this.hideLoadingState();
        }
    }
    
    resetForm() {
        // Clear all inputs
        if (this.elements.taskTitle) this.elements.taskTitle.value = '';
        if (this.elements.taskDescription) this.elements.taskDescription.value = '';
        if (this.elements.startTime) this.elements.startTime.value = '';
        if (this.elements.endTime) this.elements.endTime.value = '';
        
        // Reset category selection
        this.clearCategorySelections();
        
        // Reset states
        if (this.elements.endTime) {
            this.elements.endTime.disabled = true;
            this.elements.endTime.classList.add('disabled');
        }
        if (this.elements.timeHint) {
            this.elements.timeHint.classList.remove('hidden');
        }
        
        // Clear errors
        this.hideErrors();
    }
    
    // Public method to refresh categories
    refresh() {
        if (typeof fetchCategories === 'function') {
            fetchCategories();
        }
    }
}

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
                
                // Refresh streak when task completed
                if (typeof window.streakManager !== 'undefined') {
                    window.streakManager.refresh();
                }
            }
        })
        .catch(error => {
            console.error('Gagal memperbarui status tugas:', error);
            alert('Terjadi kesalahan saat memperbarui tugas.');
            
            // Revert UI on error
            pathElement.style.opacity = pathElement.style.opacity === "1" ? "0" : "1";
        });
    }
});

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

// Enhanced category rendering that works with TaskFormManager
function renderCategoryButtons() {
    axios.get('/api/kategori', {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        }
    }).then(response => {
        const { data } = response;
        if (data.success && data.data.length > 0) {
            if (categoryButtonsContainer) {
                categoryButtonsContainer.innerHTML = '';
            }
            if (categorySelect) {
                categorySelect.innerHTML = '<option value="">Lainnya</option>';
            }

            // Inject ke dalam tombol (max 3 tombol, sisanya ke dropdown)
            data.data.slice(0, 3).forEach((item, index) => {
                const categoryButton = document.createElement('button');
                categoryButton.classList.add('category-btn');
                categoryButton.dataset.id = item.id; // Simpan ID kategori di dataset
                if (index === 0) categoryButton.classList.add('active');
                categoryButton.textContent = item.nama_kategori;
            
                // Event handled by TaskFormManager via event delegation
                if (categoryButtonsContainer) {
                    categoryButtonsContainer.appendChild(categoryButton);
                }
            });

            // Inject ke dalam dropdown (sisanya setelah 3 pertama)
            if (data.data.length > 3) {
                data.data.slice(3).forEach((item) => {
                    const categoryOption = document.createElement('option');
                    categoryOption.value = item.id;
                    categoryOption.textContent = item.nama_kategori;
                    if (categorySelect) {
                        categorySelect.appendChild(categoryOption);
                    }
                });
                
                // Show dropdown if there are overflow categories
                if (categorySelect && categorySelect.parentElement) {
                    categorySelect.parentElement.style.display = 'block';
                }
            } else {
                // Hide dropdown if all categories fit in chips
                if (categorySelect && categorySelect.parentElement) {
                    categorySelect.parentElement.style.display = 'none';
                }
            }
            
            // Set first category as selected by default if TaskFormManager exists
            if (window.taskFormManager && data.data.length > 0) {
                window.taskFormManager.selectedCategoryId = data.data[0].id;
            }
        }
    }).catch(error => {
        console.error('Terjadi kesalahan saat mengambil data kategori:', error);
    });
}

// Update the original fetchCategories to use new rendering
function renderCategoryList(categories) {
    if (categoryButtonsContainer) {
        categoryButtonsContainer.innerHTML = '';
    }
    if (categorySelect) {
        categorySelect.innerHTML = '<option value="">Pilih kategori lainnya...</option>';
    }

    if (categories && categories.length > 0) {
        // Inject ke dalam tombol (max 3 tombol, sisanya ke dropdown)
        categories.slice(0, 3).forEach((item, index) => {
            const categoryButton = document.createElement('button');
            categoryButton.classList.add('category-btn');
            categoryButton.dataset.id = item.id;
            if (index === 0) categoryButton.classList.add('active');
            categoryButton.textContent = item.nama_kategori;
        
            if (categoryButtonsContainer) {
                categoryButtonsContainer.appendChild(categoryButton);
            }
        });

        // Inject ke dalam dropdown (sisanya setelah 3 pertama)
        if (categories.length > 3) {
            categories.slice(3).forEach((item) => {
                const categoryOption = document.createElement('option');
                categoryOption.value = item.id;
                categoryOption.textContent = item.nama_kategori;
                if (categorySelect) {
                    categorySelect.appendChild(categoryOption);
                }
            });
            
            // Show dropdown if there are overflow categories
            if (categorySelect && categorySelect.parentElement) {
                categorySelect.parentElement.style.display = 'block';
            }
        } else {
            // Hide dropdown if all categories fit in chips
            if (categorySelect && categorySelect.parentElement) {
                categorySelect.parentElement.style.display = 'none';
            }
        }
        
        // Set first category as selected by default if TaskFormManager exists
        if (window.taskFormManager && categories.length > 0) {
            window.taskFormManager.selectedCategoryId = categories[0].id;
        }
    }
}

// Call initial category rendering
renderCategoryButtons();

// Inisialisasi Notyf
const notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'center',
        y: 'top',
    },
    dismissible: true
});

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
    if (display) {
        display.textContent = formatTime(remainingTime);
    }
}

function setPlayIcon() {
    if (toggleIcon) {
        toggleIcon.innerHTML = `<polygon points="5 3 19 12 5 21 5 3" />`;
    }
}

function setPauseIcon() {
    if (toggleIcon) {
        toggleIcon.innerHTML = `
            <rect x="6" y="4" width="4" height="16" />
            <rect x="14" y="4" width="4" height="16" />
        `;
    }
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
    if (isRunning) {
        clearInterval(timerInterval);
        isRunning = false;
        setPlayIcon();
    } else {
        startTimer();
    }
}

function restartTimer() {
    clearInterval(timerInterval);
    isRunning = false;
    isBreak = false;
    remainingTime = WORK_DURATION;
    updateDisplay();
    setPlayIcon();
}

// Add event listeners if elements exist
if (toggleBtn) {
    toggleBtn.addEventListener('click', toggleTimer);
}
if (restartBtn) {
    restartBtn.addEventListener('click', restartTimer);
}

// Initialize timer display
updateDisplay();

// ===================== INITIALIZATION =====================
// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize streak manager
    window.streakManager = new StreakManager();
    
    // Initialize task form manager  
    window.taskFormManager = new TaskFormManager();
    
    // Initial data fetch
    fetchTasks();
    
    // Ensure categories are loaded
    renderCategoryButtons();
});

// Expose global functions for compatibility
window.refreshStreak = () => {
    if (window.streakManager) {
        window.streakManager.refresh();
    }
};

window.refreshTaskForm = () => {
    if (window.taskFormManager) {
        window.taskFormManager.refresh();
    }
};

// Legacy window.onload compatibility
window.onload = () => {
    fetchTasks();
    renderCategoryButtons();
};
