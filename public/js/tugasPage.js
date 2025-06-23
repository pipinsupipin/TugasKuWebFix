document.addEventListener("DOMContentLoaded", function () {
    // ===================== Axios Setup =====================
    axios.defaults.withCredentials = true;
    axios.defaults.baseURL = 'http://localhost:8000';

    // ===================== DOM Elements =====================
    const elements = {
        tasksList: document.getElementById("tasksList"),
        noTasks: document.getElementById("noTasks"),
        addTaskBtn: document.getElementById("addTaskBtn"),
        taskModal: document.getElementById("taskModal"),
        deleteModal: document.getElementById("deleteModal"),
        closeModalBtns: document.querySelectorAll(".close-modal"),
        cancelBtns: document.querySelectorAll(".cancel-btn"),
        taskForm: document.getElementById("taskForm"),
        modalTitle: document.getElementById("modalTitle"),
        confirmDeleteBtn: document.getElementById("confirmDelete"),
        filterBtns: document.querySelectorAll(".filter-btn"),
        kategoriSelect: document.getElementById("kategoriSelect"),
    };

    // ===================== State =====================
    window.state = {
        tasks: [],
        categories: [],
        currentTaskId: null,
        currentFilter: "all",
    };

    // Notifikasi Objek (notyf atau custom notifikasi)
    window.notyf = window.notyf || {
        success: function (message) {
            showNotification(message, "success");
        },
        error: function (message) {
            showNotification(message, "error");
        },
    };

    // ===================== Initialize =====================
    initializeApp();
    setupEventListeners();

    // ===================== Functions =====================

    // Initialize App
    async function initializeApp() {
        try {
            // Fetch categories first
            await fetchCategories();
            // Then fetch tasks
            await fetchTasks();
        } catch (error) {
            console.error("Error initializing app:", error);
            showNotification("Gagal memuat data aplikasi", "error");
        }
    }

    // Setup Event Listeners
    function setupEventListeners() {
        // Add task button
        elements.addTaskBtn.addEventListener("click", () => openTaskModal());

        // Close modal buttons
        elements.closeModalBtns.forEach((btn) => {
            btn.addEventListener("click", closeAllModals);
        });

        // Cancel buttons
        elements.cancelBtns.forEach((btn) => {
            btn.addEventListener("click", closeAllModals);
        });

        // Task form submission
        elements.taskForm.addEventListener("submit", handleTaskFormSubmit);

        // Delete confirmation
        elements.confirmDeleteBtn.addEventListener("click", handleDeleteTask);

        // Filter buttons
        elements.filterBtns.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const filter = e.target.getAttribute("data-filter");
                setActiveFilter(filter);
                filterTasks(filter);
            });
        });

        // Close modals when clicking outside
        window.addEventListener("click", (e) => {
            if (
                e.target === elements.taskModal ||
                e.target === elements.deleteModal
            ) {
                closeAllModals();
            }
        });

        // Event listener untuk checkbox tugas
        document.addEventListener("click", (e) => {
            const checkbox = e.target.closest(".task-checkbox");

            if (checkbox) {
                const taskId = checkbox.getAttribute("data-id");
                const checkmark = checkbox.querySelector(".checkmark");
                const taskItem = checkbox.closest(".task-item");

                // Toggle UI
                const isNowCompleted = checkmark.style.opacity !== "1";
                checkmark.style.opacity = isNowCompleted ? "1" : "0";
                taskItem.classList.toggle("completed");

                // Kirim request ke server
                axios
                    .post(
                        `/api/tugas/${taskId}/toggle-complete`,
                        {},
                        {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem(
                                    "auth_token"
                                )}`,
                            },
                        }
                    )
                    .then((response) => {
                        console.log(
                            `Tugas dengan ID ${taskId} berhasil di-update.`
                        );

                        // Update state
                        state.tasks = state.tasks.map((task) =>
                            task.id == taskId
                                ? {
                                      ...task,
                                      is_completed: isNowCompleted ? 1 : 0,
                                  }
                                : task
                        );

                        // Notifikasi sukses
                        if (isNowCompleted) {
                            notyf.success("Tugas berhasil diselesaikan!");
                        } else {
                            notyf.success("Tugas ditandai belum selesai.");
                        }
                    })
                    .catch((error) => {
                        console.error("Gagal toggle status:", error);
                        // Kembalikan UI jika gagal
                        checkmark.style.opacity = isNowCompleted ? "0" : "1";
                        taskItem.classList.toggle("completed");
                        notyf.error("Gagal mengubah status tugas.");
                    });
            }
        });
    }

    // Fetch all categories from API
    async function fetchCategories() {
        try {
            const response = await axios.get("/api/kategori", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "auth_token"
                    )}`,
                },
            });

            if (response.data.success) {
                state.categories = response.data.data;
                populateCategorySelect();
            } else {
                throw new Error("Failed to fetch categories");
            }
        } catch (error) {
            console.error("Error fetching categories:", error);
            showNotification("Gagal memuat kategori", "error");
        }
    }

    // Populate category select dropdown
    function populateCategorySelect() {
        // Clear current options
        elements.kategoriSelect.innerHTML = "";

        // Add default option
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "-- Pilih Kategori --";
        defaultOption.disabled = true;
        defaultOption.selected = true;
        elements.kategoriSelect.appendChild(defaultOption);

        // Add categories from state
        state.categories.forEach((category) => {
            const option = document.createElement("option");
            option.value = category.id;
            option.textContent = category.nama_kategori;
            elements.kategoriSelect.appendChild(option);
        });
    }

    // Fetch all tasks from API
    async function fetchTasks() {
        try {
            const response = await axios.get("/api/tugas", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "auth_token"
                    )}`,
                },
            });

            if (response.data.success) {
                state.tasks = response.data.data;
                renderTasks();
            } else {
                throw new Error("Failed to fetch tasks");
            }
        } catch (error) {
            console.error("Error fetching tasks:", error);
            showNotification("Gagal memuat tugas", "error");
        }
    }

    // Render tasks based on current filter
    window.renderTasks = function () {
        // Filter tasks based on current selection
        const filteredTasks = filterTasksByState(
            state.tasks,
            state.currentFilter
        );

        // Clear current list
        elements.tasksList.innerHTML = "";

        if (filteredTasks.length === 0) {
            elements.tasksList.appendChild(elements.noTasks);
            elements.noTasks.style.display = "block";
            return;
        }

        elements.noTasks.style.display = "none";

        // Add each task to the list
        filteredTasks.forEach((task) => {
            const taskElement = createTaskElement(task);
            elements.tasksList.appendChild(taskElement);
        });
    };

    // Create a task element
    function createTaskElement(task) {
        const taskItem = document.createElement("div");
        taskItem.className = `task-item ${
            task.is_completed ? "completed" : ""
        }`;
        taskItem.setAttribute("data-task-id", task.id);

        // Format dates for display
        const startDate = task.waktu_mulai
            ? new Date(task.waktu_mulai).toLocaleString("id-ID", {
                  day: "2-digit",
                  month: "2-digit",
                  year: "numeric",
                  hour: "2-digit",
                  minute: "2-digit",
              })
            : "-";

        const endDate = task.waktu_selesai
            ? new Date(task.waktu_selesai).toLocaleString("id-ID", {
                  day: "2-digit",
                  month: "2-digit",
                  year: "numeric",
                  hour: "2-digit",
                  minute: "2-digit",
              })
            : "-";

        // Get category name
        const categoryName = task.kategori ? task.kategori.nama_kategori : "-";

        taskItem.innerHTML = `
        <div class="task-check">
            <div class="task-checkbox" data-id="${task.id}">
                <div class="checkmark" style="opacity: ${task.is_completed ? "1" : "0"}"></div>
            </div>
        </div>
        <div class="task-title">
            ${task.judul}
            <span class="task-category">${categoryName}</span>
        </div>
        <div class="task-desc">${task.deskripsi || "-"}</div>
        <div class="task-date">${startDate}</div>
        <div class="task-date">${endDate}</div>
        <div class="task-actions">
            <button class="action-btn edit-btn" onclick="openEditTaskModal(${task.id})">
                <i class="fas fa-edit"></i>
            </button>
            <button class="action-btn delete-btn" onclick="openDeleteModal(${task.id})">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    `;

        return taskItem;
    }

    // Filter tasks based on state
    function filterTasksByState(tasks, filter) {
        switch (filter) {
            case "completed":
                return tasks.filter((task) => task.is_completed);
            case "incomplete":
                return tasks.filter((task) => !task.is_completed);
            case "all":
            default:
                return tasks;
        }
    }

    // Set active filter
    function setActiveFilter(filter) {
        state.currentFilter = filter;

        elements.filterBtns.forEach((btn) => {
            if (btn.getAttribute("data-filter") === filter) {
                btn.classList.add("active");
            } else {
                btn.classList.remove("active");
            }
        });
    }

    // Filter tasks
    function filterTasks(filter) {
        setActiveFilter(filter);
        renderTasks();
    }

    // Open task modal for adding new task
    function openTaskModal() {
        elements.modalTitle.textContent = "Tambah Tugas Baru";
        elements.taskForm.reset();
        document.getElementById("taskId").value = "";
        state.currentTaskId = null;
        elements.taskModal.style.display = "block";
    }

    // Open task modal for editing existing task
    window.openEditTaskModal = function (taskId) {
        const task = state.tasks.find((t) => t.id === taskId);
        if (!task) return;

        elements.modalTitle.textContent = "Edit Tugas";
        document.getElementById("taskId").value = task.id;
        document.getElementById("kategoriSelect").value = task.kategori_id;
        document.getElementById("taskTitle").value = task.judul;
        document.getElementById("taskDescription").value = task.deskripsi || "";

        // Format dates for datetime-local input
        if (task.waktu_mulai) {
            const startDate = new Date(task.waktu_mulai)
                .toISOString()
                .slice(0, 16);
            document.getElementById("startDate").value = startDate;
        } else {
            document.getElementById("startDate").value = "";
        }

        if (task.waktu_selesai) {
            const endDate = new Date(task.waktu_selesai)
                .toISOString()
                .slice(0, 16);
            document.getElementById("endDate").value = endDate;
        } else {
            document.getElementById("endDate").value = "";
        }

        state.currentTaskId = taskId;
        elements.taskModal.style.display = "block";
    };

    // Open delete confirmation modal
    window.openDeleteModal = function (taskId) {
        state.currentTaskId = taskId;
        elements.deleteModal.style.display = "block";
    };

    // Close all modals
    function closeAllModals() {
        elements.taskModal.style.display = "none";
        elements.deleteModal.style.display = "none";
    }

    // Handle task form submission
    async function handleTaskFormSubmit(e) {
        e.preventDefault();

        const formData = {
            kategori_id: document.getElementById("kategoriSelect").value,
            judul: document.getElementById("taskTitle").value,
            deskripsi: document.getElementById("taskDescription").value,
            waktu_mulai: document.getElementById("startDate").value || null,
            waktu_selesai: document.getElementById("endDate").value || null,
        };

        // Validate form
        if (!formData.kategori_id) {
            showNotification("Kategori harus dipilih", "error");
            return;
        }

        // Validate end date is after start date
        if (formData.waktu_mulai && formData.waktu_selesai) {
            const startDate = new Date(formData.waktu_mulai);
            const endDate = new Date(formData.waktu_selesai);

            if (endDate <= startDate) {
                showNotification(
                    "Waktu selesai harus setelah waktu mulai",
                    "error"
                );
                return;
            }
        }

        try {
            let response;

            if (state.currentTaskId) {
                // Update existing task
                // Include is_completed from current task state to preserve status
                const currentTask = state.tasks.find(
                    (t) => t.id === state.currentTaskId
                );
                formData.is_completed = currentTask.is_completed;

                response = await axios.put(
                    `/api/tugas/${state.currentTaskId}`,
                    formData,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );

                if (response.data.success) {
                    // Update local state
                    state.tasks = state.tasks.map((task) =>
                        task.id === state.currentTaskId
                            ? response.data.data
                            : task
                    );

                    renderTasks();
                    closeAllModals();
                    showNotification("Tugas berhasil diperbarui", "success");
                } else {
                    throw new Error(
                        response.data.message || "Gagal memperbarui tugas"
                    );
                }
            } else {
                // Create new task
                response = await axios.post("/api/tugas", formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "auth_token"
                        )}`,
                    },
                });

                if (response.data.success) {
                    // Add to local state
                    state.tasks.unshift(response.data.data);

                    renderTasks();
                    closeAllModals();
                    showNotification("Tugas berhasil ditambahkan", "success");
                } else {
                    throw new Error(
                        response.data.message || "Gagal menambahkan tugas"
                    );
                }
            }
        } catch (error) {
            console.error("Error saving task:", error);

            // Handle validation errors
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.message;
                let errorMessage = "Validasi gagal: ";

                // Format error messages
                if (typeof errors === "object") {
                    errorMessage += Object.values(errors).flat().join(", ");
                } else {
                    errorMessage += errors;
                }

                showNotification(errorMessage, "error");
            } else {
                showNotification("Gagal menyimpan tugas", "error");
            }
        }
    }

    // Handle delete task
    async function handleDeleteTask() {
        if (!state.currentTaskId) return;

        try {
            const response = await axios.delete(
                `/api/tugas/${state.currentTaskId}`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "auth_token"
                        )}`,
                    },
                }
            );

            if (response.data.success) {
                // Remove from local state
                state.tasks = state.tasks.filter(
                    (task) => task.id !== state.currentTaskId
                );

                renderTasks();
                closeAllModals();
                showNotification("Tugas berhasil dihapus", "success");
            } else {
                throw new Error(
                    response.data.message || "Gagal menghapus tugas"
                );
            }
        } catch (error) {
            console.error("Error deleting task:", error);
            showNotification("Gagal menghapus tugas", "error");
        }
    }

    // Show notification
    window.showNotification = function (message, type = "info") {
        // Check if notification container exists, if not create it
        let notifContainer = document.getElementById("notification-container");

        if (!notifContainer) {
            notifContainer = document.createElement("div");
            notifContainer.id = "notification-container";
            notifContainer.style.position = "fixed";
            notifContainer.style.top = "20px";
            notifContainer.style.right = "20px";
            notifContainer.style.zIndex = "9999";
            document.body.appendChild(notifContainer);
        }

        // Create notification element
        const notification = document.createElement("div");
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;

        // Style the notification
        notification.style.backgroundColor =
            type === "error" ? "#f44336" : "#4CAF50";
        notification.style.color = "white";
        notification.style.padding = "12px 24px";
        notification.style.marginBottom = "10px";
        notification.style.borderRadius = "4px";
        notification.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.2)";
        notification.style.minWidth = "300px";
        notification.style.transition = "all 0.3s ease";

        // Style the close button
        const closeBtn = notification.querySelector(".notification-close");
        closeBtn.style.background = "none";
        closeBtn.style.border = "none";
        closeBtn.style.color = "white";
        closeBtn.style.float = "right";
        closeBtn.style.fontSize = "20px";
        closeBtn.style.cursor = "pointer";

        // Add notification to container
        notifContainer.appendChild(notification);

        // Add event listener to close button
        closeBtn.addEventListener("click", () => {
            notification.remove();
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    };
});
