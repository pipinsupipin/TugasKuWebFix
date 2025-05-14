
document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");

    menuItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua menu item
            menuItems.forEach((menu) => menu.classList.remove("active"));

            // Tambahkan class 'active' ke menu yang diklik
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll(".categoryL");

    categoryItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua kategori
            categoryItems.forEach((category) =>
                category.classList.remove("active")
            );

            // Tambahkan class 'active' ke kategori yang diklik
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll(".categoryL");

    categoryItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua kategori
            categoryItems.forEach((category) =>
                category.classList.remove("active")
            );

            // Tambahkan class 'active' ke kategori yang diklik
            this.classList.add("active");
        });
    });
});

document.querySelectorAll(".box-list").forEach((item) => {
    item.addEventListener("click", () => {
        item.classList.toggle("strike");
    });
});

  // Timer configuration
        const config = {
            work: 25 * 60,      // 25 minutes
            shortBreak: 5 * 60, // 5 minutes
            longBreak: 15 * 60  // 15 minutes
        };

        // DOM Elements
        const timerDisplay = document.getElementById('timer');
        const startPauseBtn = document.getElementById('startPauseBtn');
        const resetBtn = document.getElementById('resetBtn');
        const cycleInfo = document.getElementById('cycleInfo');
        const modeButtons = document.querySelectorAll('.mode-button');

        // Timer variables
        let timeRemaining = config.work;
        let intervalId = null;
        let isRunning = false;
        let currentMode = 'work';
        let completedCycles = 0;

        // Format time to MM:SS
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
        }

        // Update timer display
        function updateDisplay() {
            timerDisplay.textContent = formatTime(timeRemaining);
        }

        // Start/Pause timer
        function toggleTimer() {
            if (isRunning) {
                // Pause timer
                clearInterval(intervalId);
                startPauseBtn.textContent = 'Start';
                isRunning = false;
            } else {
                // Start timer
                startPauseBtn.textContent = 'Pause';
                intervalId = setInterval(updateTimer, 1000);
                isRunning = true;
            }
        }

        // Update timer logic
        function updateTimer() {
            if (timeRemaining > 0) {
                timeRemaining--;
                updateDisplay();
            } else {
                // Timer finished, switch modes
                switchMode();
            }
        }

        // Switch between modes
        function switchMode() {
            // Stop current timer
            clearInterval(intervalId);
            isRunning = false;
            startPauseBtn.textContent = 'Start';

            // Determine next mode
            switch (currentMode) {
                case 'work':
                    completedCycles++;
                    cycleInfo.textContent = `Pomodoro Cycle: ${completedCycles}`;
                    
                    // Alternate between short and long breaks
                    if (completedCycles % 4 === 0) {
                        currentMode = 'longBreak';
                        timeRemaining = config.longBreak;
                        updateModeButtons('longBreak');
                    } else {
                        currentMode = 'shortBreak';
                        timeRemaining = config.shortBreak;
                        updateModeButtons('shortBreak');
                    }
                    break;
                case 'shortBreak':
                case 'longBreak':
                    currentMode = 'work';
                    timeRemaining = config.work;
                    updateModeButtons('work');
                    break;
            }

            // Update display
            updateDisplay();

            // Play sound or show notification
            const audio = new Audio('https://www.soundjay.com/button/beep-07.wav');
            audio.play();
        }

        // Reset timer
        function resetTimer() {
            // Stop timer if running
            clearInterval(intervalId);
            isRunning = false;
            
            // Reset to work mode
            currentMode = 'work';
            timeRemaining = config.work;
            
            // Reset display
            updateDisplay();
            startPauseBtn.textContent = 'Start';
            updateModeButtons('work');
        }

        // Update mode button styles
        function updateModeButtons(activeMode) {
            modeButtons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.mode === activeMode) {
                    btn.classList.add('active');
                }
            });

            // Update body background based on mode
            document.body.style.backgroundColor = 
                activeMode === 'work' ? '#f0f4f8' : 
                activeMode === 'shortBreak' ? '#e8f5e9' : 
                '#e3f2fd';
        }

        // Event Listeners
        startPauseBtn.addEventListener('click', toggleTimer);
        resetBtn.addEventListener('click', resetTimer);

        // Mode selection
        modeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const mode = btn.dataset.mode;
                
                // Stop any running timer
                if (isRunning) {
                    toggleTimer();
                }

                // Update mode
                currentMode = mode;
                timeRemaining = config[mode];
                updateDisplay();
                updateModeButtons(mode);
            });
        });

        // Initial display
        updateDisplay();

        // ---------------------------------
    // Tambahkan event listener pada setiap box-list
document.querySelectorAll('.box-list').forEach(box => {
    box.addEventListener('click', () => {
      // Ambil parent element (list-tugas)
      const parent = document.querySelector('.list-tugas');
      
      // Pindahkan box yang diklik ke posisi paling bawah
      parent.appendChild(box);
      
      // Optional: Scroll ke box tersebut
      box.scrollIntoView({ behavior: 'smooth' });
    });
  });