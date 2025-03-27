document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");

    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua menu item
            menuItems.forEach(menu => menu.classList.remove("active"));

            // Tambahkan class 'active' ke menu yang diklik
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll(".categoryL");

    categoryItems.forEach(item => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua kategori
            categoryItems.forEach(category => category.classList.remove("active"));

            // Tambahkan class 'active' ke kategori yang diklik
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll(".categoryL");

    categoryItems.forEach(item => {
        item.addEventListener("click", function () {
            // Hapus class 'active' dari semua kategori
            categoryItems.forEach(category => category.classList.remove("active"));

            // Tambahkan class 'active' ke kategori yang diklik
            this.classList.add("active");
        });
    });
});


// ini edit
document.addEventListener("DOMContentLoaded", function () {
    const menuItems = {
        "dashboard-btn": "dashboard-view",
        "calendar-btn": "calendar-view",
        "list-btn": "list-view",
        "settings-btn": "settings-view",
        "about-btn": "about-view"
    };

    function showView(selectedViewId) {
        // Sembunyikan semua tampilan
        Object.values(menuItems).forEach(viewId => {
            document.getElementById(viewId).style.display = "none";
        });

        // Hapus class 'active' dari semua menu
        Object.keys(menuItems).forEach(menuId => {
            document.getElementById(menuId).classList.remove("active");
        });

        // Tampilkan tampilan yang dipilih & aktifkan menu terkait
        document.getElementById(selectedViewId).style.display = "block";
        Object.entries(menuItems).forEach(([menuId, viewId]) => {
            if (viewId === selectedViewId) {
                document.getElementById(menuId).classList.add("active");
            }
        });
    }

    // Tambahkan event listener ke setiap menu
    Object.keys(menuItems).forEach(menuId => {
        document.getElementById(menuId).addEventListener("click", function (event) {
            event.preventDefault();
            showView(menuItems[menuId]);
        });
    });

    // Tampilkan tampilan default (Dashboard)
    showView("dashboard-view");
});
