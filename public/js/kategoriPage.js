document.addEventListener("DOMContentLoaded", function () {
    // ===================== Axios Setup =====================
    axios.defaults.withCredentials = true;
    axios.defaults.baseURL = 'https://tugas-ku.cloud';

    // ===================== MENAMPILKAN KATEGORI DAN TUGAS PER KATEGORI =====================

    // Mapping antara kata kunci kategori dengan SVG Icon modern
    const iconColor = "rgba(0, 0, 0, 0.5)";
    const iconMapping = {
        // Task/Assignment related icons
        "tugas|assignment|kerjaan|task|to-do|todo|checklist|activities|aktivitas|homework|pr|pekerjaan rumah": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <rect width="16" height="18" x="4" y="3" stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" rx="2"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l2 2 4-4"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14h8"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17h5"/>
                </svg>`,

        // Project related icons
        "proyek|project|development|pengerjaan|development|devops|programming|coding|aplikasi|software|app": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 4h6v6M10 4H4v6m0 4v6h6m10-6v6h-6"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10l6-6M4 20l6-6"/>
                </svg>`,

        // Meeting related icons
        "meeting|rapat|diskusi|briefing|pertemuan|conference|presentation|presentasi|webinar|seminar|workshop|lokakarya": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>`,

        // Education/Learning related icons
        "les|belajar|training|kursus|education|study|kuliah|kuliner|sekolah|school|university|universitas|college|pendidikan|course|pembelajaran": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 9.5v6M4.5 9.5L12 13l7.5-3.5"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v5"/>
                </svg>`,

        // Exam related icons
        "ujian|exam|test|assessment|evaluasi|evaluation|quiz|ulangan|praktek|praktikum|mid|final|uts|uas": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11v6M9 14h6"/>
                </svg>`,

        // Finance related icons
        "keuangan|finance|pembayaran|billing|invoice|money|uang|dana|fund|financial|loan|kredit|pinjaman|saving|tabungan|expenses|pengeluaran|income|pemasukan|salary|gaji": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12M8 10H4v8h4M20 10h-4v8h4M4 18v2h16v-2"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 10l-4-4-4 4"/>
                </svg>`,

        // Deadline related icons
        "deadline|due|pengumpulan|tenggat|batas waktu|time limit|timer|stopwatch|countdown|tempo|time|waktu": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 6l-1.5 1.5M3 6l1.5 1.5"/>
                </svg>`,

        // Research related icons
        "research|penelitian|riset|lab|laboratory|laboratorium|analysis|analisis|experiment|eksperimen|discovery|penemuan|science|ilmu|innovation|inovasi|exploration|eksplorasi": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6v4l3.5 7v5a2 2 0 01-2 2h-9a2 2 0 01-2-2v-5L9 7V3z"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.5 14h11"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 3v2M14 3v2"/>
                </svg>`,

        // Health related icons
        "health|kesehatan|medical|dokter|obat|wellness|fitness|olahraga|exercise|gym|workout|nutrition|nutrisi|diet|makanan": `
                <svg svg svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.8 15a8 8 0 1014.4 0"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v4M10 6h4"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 13h9a1 1 0 011 1v4a1 1 0 01-1 1h-9a1 1 0 01-1-1v-4a1 1 0 011-1z"/>
                </svg>`,

        // Travel related icons
        "travel|perjalanan|trip|vacation|liburan|tour|journey|holiday|flight|penerbangan|ticket|tiket|visa|passport|paspor": `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 4l-2 14.5-6-2.5-6 2.5L4 4l8 3 8-3z"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7v9.5"/>
                </svg>`,

        // Default icon
        default: `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                    <path stroke="${iconColor}" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7v5M12 16v.01"/>
                </svg>`,
    };

    // Ambil elemen-elemen penting
    const categoryCardsContainer = document.getElementById(
        "category-cards-container"
    );
    const btnAddCategory = document.querySelector(".btn-add-category");
    const modalOverlay = document.querySelector(".modal-overlay");
    const btnCancel = document.getElementById("btn-cancel-category");
    const btnSave = document.getElementById("btn-save-category");
    const inputCategoryName = document.getElementById("input-category-name");

    // Tombol Edit Kategori
    const editCategoryButton = document.querySelector(".btn-edit-category");
    const editCategoryModal = document.getElementById("editCategoryModal");
    const editCategoryNameInput = document.getElementById("edit-category-name");
    const saveEditCategoryButton = document.getElementById(
        "btn-save-edit-category"
    );
    const cancelEditCategoryButton = document.getElementById(
        "btn-cancel-edit-category"
    );

    let selectedCategoryId = null;
    let selectedCategoryName = null;

    // Initialize Notyf
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: "center",
            y: "top",
        },
        types: [
            {
                type: "success",
                background: "#10b981",
                icon: {
                    className: "fas fa-check-circle",
                    tagName: "i",
                    color: "white",
                },
            },
            {
                type: "error",
                background: "#ef4444",
                icon: {
                    className: "fas fa-times-circle",
                    tagName: "i",
                    color: "white",
                },
            },
            {
                type: "warning",
                background: "#f59e0b",
                icon: {
                    className: "fas fa-exclamation-circle",
                    tagName: "i",
                    color: "white",
                },
            },
        ],
    });

    // Fungsi untuk mengambil data kategori dan tugas
    const fetchCategories = () => {
        Promise.all([
            axios.get("/api/kategori", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "auth_token"
                    )}`,
                },
            }),
            axios.get("/api/tugas", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "auth_token"
                    )}`,
                },
            }),
        ])
            .then(([categoryResponse, taskResponse]) => {
                const categories = categoryResponse.data.data;
                const tasks = taskResponse.data.data;

                if (categories.length > 0) {
                    categoryCardsContainer.innerHTML = ""; // Kosongkan kontainer sebelumnya

                    // Format tanggal
                    function formatDate(dateString) {
                        const options = {
                            weekday: "long",
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                        };
                        return new Date(dateString).toLocaleDateString(
                            "id-ID",
                            options
                        );
                    }

                    // Looping melalui setiap kategori
                    categories.forEach((item) => {
                        const categoryTasks = tasks.filter(
                            (task) => task.kategori_id === item.id
                        );

                        // Cari icon yang cocok berdasarkan nama kategori
                        let icon = iconMapping["default"];
                        Object.keys(iconMapping).forEach((key) => {
                            const regex = new RegExp(`\\b(${key})\\b`, "i");
                            if (regex.test(item.nama_kategori)) {
                                icon = iconMapping[key];
                            }
                        });

                        const categoryCard = document.createElement("div");
                        categoryCard.classList.add("category-card");
                        categoryCard.setAttribute("data-id", item.id); // Set atribut ID
                        categoryCard.setAttribute(
                            "data-name",
                            item.nama_kategori
                        ); // Set atribut Nama

                        if (categoryTasks.length > 0) {
                            const closestTask = categoryTasks
                                .filter((task) => !task.is_completed)
                                .sort(
                                    (a, b) =>
                                        new Date(a.waktu_mulai) -
                                        new Date(b.waktu_mulai)
                                )[0];

                            const deadline = closestTask
                                ? formatDate(closestTask.waktu_mulai)
                                : "-";
                            const totalTasks = categoryTasks.length;
                            const completedTasks = categoryTasks.filter(
                                (task) => task.is_completed
                            ).length;
                            const progressPercentage =
                                (completedTasks / totalTasks) * 100;

                            categoryCard.innerHTML = `
                                <div class="category-icon" style="background-color: rgba(250, 192, 0, 0.2);">
                                    ${icon}
                                </div>
                                <h3>${item.nama_kategori}</h3>
                                <p class="category-date">${deadline}</p>
                                <div class="progress-bar">
                                    <div class="progress" style="width: ${progressPercentage}%"></div>
                                </div>
                                <p class="category-progress">${completedTasks} / ${totalTasks} Selesai</p>
                            `;
                        } else {
                            categoryCard.innerHTML = `
                                <div class="category-icon" style="background-color: rgba(250, 192, 0, 0.2);">
                                    ${icon}
                                </div>
                                <h3>${item.nama_kategori}</h3>
                                <p class="category-date">-</p>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 100%"></div>
                                </div>
                                <p class="category-progress">Belum ada tugas di kategori ini</p>
                            `;
                        }

                        // Event Listener untuk pilih kategori
                        categoryCard.addEventListener("click", () => {
                            // Hilangkan highlight di semua kategori
                            document
                                .querySelectorAll(".category-card")
                                .forEach((card) => {
                                    card.classList.remove("selected");
                                });

                            // Tambahkan highlight pada kategori yang diklik
                            categoryCard.classList.add("selected");

                            // Simpan ID dan Nama kategori
                            selectedCategoryId = item.id;
                            selectedCategoryName = item.nama_kategori;

                            // Tampilkan tombol Edit Kategori
                            editCategoryButton.textContent = `Edit Kategori ${selectedCategoryName}`;
                            editCategoryButton.classList.remove("hidden");

                            // Simpan ke LocalStorage
                            localStorage.setItem("selectedCategoryId", item.id);
                            localStorage.setItem(
                                "selectedCategoryName",
                                item.nama_kategori
                            );

                            renderTasksByCategoryId(selectedCategoryId);
                        });

                        categoryCardsContainer.appendChild(categoryCard);
                    });

                    // PERUBAHAN: Hilangkan pemilihan otomatis kategori dari localStorage
                    // Sebagai gantinya, tampilkan pesan default
                    const taskListContainer = document.getElementById(
                        "task-list-container"
                    );
                    taskListContainer.innerHTML =
                        "<p>Pilih Kategori untuk Menampilkan Tugas!</p>";

                    // Sembunyikan tombol edit kategori saat pertama kali load
                    editCategoryButton.classList.add("hidden");
                } else {
                    categoryCardsContainer.innerHTML =
                        "<p>Data kategori tidak ditemukan.</p>";
                }
            })
            .catch((error) => {
                console.error(
                    "Terjadi kesalahan saat mengambil data kategori atau tugas:",
                    error
                );
                categoryCardsContainer.innerHTML =
                    "<p>Terjadi kesalahan saat mengambil data kategori atau tugas.</p>";
                notyf.error("Terjadi kesalahan saat mengambil data");
            });
    };

    // Panggil fungsi fetch pertama kali
    fetchCategories();

    // Event Listener untuk Tombol Tambah Kategori
    if (btnAddCategory && modalOverlay) {
        btnAddCategory.addEventListener("click", () => {
            modalOverlay.classList.remove("hidden");
        });
    }

    // Event Listener untuk Tombol Batal
    if (btnCancel && modalOverlay) {
        btnCancel.addEventListener("click", () => {
            modalOverlay.classList.add("hidden");
            inputCategoryName.value = "";
        });
    }

    // Event Listener untuk Tombol Simpan Kategori Baru
    if (btnSave && inputCategoryName) {
        btnSave.addEventListener("click", async () => {
            const categoryName = inputCategoryName.value.trim();
            if (!categoryName) {
                notyf.error("Nama kategori tidak boleh kosong!");
                return;
            }

            try {
                const response = await axios.post(
                    "/api/kategori",
                    {
                        nama_kategori: categoryName,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );

                if (response.data.success) {
                    notyf.success("Kategori berhasil ditambahkan!");
                    modalOverlay.classList.add("hidden");
                    inputCategoryName.value = "";
                    fetchCategories();
                }
            } catch (error) {
                console.error("Gagal menambah kategori:", error);
                notyf.error("Terjadi kesalahan saat menambah kategori.");
            }
        });
    }

    // Buka Modal Edit Kategori
    if (editCategoryButton) {
        editCategoryButton.addEventListener("click", (e) => {
            e.stopPropagation(); // Mencegah event bubbling
            if (selectedCategoryId) {
                // Set nama kategori ke dalam input
                editCategoryNameInput.value = selectedCategoryName;
                // Tampilkan modal
                editCategoryModal.classList.remove("hidden");
            }
        });
    }

    // Tombol Simpan Perubahan Kategori
    if (saveEditCategoryButton) {
        saveEditCategoryButton.addEventListener("click", async () => {
            const updatedName = editCategoryNameInput.value.trim();

            if (!updatedName) {
                notyf.error("Nama kategori tidak boleh kosong!");
                return;
            }

            try {
                const response = await axios.put(
                    `/api/kategori/${selectedCategoryId}`,
                    {
                        nama_kategori: updatedName,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );

                if (response.data.success) {
                    notyf.success("Kategori berhasil diubah!");
                    editCategoryModal.classList.add("hidden");
                    fetchCategories(); // Refresh data
                }
            } catch (error) {
                console.error("Gagal mengubah kategori:", error);
                notyf.error("Terjadi kesalahan saat mengubah kategori.");
            }
        });
    }

    // Tombol Batal Edit
    if (cancelEditCategoryButton) {
        cancelEditCategoryButton.addEventListener("click", () => {
            editCategoryModal.classList.add("hidden");
        });
    }

    // Tambahkan tombol delete kategori
    const deleteButton = document.createElement("button");
    deleteButton.id = "btn-delete-category";
    deleteButton.textContent = "Hapus Kategori";
    deleteButton.classList.add("btn-delete");

    // Tambahkan tombol delete ke modal edit
    if (editCategoryModal) {
        const modalActions = editCategoryModal.querySelector(".modal-actions");
        if (modalActions) {
            modalActions.appendChild(deleteButton);
        }
    }

    // Event listener untuk tombol delete
    deleteButton.addEventListener("click", async () => {
        if (!selectedCategoryId) return;

        // PERUBAHAN: Ganti confirm dengan dialog konfirmasi kustom
        // Buat modal konfirmasi
        const confirmModal = document.createElement("div");
        confirmModal.classList.add("modal-overlay", "confirmation-modal");
        confirmModal.innerHTML = `
                <div class="modal-content">
                    <h3>Konfirmasi Hapus</h3>
                    <p>Apakah Anda yakin ingin menghapus kategori "${selectedCategoryName}"?</p>
                    <p>Semua tugas dalam kategori ini juga akan dihapus.</p>
                    <div class="modal-actions">
                        <button id="btn-cancel-delete" class="btn-cancel">Batal</button>
                        <button id="btn-confirm-delete" class="btn-danger">Hapus</button>
                    </div>
                </div>
            `;
        document.body.appendChild(confirmModal);

        // Event listener untuk tombol konfirmasi dan batal
        document
            .getElementById("btn-cancel-delete")
            .addEventListener("click", () => {
                document.body.removeChild(confirmModal);
            });

        document
            .getElementById("btn-confirm-delete")
            .addEventListener("click", async () => {
                document.body.removeChild(confirmModal);

                try {
                    const response = await axios.delete(
                        `/api/kategori/${selectedCategoryId}`,
                        {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem(
                                    "auth_token"
                                )}`,
                            },
                        }
                    );

                    if (response.data.success) {
                        notyf.success("Kategori berhasil dihapus!");
                        editCategoryModal.classList.add("hidden");

                        // Hapus dari localStorage
                        localStorage.removeItem("selectedCategoryId");
                        localStorage.removeItem("selectedCategoryName");

                        // Reset selected category
                        selectedCategoryId = null;
                        selectedCategoryName = null;

                        // Sembunyikan tombol edit
                        editCategoryButton.classList.add("hidden");

                        // Kosongkan daftar tugas
                        const taskListContainer = document.getElementById(
                            "task-list-container"
                        );
                        taskListContainer.innerHTML =
                            "<p>Pilih Kategori untuk Menampilkan Tugas!</p>";

                        // Refresh kategori
                        fetchCategories();
                    }
                } catch (error) {
                    console.error("Gagal menghapus kategori:", error);
                    notyf.error("Terjadi kesalahan saat menghapus kategori.");
                }
            });
    });

    // Fungsi untuk render tugas berdasarkan kategori
    function renderTasksByCategoryId(categoryId) {
        const taskListContainer = document.getElementById(
            "task-list-container"
        );
        taskListContainer.innerHTML = "<p>Memuat tugas...</p>";

        axios
            .get("/api/tugas", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "auth_token"
                    )}`,
                },
            })
            .then((response) => {
                const tasks = response.data.data;
                const filteredTasks = tasks.filter(
                    (task) => task.kategori_id === categoryId
                );

                if (filteredTasks.length === 0) {
                    taskListContainer.innerHTML =
                        "<p>Tidak ada tugas untuk kategori ini.</p>";
                    return;
                }

                const taskElements = filteredTasks
                    .map((task) => {
                        const waktuMulai = new Date(
                            task.waktu_mulai
                        ).toLocaleString("id-ID");
                        const waktuSelesai = task.waktu_selesai
                            ? new Date(task.waktu_selesai).toLocaleString(
                                  "id-ID"
                              )
                            : null;

                        return `
                        <div class="task-item ${
                            task.is_completed ? "completed" : ""
                        }" data-id="${task.id}">
                            <div class="task-checkbox" data-id="${task.id}">
                                <div class="checkmark" style="opacity: ${
                                    task.is_completed ? "1" : "0"
                                }"></div>
                            </div>
                            <div class="task-content">
                                <h4>${task.judul}</h4>
                                <p>${
                                    waktuSelesai
                                        ? `Waktu: ${waktuMulai} - ${waktuSelesai}`
                                        : `Waktu: ${waktuMulai}`
                                }</p>
                                ${
                                    task.deskripsi &&
                                    task.deskripsi !== "Tidak ada deskripsi"
                                        ? `<p>${task.deskripsi}</p>`
                                        : ""
                                }
                            </div>
                        </div>
                    `;
                    })
                    .join("");

                taskListContainer.innerHTML = taskElements;
            })
            .catch((error) => {
                console.error("Gagal memuat tugas:", error);
                taskListContainer.innerHTML = "<p>Gagal memuat tugas.</p>";
                notyf.error("Gagal memuat tugas.");
            });
    }

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
                    // Notifikasi sukses saat menyelesaikan tugas
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

    // Tambahkan CSS untuk modal konfirmasi
    const styleElement = document.createElement("style");
    styleElement.textContent = `
            .confirmation-modal .modal-content {
                max-width: 400px;
                padding: 20px;
                border-radius: 8px;
                background-color: white;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
            
            .confirmation-modal h3 {
                margin-top: 0;
                color: #333;
            }
            
            .confirmation-modal p {
                margin-bottom: 20px;
                color: #555;
            }
            
            .confirmation-modal .modal-actions {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
            }
            
            .confirmation-modal .btn-danger {
                background-color: #ef4444;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 4px;
                cursor: pointer;
            }
            
            .confirmation-modal .btn-cancel {
                background-color: #e5e7eb;
                color: #333;
                border: none;
                padding: 8px 16px;
                border-radius: 4px;
                cursor: pointer;
            }
            
            .btn-danger:hover {
                background-color: #dc2626;
            }
            
            .btn-cancel:hover {
                background-color: #d1d5db;
            }
        `;
});

document.head.appendChild(styleElement);
